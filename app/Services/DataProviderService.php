<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

class DataProviderService
{
    /**
     * Retrieve data from JSON files, with caching for optimization.
     *
     * @return mixed
     */
    public function getDataFromFiles()
    {
        $cacheKey = 'data_from_files';

        // Attempt to retrieve data from cache
        $data = Cache::get($cacheKey);

        if ($data === null) {
            $data = $this->processJsonFiles();
            
            // Cache the data for 10 minutes
            Cache::put($cacheKey, $data, now()->addMinutes(10));
        }

        return $data;
    }

    /**
     * Process JSON files, map data, and return as a collection.
     *
     * @return mixed
     */
    private function processJsonFiles()
    {
        $data = collect([]);

        // Get all JSON files in the public/data_provider directory
        $jsonFiles = File::files(public_path('data_provider'));

        foreach ($jsonFiles as $file) {
            try {
                $contents = File::get($file);
                $jsonData = json_decode($contents, true);

                // Validate JSON structure
                if (!$this->validateJsonStructure($jsonData)) {
                    return response()->json(['error' => 'Invalid JSON structure in file:'.$file.', Please check structure of json file']);
                }

                // Map the data and merge into the $data collection
                $mappedData = $this->mapData($jsonData);
                $data = $data->merge($mappedData);
            } catch (\Exception $e) {
                return response()->json(['error' => 'An error occurred while processing the file:'.$file.', Please check structure of json file']);
            }
        }

        return $data;
    }

    /**
     * Validate the structure of JSON data.
     *
     * @param array $jsonData
     * @return bool
     */
    public function validateJsonStructure($jsonData)
    {
        return isset($jsonData['data']) && isset($jsonData['mapKeys']) && isset($jsonData['mapStatus']);
    }

    /**
     * Map JSON data to desired format.
     *
     * @param array $jsonData
     * @return array
     */
    public function mapData($jsonData)
    {
        $mapKeys = $jsonData['mapKeys'];
        $mapStatus = $jsonData['mapStatus'];
        $provider = $jsonData['provider'];

        return collect($jsonData['data'])->map(function($item) use ($mapKeys, $mapStatus, $provider) {
            return [
                'amount' => $item[$mapKeys['amount']],
                'currency' => $item[$mapKeys['currency']],
                'email' => $item[$mapKeys['email']],
                'date' => $item[$mapKeys['date']],
                'id' => $item[$mapKeys['id']],
                'status_code' => $item[$mapKeys['status_code']],
                'status' => $mapStatus[$item[$mapKeys['status_code']]],
                'provider' => $provider
            ];
        })->all();
    }
}

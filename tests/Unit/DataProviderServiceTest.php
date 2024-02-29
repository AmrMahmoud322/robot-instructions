<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\DataProviderService;
use Illuminate\Support\Facades\File;

class DataProviderServiceTest extends TestCase
{
    public function testGetDataFromFiles()
    {
        $dataProviderService = new DataProviderService();

        $data = $dataProviderService->getDataFromFiles();

        $this->assertIsObject($data);
        $this->assertNotEmpty($data);
    }

    public function testValidateJsonStructure()
    {
        $dataProviderService = new DataProviderService();

        $validJson = [
            'data' => [],
            'mapKeys' => [],
            'mapStatus' => []
        ];

        $invalidJson = [
            'data' => [],
            'mapKeys' => []
        ];
        
        $this->assertTrue($dataProviderService->validateJsonStructure($validJson));
        $this->assertFalse($dataProviderService->validateJsonStructure($invalidJson));
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\RobotService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class RobotController extends Controller
{

    protected $robotService;

    /**
     * Constructor to inject RobotService dependency.
     *
     * @param RobotService $robotService
     */
    public function __construct(RobotService $robotService)
    {
        $this->robotService = $robotService;
    }

    
    /**
     * Parse instructions and generate output file.
     *
     * @param Request $request The incoming HTTP request containing instructions.
     * @return JsonResponse The JSON response containing file path or validation errors.
     */
    public function parser(Request $request) {
        // Manual validation using Validator facade
        $validator = Validator::make($request->all(), [
            'instructions' => ['required', 'string', 'regex:/^[FBRL]+$/i'],
        ], [
            'instructions.required' => 'Instructions are required.',
            'instructions.string' => 'Instructions must be a string.',
            'instructions.regex' => 'Instructions can only contain F, B, R, or L characters.',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Call the service to parse instructions and generate file
        $filePath = $this->robotService->parseInstructionsAndGenerateFile($request->instructions);

        // Return file path in response
        return response()->json(['file_path' => $filePath]);
    }
}

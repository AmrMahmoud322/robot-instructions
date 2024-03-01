<?php

namespace App\Services;

class RobotService
{
    /**
     * Parse instructions, generate output file, and return file path.
     *
     * @param string $instructions The instructions string.
     * @return string The file path of the generated output file.
     */
    public function parseInstructionsAndGenerateFile($instructions)
    {
        // Step 1: Parse instructions to x, y values
        $position = $this->parseInstructions($instructions);

        // Step 2: Generate output file
        $filePath = $this->generateOutputFile($instructions, $position);

        // Step 3: Return path of the generated file
        return $filePath;
    }

    /**
     * Parse instructions to calculate x and y positions.
     *
     * @param string $instructions The instructions string.
     * @return array The array containing x and y positions.
     */
    private function parseInstructions($instructions)
    {
        // Count occurrences of each instruction
        $counts = array_count_values(str_split($instructions));

        // Calculate x and y based on instruction counts
        $x = ($counts['R'] ?? 0) + ($counts['r'] ?? 0) - ($counts['L'] ?? 0) - ($counts['l'] ?? 0);
        $y = ($counts['F'] ?? 0) + ($counts['f'] ?? 0) - ($counts['B'] ?? 0) - ($counts['b'] ?? 0);

        return ['x' => $x, 'y' => $y];
    }

    /**
     * Generate output file with instructions and position information.
     *
     * @param string $instructions The instructions string.
     * @param array $position The array containing x and y positions.
     * @return string The file path of the generated output file.
     */
    private function generateOutputFile($instructions, $position)
    {
        $filePath = storage_path("app/output-$instructions.txt");

        file_put_contents($filePath, "$instructions => x={$position['x']} y={$position['y']}");

        return $filePath;
    }
}

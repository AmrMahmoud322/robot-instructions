<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RobotControllerTest extends TestCase
{
    /**
     * Test parsing valid robot instructions via API.
     *
     * @return void
     */
    public function testParseValidRobotInstructions()
    {
        $response = $this->get('/api/v1/robot/parser?instructions=FFBBFRRLRFF');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'file_path'
                 ]);
    }

    /**
     * Test parsing invalid robot instructions via API.
     *
     * @return void
     */
    public function testParseInvalidRobotInstructions()
    {
        $response = $this->get('/api/v1/robot/parser?instructions=FFBBFRR869');

        $response->assertStatus(422)
                 ->assertJsonStructure([
                     'errors'
                 ]);
    }

    /**
     * Test parsing empty request (without instructions parameter) via API.
     *
     * @return void
     */
    public function testParseEmptyRequest()
    {
        $response = $this->get('/api/v1/robot/parser');

        $response->assertStatus(422)
                 ->assertJsonStructure([
                     'errors'
                 ]);
    }
}

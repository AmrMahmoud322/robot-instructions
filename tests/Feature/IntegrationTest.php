<?php

namespace Tests\Feature;

use Tests\TestCase;

class IntegrationTest extends TestCase
{
    public function testApiEndpoint()
    {
        $response = $this->get('/api/v1/users');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data'
            ]);
    }
}

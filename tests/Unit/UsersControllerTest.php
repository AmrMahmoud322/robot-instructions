<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\UsersController;
use App\Services\DataProviderService;

class UsersControllerTest extends TestCase
{
    public function testIndexWithProviderFilter()
    {
        $response = $this->get('/api/v1/users?provider=DataProviderX');

        $response->assertStatus(200);
    }

    public function testIndexWithStatusCodeFilter()
    {
        $response = $this->get('/api/v1/users?statusCode=authorised');

        $response->assertStatus(200);
    }

    public function testIndexWithBalanceMinFilter()
    {
        $response = $this->get('/api/v1/users?balanceMin=200');

        $response->assertStatus(200);
    }

    public function testIndexWithBalanceMaxFilter()
    {
        $response = $this->get('/api/v1/users?balanceMax=500');

        $response->assertStatus(200);
    }

    public function testIndexWithCurrencyFilter()
    {
        $response = $this->get('/api/v1/users?currency=USD');

        $response->assertStatus(200);
    }
}

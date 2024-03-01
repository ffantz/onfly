<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class AuthTest extends TestCase
{
    /**
     * Testa o metodo de login.
     */
    public function testLogin(): void
    {
        $response = Http::post('http://localhost:8000/api/login', [
            "email" => "flavio@mail.com",
            "password" => "123456",
        ]);

        $data = json_decode($response->getBody(true), true);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('access_token', $data);
    }
}

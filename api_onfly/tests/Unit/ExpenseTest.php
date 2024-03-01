<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class ExpenseTest extends TestCase
{
    public function testAuthenticationIsRequiredToAction()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json'
        ])->post('http://localhost:8000/api/expense', [
            "description" => "teste despesa cadastro",
            "date" => "2024-02-01",
            "cost" => 50.22
        ]);

        $data = json_decode($response->getBody(true), true);
        $this->assertEquals(401, $response->getStatusCode());
        $this->assertArrayHasKey('message', $data);
        $this->assertEquals('Unauthenticated.', $data["message"]);
    }

    public function testFieldsAreRequired()
    {
        $accessToken = json_decode(Http::post('http://localhost:8000/api/login', [
            "email" => "flavio@mail.com",
            "password" => "123456",
        ])->getBody(true), true)["access_token"];

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $accessToken
        ])->post('http://localhost:8000/api/expense', [
        ]);

        $data = json_decode($response->getBody(true), true);
        $this->assertEquals(422, $response->getStatusCode());
        $this->assertArrayHasKey('errors', $data);
        $this->assertArrayHasKey('description', $data['errors']);
        $this->assertArrayHasKey('date', $data['errors']);
        $this->assertArrayHasKey('cost', $data['errors']);
    }

    public function testErrorMessageFieldsAreRequired()
    {
        $accessToken = json_decode(Http::post('http://localhost:8000/api/login', [
            "email" => "flavio@mail.com",
            "password" => "123456",
        ])->getBody(true), true)["access_token"];

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $accessToken
        ])->post('http://localhost:8000/api/expense', [
        ]);

        $data = json_decode($response->getBody(true), true);
        $this->assertEquals(422, $response->getStatusCode());
        $this->assertEquals($data['errors']['description'][0], 'O campo descriçao é obrigatorio.');
        $this->assertEquals($data['errors']['date'][0], 'O campo data é obrigatorio.');
        $this->assertEquals($data['errors']['cost'][0], 'O campo valor é obrigatorio.');
    }

    public function testUpdateAnotherExpenseForbidden()
    {
        $accessToken = json_decode(Http::post('http://localhost:8000/api/login', [
            "email" => "flavio@mail.com",
            "password" => "123456",
        ])->getBody(true), true)["access_token"];

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $accessToken
        ])->put('http://localhost:8000/api/expense/1', [
            "description" => "teste despesa cadastro",
        ]);

        $data = json_decode($response->getBody(true), true);
        $this->assertEquals(403, $response->getStatusCode());
        $this->assertArrayHasKey('message', $data);
        $this->assertEquals($data['message'], 'Voce nao é dono dessa despesa');
    }

    public function testDeleteAnotherExpenseForbidden()
    {
        $accessToken = json_decode(Http::post('http://localhost:8000/api/login', [
            "email" => "flavio@mail.com",
            "password" => "123456",
        ])->getBody(true), true)["access_token"];

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $accessToken
        ])->delete('http://localhost:8000/api/expense/1', [
            "description" => "teste despesa cadastro",
        ]);

        $data = json_decode($response->getBody(true), true);
        $this->assertEquals(403, $response->getStatusCode());
        $this->assertArrayHasKey('message', $data);
        $this->assertEquals($data['message'], 'Voce nao pode deletar uma despesa que nao seja sua');
    }

    public function testDescriptionLengthLimit()
    {
        $accessToken = json_decode(Http::post('http://localhost:8000/api/login', [
            "email" => "flavio@mail.com",
            "password" => "123456",
        ])->getBody(true), true)["access_token"];

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $accessToken
        ])->post('http://localhost:8000/api/expense', [
            "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
        ]); // descricao com 192 caracteres

        $data = json_decode($response->getBody(true), true);
        $this->assertEquals(422, $response->getStatusCode());
        $this->assertEquals($data['errors']['description'][0], 'A descricao deve conter no maximo 191 caracteres.');
    }

    public function testValidDate()
    {
        $accessToken = json_decode(Http::post('http://localhost:8000/api/login', [
            "email" => "flavio@mail.com",
            "password" => "123456",
        ])->getBody(true), true)["access_token"];

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $accessToken
        ])->post('http://localhost:8000/api/expense', [
            "date" => "2024-13-31",
        ]); // data invalida

        $data = json_decode($response->getBody(true), true);
        $this->assertEquals(422, $response->getStatusCode());
        $this->assertEquals($data['errors']['date'][0], 'O campo data deve ser uma data valida.');
    }

    public function testFutureDateNotAllowed()
    {
        $accessToken = json_decode(Http::post('http://localhost:8000/api/login', [
            "email" => "flavio@mail.com",
            "password" => "123456",
        ])->getBody(true), true)["access_token"];

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $accessToken
        ])->post('http://localhost:8000/api/expense', [
            "date" => "2024-03-31",
        ]); // data futura

        $data = json_decode($response->getBody(true), true);
        $this->assertEquals(422, $response->getStatusCode());
        $this->assertEquals($data['errors']['date'][0], 'A data deve ser igual ou antes de hoje.');
    }

    public function testNegativeCostValueNotAllowed()
    {
        $accessToken = json_decode(Http::post('http://localhost:8000/api/login', [
            "email" => "flavio@mail.com",
            "password" => "123456",
        ])->getBody(true), true)["access_token"];

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $accessToken
        ])->post('http://localhost:8000/api/expense', [
            "cost" => "-10",
        ]); // valor negativo

        $data = json_decode($response->getBody(true), true);
        $this->assertEquals(422, $response->getStatusCode());
        $this->assertEquals($data['errors']['cost'][0], 'O campo valor deve ser maior que 0.');
    }
}

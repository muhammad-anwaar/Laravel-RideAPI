<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DriverTest extends TestCase
{
    /**
     * Add Driver Test , Get JWT Auth Token And perform Add Driver Request
     *
     * @test
     */
    public function AddDriverTest()
    {
        $tokenContent = $this->json('POST', '/api/login',  ["email"=> "m.anwaarr@yahoo.com","password"=> "apikey"])->assertStatus(200)->getContent();
       
       $tokenData=json_decode($tokenContent, true);
       $token=$tokenData['token'];
       
       $response = $this->json('POST', '/api/addDriver',  ["name"=> "Ahsan Khan", "vehiclertype" => "Myvi", "status"=>"Available"],['Authorization' => "Bearer ".$token]); 
       $response->assertStatus(201);
    }
}

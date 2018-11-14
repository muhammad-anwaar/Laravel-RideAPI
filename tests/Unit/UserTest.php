<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * User Registration Test.
     *
     * @test
     */
    public function RegisterUserTest()
    {

        $response = $this->json('POST', '/api/register',  ["name"=> "Anwaar", "email"=> "m.anwaar".uniqid()."@yahoo.com","password"=> "apikey", "password_confirmation"=>"apikey"]); 
        //dd($response); 
        $response->assertStatus(201);
    }

    /**
     * User Login Test
     *
     * @test
     */
    public function LoginUserTest()
    {
       $response = $this->json('POST', '/api/login',  ["email"=> "m.anwaarr@yahoo.com","password"=> "apikey"]); 
       $response->assertStatus(200);	
    }

    /**
     * Get User Information
     *
     * @test
     */
    public function GetUserInformationTest()
    { 
    	$tokenContent = $this->json('POST', '/api/login',  ["email"=> "m.anwaarr@yahoo.com","password"=> "apikey"])->assertStatus(200)->getContent();
       
       $tokenData=json_decode($tokenContent, true);
       $token=$tokenData['token'];
       
       //// Get User Information
       $response = $this->json('GET', '/api/user',  [],['Authorization' => "Bearer ".$token]); 
       $response->assertStatus(200);
    }

    /**
     * User Logout test
     *
     *@test 
     */
    public function LogoutTest()
    {
    	///receive token and do perform test with jwt auth token 
       
       $tokenContent = $this->json('POST', '/api/login',  ["email"=> "m.anwaarr@yahoo.com","password"=> "apikey"])->assertStatus(200)->getContent();
       
       $tokenData=json_decode($tokenContent, true);
       $token=$tokenData['token'];
       
       $response = $this->json('POST', '/api/logout',  [],['Authorization' => "Bearer ".$token]); 
       $response->assertStatus(200);
    }

}

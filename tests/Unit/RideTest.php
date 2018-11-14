<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RideTest extends TestCase
{
    /**
     * Test Send Ride Request
     *
     * @test
     */
    public function SendRideRequestTest()
    {
        //get toekn and perform send request to available drivers
        $tokenContent = $this->json('POST', '/api/login',  ["email"=> "m.anwaarr@yahoo.com","password"=> "apikey"])->assertStatus(200)->getContent();
       
       $tokenData=json_decode($tokenContent, true);
       $token=$tokenData['token'];
       
       $response = $this->json('POST', '/api/sendRideRequest',  ["userid" => 6 ],['Authorization' => "Bearer ".$token]); 
       $response->assertStatus(200);
    }

    /**
     * Test Accept Ride Request by driver
     *
     * @test
     */
    public function AcceptRideRequestTest()
    {
        //get toekn and perform Accept Ride Request 
        $tokenContent = $this->json('POST', '/api/login',  ["email"=> "m.anwaarr@yahoo.com","password"=> "apikey"])->assertStatus(200)->getContent();
       
       $tokenData=json_decode($tokenContent, true);
       $token=$tokenData['token'];
       
       $response = $this->json('POST', '/api/acceptRideRequest',  ["userid" => 6 , "driverid" => 10 ],['Authorization' => "Bearer ".$token]); 
       $response->assertStatus(200);
    }

    /**
     * Test Drop User to Destination
     *
     * @test
     */
    public function DropUserDestinationTest()
    {
        //get toekn and perform drop user to destination Request
        $tokenContent = $this->json('POST', '/api/login',  ["email"=> "m.anwaarr@yahoo.com","password"=> "apikey"])->assertStatus(200)->getContent();
       
       $tokenData=json_decode($tokenContent, true); 
       $token=$tokenData['token'];
       
       $response = $this->json('POST', '/api/dropUserDestination',  ["userid" => 6 , "driverid" => 10 ],['Authorization' => "Bearer ".$token]); 
       $response->assertStatus(200);
    }

    /**
     * Test Get the Ride Status
     *
     * @test
     */
    public function GetRideStatusTest()
    {
        //get toekn and perform Get Ride Status
        $tokenContent = $this->json('POST', '/api/login',  ["email"=> "m.anwaarr@yahoo.com","password"=> "apikey"])->assertStatus(200)->getContent();
       
       $tokenData=json_decode($tokenContent, true); 
       $token=$tokenData['token'];
       
       $userid=6;
       $response = $this->json('GET', '/api/getRideStatus?userid= '.$userid,  [],['Authorization' => "Bearer ".$token]); 
       $response->assertStatus(200);
    }
}

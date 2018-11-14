<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller {

	/**
	 * [Perform authentication of user with email and password]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function authenticate(Request $request) {
		$credentials = $request->only('email', 'password');

		try {
			if (!$token = JWTAuth::attempt($credentials)) {
				return response()->json(['error' => 'invalid_credentials'], 400);
			}
		} catch (JWTException $e) {
			return response()->json(['error' => 'could_not_create_token'], 500);
		}

		return response()->json(compact('token'));
	}

	/**
	 * [register user with name , email amd password]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function register(Request $request) {
		
		$validator = Validator::make($request->all(), [
			'name' => 'required|string|max:255',
			'email' => 'required|string|email|max:255|unique:users',
			'password' => 'required|string|min:6|confirmed',
		]);

		if ($validator->fails()) {
			return response()->json($validator->errors()->toJson(), 400);
		}

		$user = User::create([
			'name' => $request->get('name'),
			'email' => $request->get('email'),
			'password' => Hash::make($request->get('password')),
		]);

		$token = JWTAuth::fromUser($user);

		return response()->json(compact('user', 'token'), 201);
	}

	/**
	 * [Authiticate user based on token issue , isse during login request]
	 * @return [type] [description]
	 */
	public function getAuthenticatedUser() {
		try {

			if (!$user = JWTAuth::parseToken()->authenticate()) {
				return response()->json(['user_not_found'], 404);
			}

		} catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

			return response()->json(['token_expired'], $e->getStatusCode(), 401);

		} catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

			return response()->json(['token_invalid'], $e->getStatusCode(), 401);

		} catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

			return response()->json(['token_absent'], $e->getStatusCode(), 401);

		}

		return response()->json(compact('user'), 200);
	}

	/**
	 * [logout and destroy jwt token]
	 * @return [type] [description]
	 */
	public function logout() {
		JWTAuth::invalidate();
		return response()->json(['message' => 'logout successfully'], 200);

	}

}
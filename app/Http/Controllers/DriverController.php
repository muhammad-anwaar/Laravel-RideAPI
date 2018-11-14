<?php

namespace App\Http\Controllers;

use App\Drivers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DriverController extends Controller {

	/**
	 * [Driver Registration ]
	 * @param Request $request
	 */
	public function addDriver(Request $request) {

		$validator = Validator::make($request->all(), [
			'name' => 'required|string|max:255',
			'vehiclertype' => 'required|string|max:255',
			'status' => 'required|string|max:255',
		]);

		if ($validator->fails()) {
			return response()->json($validator->errors()->toJson(), 400);
		}

		$driver = Drivers::create([
			'name' => $request->get('name'),
			'vehiclertype' => $request->get('vehiclertype'),
			'status' => $request->get('status'),
		]);

		$response = array('message' => 'Driver information added successfully', 'data' => compact('driver'));

		return response()->json($response, 201);
	}

}
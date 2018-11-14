<?php

namespace App\Http\Controllers;

use App\Drivers;
use App\Ride;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RideController extends Controller {

	/**
	 * [sendRideRequest to available Drivers]
	 * @param  Request $request
	 * @return [list of available Drivers with user ID]
	 */
	public function sendRideRequest(Request $request) {
		//send user request to Available drivers
		$userID = $request->get('userid');
		$validator = Validator::make($request->all(), [
			'userid' => 'required|int',
		]);

		if ($validator->fails()) {
			return response()->json($validator->errors()->toJson(), 400);
		}

		$Drivers = Drivers::all()->where('status', 'Available');
		//Assuming that sending push notification to drivers
		return response()->json(array(array("message" => "Notification Sent To Drivers.", "userID" => $userID, "drivers" => $Drivers)), 200);
	}

	/**
	 * [Accept Ride Request By Driver]
	 * @param  Request $request
	 * @return [After Booking Send the Response]
	 */
	public function acceptRideRequest(Request $request) {
		$userID = $request->get('userid');
		$driverID = $request->get('driverid');

		$validator = Validator::make($request->all(), [
			'userid' => 'required|int',
			'driverid' => 'required|int',
		]);

		if ($validator->fails()) {
			return response()->json($validator->errors()->toJson(), 400);
		}

		if (Ride::where('userid', '=', $userID)->where('driverid', '=', $driverID)->exists()) {

			if (Ride::where('travellingstatus', '=', 'travelling')->exists()) {
				return response()->json(array("message" => "User Travelling with Driver :" . $driverID), 400);
			} else {
				if (Ride::where('travellingstatus', '=', 'Drop')->exists()) {
					$ride = Ride::create([
						'userid' => $userID,
						'driverid' => $driverID,
						'travellingstatus' => 'travelling',
					]);
					return response()->json(array("userid" => $userID, "driverid" => $status));
				}
			}
		} else {
			$ride = Ride::create([
				'userid' => $userID,
				'driverid' => $driverID,
				'travellingstatus' => 'travelling',
			]);
			return response()->json(array("message" => "Ride Booked "), 200);
		}
	}

	/**
	 * [Drop User to Destination ]
	 * @param  Request $request
	 * @return [Return the status of ride completion]
	 */
	public function dropUserDestination(Request $request) {

		$userID = $request->get('userid');
		$driverID = $request->get('driverid');

		$validator = Validator::make($request->all(), [
			'userid' => 'required|int',
			'driverid' => 'required|int',
		]);

		if ($validator->fails()) {
			return response()->json($validator->errors()->toJson(), 400);
		}

		if (Ride::where('userid', '=', $userID)->where('driverid', '=', $driverID)->exists()) {

			if (Ride::where('travellingstatus', '=', 'travelling')->exists()) {
				Ride::where('userid', '=', $userID)
					->where('driverid', '=', $driverID)
					->update(array('travellingstatus' => 'Drop'));
				return response()->json(array("message" => "User Droped on its Destination"), 200);
			} else {
				if (Ride::where('travellingstatus', '=', 'Drop')->exists()) {
					return response()->json(array("message" => "Ride Already Completed"));
				}
			}

		} else {

			return response()->json(array("message" => "No Ride Exist"), 400);
		}

	}

	/**
	 * [Get Ride status of user]
	 * @param  Request $request
	 * @return [User rides status sent in response]
	 */
	public function getRideStatus(Request $request) {

		$userID = $request->get('userid');

		$validator = Validator::make($request->all(), [
			'userid' => 'required|int',
		]);

		if ($validator->fails()) {
			return response()->json($validator->errors()->toJson(), 400);
		}

		$userRides = Ride::where('userid', '=', $userID)->get();
		return response()->json($userRides);
	}

}
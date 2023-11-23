<?php

namespace App\Http\Controllers\Api\Admin\Drivers;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DriversController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */

    /**
     * All Drivers
     *
     * Check that the Drivers is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be List of all Drivers added!.
     *
     */

    public function index()
    {
        //Get a list of users with driver role
        $drivers = User::whereHas("roles", function($q){ $q->where("name", "Drivers Role"); })->get();
        $driversArray = [];
        foreach ($drivers as $driver) {
            $driversArray[] = [
                "id" => $driver->id,
                "name" => $driver->name,
                "email" => $driver->email,
            ];
        }
        return $driversArray;
    }

    public function allDrivers()
    {
        $drivers = User::with('userProfile')->where('user_type', 5)->get();
        $drivers = UserResource::collection($drivers);
        return response()->json([
            'success' => true,
            'data' => $drivers,
        ],200, ['Content-Type' => 'application/json; charset=UTF-8',
            'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */

    /**
     * Add Driver
     *
     * Check that the Add New Driver is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Driver added with success message!.
     *
     */

    public function store(Request $request)
    {
       //
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonResponse
     */

    /**
     *
     * Show Driver
     *
     * Check that the Show Invoice is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Driver object for a specific id!.
     *
     */

    public function show(Request $request)
    {
        $drivers = User::with('userProfile')->where('user_type', 5)->where('id', $request->id)->first();
        $driver = new UserResource($drivers);
        return response()->json([
            'success' => true,
            'data' => $driver,
        ],200, ['Content-Type' => 'application/json; charset=UTF-8',
            'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */

    /**
     *
     * Update Driver
     *
     * Check that the Update Driver is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be Driver updated with success message!.
     *
     */

    public function update(Request $request, $id)
    {
       //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse|void
     *
     */

    /**
     *
     * Delete Driver
     *
     * Check that the Delete Driver is working.If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with an error, and a response listing the validation errors.
     *
     * @responseField The response of API will be a success message!.
     *
     */

    public function destroy($id)
    {
        //
    }
}

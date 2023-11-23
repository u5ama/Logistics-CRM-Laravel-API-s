<?php

namespace App\Http\Controllers\Api\Assignar;

use App\Http\Controllers\Controller;
use App\Models\Assets;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AssignarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     *
     * @throws GuzzleException
     */
    public function getAssets()
    {
        $accessToken = env("ASSIGNAR_TOKEN");
        try {
            $headers = [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$accessToken
            ];
            $client = new \GuzzleHttp\Client([
                'headers' => $headers
            ]);

            $request = $client->get('https://api.assignar.com.au/v2/assets');
//            $request = $client->get('https://api.assignar.com.au/v2/suppliers');

            $contents = json_decode($request->getBody()->getContents());
            foreach ($contents->data as $key => $datum) {
                $asset = new Assets();
                $asset->name = $datum->name;
                $asset->description = $datum->description;
                $asset->rego_number = $datum->rego_number;
                $asset->year = $datum->year;
                $asset->model = $datum->model;
                $asset->make = $datum->make;
                $asset->serial_number = $datum->serial_number;
                $asset->avg_hourly_rate = $datum->charge_rate;
                $asset->current_number_reading = $datum->number_reading;
                $asset->external_id = $datum->external_id;
                $asset->save();
            }
        }
        catch (\Exception $e)
        {
            $message = $e->getMessage();
            $error = ['field'=>'assignar_assets','message'=>$message];
            $errors =[$error];
            return response()->json(['errors' => $errors], 500);
        }
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
     * @return void
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return void
     *
     */
    public function show(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return void
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return void
     */
    public function destroy($id)
    {
        //
    }
}

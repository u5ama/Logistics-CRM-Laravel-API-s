<?php

namespace App\Http\Controllers\Api\Admin\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Resources\DriverDailyChecklistResource;
use App\Models\Assets;
use App\Models\DriverDailyChecklist;
use App\Models\Jobs;
use App\Models\Tags;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws GuzzleException
     */
    public function index(Request $request)
    {
        $weather = [];
        $disabledEnvironments = ['local', 'development'];

        // Disable weather data retrieval for local and development environments
        if (in_array(env('APP_ENV'), $disabledEnvironments)) {
            return response()->json([
                'success' => true,
                'data' => $weather
            ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }

        $melbourneWeather = $this->getWeatherData('Melbourne');

        // Extract weather data for each forecast day
        foreach ($melbourneWeather['forecast']['forecastday'] as $forecast) {
            $weather[] = [
                "date" => date('jS', strtotime($forecast['date'])),
                "day" => date('l', strtotime($forecast['date'])),
                "avg_temp" => $forecast['day']['avgtemp_c'],
                "min_temp" => $forecast['day']['mintemp_c'],
                "max_temp" => $forecast['day']['maxtemp_c'],
                "condition" => $forecast['day']['condition']['text']
            ];
        }

        return response()->json([
            'success' => true,
            "data" => $weather
        ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
            'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Retrieve weather data for a specific city.
     *
     * @param string $city
     * @param int $days
     * @return mixed|null
     * @throws GuzzleException
     */
    private function getWeatherData(string $city, int $days = 7)
    {
        $apiKey = 'c38626d66ec04158a4c235059230304';
        $url = "http://api.weatherapi.com/v1/forecast.json?key={$apiKey}&q={$city}&days={$days}&aqi=no&alerts=no";

        $client = new Client();
        try {
            $response = $client->request('GET', $url);
            $statusCode = $response->getStatusCode();
            if ($statusCode === 200) {
                return json_decode($response->getBody()->getContents(), true);
            } else {
                return null;
            }
        } catch (RequestException $e) {
            return null;
        }
    }

    /**
     * Get dashboard data for assets.
     *
     * @return JsonResponse
     */
    public function getDashboardDataAssets()
    {
        $jobs = Jobs::withCount('asset')->get();

        return response()->json([
            'success' => true,
            "data" => $jobs
        ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
            'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Get assets currently in use.
     *
     * @return JsonResponse
     */
    public function getDashboardAssetsInUse()
    {
        try {
            $assets = [];
            $jobs = Jobs::with('asset')->get();

            if (count($jobs) > 0) {
                foreach ($jobs as $job) {
                    foreach ($job->asset as $asset) {
                        $a = Assets::with('tag')->where('id', $asset->asset_id)->first();
                        $a->start_date = $job->start_date;
                        $a->end_date = $job->end_date;
                        $tt = [];

                        if (count($a->tag) > 0) {
                            foreach ($a->tag as $tag) {
                                $t = Tags::where(['id' => $tag->tag_id, 'tag_type' => 'asset'])->first();
                                if ($t) {
                                    $tt[]['tag_name'] = $t->name;
                                }
                            }
                            $a->tags = $tt;
                            $assets[] = $a;
                        }
                    }
                }

                return response()->json([
                    'success' => true,
                    "data" => $assets
                ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $error = ['field' => 'dashboard_asset_in_use', 'message' => $message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }

    /**
     * Get dashboard data for safety officers.
     *
     * @return JsonResponse
     */
    public function getSafetyOfficerDash()
    {
        try {
            $data = [];

            // Count of driver daily checklists created in the last day, two days, and week
            $day = DriverDailyChecklist::where("created_at", ">", Carbon::now()->subDay(1))->count();
            $twoDay = DriverDailyChecklist::where("created_at", ">", Carbon::now()->subDay(2))->count();
            $week = DriverDailyChecklist::where("created_at", ">", Carbon::now()->subDay(7))->count();

            // Retrieve driver daily checklists with related models
            $checklists = DriverDailyChecklist::with('checklist', 'driver', 'job')->get();
            $checklists = DriverDailyChecklistResource::collection($checklists);

            $data['checklists'] = $checklists;
            $data['day'] = $day;
            $data['twoDay'] = $twoDay;
            $data['week'] = $week;

            return response()->json([
                'success' => true,
                "data" => $data
            ], 200, ['Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $error = ['field' => 'dashboard_safety_officer', 'message' => $message];
            $errors = [$error];
            return response()->json(['errors' => $errors], 500);
        }
    }
}

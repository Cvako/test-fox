<?php

namespace App\Http\Controllers;

use App;
use App\Models\Country;
use App\Models\Genre;
use App\Models\Language;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // Site Settings
        $site_settings = DB::table('settings')->get();

        foreach ($site_settings as $setting) {
            $setting_name = $setting->name;
            $this->settings[$setting->name] = $setting->value;
        }

        // Pass data to views
        View::share(['settings' => $this->settings]);
    }

    /** Index */
    public function index()
    {
        // Retrieve data from the API using GuzzleHTTP
        $client = new Client();
        $response = $client->request('GET', 'http://'.$this->settings['api_source'].'.api.radio-browser.info/json/countries/?order=stationcount&reverse=true');

        // Convert the JSON response to an array
        $countries = json_decode($response->getBody(), true);

        // Return view
        return view('adminlte::api.index', compact('countries'));
    }

    /** Country */
    public function country(Request $request)
    {
        $code = request()->code;

        // Retrieve data from the API using GuzzleHTTP
        $client = new Client();
        $response = $client->request('GET', 'http://'.$this->settings['api_source'].'.api.radio-browser.info/json/countrycodes/' . $code . '?hidebroken=true');

        // Convert the JSON response to an array
        $stations = json_decode($response->getBody(), true);

        $total_stations = $stations[0]['stationcount'];

        $per_page = 25;
        $page = request()->get('page', 1);

        $offset = ($page - 1) * $per_page;

        $stations = range(1, $total_stations);

        $paginator = new LengthAwarePaginator(
            array_slice($stations, $offset, $per_page),
            $total_stations,
            $per_page,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // Retrieve data from the API using GuzzleHTTP
        $response = $client->request('GET', 'https://'.$this->settings['api_source'].'.api.radio-browser.info/json/stations/search?countrycode=' . $code . '&limit=25&offset=' . $offset . '&hidebroken=true&order=clickcount&reverse=true');

        // Convert the JSON response to an array
        $stations = json_decode($response->getBody(), true);

        // Return view
        return view('adminlte::api.country', compact('stations', 'paginator'));
    }

    /** Create */
    public function create()
    {
        $id = request()->id;

        // Retrieve data from the API using GuzzleHTTP
        $client = new Client();
        $response = $client->request('GET', 'http://'.$this->settings['api_source'].'.api.radio-browser.info/json/stations/byuuid/' . $id);

        // Convert the JSON response to an array
        $station = json_decode($response->getBody(), true);

        // Genres
        $genres = Genre::orderBy('title', 'ASC')->get()->pluck('title', 'id');

        // Countries
        $countries = Country::orderBy('title', 'ASC')->get();

        // Languages
        $languages = Language::orderBy('title', 'ASC')->get();

        // Return view
        return view('adminlte::api.create', compact('station', 'genres', 'countries', 'languages'));
    }

}

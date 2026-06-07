<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Station;
use App\Models\Genre;
use App\Models\Country;
use App\Models\Language;
use App\Models\Page;
use Illuminate\Support\Facades\View;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $site_settings = Setting::get();

        foreach ($site_settings as $setting) {
            $settings[$setting->name] = $setting->value;
        }

        View::share(['settings' => $settings]);
    }

    /** Index */
    public function index()
    {
        $searchquery = request()->post('q');

        $stations = Station::orderBy('id', 'desc')->where('title', 'like', "%$searchquery%")->limit(50)->get();

        $genres = Genre::orderBy('id', 'desc')->where('title', 'like', "%$searchquery%")->limit(50)->get();
        
        $countries = Country::orderBy('id', 'desc')->where('title', 'like', "%$searchquery%")->limit(50)->get();
        
        $languages = Language::orderBy('id', 'desc')->where('title', 'like', "%$searchquery%")->limit(50)->get();
        
        $pages = Page::orderBy('id', 'desc')->where('title', 'like', "%$searchquery%")->limit(50)->get();

        return View::make('adminlte::search.index')->with('stations', $stations)->with('genres', $genres)->with('countries', $countries)->with('languages', $languages)->with('pages', $pages);
    }

    /** Create */
    public function create()
    {
        //
    }

    /** Edit */
    public function edit($id)
    {
        //
    }

    /** Update */
    public function update(Request $request, $id)
    {
        //
    }

    /** Store */
    public function store(Request $request)
    {
        //
    }

    /** Destroy */
    public function destroy($id)
    {
        //
    }

}

<?php
namespace App\Http\Controllers;

use App\Models\Station;
use App\Models\Genre;
use App\Models\Country;
use App\Models\Language;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{

    public function __construct()
    {
        // Site Settings
        $settings = Cache::rememberForever('settings', function () {
            return Setting::get();
        });
        
        foreach ($settings as $setting) {
            $this->settings[$setting->name] = $setting->value;
        }
        
        // Pass data to views
        View::share(['settings' => $this->settings]);
    }

    /** Index */
    public function index()
    {
        // Total stations
        $total_stations = Station::count();

        // Total genres
        $total_genres = Genre::count();

        // Total countries
        $total_countries = Country::count();

        // Total languages
        $total_languages = Language::count();

        // Total pages
        $total_pages = Page::count();

        // Return view
        return response()->view('frontend::sitemap.index', ['total_stations' => $total_stations, 'total_genres' => $total_genres, 'total_countries' => $total_countries, 'total_languages' => $total_languages, 'total_pages' => $total_pages])->header('Content-Type', 'text/xml');
    }

    /** Sitemaps */
    public function sitemap()
    {
        // List of Sitemaps
        $sitemaps = array('stations', 'genres', 'countries', 'languages', 'pages');
        $slug = request()->slug;

        if (!in_array($slug, $sitemaps)) {
            abort(404);
        }

        switch ($slug) {

            /** Stations Sitemap */
            case "stations":

                // List of stations
                $rows = Station::where('status', '1')->latest()->paginate($this->settings['sitemap_records_per_page']);

                // Return view
                return response()->view('frontend::sitemap.stations', ['rows' => $rows])->header('Content-Type', 'text/xml');

                break;

            /** Genres Sitemap */
            case "genres":

                // List of genres
                $rows = Genre::latest()->paginate($this->settings['sitemap_records_per_page']);

                // Return view
                return response()->view('frontend::sitemap.genres', ['rows' => $rows])->header('Content-Type', 'text/xml');

                break;

            /** Countries Sitemap */
            case "countries":

                // List of countries
                $rows = Country::latest()->paginate($this->settings['sitemap_records_per_page']);

                // Return view
                return response()->view('frontend::sitemap.countries', ['rows' => $rows])->header('Content-Type', 'text/xml');

                break;
                
            /** Languages Sitemap */
            case "languages":

                // List of languages
                $rows = Language::latest()->paginate($this->settings['sitemap_records_per_page']);

                // Return view
                return response()->view('frontend::sitemap.languages', ['rows' => $rows])->header('Content-Type', 'text/xml');

                break;

            /** Pages Sitemap */
            case "pages":

                // List of pages
                $rows = Page::latest()->paginate($this->settings['sitemap_records_per_page']);

                // Return view
                return response()->view('frontend::sitemap.pages', ['rows' => $rows])->header('Content-Type', 'text/xml');

                break;
        }
    }

}

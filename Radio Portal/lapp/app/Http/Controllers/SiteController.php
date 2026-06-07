<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Country;
use App\Models\Genre;
use App\Models\Language;
use App\Models\Comment;
use App\Models\Page;
use App\Models\Report;
use App\Models\Setting;
use App\Models\Station;
use App\Models\Vote;
use App\Models\FAQ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use MetaTag;
use Response;
use Validator;

class SiteController extends Controller
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

        // Ads
        $ad_places = Cache::rememberForever('ad_places', function () {
            return Ad::get();
        });

        foreach ($ad_places as $ads) {
            $ad[$ads->id] = $ads->code;
        }

        // Footer Array
        $footer_array = Cache::rememberForever('footer_array', function () {

            $footer_pages = Page::select('id', 'slug', 'title')->where('footer', '1')->orderBy('sort', 'ASC')->get();

            $page_array = [];
            foreach ($footer_pages as $page) {
                array_push($page_array, [$page->title, $page->slug]);
            }

            $footer_countries = Country::select('id', 'slug', 'title')->where('footer', '1')->orderBy('sort', 'ASC')->get();

            $country_array = [];
            foreach ($footer_countries as $country) {
                array_push($country_array, [$country->title, $country->slug]);
            }

            $footer_genres = Genre::select('id', 'slug', 'title')->where('footer', '1')->orderBy('sort', 'ASC')->get();

            $genre_array = [];
            foreach ($footer_genres as $genre) {
                array_push($genre_array, [$genre->title, $genre->slug]);
            }

            $footer_array = array("pages" => $page_array, "countries" => $country_array, "genres" => $genre_array);

            return $footer_array;
        });

        // Left Column Array
        $left_array = Cache::rememberForever('left_array', function () {

            $languages = Language::select('id', 'slug', 'title')->where('left_column', '1')->orderBy('sort', 'ASC')->get();

            $language_array = [];
            foreach ($languages as $language) {
                array_push($language_array, [$language->title, $language->slug, count($language->stations)]);
            }

            $countries = Country::select('id', 'slug', 'title')->where('left_column', '1')->orderBy('sort', 'ASC')->get();

            $country_array = [];
            foreach ($countries as $country) {
                array_push($country_array, [$country->title, $country->slug, count($country->stations)]);
            }

            $genres = Genre::select('id', 'slug', 'title')->where('left_column', '1')->orderBy('sort', 'ASC')->get();

            $genre_array = [];
            foreach ($genres as $genre) {
                array_push($genre_array, [$genre->title, $genre->slug, count($genre->stations)]);
            }

            $left_array = array("languages" => $language_array, "countries" => $country_array, "genres" => $genre_array);

            return $left_array;
        });

        // Pass data to views
        View::share(['settings' => $this->settings, 'ad' => $ad, 'footer_array' => $footer_array, 'left_array' => $left_array]);
    }

    /** Index */
    public function index()
    {
        // Index Array
        $index_array = Cache::rememberForever('index_array', function () {

            $stations = Station::select('id', 'slug', 'title', 'image')->where('home_page', '1')->where('status', '1')->orderBy('sort', 'ASC')->get();

            $station_array = [];
            foreach ($stations as $station) {
                array_push($station_array, [$station->title, $station->slug, $station->image]);
            }

            $home_genres = Genre::select('id', 'slug', 'title', 'image')->where('home_page', '1')->orderBy('sort_home', 'ASC')->get();

            $genre_array = [];
            foreach ($home_genres as $genre) {
                array_push($genre_array, [$genre->title, $genre->slug, $genre->image]);
            }

            $index_array = array("stations" => $station_array, "genres" => $genre_array);

            return $index_array;
        });

        // Default Title Format
        if ($this->settings['home_page_title_format'] == null) {
            $this->settings['home_page_title_format'] = '%site_title%';
        }

        // Default Description Format
        if ($this->settings['home_page_description_format'] == null) {
            $this->settings['home_page_description_format'] = $this->settings['site_description'];
        }

        // Default H1 Format
        if ($this->settings['home_page_h1_format'] == null) {
            $this->settings['home_page_h1_format'] = __('general.featured_radio_stations');
        }

        $title = title_format($this->settings['site_title'], $this->settings['home_page_title_format']);
        $description = title_format($this->settings['site_title'], $this->settings['home_page_description_format']);
        $h1_title = title_format($this->settings['site_title'], $this->settings['home_page_h1_format']);

        // Meta tags
        meta_tags($title, $description, $this->settings['twitter_account'], asset('images/default_share_image.png'), 600, 315, 'website');

        // Return view
        return view('frontend::home')->with('index_array', $index_array)->with('h1_title', $h1_title);
    }

    /** Station */
    public function station()
    {
        $slug = request()->slug;

        $station = Station::where('slug', $slug)->where('status', '1')->first();

        // Return 404 page if query is empty
        $station == null ? abort(404) : '';

        $share_image = $station->image;

        // Use default image if image is not uploaded
        empty($station->image) ? $share_image = 'no_image.png' : '';

        // Default Title Format
        if ($this->settings['station_title_format'] == null) {
            $this->settings['station_title_format'] = '%station_title% %sep% %site_title%';
        }

        // Default Description Format
        if ($this->settings['station_description_format'] == null) {
            $this->settings['station_description_format'] = $this->settings['site_description'];
        }

        // Default H1 Format
        if ($this->settings['station_h1_format'] == null) {
            $this->settings['station_h1_format'] = '%station_title%';
        }

        // Genres List for Custom Meta Tags
        $meta_genres = '';
        foreach ($station->genres as $key => $genre) {
            if ($key != 0) {$meta_genres .= ', ';}
            $meta_genres .= $genre->title;
        }

        // Country List for Custom Meta Tags
        $meta_countries = '';
        foreach ($station->countries as $key => $country) {
            if ($key != 0) {$meta_countries .= ', ';}
            $meta_countries .= $country->title;
        }

        // Language List for Custom Meta Tags
        $meta_languages = '';
        foreach ($station->languages as $key => $language) {
            if ($key != 0) {$meta_languages .= ', ';}
            $meta_languages .= $language->title;
        }

        $station_title = title_format($this->settings['site_title'], $this->settings['station_title_format'], $station->title, $meta_genres, $meta_countries, $meta_languages);
        $station_description = title_format($this->settings['site_title'], $this->settings['station_description_format'], $station->title, $meta_genres, $meta_countries, $meta_languages);
        $h1_title = title_format($this->settings['site_title'], $this->settings['station_h1_format'], $station->title, $meta_genres, $meta_countries, $meta_languages);

        if ($station->custom_title != null) {
            $station_title = title_format($this->settings['site_title'], $station->custom_title, $station->title, $meta_genres, $meta_countries, $meta_languages);
        }

        if ($station->custom_description != null) {
            $station_description = title_format($this->settings['site_title'], $station->custom_description, $station->title, $meta_genres, $meta_countries, $meta_languages);
        }

        if ($station->description != null) {
            $station->description = title_format($this->settings['site_title'], $station->description, $station->title, $meta_genres, $meta_countries, $meta_languages);
        } else {
            $station->description = title_format($this->settings['site_title'], $this->settings['custom_station_description'], $station->title, $meta_genres, $meta_countries, $meta_languages);
        }

        if ($station->custom_h1 != null) {
            $h1_title = title_format($this->settings['site_title'], $station->custom_h1, $station->title, $meta_genres, $meta_countries, $meta_languages);
        }

        // Meta tags
        meta_tags($station_title, $station_description, $this->settings['twitter_account'], asset('images/stations/' . $share_image), 300, 300, '');

        // Similar Radio Stations
        $post_categories = $station->genres->pluck('id');

        $similar_stations = Station::whereHas('genres', function ($query) use ($post_categories) {
            $query->whereIn('genre_station.genre_id', $post_categories);
        })->where('id', '!=', $station->id)->where('status', '1')->limit(24)->get();

        // Increase page views
        Station::where('id', $station->id)->increment('page_views');

        // List of comments
        $comments = Comment::where('content_id', $station->id)->where('approval', 1)->orderBy('id', 'desc')->get();

        // Return view
        return view('frontend::station')->with('station', $station)->with('similar_stations', $similar_stations)->with('report_reasons', report_reasons())->with('h1_title', $h1_title)->with('comments', $comments);
    }

    /** Genre */
    public function genre()
    {
        $slug = request()->slug;

        $genre = Genre::where('slug', $slug)->first();

        // Return 404 page if query is empty
        $genre == null ? abort(404) : '';

        $share_image = $genre->image;

        // Use default image if image is not uploaded
        empty($genre->image) ? $share_image = 'no_image.png' : '';

        // Default Genre Title Format
        if ($this->settings['genres_title_format'] == null) {
            $this->settings['genres_title_format'] = '%genre_title% %sep% %site_title%';
        }

        // Default Description Format
        if ($this->settings['genres_description_format'] == null) {
            $this->settings['genres_description_format'] = $this->settings['site_description'];
        }

        // Default H1 Format
        if ($this->settings['genres_h1_format'] == null) {
            $this->settings['genres_h1_format'] = '%genre_title%';
        }

        $genre_title = title_format($this->settings['site_title'], $this->settings['genres_title_format'], null, null, null, null, $genre->title);
        $genre_description = title_format($this->settings['site_title'], $this->settings['genres_description_format'], null, null, null, null, $genre->title);
        $h1_title = title_format($this->settings['site_title'], $this->settings['genres_h1_format'], null, null, null, null, $genre->title);

        if ($genre->custom_title != null) {
            $genre_title = title_format($this->settings['site_title'], $genre->custom_title, null, null, null, null, $genre->title);
        }

        if ($genre->custom_description != null) {
            $genre_description = title_format($this->settings['site_title'], $genre->custom_description, null, null, null, null, $genre->title);
        }

        if ($genre->custom_h1 != null) {
            $h1_title = title_format($this->settings['site_title'], $genre->custom_h1, null, null, null, null, $genre->title);
        }

        // Meta tags
        meta_tags($genre_title, $genre_description, $this->settings['twitter_account'], asset('images/genres/' . $share_image), 516, 258, '');

        $page = request()->has('page') ? request()->get('page') : 1;

        $stations = Cache::rememberForever("stations-$slug-$page", function () use ($genre) {
            return Genre::find($genre->id)->stations()->where('status', '1')->orderBy('id', 'DESC')->paginate($this->settings['records_per_page']);
        });

        /*
        Return 404 page if query is empty
        The system will not return 404 page on the first page, it will display a warning message
         */
        $stations->isEmpty() && $page > '1' ? abort(404) : '';

        // Return view
        return view('frontend::genre')->with('genre', $genre)->with('stations', $stations)->with('h1_title', $h1_title);
    }

    /** Country */
    public function country()
    {
        $slug = request()->slug;

        $country = Country::where('slug', $slug)->first();

        // Return 404 page if query is empty
        $country == null ? abort(404) : '';

        // Default Title Format
        if ($this->settings['countries_title_format'] == null) {
            $this->settings['countries_title_format'] = '%country_title% %sep% %site_title%';
        }

        // Default Description Format
        if ($this->settings['countries_description_format'] == null) {
            $this->settings['countries_description_format'] = $this->settings['site_description'];
        }

        // Default H1 Format
        if ($this->settings['countries_h1_format'] == null) {
            $this->settings['countries_h1_format'] = '%country_title%';
        }

        $country_title = title_format($this->settings['site_title'], $this->settings['countries_title_format'], null, null, null, null, null, $country->title);
        $country_description = title_format($this->settings['site_title'], $this->settings['countries_description_format'], null, null, null, null, null, $country->title);
        $h1_title = title_format($this->settings['site_title'], $this->settings['countries_h1_format'], null, null, null, null, null, $country->title);

        if ($country->custom_title != null) {
            $country_title = title_format($this->settings['site_title'], $country->custom_title, null, null, null, null, null, $country->title);
        }

        if ($country->custom_description != null) {
            $country_description = title_format($this->settings['site_title'], $country->custom_description, null, null, null, null, null, $country->title);
        }

        if ($country->custom_h1 != null) {
            $h1_title = title_format($this->settings['site_title'], $country->custom_h1, null, null, null, null, null, $country->title);
        }

        // Meta tags
        meta_tags($country_title, $country_description, $this->settings['twitter_account'], asset('images/default_share_image.png'), 600, 315, '');

        $page = request()->has('page') ? request()->get('page') : 1;

        $stations = Cache::rememberForever("countries-$slug-$page", function () use ($country) {
            return Country::find($country->id)->stations()->where('status', '1')->orderBy('id', 'DESC')->paginate($this->settings['records_per_page']);
        });

        /*
        Return 404 page if query is empty
        The system will not return 404 page on the first page, it will display a warning message
         */
        $stations->isEmpty() && $page > '1' ? abort(404) : '';

        // Return view
        return view('frontend::country')->with('country', $country)->with('stations', $stations)->with('h1_title', $h1_title);
    }

    /** Language */
    public function language()
    {
        $slug = request()->slug;

        $language = Language::where('slug', $slug)->first();

        // Return 404 page if query is empty
        $language == null ? abort(404) : '';

        // Default Title Format
        if ($this->settings['languages_title_format'] == null) {
            $this->settings['languages_title_format'] = '%language_title% %sep% %site_title%';
        }

        // Default Description Format
        if ($this->settings['languages_description_format'] == null) {
            $this->settings['languages_description_format'] = $this->settings['site_description'];
        }

        // Default H1 Format
        if ($this->settings['languages_h1_format'] == null) {
            $this->settings['languages_h1_format'] = '%language_title%';
        }

        $language_title = title_format($this->settings['site_title'], $this->settings['languages_title_format'], null, null, null, null, null, null, $language->title);
        $language_description = title_format($this->settings['site_title'], $this->settings['languages_description_format'], null, null, null, null, null, null, $language->title);
        $h1_title = title_format($this->settings['site_title'], $this->settings['languages_h1_format'], null, null, null, null, null, null, $language->title);

        if ($language->custom_title != null) {
            $language_title = title_format($this->settings['site_title'], $language->custom_title, null, null, null, null, null, null, $language->title);
        }

        if ($language->custom_description != null) {
            $language_description = title_format($this->settings['site_title'], $language->custom_description, null, null, null, null, null, null, $language->title);
        }

        if ($language->custom_h1 != null) {
            $h1_title = title_format($this->settings['site_title'], $language->custom_h1, null, null, null, null, null, null, $language->title);
        }

        // Meta tags
        meta_tags($language_title, $language_description, $this->settings['twitter_account'], asset('images/default_share_image.png'), 600, 315, '');

        $page = request()->has('page') ? request()->get('page') : 1;

        $stations = Cache::rememberForever("languages-$slug-$page", function () use ($language) {
            return Language::find($language->id)->stations()->where('status', '1')->orderBy('id', 'DESC')->paginate($this->settings['records_per_page']);
        });

        /*
        Return 404 page if query is empty
        The system will not return 404 page on the first page, it will display a warning message
         */
        $stations->isEmpty() && $page > '1' ? abort(404) : '';

        // Return view
        return view('frontend::language')->with('language', $language)->with('stations', $stations)->with('h1_title', $h1_title);
    }

    /** Custom Pages */
    public function page()
    {
        $slug = request()->slug;

        // Page query
        $page = Page::where('slug', $slug)->first();

        // Return 404 page if page not found
        $page == null ? abort(404) : '';

        // Default Title Format
        if ($this->settings['page_title_format'] == null) {
            $this->settings['page_title_format'] = '%page_title% %sep% %site_title%';
        }

        // Default Description Format
        if ($this->settings['page_description_format'] == null) {
            $this->settings['page_description_format'] = $this->settings['site_description'];
        }

        // Default H1 Format
        if ($this->settings['page_h1_format'] == null) {
            $this->settings['page_h1_format'] = '%page_title%';
        }

        $page_title = title_format($this->settings['site_title'], $this->settings['page_title_format'], null, null, null, null, null, null, null, $page->title);
        $page_description = title_format($this->settings['site_title'], $this->settings['page_description_format'], null, null, null, null, null, null, null, $page->title);
        $h1_title = title_format($this->settings['site_title'], $this->settings['page_h1_format'], null, null, null, null, null, null, null, $page->title);

        if ($page->custom_title != null) {
            $page_title = title_format($this->settings['site_title'], $page->custom_title, null, null, null, null, null, null, null, $page->title);
        }

        if ($page->custom_description != null) {
            $page_description = title_format($this->settings['site_title'], $page->custom_description, null, null, null, null, null, null, null, $page->title);
        }

        if ($page->custom_h1 != null) {
            $h1_title = title_format($this->settings['site_title'], $page->custom_h1, null, null, null, null, null, null, null, $page->title);
        }

        // Meta tags
        meta_tags($page_title, $page_description, $this->settings['twitter_account'], asset('images/default_share_image.png'), 600, 315, '');

        Page::where('id', $page->id)->increment('page_views');

        // Return view
        return view('frontend::custom_page')->with('page', $page)->with('h1_title', $h1_title);
    }

    /** Browse Genres */
    public function genres()
    {
        // Default Page Title Format
        if ($this->settings['browse_genres_title'] == null) {
            $this->settings['browse_genres_title'] = __('general.browse_genres') . ' %sep% %site_title%';
        }

        // Default Description Format
        if ($this->settings['browse_genres_description'] == null) {
            $this->settings['browse_genres_description'] = $this->settings['site_description'];
        }

        // Default H1 Format
        if ($this->settings['browse_genres_h1_title'] == null) {
            $this->settings['browse_genres_h1_title'] = __('general.browse_genres');
        }

        $title = title_format($this->settings['site_title'], $this->settings['browse_genres_title']);
        $description = title_format($this->settings['site_title'], $this->settings['browse_genres_description']);
        $h1_title = title_format($this->settings['site_title'], $this->settings['browse_genres_h1_title']);

        // Meta tags
        meta_tags($title, $description, $this->settings['twitter_account'], asset('images/default_share_image.png'), 600, 315, '');

        // Genres
        $rows = Genre::orderByRaw("CASE WHEN title REGEXP '^[0-9]' THEN 2 ELSE 1 END,title")->get();

        // Return view
        return view('frontend::browse')->with('rows', $rows)->with('section_base', $this->settings['genre_base'])->with('section_title', $h1_title);
    }

    /** Browse Countries */
    public function countries()
    {
        // Default Page Title Format
        if ($this->settings['browse_countries_title'] == null) {
            $this->settings['browse_countries_title'] = __('general.browse_countries') . ' %sep% %site_title%';
        }

        // Default Description Format
        if ($this->settings['browse_countries_description'] == null) {
            $this->settings['browse_countries_description'] = $this->settings['site_description'];
        }

        // Default H1 Format
        if ($this->settings['browse_countries_h1_title'] == null) {
            $this->settings['browse_countries_h1_title'] = __('general.browse_countries');
        }

        $title = title_format($this->settings['site_title'], $this->settings['browse_countries_title']);
        $description = title_format($this->settings['site_title'], $this->settings['browse_countries_description']);
        $h1_title = title_format($this->settings['site_title'], $this->settings['browse_countries_h1_title']);

        // Meta tags
        meta_tags($title, $description, $this->settings['twitter_account'], asset('images/default_share_image.png'), 600, 315, '');

        // Countries
        $rows = Country::orderBy('title', 'ASC')->get();

        // Return view
        return view('frontend::browse')->with('rows', $rows)->with('section_base', $this->settings['country_base'])->with('section_title', $h1_title);
    }

    /** Browse Languages */
    public function languages()
    {
        // Default Title Format
        if ($this->settings['browse_languages_title'] == null) {
            $this->settings['browse_languages_title'] = __('general.browse_languages') . ' %sep% %site_title%';
        }

        // Default Description Format
        if ($this->settings['browse_languages_description'] == null) {
            $this->settings['browse_languages_description'] = $this->settings['site_description'];
        }

        // Default H1 Format
        if ($this->settings['browse_languges_h1_title'] == null) {
            $this->settings['browse_languges_h1_title'] = __('general.browse_languages');
        }

        $title = title_format($this->settings['site_title'], $this->settings['browse_languages_title']);
        $description = title_format($this->settings['site_title'], $this->settings['browse_languages_description']);
        $h1_title = title_format($this->settings['site_title'], $this->settings['browse_languges_h1_title']);

        // Meta tags
        meta_tags($title, $description, $this->settings['twitter_account'], asset('images/default_share_image.png'), 600, 315, '');

        // Languages
        $rows = Language::orderBy('title', 'ASC')->get();

        // Return view
        return view('frontend::browse')->with('rows', $rows)->with('section_base', $this->settings['language_base'])->with('section_title', $h1_title);
    }

    /** Listen History */
    public function history()
    {
        // Default Page Title Format
        if ($this->settings['listen_history_title'] == null) {
            $this->settings['listen_history_title'] = __('general.listen_history') . ' %sep% %site_title%';
        }

        // Default Description Format
        if ($this->settings['listen_history_description'] == null) {
            $this->settings['listen_history_description'] = $this->settings['site_description'];
        }

        // Default H1 Format
        if ($this->settings['listen_history_h1_title'] == null) {
            $this->settings['listen_history_h1_title'] = __('general.listen_history');
        }

        $title = title_format($this->settings['site_title'], $this->settings['listen_history_title']);
        $description = title_format($this->settings['site_title'], $this->settings['listen_history_description']);
        $h1_title = title_format($this->settings['site_title'], $this->settings['listen_history_h1_title']);

        // Meta tags
        meta_tags($title, $description, $this->settings['twitter_account'], asset('images/default_share_image.png'), 600, 315, '');

        if ($this->settings['no_index_history'] == '1') {
            MetaTag::setTags([
                'robots' => 'noindex',
            ]);
        }

        // Return view
        return view('frontend::history')->with('h1_title', $h1_title);
    }

    /** Favorites */
    public function favorites()
    {
        // Default Page Title Format
        if ($this->settings['favorites_title'] == null) {
            $this->settings['favorites_title'] = __('general.favorites') . ' %sep% %site_title%';
        }

        // Default Description Format
        if ($this->settings['favorites_description'] == null) {
            $this->settings['favorites_description'] = $this->settings['site_description'];
        }

        // Default H1 Format
        if ($this->settings['favorites_h1_title'] == null) {
            $this->settings['favorites_h1_title'] = __('general.favorites');
        }

        $title = title_format($this->settings['site_title'], $this->settings['favorites_title']);
        $description = title_format($this->settings['site_title'], $this->settings['favorites_description']);
        $h1_title = title_format($this->settings['site_title'], $this->settings['favorites_h1_title']);

        // Meta tags
        meta_tags($title, $description, $this->settings['twitter_account'], asset('images/default_share_image.png'), 600, 315, '');

        if ($this->settings['no_index_favorites'] == '1') {
            MetaTag::setTags([
                'robots' => 'noindex',
            ]);
        }

        // Return view
        return view('frontend::favorites')->with('h1_title', $h1_title);
    }

    /** Contact Page */
    public function contact()
    {
     // Default Page Title Format
        if ($this->settings['contact_title'] == null) {
            $this->settings['contact_title'] = __('general.contact') . ' %sep% %site_title%';
        }

        // Default Description Format
        if ($this->settings['contact_description'] == null) {
            $this->settings['contact_description'] = $this->settings['site_description'];
        }

        // Default H1 Format
        if ($this->settings['contact_h1_title'] == null) {
            $this->settings['contact_h1_title'] = __('general.contact');
        }

        $title = title_format($this->settings['site_title'], $this->settings['contact_title']);
        $description = title_format($this->settings['site_title'], $this->settings['contact_description']);
        $h1_title = title_format($this->settings['site_title'], $this->settings['contact_h1_title']);

        // Meta tags
        meta_tags($title, $description, $this->settings['twitter_account'], asset('images/default_share_image.png'), 600, 315, '');

        // Return view
        return view('frontend::contact')->with('h1_title', $h1_title);
    }

    /** FAQ */
    public function faq()
    {
        // Check if FAQ is enabled
        if ($this->settings['enable_faq'] != '1') {
            abort(404);
        }
        
       // Default Page Title Format
        if ($this->settings['faq_title'] == null) {
            $this->settings['faq_title'] = __('general.faq') . ' %sep% %site_title%';
        }

        // Default Description Format
        if ($this->settings['faq_description'] == null) {
            $this->settings['faq_description'] = $this->settings['site_description'];
        }

        // Default H1 Format
        if ($this->settings['faq_h1_title'] == null) {
            $this->settings['faq_h1_title'] = __('general.faq');
        }

        $title = title_format($this->settings['site_title'], $this->settings['faq_title']);
        $description = title_format($this->settings['site_title'], $this->settings['faq_description']);
        $h1_title = title_format($this->settings['site_title'], $this->settings['faq_h1_title']);

        // Meta tags
        meta_tags($title, $description, $this->settings['twitter_account'], asset('images/default_share_image.png'), 600, 315, '');

        $faqs = FAQ::orderBy('sort', 'ASC')->get();

        // Return view
        return view('frontend::faq')->with('h1_title', $h1_title)->with('faqs', $faqs);
    }

    /** Random Link */
    public function random()
    {
        // Grab a random link
        $random_station = Station::where('status', '1')->inRandomOrder()->first();

        // Redirect to home page if there are no stations on the site
        if ($random_station == null) {
            return redirect('/');
        }

        // Redirect to link
        return redirect($this->settings['station_base'] . '/' . $random_station->slug);
    }

    /** Search */
    public function search()
    {
        $search_query = request()->post('term');

        $char_count = strlen($search_query);

        // Meta tags
        MetaTag::setTags([
            'title' => 'Search' . ' › ' . $this->settings['site_title'],
            'robots' => 'noindex',
        ]);

        $stations = collect(new Station);

        // Return a warning message if the search text is less than or equal to 2 characters
        if ($char_count <= 2) {
            return view('frontend::search')->withErrors(['msg', 'The Message'])->with('stations', $stations)->with('search_query', $search_query);
        }

        // Search query
        $stations = Station::where('title', 'like', "%{$search_query}%")->where('status', '1')->orderBy('id', 'DESC')->limit(33)->get();

        // Return view
        return view('frontend::search')->with('stations', $stations)->with('search_query', $search_query);
    }
    
  /** Radio Submission */
    public function submission()
    {
        // Check if submission form is enabled
        if ($this->settings['radio_submission'] != '1') {
            abort(404);
        }

        // Default Page Title Format
        if ($this->settings['submission_title'] == null) {
            $this->settings['submission_title'] = __('general.submit_radio') . ' %sep% %site_title%';
        }

        // Default Description Format
        if ($this->settings['submission_description'] == null) {
            $this->settings['submission_description'] = $this->settings['site_description'];
        }

        // Default H1 Format
        if ($this->settings['submission_h1_title'] == null) {
            $this->settings['submission_h1_title'] = __('general.submit_radio');
        }

        $title = title_format($this->settings['site_title'], $this->settings['submission_title']);
        $description = title_format($this->settings['site_title'], $this->settings['submission_description']);
        $h1_title = title_format($this->settings['site_title'], $this->settings['submission_h1_title']);

        // Meta tags
        meta_tags($title, $description, $this->settings['twitter_account'], asset('images/default_share_image.png'), 600, 315, '');

        if ($this->settings['radio_submission'] == '1') {
            MetaTag::setTags([
                'robots' => 'noindex',
            ]);
        }

        // Genres
        $genres = Genre::orderBy('title', 'ASC')->get()->pluck('title', 'id');
        
        // Countries
        $countries = Country::orderBy('title', 'ASC')->get()->pluck('title', 'id');
        
        // Languages
        $languages = Language::orderBy('title', 'ASC')->get()->pluck('title', 'id');

        // Return view
        return view('frontend::submission', compact('h1_title', 'genres', 'countries', 'languages'));
    }

    /** Json Search */
    public function json_search(Request $request)
    {

        $search_term = $request->get('search');

        $rows = Station::where('title', 'like', "%{$search_term}%")->where('status', '1')->orderBy('id', 'desc')->limit(5)->get();

        if ($rows->isEmpty()) {
            $response = array();
        } else {
            foreach ($rows as $row) {
                if (empty($row->image)) {
                    $image_url = asset('/images/stations/no_image.png');
                } else {
                    $image_url = asset('/images/stations/' . $row->image);
                }

                $site_url = asset($this->settings['station_base']) . '/' . $row->slug;

                $response[] = array("value" => $row->id, "title" => $row->title, "url" => $site_url, "image" => $image_url);
            }
        }
        echo json_encode($response);
    }

    /** Cronjob */
    public function cronjob(Request $request)
    {
        $slug = request()->slug;

        // Return 404 page if cronjob code is not correct
        if ($this->settings['cronjob_code'] != $slug) {
            abort(404);
        }

        // Truncate Votes Table
        Vote::query()->truncate();

        // Return Success Message
        return Response::json('success', 200);
    }

    /** Report */
    public function report(Request $request)
    {
        $rules = array(
            'station_id' => 'required',
            'email' => 'required|email',
            'reason' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);

        // Return error response if form validation fails
        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),
            ), 400);

        } else {

            $process = 1;

            if ($this->settings['enable_google_recaptcha'] == '1') {

                // Google reCAPTCHA validation
                $secret = $this->settings['google_recaptcha_secret_key'];
                $recaptcha_data = request()->recaptcha;

                $client = new \GuzzleHttp\Client();
                $response = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
                    'form_params' => [
                        'secret' => $secret,
                        'response' => $recaptcha_data,
                    ],
                ]);

                $response = $response->getBody();

                $responseData = json_decode($response, true);

                if ($responseData['success'] == false) {

                    $process = 0;

                    // If Google reCAPTCHA validation fails, return error response
                    return Response::json(array(
                        'success' => false,
                        'errors' => $responseData['error-codes'],
                    ), 400);
                }
            }

            if ($process == '1') {

                $email = $request->get('email');
                $reason = $request->get('reason');
                $ip_address = $request->ip();
                $admin_email = $this->settings['enable_google_recaptcha'];
                $link = request()->headers->get('referer');

                $client_ip = $request->ip();

                Report::insert(
                    [
                        'station_id' => request()->station_id,
                        'email' => request()->email,
                        'reason' => request()->reason,
                        'ip' => $client_ip,
                        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    ]
                );

                // Return success message
                return '<div class="alert alert-success mt-3 show" role="alert">' . __('general.report_submission_thanks') . '</div>';
            }

        }
    }

}

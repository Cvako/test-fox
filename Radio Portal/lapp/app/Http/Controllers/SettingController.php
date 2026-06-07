<?php
namespace App\Http\Controllers;

use App;
use App\Models\Setting;
use App\Models\Translation;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Intervention\Image\ImageManagerStatic as Image;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // Site Settings
        $site_settings = DB::table('settings')->get();

        foreach ($site_settings as $setting) {
            $this->settings[$setting->name] = $setting->value;
        }

        // Pass data to views
        View::share(['settings' => $this->settings]);
    }

    /** General Settings */
    public function index(Request $request)
    {
        // Generate Cronjob Code
        if ($request->has('cronjob_code')) {
            $rand = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 25)), 0, 25);

            // Update cronjob link
            Setting::where('name', 'cronjob_code')->update(['value' => $rand]);

            // New Cronjob Link
            $new_link = asset('cronjob/' . $rand);

            // Clear cache
            Cache::flush();

            // Redirect to settings page
            return back()->with('success', __('admin.new_link_generated'));
        }

        // Themes
        $themes = DB::table('themes')->pluck('title', 'id');

        // Languages
        $languages = Translation::pluck('language', 'code');

        // API Sources
        $api_sources = array('de1' => 'de1.api.radio-browser.info', 'nl' => 'nl.api.radio-browser.info', 'at1' => 'at1.api.radio-browser.info');

        // Return view
        return view('adminlte::settings.general')->with('themes', $themes)->with('languages', $languages)->with('api_sources', $api_sources);
    }

    // Checkbox Update Function
    public function checkbox_update($box, $box_data)
    {
        if ($box_data == 'on') {
            DB::update("update settings set value = '1' WHERE name = '$box'");
        } else {
            DB::update("update settings set value = '0' WHERE name = '$box'");
        }
    }

    /** General Settings Update */
    public function store(Request $request)
    {
        $this->validate($request, [
            'site_title' => 'required|max:255',
            'site_description' => 'required|max:255',
            'records_per_page' => 'required|numeric',
            'sitemap_records_per_page' => 'required|numeric',
            'cookie_prefix' => 'required|max:15',
            'records_per_page' => 'required|numeric',
            'image_quality' => 'required|integer|between:0,100',
            'facebook_page' => 'nullable|url',
            'telegram_page' => 'nullable|url',
        ]);

        foreach ($request->except(array(
            '_token',
            '_method',
        )) as $key => $value) {

            $value = addslashes($value);

            // Update settings
            DB::update("update settings set value = '$value' WHERE name = '$key'");

            $this->checkbox_update('save_as_webp', $request->get('save_as_webp'));
            $this->checkbox_update('show_cookie_bar', $request->get('show_cookie_bar'));
            $this->checkbox_update('enable_google_recaptcha', $request->get('enable_google_recaptcha'));
            $this->checkbox_update('enable_faq', $request->get('enable_faq'));
            $this->checkbox_update('radio_submission', $request->get('radio_submission'));

            // Upload Site Logo
            if ($request->hasFile('logo')) {
                $image = $request->file('logo');
                $location = public_path('images/logo.png');
                Image::make($image)->save($location);
            }

            // Upload Favicon
            if ($request->hasFile('favicon')) {
                $image = $request->file('favicon');
                $location = public_path('images/favicon.png');
                Image::make($image)->resize(192, 192)->save($location);
            }

            // Upload Default Station Icon
            if ($request->hasFile('station')) {
                $image = $request->file('station');
                $location = public_path('images/stations/no_image.png');
                Image::make($image)->resize(300, 300)->save($location);
            }

            // Upload Default Genre Image
            if ($request->hasFile('genre')) {
                $image = $request->file('genre');
                $location = public_path('images/genres/no_image.png');
                Image::make($image)->resize(516, 258)->save($location);
            }

            // Upload Default Share Image
            if ($request->hasFile('share')) {
                $image = $request->file('share');
                $location = public_path('images/default_share_image.png');
                Image::make($image)->resize(600, 315)->save($location);
            }

        }

        // Clear cache
        Cache::flush();

        // Redirect to settings page
        return redirect(env('ADMIN_URL') . '/general_settings')->with('success', __('admin.content_updated'));
    }

    /** SEO Settings */
    public function seo_settings()
    {
        // Return view
        return view('adminlte::settings.seo');
    }

    /** SEO Settings Update */
    public function seo_settings_update(Request $request)
    {
        $this->validate($request, [
            'station_base' => 'required',
            'genre_base' => 'required',
            'language_base' => 'required',
            'country_base' => 'required',
            'page_base' => 'required',
            'browse_genres_base' => 'required',
            'browse_countries_base' => 'required',
            'browse_languages_base' => 'required',
            'history_base' => 'required',
            'favorites_base' => 'required',
        ]);

        foreach ($request->except(array(
            '_token',
            '_method',
        )) as $key => $value) {

            $value = addslashes($value);

            // Update settings
            DB::update("update settings set value = '$value' WHERE name = '$key'");

            $this->checkbox_update('no_index_history', $request->get('no_index_history'));
            $this->checkbox_update('no_index_favorites', $request->get('no_index_favorites'));
        }

        // Clear cache
        Cache::flush();

        // Redirect to SEO settings page
        return back()->with('success', __('admin.content_updated'));
    }

    /** PWA Settings */
    public function pwa_settings()
    {
        // Return view
        return view('adminlte::settings.pwa');
    }

    /** PWA Settings Update */
    public function pwa_settings_update(Request $request)
    {
        $this->validate($request, [
            'pwa_name' => 'required|max:255',
            'pwa_short_name' => 'required|max:255',
            'pwa_description' => 'required|max:255',
            'pwa_theme_color' => 'required|max:7',
            'pwa_background_color' => 'required|max:7',
        ]);

        foreach ($request->except(array(
            '_token',
            '_method',
        )) as $key => $value) {

            $value = addslashes($value);

            // Update settings
            DB::update("update settings set value = '$value' WHERE name = '$key'");

$manifest_json = '{
  "id": "/",
  "scope": "/",
  "name": "' . $request->get('pwa_name') . '",
  "display": "standalone",
  "start_url": "/",
  "short_name": "' . $request->get('pwa_short_name') . '",
  "theme_color": "' . $request->get('pwa_theme_color') . '",
  "description": "' . $request->get('pwa_description') . '",
  "orientation": "any",
  "background_color": "' . $request->get('pwa_background_color') . '",
  "related_applications": [],
  "prefer_related_applications": false,
  "display_override": ["window-controls-overlay"],
  "icons": [
    {
      "src": "/images/pwa-512x512.png",
      "sizes": "512x512",
      "type": "image/png"
    },
    {
      "src": "/images/pwa-192x192.png",
      "sizes": "192x192",
      "type": "image/png"
    },
    {
      "src": "/images/pwa-48x48.png",
      "sizes": "48x48",
      "type": "image/png"
    },
    {
      "src": "/images/pwa-24x24.png",
      "sizes": "24x24",
      "type": "image/png"
    }
  ],
  "screenshots": [
    {
      "src": "/images/pwa-screenshot.png",
      "sizes": "1080x1910",
      "type": "image/png"
    }
  ],
  "features": [
    "Cross Platform",
    "fast",
    "simple"
  ],
  "categories": [
    "utility"
  ],
  "shortcuts": [
    {
      "name": "Open About",
      "short_name": "About",
      "description": "Open the about page",
      "url": "/page/contact",
      "icons": [{ "src": "/images/pwa-192x192.png", "sizes": "192x192" }]
    },
    {
      "name": "Open Privacy Policy",
      "short_name": "Privacy Policy",
      "description": "Open the privacy policy page",
      "url": "/page/privacy-policy",
      "icons": [{ "src": "/images/pwa-192x192.png", "sizes": "192x192" }]
    }
  ]
}';

            File::put('manifest.json', $manifest_json);

            // Upload PWA Screenshot
            if ($request->hasFile('pwa_screenshot')) {
                $image = $request->file('pwa_screenshot');
                $location = public_path('images/pwa-screenshot.png');
                Image::make($image)->resize(1080, 1920)->save($location);
            }

            // Upload PWA Icon (512x512)
            if ($request->hasFile('pwa_512')) {
                $image = $request->file('pwa_512');
                $location = public_path('images/pwa-512x512.png');
                Image::make($image)->resize(512, 512)->save($location);
            }

            // Upload PWA Icon (192x192)
            if ($request->hasFile('pwa_192')) {
                $image = $request->file('pwa_192');
                $location = public_path('images/pwa-192x192.png');
                Image::make($image)->resize(192, 192)->save($location);
            }

            // Upload PWA Icon (48x48)
            if ($request->hasFile('pwa_48')) {
                $image = $request->file('pwa_48');
                $location = public_path('images/pwa-48x48.png');
                Image::make($image)->resize(48, 48)->save($location);
            }

            // Upload PWA Icon (24x24)
            if ($request->hasFile('pwa_24')) {
                $image = $request->file('pwa_24');
                $location = public_path('images/pwa-24x24.png');
                Image::make($image)->resize(24, 24)->save($location);
            }

            $this->checkbox_update('enable_pwa', $request->get('enable_pwa'));
        }

        // Clear cache
        Cache::flush();

        // Redirect to PWA settings page
        return back()->with('success', __('admin.content_updated'));
    }

    /** Clear Cache */
    public function clear_cache()
    {
        // Clear cache
        Cache::flush();

        // Redirect back
        return back()->with('success', __('admin.system_cache_cleared'));
    }

}

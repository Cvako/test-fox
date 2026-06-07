<?php

use Illuminate\Support\Facades\Route;
use App\Models\Setting;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Site Settings
$settings = Setting::get();

foreach ($settings as $setting) {
    $settings[$setting->name] = $setting->value;
}

Route::get('/', 'App\Http\Controllers\SiteController@index');
Route::get("/$settings[station_base]/{slug}", 'App\Http\Controllers\SiteController@station');
Route::get("/$settings[page_base]/{slug}", 'App\Http\Controllers\SiteController@page');
Route::get("/$settings[genre_base]/{slug}", 'App\Http\Controllers\SiteController@genre');
Route::get("/$settings[language_base]/{slug}", 'App\Http\Controllers\SiteController@language');
Route::get("/$settings[country_base]/{slug}", 'App\Http\Controllers\SiteController@country');
Route::get("/$settings[page_base]/{slug}", 'App\Http\Controllers\SiteController@page');
Route::post('/comment', 'App\Http\Controllers\FrontendCommentController@store');
Route::match(array('GET', 'POST'), '/search', 'App\Http\Controllers\SiteController@search');
Route::get("/report/{slug}", 'App\Http\Controllers\SiteController@report');
Route::post('/json-search', 'App\Http\Controllers\SiteController@json_search');
Route::get("/random", 'App\Http\Controllers\SiteController@random');
Route::get("$settings[history_base]", 'App\Http\Controllers\SiteController@history');
Route::get("$settings[favorites_base]", 'App\Http\Controllers\SiteController@favorites');
Route::get("/$settings[browse_genres_base]", 'App\Http\Controllers\SiteController@genres');
Route::get("/$settings[browse_countries_base]", 'App\Http\Controllers\SiteController@countries');
Route::get("/$settings[browse_languages_base]", 'App\Http\Controllers\SiteController@languages');
Route::get("/$settings[contact_slug]", 'App\Http\Controllers\SiteController@contact');
Route::get("/$settings[faq_slug]", 'App\Http\Controllers\SiteController@faq');
Route::get("/$settings[submission_slug]", 'App\Http\Controllers\SiteController@submission');
Route::post('/contact-form', 'App\Http\Controllers\ContactFormController@store');
Route::post('/vote', 'App\Http\Controllers\VoteController@vote');
Route::post('/report', 'App\Http\Controllers\SiteController@report');
Route::get('/sitemaps.xml', 'App\Http\Controllers\SitemapController@index');
Route::get("/sitemap/{slug}.xml", 'App\Http\Controllers\SitemapController@sitemap');
Route::get('/cronjob/{slug}', 'App\Http\Controllers\SiteController@cronjob');
Route::post('/submission', 'App\Http\Controllers\FrontendSubmissionController@store');

Route::group(['prefix' => env('ADMIN_URL'), 'middleware' => ['auth', 'isAdmin']], function () {
Route::get('/', [App\Http\Controllers\StationController::class, 'index'])->name('home');
Route::resource('/pages', 'App\Http\Controllers\PageController');
Route::match(array('GET', 'POST'), '/stations/sort', 'App\Http\Controllers\StationController@sort');
Route::resource('/stations', 'App\Http\Controllers\StationController');
Route::get('/genres_home', 'App\Http\Controllers\GenreController@sort_home');
Route::get('/genres/sort_home', 'App\Http\Controllers\GenreController@sort_home');
Route::match(array('GET', 'POST'), '/genres/sort', 'App\Http\Controllers\GenreController@sort');
Route::resource('/genres', 'App\Http\Controllers\GenreController');
Route::match(array('GET', 'POST'), '/countries/sort', 'App\Http\Controllers\CountryController@sort');
Route::resource('/countries', 'App\Http\Controllers\CountryController');
Route::match(array('GET', 'POST'), '/languages/sort', 'App\Http\Controllers\LanguageController@sort');
Route::resource('/languages', 'App\Http\Controllers\LanguageController');
Route::resource('/ads', 'App\Http\Controllers\AdController');
Route::resource('/reports', 'App\Http\Controllers\ReportController');
Route::resource('/translations', 'App\Http\Controllers\TranslationController');
Route::resource('/error_handling', 'App\Http\Controllers\ErrorHandlingController');
Route::resource('/comments', 'App\Http\Controllers\CommentController');
Route::resource('/submissions', 'App\Http\Controllers\SubmissionController');
Route::get('/api', 'App\Http\Controllers\ApiController@index');
Route::get('/api/{code}', 'App\Http\Controllers\ApiController@country');
Route::get('/api/station/{id}', 'App\Http\Controllers\ApiController@create');
Route::get('/faq_list/{id}', 'App\Http\Controllers\FAQController@faq_list');
Route::resource('/faqs', 'App\Http\Controllers\FAQController');
Route::get('/search', 'App\Http\Controllers\SearchController@index');
Route::get('/general_settings/clear_cache', 'App\Http\Controllers\SettingController@clear_cache');
Route::get('/general_settings', 'App\Http\Controllers\SettingController@index');
Route::post('/general_settings', 'App\Http\Controllers\SettingController@store');
Route::get('/seo_settings', 'App\Http\Controllers\SettingController@seo_settings');
Route::post('/seo_settings', 'App\Http\Controllers\SettingController@seo_settings_update');
Route::get('/pwa_settings', 'App\Http\Controllers\SettingController@pwa_settings');
Route::post('/pwa_settings', 'App\Http\Controllers\SettingController@pwa_settings_update');
Route::get('/account_settings', 'App\Http\Controllers\AccountController@accountsettingsform');
Route::post('/account_settings', 'App\Http\Controllers\AccountController@accountsettings')->name('accountsettings');
});

Route::get(env('ADMIN_LOGIN_URL'), 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route::post(env('ADMIN_LOGIN_URL'), 'App\Http\Controllers\Auth\LoginController@login');

Auth::routes([
    'login' => false,
    'register' => false,
    'reset' => true,
    'verify' => false,
]);
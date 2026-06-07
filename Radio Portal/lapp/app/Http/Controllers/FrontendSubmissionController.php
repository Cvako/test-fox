<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Response;
use App\Models\Submission;

class FrontendSubmissionController extends Controller
{

    public function __construct()
    {
        // Site Settings
        $site_settings = DB::table('settings')->get();

        foreach ($site_settings as $setting) {
            $setting_name = $setting->name;
            $this->$setting_name = $setting->value;
            $settings[$setting->name] = $setting->value;
        }
    }

    /** Store */
    public function store(Request $request)
    {

        if ($request->hasFile('image') != null) {
            $this->validate($request, [
            ]);
        }

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'title' => 'required',
            'stream_url' => 'required|url',
            "image" => "sometimes|image|mimes:jpeg,jpg,png,gif,svg,webp",
            'description' => 'required|min:25',
            'genres' => ['required', 'array', 'min:1'],
            'genres.*' => ['required', 'integer', 'exists:genres,id'],
            'countries' => ['sometimes', 'array', 'min:1'],
            'countries.*' => ['sometimes', 'integer', 'exists:countries,id'],
            'languages' => ['sometimes', 'array', 'min:1'],
            'languages.*' => ['sometimes', 'integer', 'exists:languages,id'],
        ]);

        if ($this->enable_google_recaptcha == '1') {

            // Google reCAPTCHA validation
            $secret = $this->google_recaptcha_secret_key;
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

        $file_name = '';

        // Check if the picture has been uploaded
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if ($this->save_as_webp == '1') {
                $file_name = time() . '.webp';
            } else {
                $file_name = time() . '.' . $image->getClientOriginalExtension();
            }
            $location = public_path('images/submissions/' . $file_name);
            Image::make($image)->resize(300, 300)->save($location, $this->image_quality);
        }

        $client_ip = $request->ip();

        $genres = implode(',', request()->genres);

        if (!empty(request()->countries)) {
            $countries = implode(',', request()->countries);
        } else {
            $countries = null;
        }

        if (!empty(request()->languages)) {
            $languages = implode(',', request()->languages);
        } else {
            $languages = null;
        }

        Submission::insert(
            [
                'name' => request()->name,
                'email' => request()->email,
                'title' => request()->title,
                'stream_url' => request()->stream_url,
                'description' => request()->description,
                'details' => nl2br(request()->details),
                'genres' => $genres,
                'countries' => $countries,
                'languages' => $languages,
                'image' => $file_name,
                'ip' => $client_ip,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]
        );

        return '<div class="alert alert-success mt-2 mb-2 show" role="alert">' . __('general.submission_thanks') . '</div>';
    }

}
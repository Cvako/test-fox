<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Response;

class FrontendCommentController extends Controller
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

    /** Show */
    public function store(Request $request)
    {
        $this->validate($request, [
            'content_id' => 'required',
            'name' => 'required',
            'comment' => 'required|min:25',
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

        $client_ip = $request->ip();

        DB::table('comments')->insert(
            [
                'content_id' => request()->content_id,
                'name' => request()->name,
                'comment' => request()->comment,
                'ip' => $client_ip,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]
        );

        return '<div class="alert alert-success my-2" role="alert">' . __('general.comment_thanks') . '</div>';
    }

}

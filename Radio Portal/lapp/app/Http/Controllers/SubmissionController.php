<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Country;
use App\Models\Language;
use App\Models\Submission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Intervention\Image\ImageManagerStatic as Image;

class SubmissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

         // Genres
        $genres = Genre::orderBy('title', 'ASC')->get()->pluck('title', 'id');
        
        // Countries
        $countries = Country::orderBy('title', 'ASC')->get()->pluck('title', 'id');
        
        // Languages
        $languages = Language::orderBy('title', 'ASC')->get()->pluck('title', 'id');


        // Site settings
        $site_settings = DB::table('settings')->get();

        foreach ($site_settings as $setting) {
            $settings[$setting->name] = $setting->value;
        }

        // Pass data to views
        View::share(['settings' => $settings, 'genres' => $genres, 'countries' => $countries, 'languages' => $languages]);
    }

    /** Index */
    public function index()
    {
        // List of latest submissions
        $submissions = Submission::orderBy('id', 'desc')->paginate(10);

        // Return view
        return view('adminlte::submissions.index', compact('submissions'));
    }

    /** Show */
    public function show($id)
    {
        // Retrieve submission details
        $submission = Submission::find($id);

        // Return 404 page if submission not found
        if ($submission == null) {
            abort(404);
        }

        // Return view
        return view('adminlte::submissions.create', compact('submission', 'id'));
    }

    /** Destory */
    public function destroy($id)
    {

        // Retrieve submission details
        $submission = Submission::find($id);

        if (!empty($submission->image)) {
            if (file_exists(public_path() . '/images/submissions/' . $submission->image)) {
                unlink(public_path() . '/images/submissions/' . $submission->image);
            }
        }
        
        $submission->delete();

        // Redirect to list of submissions
        return redirect()->route('submissions.index')->with('success', __('admin.content_deleted'));
    }

}

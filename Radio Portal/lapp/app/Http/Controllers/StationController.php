<?php
namespace App\Http\Controllers;

use App;
use App\Models\Country;
use App\Models\Genre;
use App\Models\Language;
use App\Models\Report;
use App\Models\Station;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use Intervention\Image\ImageManagerStatic as Image;
use Redirect;

class StationController extends Controller
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
    public function index(Request $request)
    {
        if ($request->has('sort')) {
            // List of pages
            $posts = Station::where('home_page', 1)->orderBy('sort', 'ASC')->get();

            $id = $request->input('id');
            $sorting = $request->input('sort');

            // Update sort order
            foreach ($posts as $item) {
                Station::where('id', '=', $id)->update(array(
                    'sort' => $sorting,
                ));
            }

            // Clear cache
            Cache::flush();

            return \Response::json('success', 200);
        }

        // List of pages
        $rows = Station::orderBy('id', 'DESC')->paginate(15);

        // Return view
        return view('adminlte::stations.index')->with('rows', $rows);
    }

    /** Sort */
    public function sort(Request $request)
    {
        // List of pages
        $rows = Station::where('home_page', 1)->orderBy('sort', 'ASC')->get();

        // Return view
        return view('adminlte::stations.sort')->with('rows', $rows);
    }

    /** Create */
    public function create()
    {
        // Genres
        $genres = Genre::orderBy('title', 'ASC')->get()->pluck('title', 'id');

        // Countries
        $countries = Country::orderBy('title', 'ASC')->get()->pluck('title', 'id');

        // Languages
        $languages = Language::orderBy('title', 'ASC')->get()->pluck('title', 'id');

        // Return view
        return view('adminlte::stations.create', compact('genres', 'countries', 'languages'));
    }

    /** Store */
    public function store(Request $request)
    {
        // Check if slug exists
        $slug_check = Station::where('slug', $request->get('slug'))->first();

        // Return error message if slug is in use
        if ($slug_check != null) {
            return Redirect::back()->withErrors(__('admin.slug_in_use'));
        }

        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'nullable|max:755',
            'stream_url' => 'required|url',
            'custom_title' => 'nullable|max:255',
            'custom_description' => 'nullable|max:255',
            'custom_h1' => 'nullable|max:255',
            'page_views' => 'required|numeric',
            'up_votes' => 'required|numeric',
            'down_votes' => 'required|numeric',
            'genres' => ['required', 'array', 'min:1'],
            'genres.*' => ['required', 'integer', 'exists:genres,id'],
            'countries' => ['sometimes', 'array', 'min:1'],
            'countries.*' => ['sometimes', 'integer', 'exists:countries,id'],
            'languages' => ['sometimes', 'array', 'min:1'],
            'languages.*' => ['sometimes', 'integer', 'exists:languages,id'],
        ]);

        $row = new Station;
        $row->slug = $request->get('slug');
        $row->title = $request->get('title');
        $row->description = $request->get('description');
        $row->details = $request->get('details');
        if ($row->details == '<br>') {
            $row->details = null;
        }
        $row->stream_url = $request->get('stream_url');
        $row->custom_title = $request->get('custom_title');
        $row->custom_description = $request->get('custom_description');
        $row->custom_h1 = $request->get('custom_h1');
        $row->page_views = $request->get('page_views');
        $row->up_votes = $request->get('up_votes');
        $row->down_votes = $request->get('down_votes');
        $row->status = $request->get('status') ? 1 : 0;
        $row->home_page = $request->get('home_page') ? 1 : 0;
        $row->sort = 0;

        if ($row->home_page == '1') {
            // Retrieve last item in sort order and add +1
            $row->sort = Station::max('sort') + 1;
        }

        if ($request->get('submission') == 1) {
            $submission_id = $request->get('submission_id');

            // Check if the picture has been uploaded
            if ($request->hasFile('different_image')) {
                $image = $request->file('different_image');

                if ($this->settings['save_as_webp'] == '1') {
                    $file_name = time() . '.webp';
                } else {
                    $file_name = time() . '.' . $image->getClientOriginalExtension();
                }

                $location = public_path('images/stations/' . $file_name);
                Image::make($image)->resize(300, 300)->save($location, $this->settings['image_quality']);
                $row->image = $file_name;

            } else {
                $image = $request->get('image');
                if ($image != null) {
                    if (file_exists(public_path() . '/images/submissions/' . $image)) {
                        $location = public_path('images/submissions/' . $image);
                        $target_location = public_path('images/stations/' . $image);
                        File::move($location, $target_location);
                        $row->image = $image;
                    }
                }
            }

            $submission = Submission::find($submission_id);
            $submission->delete();

            if (file_exists(public_path() . '/images/submissions/' . $request->get('image'))) {
                unlink(public_path() . '/images/submissions/' . $request->get('image'));
            }

        } elseif ($request->get('api') == 1) {

            // Check if the picture has been uploaded
            if ($request->hasFile('different_image')) {
                $image = $request->file('different_image');

                if ($this->settings['save_as_webp'] == '1') {
                    $file_name = time() . '.webp';
                } else {
                    $file_name = time() . '.' . $image->getClientOriginalExtension();
                }

                $location = public_path('images/stations/' . $file_name);
                Image::make($image)->resize(300, 300)->save($location, $this->settings['image_quality']);
                $row->image = $file_name;

            } else {
                $image = $request->get('image');

                if ($image != null) {

                    if ($this->settings['save_as_webp'] == '1') {
                        $file_name = time() . '.webp';
                    } else {
                        $file_name = time() . '.png';
                    }

                    $response = Http::get($image);

                    if ($response->ok()) {
                        $content_type = $response->header('Content-Type');
                        if (strpos($content_type, 'image/') === 0) {
                            file_put_contents(public_path('images/stations/' . $file_name), $response->body());
                            $row->image = $file_name;
                        } else {
                            $row->image = null;
                        }
                    }

                }
            }

        } else {
            // Check if the picture has been uploaded
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                if ($this->settings['save_as_webp'] == '1') {
                    $file_name = time() . '.webp';
                } else {
                    $file_name = time() . '.' . $image->getClientOriginalExtension();
                }
                $location = public_path('images/stations/' . $file_name);
                Image::make($image)->resize(300, 300)->save($location, $this->settings['image_quality']);
                $row->image = $file_name;
            }
        }

        $row->save();

        $row->genres()->sync((array) $request->input('genres'));
        $row->countries()->sync((array) $request->input('countries'));
        $row->languages()->sync((array) $request->input('languages'));

        if ($request->get('slug') == null) {
            $row->slug = null;
            $row->update(['title' => $row->title]);
        }

        // Clear cache
        Cache::flush();

        // Redirect to page edit page
        return redirect()->route('stations.edit', $row->id)->with('success', __('admin.content_added'));
    }

    /** Edit */
    public function edit($id)
    {
        // Retrieve details
        $row = Station::find($id);

        // Return 404 page if page not found
        if ($row == null) {
            abort(404);
        }

        // Genres
        $genres = Genre::orderBy('title', 'ASC')->get()->pluck('title', 'id');

        // Countries
        $countries = Country::orderBy('title', 'ASC')->get()->pluck('title', 'id');

        // Languages
        $languages = Language::orderBy('title', 'ASC')->get()->pluck('title', 'id');

        // Return view
        return view('adminlte::stations.edit', compact('row', 'genres', 'countries', 'languages', 'id'));
    }

    /** Update */
    public function update(Request $request, $id)
    {
        // Check if slug exists
        $slug_check = Station::where('slug', $request->get('slug'))->where('id', '!=', $id)->first();

        // Return error message if slug is in use
        if ($slug_check != null) {
            return Redirect::back()->withErrors(__('admin.slug_in_use'));
        }

        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'nullable|max:755',
            'stream_url' => 'required|url',
            'custom_title' => 'nullable|max:255',
            'custom_description' => 'nullable|max:255',
            'custom_h1' => 'nullable|max:255',
            'page_views' => 'required|numeric',
            'up_votes' => 'required|numeric',
            'down_votes' => 'required|numeric',
            "image" => "sometimes|image|mimes:jpeg,jpg,png,gif,svg,webp",
            'genres' => ['required', 'array', 'min:1'],
            'genres.*' => ['required', 'integer', 'exists:genres,id'],
            'countries' => ['sometimes', 'array', 'min:1'],
            'countries.*' => ['sometimes', 'integer', 'exists:countries,id'],
            'languages' => ['sometimes', 'array', 'min:1'],
            'languages.*' => ['sometimes', 'integer', 'exists:languages,id'],
        ]);

        // Retrieve details
        $row = Station::find($id);

        $row->slug = $request->get('slug');
        $row->title = $request->get('title');
        $row->description = $request->get('description');
        $row->details = $request->get('details');
        if ($row->details == '<br>') {
            $row->details = null;
        }
        $row->stream_url = $request->get('stream_url');
        $row->custom_title = $request->get('custom_title');
        $row->custom_description = $request->get('custom_description');
        $row->custom_h1 = $request->get('custom_h1');
        $row->page_views = $request->get('page_views');
        $row->up_votes = $request->get('up_votes');
        $row->down_votes = $request->get('down_votes');
        $row->status = $request->get('status') ? 1 : 0;
        $row->home_page = $request->get('home_page') ? 1 : 0;
        $row->genres()->sync((array) $request->input('genres'));
        $row->countries()->sync((array) $request->input('countries'));
        $row->languages()->sync((array) $request->input('languages'));

        if ($row->isDirty('home_page')) {
            if ($row->home_page == '1') {
                // Retrieve last item in sort order and add +1
                $row->sort = Station::max('sort') + 1;
            } else {
                $row->sort = 0;
            }
        }

        if ($request->get('slug') == null) {
            $row->slug = null;
            $row->update(['title' => $row->title]);
        }

        // Check if the picture has been changed
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if ($this->settings['save_as_webp'] == '1') {
                $file_name = time() . '.webp';
            } else {
                $file_name = time() . '.' . $image->getClientOriginalExtension();
            }
            $location = public_path('images/stations/' . $file_name);
            Image::make($image)->resize(300, 300)->save($location, $this->settings['image_quality']);
            // Remove old image file
            if (!empty($row->image)) {
                if (file_exists(public_path() . '/images/stations/' . $row->image)) {
                    unlink(public_path() . '/images/stations/' . $row->image);
                }
            }
            $row->image = $file_name;
        }

        $row->save();

        // Clear cache
        Cache::flush();

        // Redirect to page edit page
        return redirect()->route('stations.edit', $row->id)->with('success', __('admin.content_updated'));
    }

    /** Destroy */
    public function destroy($id)
    {
        // Retrieve details
        $row = Station::find($id);

        if (!empty($row->image)) {
            if (file_exists(public_path() . '/images/stations/' . $row->image)) {
                unlink(public_path() . '/images/stations/' . $row->image);
            }
        }

        Report::where('station_id', $id)->delete();

        $row->genres()->detach();
        $row->countries()->detach();
        $row->languages()->detach();

        $row->delete();

        // Clear cache
        Cache::flush();

        // Redirect to list of pages
        return redirect()->back()->with('success', __('admin.content_deleted'));
    }

}

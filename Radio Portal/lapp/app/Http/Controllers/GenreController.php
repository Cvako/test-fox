<?php
namespace App\Http\Controllers;

use App;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Intervention\Image\ImageManagerStatic as Image;
use Redirect;
use Illuminate\Support\Facades\Cache;

class GenreController extends Controller
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
            $posts = Genre::where('left_column', 1)->orderBy('sort', 'ASC')->get();

            $id = $request->input('id');
            $sorting = $request->input('sort');

            // Update sort order
            foreach ($posts as $item) {
                Genre::where('id', '=', $id)->update(array(
                    'sort' => $sorting,
                ));
            }
                       
        // Clear cache
        Cache::flush();
        
        return \Response::json('success', 200);
        }
        
        // List of genres
        $rows = Genre::orderBy('id', 'DESC')->paginate(15);

        // Return view
        return view('adminlte::genres.index')->with('rows', $rows);
    }
    
    /** Sort */
    public function sort(Request $request)
    {
        // List of pages
        $rows = Genre::where('left_column', 1)->orderBy('sort', 'ASC')->get();

        // Return view
        return view('adminlte::genres.sort')->with('rows', $rows);
    }

    /** Sort Home Genres */
    public function sort_home(Request $request)
    {
        if ($request->has('sort')) {
            // List of pages
            $posts = Genre::where('home_page', 1)->orderBy('sort_home', 'ASC')->get();

            $id = $request->input('id');
            $sorting = $request->input('sort');

            // Update sort order
            foreach ($posts as $item) {
                Genre::where('id', '=', $id)->update(array(
                    'sort_home' => $sorting,
                ));
            }
            
        // Clear cache
        Cache::flush();
        
        return \Response::json('success', 200);
        }
        
         // List of pages
        $rows = Genre::where('home_page', 1)->orderBy('sort_home', 'ASC')->get();

        // Return view
        return view('adminlte::genres.sort_home')->with('rows', $rows);
    }
    
    /** Create */
    public function create()
    {
        // Return view
        return view('adminlte::genres.create');
    }

    /** Store */
    public function store(Request $request)
    {
        // Check if slug exists
        $slug_check = Genre::where('slug', $request->get('slug'))->first();

        // Return error message if slug is in use
        if ($slug_check != null) {
            return Redirect::back()->withErrors(__('admin.slug_in_use'));
        }

        $this->validate($request, [
            'title' => 'required|max:255',
            'custom_title' => 'nullable|max:255',
            'custom_description' => 'nullable|max:255',
            'custom_h1' => 'nullable|max:255',
            "image" => "sometimes|image|mimes:jpeg,jpg,png,gif,svg,webp",
       ]);

        $row = new Genre;
        $row->slug = $request->get('slug');
        $row->title = $request->get('title');
        $row->custom_title = $request->get('custom_title');
        $row->custom_description = $request->get('custom_description');
        $row->custom_h1 = $request->get('custom_h1');
        $row->left_column = $request->get('left_column') ? 1 : 0;
        $row->home_page = $request->get('home_page') ? 1 : 0;
        $row->footer = $request->get('footer') ? 1 : 0;

        if ($row->left_column == '1') {
            // Retrieve last item in sort order and add +1
            $row->sort = Genre::max('sort') + 1;
        } else {
            $row->sort = 0;
        }
        
        if ($row->home_page == '1') {
            // Retrieve last item in sort order and add +1
            $row->sort_home = Genre::max('sort_home') + 1;
        } else {
            $row->sort_home = 0;
        }

        // Check if the picture has been uploaded
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if ($this->settings['save_as_webp'] == '1') {
                $file_name = time() . '.webp';
            } else {
                $file_name = time() . '.' . $image->getClientOriginalExtension();
            }
            $location = public_path('images/genres/' . $file_name);
            Image::make($image)->resize(516, 258)->save($location, $this->settings['image_quality']);
            $row->image = $file_name;
        }

        $row->save();
        
        if ($request->get('slug') == null) {
            $row->slug = null;
            $row->update(['title' => $row->title]);
        }

        // Clear cache
        Cache::flush();
        
        // Redirect to page edit page
        return redirect()->route('genres.edit', $row->id)->with('success', __('admin.content_added'));
    }

    /** Edit */
    public function edit($id)
    {
        // Retrieve details
        $row = Genre::find($id);

        // Return 404 page if page not found
        if ($row == null) {
            abort(404);
        }
        
        // Return view
        return view('adminlte::genres.edit', compact('row'));
    }

    /** Update */
    public function update(Request $request, $id)
    {
        // Check if slug exists
        $slug_check = Genre::where('slug', $request->get('slug'))->where('id', '!=', $id)->first();

        // Return error message if slug is in use
        if ($slug_check != null) {
            return Redirect::back()->withErrors(__('admin.slug_in_use'));
        }

        $this->validate($request, [
            'title' => 'required|max:255',
            'custom_title' => 'nullable|max:255',
            'custom_description' => 'nullable|max:255',
            'custom_h1' => 'nullable|max:255',
            "image" => "sometimes|image|mimes:jpeg,jpg,png,gif,svg,webp",
        ]);
        
        // Retrieve details
        $row = Genre::find($id);

        $row->left_column = $request->get('left_column') ? 1 : 0;
        $row->home_page = $request->get('home_page') ? 1 : 0;
        $row->footer = $request->get('footer') ? 1 : 0;

        if($row->isDirty('left_column')){
        if ($row->left_column == '1') {
            // Retrieve last item in sort order and add +1
            $row->sort = Genre::max('sort') + 1;
        } else {
            $row->sort = 0;
        }
        }
        
        if($row->isDirty('home_page')){
        if ($row->home_page == '1') {
            // Retrieve last item in sort order and add +1
            $row->sort_home = Genre::max('sort_home') + 1;
        } else {
            $row->sort_home = 0;
        }
        }

        $row->slug = $request->get('slug');
        $row->title = $request->get('title');
        $row->custom_title = $request->get('custom_title');
        $row->custom_description = $request->get('custom_description');
        $row->custom_h1 = $request->get('custom_h1');

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
            $location = public_path('images/genres/' . $file_name);
            Image::make($image)->resize(516, 258)->save($location, $this->settings['image_quality']);
            // Remove old image file
            if (!empty($row->image)) {
            if (file_exists(public_path() . '/images/genres/' . $row->image)) {
                unlink(public_path() . '/images/genres/' . $row->image);
            }
            }
            $row->image = $file_name;
        }

        $row->save();
        
        // Clear cache
        Cache::flush();

        // Redirect to page edit page
        return redirect()->route('genres.edit', $row->id)->with('success', __('admin.content_updated'));
    }

    /** Destroy */
    public function destroy($id)
    {
        // Retrieve details
        $row = Genre::find($id);

        // Check if there are Radio Stations under the Genre
        $stations_list = count($row->stations->pluck('id'));

        if ($stations_list != '0') {
            return Redirect::back()->withErrors(__('admin.stations_exists_under_genre'));
        }

        $row->delete();
        
        // Clear cache
        Cache::flush();

        // Redirect to list of pages
        return redirect()->back()->with('success', __('admin.content_deleted'));
    }

}
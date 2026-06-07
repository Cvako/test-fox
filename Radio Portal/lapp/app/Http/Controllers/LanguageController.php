<?php
namespace App\Http\Controllers;

use App;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Intervention\Image\ImageManagerStatic as Image;
use Redirect;
use Illuminate\Support\Facades\Cache;

class LanguageController extends Controller
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
            $posts = Language::where('left_column', 1)->orderBy('sort', 'ASC')->get();

            $id = $request->input('id');
            $sorting = $request->input('sort');

            // Update sort order
            foreach ($posts as $item) {
                Language::where('id', '=', $id)->update(array(
                    'sort' => $sorting,
                ));
            }
                       
        // Clear cache
        Cache::flush();
        
        return \Response::json('success', 200);
        }
        
        // List of pages
        $rows = Language::orderBy('id', 'DESC')->paginate(15);

        // Return view
        return view('adminlte::languages.index')->with('rows', $rows);
    }
    
    /** Sort */
    public function sort(Request $request)
    {
        // List of pages
        $rows = Language::where('left_column', 1)->orderBy('sort', 'ASC')->get();

        // Return view
        return view('adminlte::languages.sort')->with('rows', $rows);
    }
 
 
    /** Create */
    public function create()
    {
        // Return view
        return view('adminlte::languages.create');
    }

    /** Store */
    public function store(Request $request)
    {
        // Check if slug exists
        $slug_check = Language::where('slug', $request->get('slug'))->first();

        // Return error message if slug is in use
        if ($slug_check != null) {
            return Redirect::back()->withErrors(__('admin.slug_in_use'));
        }

        $this->validate($request, [
            'title' => 'required|max:255',
            'custom_title' => 'nullable|max:255',
            'custom_description' => 'nullable|max:255',
            'custom_h1' => 'nullable|max:255',
       ]);

        $row = new Language;
        $row->slug = $request->get('slug');
        $row->title = $request->get('title');
        $row->custom_title = $request->get('custom_title');
        $row->custom_description = $request->get('custom_description');
        $row->custom_h1 = $request->get('custom_h1');
        $row->left_column = $request->get('left_column') ? 1 : 0;

        if ($row->left_column == '1') {
            // Retrieve last item in sort order and add +1
            $row->sort = Language::max('sort') + 1;
        } else {
            $row->sort = 0;
        }
        
        $row->save();

        if ($request->get('slug') == null) {
            $row->slug = null;
            $row->update(['title' => $row->title]);
        }

        // Clear cache
        Cache::flush();

        // Redirect to page edit page
        return redirect()->route('languages.edit', $row->id)->with('success', __('admin.content_added'));
    }

    /** Edit */
    public function edit($id)
    {
        // Retrieve details
        $row = Language::find($id);

        // Return 404 page if page not found
        if ($row == null) {
            abort(404);
        }
        
        // Return view
        return view('adminlte::languages.edit', compact('row'));
    }

    /** Update */
    public function update(Request $request, $id)
    {
        // Check if slug exists
        $slug_check = Language::where('slug', $request->get('slug'))->where('id', '!=', $id)->first();

        // Return error message if slug is in use
        if ($slug_check != null) {
            return Redirect::back()->withErrors(__('admin.slug_in_use'));
        }

        $this->validate($request, [
            'title' => 'required|max:255',
            'custom_title' => 'nullable|max:255',
            'custom_description' => 'nullable|max:255',
            'custom_h1' => 'nullable|max:255',
        ]);

        // Retrieve details
        $row = Language::find($id);
        
        $row->slug = $request->get('slug');
        $row->title = $request->get('title');
        $row->custom_title = $request->get('custom_title');
        $row->custom_description = $request->get('custom_description');
        $row->custom_h1 = $request->get('custom_h1');
        $row->left_column = $request->get('left_column') ? 1 : 0;

        if($row->isDirty('left_column')){
        if ($row->left_column == '1') {
            // Retrieve last item in sort order and add +1
            $row->sort = Language::max('sort') + 1;
        } else {
            $row->sort = 0;
        }
        }
        
        if ($request->get('slug') == null) {
            $row->slug = null;
            $row->update(['title' => $row->title]);
        }

        $row->save();

        // Clear cache
        Cache::flush();
        
        // Redirect to page edit page
        return redirect()->route('languages.edit', $row->id)->with('success', __('admin.content_updated'));
    }

    /** Destroy */
    public function destroy($id)
    {
        // Retrieve details
        $row = Language::find($id);
        
        // Check if there are Radio Stations under the language
        $stations_list = count($row->stations->pluck('id'));

        if ($stations_list != '0') {
            return Redirect::back()->withErrors(__('admin.stations_exists_under_language'));
        }

        $row->delete();

        // Clear cache
        Cache::flush();
        
        // Redirect to list of pages
        return redirect()->back()->with('success', __('admin.content_deleted'));
    }

}
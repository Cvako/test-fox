<?php
namespace App\Http\Controllers;

use App;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Redirect;
use Illuminate\Support\Facades\Cache;

class PageController extends Controller
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
            $posts = Page::orderBy('sort', 'ASC')->get();

            $id = $request->input('id');
            $sorting = $request->input('sort');

            // Update sort order
            foreach ($posts as $item) {
                Page::where('id', '=', $id)->update(array(
                    'sort' => $sorting,
                ));
            }
                       
        // Clear cache
        Cache::flush();
        
        return \Response::json('success', 200);
        }

        // List of pages
        $rows = Page::orderBy('sort', 'ASC')->get();

        // Return view
        return view('adminlte::pages.index')->with('rows', $rows);
    }
 
    /** Create */
    public function create()
    {
        // Return view
        return view('adminlte::pages.create');
    }

    /** Store */
    public function store(Request $request)
    {
        // Check if slug exists
        $slug_check = Page::where('slug', $request->get('slug'))->first();

        // Return error message if slug is in use
        if ($slug_check != null) {
            return Redirect::back()->withErrors(__('admin.slug_in_use'));
        }

        $this->validate($request, [
            'title' => 'required|max:255',
            'content' => 'required',
            'custom_title' => 'nullable|max:255',
            'custom_description' => 'nullable|max:255',
            'custom_h1' => 'nullable|max:255',
            'page_views' => 'required|numeric',
       ]);

        $row = new Page;
        $row->slug = $request->get('slug');
        $row->title = $request->get('title');
        $row->content = $request->get('content');
        $row->custom_title = $request->get('custom_title');
        $row->custom_description = $request->get('custom_description');
        $row->custom_h1 = $request->get('custom_h1');
        $row->page_views = $request->get('page_views');
        $row->footer = $request->get('footer') ? 1 : 0;
        
        // Retrieve last item in sort order and add +1
        $row->sort = Page::max('sort') + 1;

        $row->save();

        if ($request->get('slug') == null) {
            $row->slug = null;
            $row->update(['title' => $row->title]);
        }
        
        // Clear cache
        Cache::flush();

        // Redirect to page edit page
        return redirect()->route('pages.edit', $row->id)->with('success', __('admin.content_added'));
    }

    /** Edit */
    public function edit($id)
    {
        // Retrieve page details
        $row = Page::find($id);

        // Return 404 page if page not found
        if ($row == null) {
            abort(404);
        }

        // Return view
        return view('adminlte::pages.edit', compact('row', 'id'));
    }

    /** Update */
    public function update(Request $request, $id)
    {
        // Check if slug exists
        $slug_check = Page::where('slug', $request->get('slug'))->where('id', '!=', $id)->first();

        // Return error message if slug is in use
        if ($slug_check != null) {
            return Redirect::back()->withErrors(__('admin.slug_in_use'));
        }

        $this->validate($request, [
            'title' => 'required|max:255',
            'content' => 'required',
            'custom_title' => 'nullable|max:255',
            'custom_description' => 'nullable|max:255',
            'custom_h1' => 'nullable|max:255',
            'page_views' => 'required|numeric',
        ]);

        // Retrieve page details
        $row = Page::find($id);
        $row->slug = $request->get('slug');
        $row->title = $request->get('title');
        $row->content = $request->get('content');
        $row->custom_title = $request->get('custom_title');
        $row->custom_description = $request->get('custom_description');
        $row->custom_h1 = $request->get('custom_h1');
        $row->page_views = $request->get('page_views');
        $row->footer = $request->get('footer') ? 1 : 0;
        
        if ($request->get('slug') == null) {
            $row->slug = null;
            $row->update(['title' => $row->title]);
        }

        $row->save();
        
        // Clear cache
        Cache::flush();        

        // Redirect to page edit page
        return redirect()->route('pages.edit', $row->id)->with('success', __('admin.content_updated'));
    }

    /** Destroy */
    public function destroy($id)
    {
        // Retrieve page details
        $row = Page::find($id);

        $row->delete();

        // Clear cache
        Cache::flush();
        
        // Redirect to list of pages
        return redirect()->back()->with('success', __('admin.content_deleted'));
    }

}
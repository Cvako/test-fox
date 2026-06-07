<?php
namespace App\Http\Controllers;

use App;
use App\Models\FAQ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Redirect;
use Illuminate\Support\Facades\Cache;

class FAQController extends Controller
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
            // List of FAQ's
            $posts = FAQ::orderBy('sort', 'ASC')->get();

            $id = $request->input('id');
            $sorting = $request->input('sort');

            // Update sort order
            foreach ($posts as $item) {
                FAQ::where('id', '=', $id)->update(array(
                    'sort' => $sorting,
                ));
            }
                       
        // Clear cache
        Cache::flush();
        
        return \Response::json('success', 200);
        }

        // List of FAQ's
        $rows = FAQ::orderBy('sort', 'ASC')->get();

        // Return view
        return view('adminlte::faqs.index')->with('rows', $rows);
    }
 
    /** Create */
    public function create()
    {
        // Return view
        return view('adminlte::faqs.create');
    }

    /** Store */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'details' => 'required',
       ]);

        $row = new FAQ;
        $row->title = $request->get('title');
        $row->details = $request->get('details');

        // Retrieve last item in sort order and add +1
        $row->sort = FAQ::max('sort') + 1;

        $row->save();

        // Clear cache
        Cache::flush();

        // Redirect to FAQ edit page
        return redirect()->route('faqs.edit', $row->id)->with('success', __('admin.content_added'));
    }

    /** Edit */
    public function edit($id)
    {
        // Retrieve FAQ details
        $row = FAQ::find($id);

        // Return 404 page if FAQ not found
        if ($row == null) {
            abort(404);
        }

        // Return view
        return view('adminlte::faqs.edit', compact('row', 'id'));
    }

    /** Update */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'details' => 'required',
        ]);

        // Retrieve FAQ details
        $row = FAQ::find($id);
        $row->title = $request->get('title');
        $row->details = $request->get('details');

        $row->save();
        
        // Clear cache
        Cache::flush();        

        // Redirect to FAQ edit page
        return redirect()->route('faqs.edit', $row->id)->with('success', __('admin.content_updated'));
    }

    /** Destroy */
    public function destroy($id)
    {
        // Retrieve FAQ details
        $row = FAQ::find($id);

        $row->delete();

        // Clear cache
        Cache::flush();
        
        // Redirect to list of FAQ's
        return redirect()->back()->with('success', __('admin.content_deleted'));
    }

}
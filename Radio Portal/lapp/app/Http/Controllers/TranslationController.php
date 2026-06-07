<?php

namespace App\Http\Controllers;

use App;
use App\Models\Translation;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class TranslationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

        // List of translations
        $rows = Translation::orderBy('language', 'ASC')->get();

        // Pass data to views
        View::share(['rows' => $rows]);
    }

    /** Index */
    public function index()
    {
        // Return view
        return view('adminlte::translations.index');
    }

    /** Create */
    public function create()
    {
        // Return view
        return view('adminlte::translations.create');
    }

    /** Store */
    public function store(Request $request)
    {
        $this->validate($request, [
            'language' => 'required',
            'code' => 'required|unique:translations,code|max:2',
            'locale_code' => 'required',
        ]);

        $translate = new Translation;
        $translate->language = $request->get('language');
        $translate->code = $request->get('code');
        $translate->locale_code = $request->get('locale_code');

        $translation_folder = app()['path.lang'] . '/' . $translate->code;

        File::makeDirectory($translation_folder);
        File::copy(app()['path.lang'] . '/en/general.php', app()['path.lang'] . '/' . $translate->code . '/general.php');
        File::copy(app()['path.lang'] . '/en/admin.php', app()['path.lang'] . '/' . $translate->code . '/admin.php');

        $translate->save();

        // Redirect to translation edit page
        return redirect()->route('translations.edit', $translate->id)->with('success', __('admin.content_added'));
    }

    /** Edit */
    public function edit($id)
    {
        // Retrieve translation details
        $translation = Translation::find($id);

        // Return 404 page if translation not found
        if ($translation == null) {
            abort(404);
        }

        $frontend_location = app()['path.lang'] . '/en/general.php';
        $admin_location = app()['path.lang'] . '/en/admin.php';
        $translation_admin_org = include $admin_location;
        $translation_frontend_org = include $frontend_location;

        $frontend_location_target = app()['path.lang'] . '/' . $translation->code . '/general.php';
        $admin_location_target = app()['path.lang'] . '/' . $translation->code . '/admin.php';
        $translation_frontend_target = include $frontend_location_target;
        $translation_admin_target = include $admin_location_target;

        // Return view
        return view('adminlte::translations.edit', compact('translation', 'id', 'translation_admin_org', 'translation_frontend_org', 'translation_frontend_target', 'translation_admin_target'));
    }

    /** Update */
    public function update(Request $request, $id)
    {
        // Retrieve translation details
        $translate = Translation::find($id);

        if ($request->get('translation_type') == 1) {
            $this->validate($request, [
                'language' => 'required',
                'code' => 'required|max:2|unique:translations,code,' . $id,
                'locale_code' => 'required',
            ]);

            $translation_folder = $translate->code;
            $translate->language = $request->get('language');
            $translate->code = $request->get('code');
            $translate->locale_code = $request->get('locale_code');

            if ($translate->isDirty('code')) {
                File::moveDirectory(app()['path.lang'] . '/' . $translation_folder, app()['path.lang'] . '/' . $translate->code);
            }

            $translate->save();
        }

        if ($request->get('translation_type') == 2 or $request->get('translation_type') == 3) {

            function varexport($expression, $return = false)
            {
                $export = var_export($expression, true);
                $export = preg_replace("/^([ ]*)(.*)/m", '$1$1$2', $export);
                $array = preg_split("/\r\n|\n|\r/", $export);
                $array = preg_replace(["/\s*array\s\($/", "/\)(,)?$/", "/\s=>\s$/"], [null, ']$1', ' => ['], $array);
                $export = join(PHP_EOL, array_filter(["["] + $array));
                $export = "<?php\nreturn " . $export . ";";
                if ((bool) $return) {
                    return $export;
                } else {
                    echo $export;
                }

            }

            $a = array();

            foreach ($request->except(array('_token', '_method')) as $key => $value) {
                $a[$key] = $value;
            }

            if ($request->get('translation_type') == 2) {
                $target_lang = app()['path.lang'] . '/' . $translate->code . '/general.php';
            }
            if ($request->get('translation_type') == 3) {
                $target_lang = app()['path.lang'] . '/' . $translate->code . '/admin.php';
            }

            File::put($target_lang, varexport($a, true));

        }

        // Redirect to translation edit page
        return redirect()->route('translations.edit', $translate->id)->with('success', __('admin.content_updated'));
    }

    /** Destroy */
    public function destroy($id)
    {

        // Check if user is trying to delete main language (English)
        if ($id == '1') {

            // Redirect to list of translations
            return redirect()->route('translations.index')->with('error', __('admin.error'));

        } else {

            // Retrieve translation details
            $translate = Translation::find($id);

            $translate->delete();

            File::deleteDirectory(app()['path.lang'] . '/' . $translate->code);

            // Redirect to list of translations
            return redirect()->route('translations.index')->with('success', __('admin.content_deleted'));

        }
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;

class CommentController extends Controller
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
    public function index()
    {

        $comments = Comment::leftJoin('stations', 'comments.content_id', '=', 'stations.id')
            ->select('comments.*', 'stations.title as app_title', 'stations.slug as slug')
            ->orderBy('created_at', 'desc')->paginate(15);

        // Return view
        return view('adminlte::comments.index', compact('comments'));
    }

    /** Update */
    public function update($id)
    {
       $comment = Comment::find($id);
        $user_rating = $comment->rating;
        $content_id = $comment->content_id;

        if ($comment->approval == 1) {
            $comment->update(['approval' => 0]);
        } else {
            $comment->update(['approval' => 1]);
        }

        // Return view
        return redirect()->route('comments.index')->with('success', __('admin.content_updated'));
    }

    /** Destroy */
    public function destroy($id)
    {
       // Retrieve comment details
        $comment = Comment::find($id);
        $comment->delete();

        // Redirect to list of comments
        return redirect()->route('comments.index')->with('success', __('admin.content_deleted'));
    }
}

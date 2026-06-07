<?php

namespace App\Http\Controllers;

use App;
use DB;
use Illuminate\Http\Request;
use Response;

class VoteController extends Controller
{

    public function __construct()
    {
        //
    }

    /** Show */
    public function vote(Request $request)
    {

        $station_id = $request->get('station_id');
        $direction = $request->get('direction');

        if ( $direction != 'up' && $direction != 'down' ){
            exit;
        }

        if ($direction == 'up') {
            $vote_direction='1';
            $vote_data='up_votes';
        } else {
            $vote_direction='2';
            $vote_data='down_votes';
        }

        // Get user IP address
          $client_ip = $request->ip();
         //   $client_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];

        // Check if user voted for the list item
        $vote_query = DB::table('votes')->where([['ip', '=', $client_ip], ['station_id', '=', $station_id]])->get();

        if (count($vote_query) == 0) {

            // Insert vote to records table
            DB::table('votes')->insert(['station_id' => $station_id,  'vote' => $vote_direction, 'ip' => $client_ip]);

            // Update total voter for the list
             DB::table('stations')->where('id', $station_id)->increment($vote_data);
            
            // Get up to date vote count
            $rating_query = DB::table('stations')->where('id', $station_id)->first();

            // Return result
            return Response::json(['success' => true, 'vote' => number_format($rating_query->$vote_data)]);
        } else {
            return Response::json(['success' => false]);
        }
    

}
}

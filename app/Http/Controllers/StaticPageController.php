<?php

namespace App\Http\Controllers;

use App\Models\Battle;
use App\Models\Search;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class StaticPageController extends Controller
{
    public function welcome() {
        $battleCounts = DB::table('battles')
                        ->leftJoin('videos', 'videos.id', '=', 'battles.video_id')
                         ->leftJoin('creators', 'creators.id', '=', 'videos.creator_id')
                         ->select('creators.id', 'creators.name', 'creators.url', DB::raw('COUNT(battles.id) as count'))
                         ->groupBy('videos.creator_id')
                         ->orderBy('count', 'desc')
                         ->get();

        $offensiveLeaders = DB::table('battles')
                              ->leftJoin('characters', 'characters.id', '=', 'battles.offense_leader')
                              ->select('characters.name', DB::raw('AVG(battles.id) as avg'), DB::raw('COUNT(battles.id) as count'))
                              ->where('characters.combat_type', 'CHARACTER')
                              ->groupBy('battles.offense_leader')
                              ->orderBy('count', 'desc')
                              ->take(5)
                              ->get();

        $defensiveLeaders = DB::table('battles')
                              ->leftJoin('characters', 'characters.id', '=', 'battles.defense_leader')
                              ->select('characters.name', DB::raw('AVG(battles.id) as avg'), DB::raw('COUNT(battles.id) as count'))
                              ->where('characters.combat_type', 'CHARACTER')
                              ->groupBy('battles.defense_leader')
                              ->orderBy('count', 'desc')
                              ->take(5)
                              ->get();

        return view('welcome', [
            'battleCounts' => $battleCounts,
            'offensiveLeaders' => $offensiveLeaders,
            'defensiveLeaders' => $defensiveLeaders,
            'videoCount' => Video::all()->count(),
            'lastBattleUpdated' => Battle::orderBy('updated_at', 'desc')->first(),
            'searchCount' => Search::all()->count(),
        ]);
    }

    public function faq() {
        return Inertia::render('Faq');
    }
}

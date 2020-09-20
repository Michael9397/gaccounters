<?php

namespace App\Http\Controllers;

use App\Models\Battle;
use App\Models\Character;
use App\Models\Creator;
use App\Models\Search;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\In;
use Inertia\Inertia;

class SearchController extends Controller
{

    /**
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Search', [
           'battles' => Battle::orderBy('updated_at', 'desc')->limit(10)->get(),
            'characters' => Character::orderBy('name')->get(),
            'creators' => Creator::orderBy('name')->get(),
            'videos' => Video::orderBy('title')->get(),
        ]);
    }
    /**
     * Simple Search
     *
     */
    public function search(Request $request)
    {
        $validatedData = $request->validate([
            'battle_type' => 'required',
            'character_id' => 'required|int',
            'position_type' => 'required'
        ]);

        $data = [
            'user_id' => auth()->user()->id ?? null,
            'parameters' => json_encode([
                'battle_type' => $validatedData['battle_type'],
                'character_id' => $validatedData['character_id'],
                'position_type' => $validatedData['position_type'],
            ]),
        ];

        Search::create($data);

        $characterId = $request->input('character_id');
        $character = Character::where('id', $characterId)->get()[0];
        $battles = Battle::where('battle_type', '=', $request->input('battle_type'))
                          ->where(function($query) use ($character, $validatedData) {
                              switch ($validatedData['position_type']) {
                                  case 'offense':
                                      $this->checkOffenseSlots($query, $character->id);
                                      break;
                                  case 'defense':
                                      $this->checkDefenseSlots($query, $character->id);
                                      break;
                                  default:
                                    $this->checkAllSlots($query, $character->id);
                              }
                          })->orderBy('score', 'desc');
        $battles = $battles->get();
        $videos = Video::whereIn('id', $battles->pluck('video_id'))->get();
        $creators = Creator::whereIn('id', $videos->pluck('creator_id'))->get();
        $battleTitle = $battles->count() . ' search Results for ' . $character->name;
        $battleTitle .= $validatedData['position_type'] == 'both' ? '!': ' on ' . ucwords($validatedData['position_type']) . '!';

        return Inertia::render('Search', [
            'battles' => $battles,
            'characters' => Character::orderBy('name')->get(),
            'creators' => $creators,
            'videos' => $videos,
            'battle_title' => $battleTitle,
        ]);

    }

    public function searchagain(Request $request)
    {
        if (!$request->has('id')) {
            abort(404);
        }
        $search = Search::find($request->input('id'));
        $search->touch();
        $params = json_decode($search->parameters);

        $characterId = $params->character_id;
        $battleType = $params->battle_type;
        $character = Character::find($characterId);
        $battles = Battle::where('battle_type', '=', $battleType)
                         ->where(function($query) use ($character, $params) {
                             switch ($params->position_type) {
                                 case 'offense':
                                     $this->checkOffenseSlots($query, $character->id);
                                     break;
                                 case 'defense':
                                     $this->checkDefenseSlots($query, $character->id);
                                     break;
                                 default:
                                     $this->checkAllSlots($query, $character->id);
                             }
                         })->orderBy('score', 'desc');
        $battles = $battles->get();
        $videos = Video::whereIn('id', $battles->pluck('video_id'))->get();
        $creators = Creator::whereIn('id', $videos->pluck('creator_id'))->get();
        $battleTitle = $battles->count() . ' search Results for ' . $character->name;
        $battleTitle .= $params->position_type == 'both' ? '!': ' on ' . ucwords($params->position_type) . '!';


        return Inertia::render('Search', [
            'battles' => $battles,
            'characters' => Character::orderBy('name')->get(),
            'creators' => $creators,
            'videos' => $videos,
            'battle_title' => $battleTitle,
        ]);
    }


    public function history() {
        return Inertia::render('History', [
            'history' => Search::where('user_id', '=', auth()->user()->id)->orderBy('updated_at', 'desc')->limit(50)->get()->map->only('id', 'parameters'),
            'characters' => Character::all(),
        ]);
    }

    private function checkOffenseSlots($query, $id) {
        return $query->orWhere('offense_leader', '=', $id)
                     ->orWhere('offense_slot_2', '=', $id)
                     ->orWhere('offense_slot_3', '=', $id)
                     ->orWhere('offense_slot_4', '=', $id)
                     ->orWhere('offense_slot_5', '=', $id)
                     ->orWhere('offense_slot_6', '=', $id)
                     ->orWhere('offense_slot_7', '=', $id)
                     ->orWhere('offense_slot_8', '=', $id);
    }

    private function checkDefenseSlots($query, $id) {
        return $query->orWhere('defense_leader', '=', $id)
                     ->orWhere('defense_slot_2', '=', $id)
                     ->orWhere('defense_slot_3', '=', $id)
                     ->orWhere('defense_slot_4', '=', $id)
                     ->orWhere('defense_slot_5', '=', $id)
                     ->orWhere('defense_slot_6', '=', $id)
                     ->orWhere('defense_slot_7', '=', $id)
                     ->orWhere('defense_slot_8', '=', $id);
    }

    private function checkAllSlots($query, $id) {
        return $query->orWhere('offense_leader', '=', $id)
                     ->orWhere('offense_slot_2', '=', $id)
                     ->orWhere('offense_slot_3', '=', $id)
                     ->orWhere('offense_slot_4', '=', $id)
                     ->orWhere('offense_slot_5', '=', $id)
                     ->orWhere('offense_slot_6', '=', $id)
                     ->orWhere('offense_slot_7', '=', $id)
                     ->orWhere('offense_slot_8', '=', $id)
                     ->orWhere('defense_leader', '=', $id)
                     ->orWhere('defense_leader', '=', $id)
                     ->orWhere('defense_slot_2', '=', $id)
                     ->orWhere('defense_slot_3', '=', $id)
                     ->orWhere('defense_slot_4', '=', $id)
                     ->orWhere('defense_slot_5', '=', $id)
                     ->orWhere('defense_slot_6', '=', $id)
                     ->orWhere('defense_slot_7', '=', $id)
                     ->orWhere('defense_slot_8', '=', $id);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Battle;
use App\Models\Character;
use App\Models\Creator;
use App\Models\Team;
use App\Models\Video;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BattleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * @return \Inertia\Response
     */
    public function create()
    {

        return Inertia::render('Admin/Battle', [
            'characters' => Character::orderBy('name')->get()->map(function($toon, $_) {
                return $toon->only([
                    'id',
                    'name',
                    'swgoh_api_id',
                    'force_alignment',
                    'category_id_list',
                    'combat_type'
                ]);
            }),
            'characters' => Character::orderBy('name')->get(),
            'battles' => Battle::orderByDesc('updated_at', 'desc')->get(),
            'creators' => Creator::orderBy('name')->get(),
            'teams' => Team::orderBy('name')->get(),
            'videos' => Video::orderBy('updated_at', 'desc')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Battle::create($request->validate($this->validateBattle()));

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Battle $battle
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Battle $battle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Battle $battle
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Battle $battle)
    {
        //
    }

    /**
     * @param Request $request
     * @param Battle $battle
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Battle $battle)
    {
        $battle->update($request->validate($this->validateBattle()));

        return redirect()->back();
    }

    /**
     * @param Battle $battle
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Battle $battle)
    {
        $battle->delete();
        return redirect()->back();
    }

    private function validateBattle() {
        return [
            'id' => 'nullable',
            'battle_type' => 'required|in:5v5,3v3,ships,training',
            'offense_leader' => 'required|integer',
            'offense_slot_2' => 'integer|nullable',
            'offense_slot_3' => 'integer|nullable',
            'offense_slot_4' => 'integer|nullable',
            'offense_slot_5' => 'integer|nullable',
            'offense_slot_6' => 'integer|nullable',
            'offense_slot_7' => 'integer|nullable',
            'offense_slot_8' => 'integer|nullable',
            'defense_leader' => 'required|integer|nullable',
            'defense_slot_2' => 'integer|nullable',
            'defense_slot_3' => 'integer|nullable',
            'defense_slot_4' => 'integer|nullable',
            'defense_slot_5' => 'integer|nullable',
            'defense_slot_6' => 'integer|nullable',
            'defense_slot_7' => 'integer|nullable',
            'defense_slot_8' => 'integer|nullable',
            'video_id' => 'required|integer',
            'score' => 'integer|nullable',
            'notes' => 'nullable',
            'video_timestamp' => 'required',
        ];
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Battle;
use App\Models\Character;
use App\Models\Creator;
use App\Models\Video;
use App\Policies\UserPolicy;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CreatorController extends Controller
{

    /**
     * @return \Inertia\Response
     */
    public function index()
    {
      return Inertia::render('Creators', [
            'creators' => Creator::orderBy('name')->get(),
            ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|string
     */
    public function create()
    {
        if (\Gate::denies('viewAdmin')) {
            return Redirect::route('search');
        }
        return Inertia::render('Admin/Creators', [
            'creators' => Creator::orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Creator::create(
            $request->validate([
                'name' => 'required',
                'url' => 'url|nullable',
                'notes' => 'nullable'
            ])
        );

        return redirect()->back();
    }

    /**
     * @param Creator $creator
     *
     * @return \Inertia\Response
     */
    public function show(Creator $creator)
    {
        $videos = Video::where('creator_id', '=', $creator->id)->get();
        return Inertia::render('Creator', [
            'creator' => $creator,
            'videos' => $videos,
            'battles' => Battle::whereIn('video_id', $videos->pluck('id'))->orderBy('score', 'desc')->get(),
            'characters' => Character::orderBy('name')->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Creator  $creator
     * @return \Illuminate\Http\Response
     */
    public function edit(Creator $creator)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Creator  $creator
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Creator $creator)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'url' => 'url|nullable',
            'notes' => 'nullable'
        ]);
        $creator->update($validatedData);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Creator  $creator
     * @return \Illuminate\Http\Response
     */
    public function destroy(Creator $creator)
    {
        $creator->delete();
        return redirect()->back();

    }
}

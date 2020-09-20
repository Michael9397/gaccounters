<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Creator;
use App\Models\Video;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Used for public page if we end up using it...
    }

    /**
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Video', [
           'creators' => Creator::orderBy('name')->get(),
           'videos' => Video::orderBy('created_at', 'desc')->get(),
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'creator_id' => 'required|int',
            'url' => 'url|nullable',
            'title' => 'nullable',
        ]);

        Video::create($validatedData);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video)
    {
        //
    }

    /**
     * @param Request $request
     * @param Video $video
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Video $video)
    {
        $validatedVideo = $request->validate([
            'creator_id' => 'required|int',
            'url' => 'url|nullable',
            'title' => 'nullable',
        ]);

        $video->update($validatedVideo);

        return redirect()->back();
    }

    /**
     * @param Video $video
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Video $video)
    {
        $video->delete();
        return redirect()->back();
    }
}

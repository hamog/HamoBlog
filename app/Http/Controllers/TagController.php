<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Tag;

class TagController extends Controller
{
    /**
     * Display a listing of the tag.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::paginate(10);
        return view('backend.tag.index', compact('tags'));
    }

    /**
     * Show the form for editing the specified tag.
     *
     * @param Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        return view('backend.tag.edit', compact('tag'));
    }

    /**
     * Update the specified tag in database.
     *
     * @param TagRequest|\Illuminate\Http\Request $request
     * @param Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function update(TagRequest $request, Tag $tag)
    {
        $tag->name = $request->name;
        $tag->save();
        return back()->with('success', 'Tag Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return back()->with('success', 'Tag removed!');
    }
}

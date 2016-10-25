<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Repositories\TagRepository;
use App\Tag;

class TagController extends Controller
{
    /**
     * Display a listing of the tag.
     *
     * @param TagRepository $tagRepository
     * @return \Illuminate\Http\Response
     */
    public function index(TagRepository $tagRepository)
    {
        $tags = $tagRepository->paginate(10);
        return view('backend.tag.index', compact('tags'));
    }

    /**
     * Show the form for editing the specified tag.
     *
     * @param $id
     * @param TagRepository $tagRepository
     * @return \Illuminate\Http\Response
     */
    public function edit($id, TagRepository $tagRepository)
    {
        $tag = $tagRepository->find($id);
        return view('backend.tag.edit', compact('tag'));
    }

    /**
     * Update the specified tag in database.
     *
     * @param integer $id
     * @param TagRequest $request
     * @param TagRepository $tagRepository
     * @return \Illuminate\Http\Response
     */
    public function update($id, TagRequest $request, TagRepository $tagRepository)
    {
        $tagRepository->update($id, ['name' => $request->name]);
        alert()->success('Success', 'Tag Updated.');
        return redirect()->route('tag.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param integer $id
     * @param TagRepository $tagRepository
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, TagRepository $tagRepository)
    {
        $tagRepository->delete($id);
        alert()->success('Success', 'Tag Removed.');
        return redirect()->route('tag.index');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Repositories\CategoryRepository;

class CategoryController extends Controller
{
    /**
     * Clear category count cache.
     *
     * @return void
     */
    private function clearCache()
    {
        if (cache()->has('catsCount')) {
            cache()->forget('catsCount');
        }
    }

    /**
     * Display a listing of the categories.
     *
     * @param CategoryRepository $category
     * @return \Illuminate\Http\Response
     */
    public function index(CategoryRepository $category)
    {
        $categories = $category->paginate(10);
        return view('backend.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.category.create');
    }

    /**
     * Store a newly created category in database.
     *
     * @param CategoryRequest $request
     * @param CategoryRepository $category
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request, CategoryRepository $category)
    {
        $category->create($request->all());
        $this->clearCache();
        alert()->success('Success', 'Category created.');
        return redirect()->route('category.index');
    }

    /**
     * Display the specified category.
     *
     * @param integer $id
     * @param CategoryRepository $category
     * @return \Illuminate\Http\Response
     */
    public function show($id, CategoryRepository $category)
    {
        $category = $category->find($id);
        return view('backend.category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param integer $id
     * @param CategoryRepository $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id, CategoryRepository $category)
    {
        $category = $category->find($id);
        return view('backend.category.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     *
     * @param integer $id
     * @param CategoryRequest $request
     * @param CategoryRepository $category
     * @return \Illuminate\Http\Response
     */
    public function update($id, CategoryRequest $request, CategoryRepository $category)
    {
        $category->update($id, ['name' => $request->name]);
        alert()->success('Category Updated.', "The category name='{$request->name}' successfully updated.");
        return redirect()->route('category.index');
    }

    /**
     * Remove the specified category from database.
     *
     * @param integer $id
     * @param CategoryRepository $categoryRepository
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, CategoryRepository $categoryRepository)
    {
        $categoryRepository->delete($id);
        $this->clearCache();
        alert()->error('Woops!', "Category is Removed.");
        return back();
    }
}

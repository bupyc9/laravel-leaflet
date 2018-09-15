<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        return \response(Category::all()->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function store(Request $request): Response
    {
        $data = \Validator::make(
            $request->post(),
            [
                'name' => 'required|max:255',
            ]
        )->validate();

        $category = Category::create($data);

        return \response(['id' => $category->id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Category $category
     * @return Response
     * @throws ValidationException
     */
    public function update(Request $request, Category $category): Response
    {
        $data = \Validator::make(
            $request->post(),
            [
                'name' => 'required|max:255',
            ]
        )->validate();

        $category->fill($data);
        $category->save();

        return \response($category->toArray());
    }
}

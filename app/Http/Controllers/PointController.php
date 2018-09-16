<?php

namespace App\Http\Controllers;

use App\Point;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class PointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        return \response(Point::query()->with('category')->get()->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     * @throws ValidationException
     */
    public function store(Request $request): Response
    {
        $data = \Validator::make(
            $request->post(),
            [
                'longitude' => 'required|numeric|min:-180|max:180',
                'latitude' => 'required|numeric|min:-90|max:90',
                'category_id' => 'required|exists:categories,id',
            ]
        )->validate();

        $point = Point::create($data);
        $point->category;

        return \response($point->toArray());
    }
}

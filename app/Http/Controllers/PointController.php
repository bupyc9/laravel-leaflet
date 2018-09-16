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
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function index(Request $request): Response
    {
        $data = \Validator::make(
            $request->query(),
            [
                'category_id' => 'integer|exists:categories,id'
            ]
        )->validate();

        $where = [];
        if (\array_key_exists('category_id', $data)) {
            $where['category_id'] = $data['category_id'];
        }

        $items = Point::query()
            ->where($where)
            ->with('category')
            ->get();

        return \response($items->toArray());
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

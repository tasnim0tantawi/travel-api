<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TourListRequest;
use App\Http\Resources\TourResource;
use App\Models\Travel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TourController extends Controller
{
    public function index(Travel $travel, TourListRequest $request)
    {

        $tours = TourResource::collection($travel->tours()->orderBy('starting_date', 'asc')->when($request->priceFrom, function ($query) use ($request) {
            $query->where('price', '>=', $request->priceFrom);
        })
            ->when($request->priceTo, function ($query) use ($request) {
                $query->where('price', '<=', $request->priceTo);
            })
            ->when($request->dateFrom, function ($query) use ($request) {
                $query->where('starting_date', '>=', $request->dateFrom);
            })
            ->when($request->dateTo, function ($query) use ($request) {
                $query->where('ending_date', '<=', $request->dateTo);
            })
            ->when($request->orderBy, function ($query) use ($request) {
                $query->orderBy($request->orderBy, $request->orderDirection);
            })

            ->paginate());

        return response()->json(
            [
                'data' => $tours,
                'meta' => [
                    'last_page' => $tours->lastPage(),
                    'current_page' => $tours->currentPage(),
                    'next_page_url' => $tours->nextPageUrl(),
                ],
            ],
            200
        );
    }
}

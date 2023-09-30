<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TourResource;
use App\Models\Travel;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function index(Travel $travel, Request $request)
    {
        $request->validate(
            [
                'priceFrom' => 'nullable|numeric|min:0',
                'priceTo' => 'nullable|numeric|min:0',
                'dateFrom' => 'nullable|date',
                'dateTo' => 'nullable|date',
                'orderBy' => 'nullable|in:price,starting_date',
                'orderDirection' => 'nullable|in:asc,desc',
            ],
            [
                'priceFrom.numeric' => 'The price from must be a number',
                'priceFrom.min' => 'The price from must be at least 0',
                'priceTo.numeric' => 'The price to must be a number',
                'priceTo.min' => 'The price to must be at least 0',
                'dateFrom.date' => 'The date from must be a date',
                'dateTo.date' => 'The date to must be a date',
                
            ]
        );

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

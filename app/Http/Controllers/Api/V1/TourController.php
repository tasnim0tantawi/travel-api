<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TourResource;
use App\Models\Travel;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function index(Travel $travel)
    {
        $tours = TourResource::collection($travel->tours()->paginate());

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

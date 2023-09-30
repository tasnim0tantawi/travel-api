<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TravelResource;
use Illuminate\Http\Request;
use App\Models\Travel;

class TravelController extends Controller
{
    public function index(){
        $travels = TravelResource::collection( Travel::where('is_public', true)->paginate());
        return response()->json(
            [
                'data' => $travels,
                'meta' => [
                    'last_page' => $travels->lastPage(),
                    'current_page' => $travels->currentPage(),
                    'next_page_url' => $travels->nextPageUrl(),

                ],
            ],
            200
        );
    }
}

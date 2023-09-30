<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tour;
use App\Models\Travel;

class TourListTest extends TestCase
{
    use RefreshDatabase;
    public function test_tours_list_by_travel_slug_returns_correct_data(): void
    {
        $travel = Travel::factory()->create([
            'is_public' => true,
        ]);
        $tour = Tour::factory()->count(16)->create([
            'travel_id' => $travel->id,
        ]);

        $response = $this->get('/api/v1/travels/' . $travel->slug . '/tours');

        $response->assertStatus(200);
        $response->assertJsonCount(15, 'data');
        $response->assertJsonPath('meta.last_page', 2);
    }

    public function test_tour_price_is_correct(): void
    {
        $travel = Travel::factory()->create([
            'is_public' => true,
        ]);
        $tour = Tour::factory()->create([
            'travel_id' => $travel->id,
            // float of 2 decimal places
            'price' => number_format(100.00, 2)
        ]);

        $response = $this->get('/api/v1/travels/' . $travel->slug . '/tours');

        $response->assertStatus(200);
        $response->assertJsonPath('data.0.price', number_format(100.00, 2));
    }

    public function test__tours_list_sorted_by_starting_date_correctly(){
        $travel = Travel::factory()->create([
            'is_public' => true,
        ]);
        $tour1 = Tour::factory()->create([
            'travel_id' => $travel->id,
            'starting_date' => '2021-01-01',
        ]);
        $tour2 = Tour::factory()->create([
            'travel_id' => $travel->id,
            'starting_date' => '2021-01-02',
        ]);
        $tour3 = Tour::factory()->create([
            'travel_id' => $travel->id,
            'starting_date' => '2021-01-03',
        ]);

        $response = $this->get('/api/v1/travels/' . $travel->slug . '/tours?orderBy=starting_date&orderDirection=asc');

        $response->assertStatus(200);
        $response->assertJsonPath('data.0.starting_date', '2021-01-01');
        $response->assertJsonPath('data.1.starting_date', '2021-01-02');
        $response->assertJsonPath('data.2.starting_date', '2021-01-03');

    }

}

<?php

namespace App\Observers;

use App\Models\Travel;

class TravelObserver
{
    /**
     * Handle the Travel "created" event.
     */
    public function creating(Travel $travel): void
    {
        //
        // $travel->slug = str($travel->name)->slug('-');

    }

    /**
     * Handle the Travel "updated" event.
     */
    public function updated(Travel $travel): void
    {
        //
    }

    /**
     * Handle the Travel "deleted" event.
     */
    public function deleted(Travel $travel): void
    {
        //
    }

    /**
     * Handle the Travel "restored" event.
     */
    public function restored(Travel $travel): void
    {
        //
    }

    /**
     * Handle the Travel "force deleted" event.
     */
    public function forceDeleted(Travel $travel): void
    {
        //
    }
}

<?php

namespace App\Events;

use App\Models\GuardianEarth;
use Illuminate\Queue\SerializesModels;

class GuardianShareEvents
{
    use SerializesModels;

    /**
     * App\Models\GuardianEarth
     * @var Model
     */
    public $activity;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($activity_id)
    {
        $this->activity = GuardianEarth::findOrFail($activity_id);
    }

}

<?php

namespace Modules\CustomerTracker\Services;

use Modules\CustomerTracker\Entities\UniqueVisitors;

class UniqueVisitorService
{
    /**
     * Records unique visitors for the current date.
     */
    public function recordUniqueVisitor(): void
    {
        $visitor = UniqueVisitors::whereDate('date', now()->toDateString())->first();
        
        if (!$visitor) {
            UniqueVisitors::create([
                'count' => 1,
                'date' => now()->toDateString(),
            ]);
        } else {
            $visitor->increment('count');
        }
    }
}

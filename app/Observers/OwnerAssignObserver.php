<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;

class OwnerAssignObserver
{
    public function creating($model)
    {
        if (Auth::user()) {
            \Log::info("Owner assignObserver dentro if");

            \Log::info("if");
            $model->owner_id = Auth::user()->owner_id;
            \Log::info($model);
        }
    }
}

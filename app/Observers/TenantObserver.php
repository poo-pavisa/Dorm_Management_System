<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Tenant;
use App\Models\Room;


class TenantObserver
{
    public function created(Tenant $tenant)
    {
        $user = User::find($tenant->user_id);
        if ($user) {
            $user->role = 'Tenant';
            $user->save();
        }
        
        $room = $tenant->room;
        if ($room) {
            $room->is_available = false;
            $room->save();
        }
    }

}

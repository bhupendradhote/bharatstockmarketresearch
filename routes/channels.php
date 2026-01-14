<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('bsmr-chat', function () {
    return true;
});



/**
 * User ka private channel
 * user.{id}
 */
Broadcast::channel('user.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});



// User-specific private channel
Broadcast::channel('user.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

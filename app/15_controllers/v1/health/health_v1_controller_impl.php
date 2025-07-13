<?php

namespace App\Controllers\V1\Health;

use Illuminate\Http\Request;

class HealthV1ControllerImpl implements HealthV1Controller {

    public function ping(): \Closure
    {
        return function(Request $request) {
            return response()->json(['status' => 'ok']);
        };
    }

}

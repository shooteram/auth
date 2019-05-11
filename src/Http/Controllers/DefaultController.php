<?php

namespace shooteram\Auth\Http\Controllers;

class DefaultController
{
    public function getCsrfToken()
    {
        return response()->json(null, 200);
    }
}

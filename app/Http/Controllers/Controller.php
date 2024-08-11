<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function authorization()
    {

         $user = auth()->user();
         if ($user->is_admin == 0)
        {
            abort(403, 'PLEASE CONTACT THE ADMINISTRATOR');
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class ApiController extends Controller
{
    use ApiResponse;

    protected function allowedAdminAction()
    {
    	// if (Gate::denies('admin-action')) {
     //        throw new AuthorizationException('This action is unauthorized');
     //    }
    }
}

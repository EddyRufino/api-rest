<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class ApiController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
    	$this->middleware('auth:api');
    }

    protected function allowedAdminAction()
    {
    	// if (Gate::denies('admin-action')) {
     //        throw new AuthorizationException('This action is unauthorized');
     //    }
    }
}

<?php

namespace Modules\AuthAdmin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\AuthAdmin\Services\AuthService;

class AuthAdminController extends Controller
{
    protected $auth_service;

    public function __construct(AuthService $auth_service)
    {
        $this->auth_service = $auth_service;
    }

    /**
     * Authenticates the admin user.
     * 
     * @param Request login, password
     * @return \Illuminate\Http\JsonResponse A JSON response indicating authentication success or failure.
     */
    public function authAdmin(Request $request)
    {
        $login = $request->input('login');
        $password = $request->input('password');

        $result = $this->auth_service->authenticate($login, $password);

        return response()->json($result, 200);
    }
}

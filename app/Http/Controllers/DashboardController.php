<?php

namespace App\Http\Controllers;

use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $userController = app(UserController::class);
        $users = $userController->index();

        return view("dashboard", compact("users"));
    }
}

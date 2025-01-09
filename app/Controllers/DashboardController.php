<?php

namespace App\Controllers;

class DashboardController extends BaseController
{
    public function index()
    {
        $session = session();
        $role = $session->get('user')['role'];

        return view('dashboard/index', ['role' => $role]);
    }
}

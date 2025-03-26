<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Home Page'
        ];

        return view('home', $data);
    }

    public function dashboardCustomer()
    {
        $data = [
            'title' => 'Dashboard'
        ];

        return View('components/dashboard', $data);
    }

}

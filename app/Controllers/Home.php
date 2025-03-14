<?php

namespace App\Controllers;

use Config\View;
use SebastianBergmann\Type\VoidType;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Home Page'
        ];

        return view('home', $data);
    }

    public function dashboardProductManager()
    {
        $data = [
            'title' => 'Dashboard'
        ];

        return View('components/dashboard', $data);
    }

    public function dashboardCustomer()
    {
        $data = [
            'title' => 'Dashboard'
        ];

        return View('components/dashboard', $data);
    }

}

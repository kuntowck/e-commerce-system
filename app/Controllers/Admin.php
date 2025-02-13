<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function dashboard()
    {
        echo 'Admin controller | Dashboard';
    }

    public function users()
    {
        echo 'Admin controller | Users';
    }
}

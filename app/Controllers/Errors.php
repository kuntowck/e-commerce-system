<?php

namespace App\Controllers;

class Errors extends BaseController
{
    public function show404()
    {
        return "404. Gak ketemu gan :D";
    }
}

<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $role = 'admin';

        if (!$role !== 'admin') {
            // Jika tidak, arahkan ke halaman login atau halaman lain yang sesuai
            return redirect()->to('/')->with('error', 'You must be an admin to access this page.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}

<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;

class User extends BaseController
{
    protected $helpers = ['url', 'form'];

    public function __construct()
    {
        helper(['form', 'url', 'text', 'date']);
    }

    public function index()
    {
        echo "Admin \ user controller page";
    }

    public function profile($id, $slug)
    {
        // url helper
        // $previousUrl = previous_url();
        // $currentUrl = current_url();

        // form helper
        $dropdown = form_dropdown(
            'categories',
            [
                '1' => 'electronics',
                '2' => 'fashion',
                '3' => 'books'
            ],
            '3',
            ['class' => 'form-control']
        );

        helper('product');
        $calculateDiscount = calculate_discount(150000, 20);
        $formattedPrice = format_price($calculateDiscount);

        $data = [
            'id' => $id,
            'name' => $slug
        ];

        $rule = [
            'id' => 'integer',
            'name' => 'required | max_length[255]'
        ];

        if (! $this->validateData($data, $rule)) {
            echo $this->validator->getErrors();
        }

        // echo $formattedPrice;
    }
}

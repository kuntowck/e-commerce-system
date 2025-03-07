<?php

namespace App\Libraries;

use CodeIgniter\HTTP\IncomingRequest;

class DataParams
{
    public $search = '';
    public $sort = 'id';
    public $order = 'asc';
    public $page = 1;
    public $perPage = 2;

    // user filter
    public $role = '';
    public $status = '';

    // product filter
    public $price_range = '';
    public $category_id = '';

    public function __construct(array $params = [])
    {
        $this->search = $params['search'] ?? '';
        $this->sort = $params['sort'] ?? 'id';
        $this->order = $params['order'] ?? 'asc';
        $this->page = (int)($params['page'] ?? 1);
        $this->perPage = (int)($params['perPage'] ?? 2);

        $this->role = $params['role'] ?? '';
        $this->status = $params['status'] ?? '';

        $this->category_id = $params['category_id'] ?? '';
        $this->price_range = $params['price_range'] ?? '';
    }

    public function getParams()
    {
        return [
            'search' => $this->search,
            'sort' => $this->sort,
            'order' => $this->order,
            'page' => $this->page,
            'perPage' => $this->perPage,
            'role' => $this->role,
            'status' => $this->status,
            'category_id' => $this->category_id,
            'price_range' => $this->price_range
        ];
    }

    public function getSortUrl($column, $baseUrl)
    {
        $params = $this->getParams();

        // Set sort to column and toggle order if already sorted by this column
        $params['sort'] = $column;
        $params['order'] = ($column == $this->sort && $this->order == 'asc') ? 'desc' : 'asc';

        // Build query string
        $queryString = http_build_query(array_filter($params));
        return $baseUrl . '?' . $queryString;
    }

    public function getResetUrl($baseUrl)
    {
        return $baseUrl;
    }


    public function isSortedBy($column)
    {
        return $this->sort === $column;
    }


    public function getSortDirection()
    {
        return $this->order;
    }
}

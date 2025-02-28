<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Produk;

class M_Produk extends Model
{
    private $products = [];

    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \App\Entities\Produk::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'name', 'description', 'price', 'stock', 'status', 'is_new', 'is_sale'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'name' => 'required|min_length[3]',
        'price' => 'required|numeric|greater_than[0]',
        'stock' => 'required|integer|greater_than_equal_to[0]',
    ];
    protected $validationMessages = [
        'name' => [
            'required' => 'Product name is required.',
            'min_length' => 'Product name must be at least 3 characters long.',
        ],
        'price' => [
            'required' => 'Price is required.',
            'numeric' => 'Price must be a numeric value.',
            'greater_than' => 'Price must be greater than 0.',
        ],
        'stock' => [
            'required' => 'Stock is required.',
            'integer' => 'Stock must be an integer value.',
            'greater_than_equal_to' => 'Stock must be greater than or equal to 0.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function findAvailableProducts()
    {
        return $this->where('status', 'Available')->countAllResults();
    }

    public function getLowStockProducts($threshold = 5)
    {
        return $this->where('stock <', $threshold)->countAllResults();
    }

    public function getProductsByCategory($category)
    {
        return $this->where('category', $category)->findAll();
    }

    public function countTotalProducts()
    {
        return $this->countAllResults();
    }

    public function getProductStatistics()
    {
        $productStats['total_products'] = $this->countAllResults();
        $productStats['available_products'] = $this->findAvailableProducts();
        $productStats['out_of_stock'] = $this->getLowStockProducts();

        return $productStats;
    }

    public function getCategoriesByProductId($productId)
    {
        $categories = [
            1 => ['Makanan', 'Rice'],
            2 => ['Makanan', 'Sate'],
            3 => ['Makanan', 'Snacks'],
        ];

        return $categories[$productId];
    }
}

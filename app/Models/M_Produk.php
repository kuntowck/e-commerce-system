<?php

namespace App\Models;

use App\Libraries\DataParams;
use CodeIgniter\Model;

class M_Produk extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \App\Entities\Produk::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'name', 'description', 'price', 'stock', 'category_id', 'status', 'is_new', 'is_sale', 'created_at'];

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

    public function getProductJoinCategoriesImages()
    {
        return $this->select('products.*, categories.name as category_name, product_images.image_path, product_images.id as product_images_id, product_images.is_primary')
            ->join('categories', 'categories.id = products.category_id')
            ->join('product_images', 'product_images.product_id = products.id', 'left')
            ->where('product_images.is_primary', 1);
    }


    public function getFilteredProducts(DataParams $params)
    {
        // Apply search
        if (!empty($params->search)) {
            $this->groupStart()
                ->like('products.name', $params->search, 'both', null, true)
                ->orLike('products.description', $params->search, 'both', null, true)
                ->orLike('products.status', $params->search, 'both', null, true);

            if (is_numeric($params->search)) {
                $this->Where('CAST (products.id AS TEXT) LIKE', "%$params->search%")
                    ->orWhere('CAST (products.price AS TEXT) LIKE', "%$params->search%")
                    ->orWhere('CAST (products.stock AS TEXT) LIKE', "%$params->search%");
            }
            $this->groupEnd();
        }

        // Apply category filter
        if (!empty($params->category_id)) {
            $this->where('products.category_id', $params->category_id);
        }

        // Apply price range filter
        if (!empty($params->price_range)) {
            $priceRange = $params->price_range;

            $params->price_range = explode('-', $params->price_range);
            $this->where('products.price >=', $params->price_range[0]);
            $this->where('products.price <=', $params->price_range[1]);

            $params->price_range = $priceRange;
        }

        $allowedSortColumns = ['id', 'name', 'price', 'created_at'];

        $sort = in_array($params->sort, $allowedSortColumns) ? $params->sort : 'id';
        $order = ($params->order === 'desc') ? 'desc' : 'asc';

        $this->orderBy($sort, $order);

        return [
            'products' => $this->getProductJoinCategoriesImages()
                ->paginate($params->perPage, 'products', $params->page),
            'pager' => $this->pager,
            'total' => $this->countAllResults(false),
        ];
    }

    public function getAllPriceRange()
    {
        return [
            ['value' => '0-25000', 'label' => '0 - Rp25.000'],
            ['value' => '25000-50000', 'label' => 'Rp25.000 - Rp50.000'],
            ['value' => '50000-100000', 'label' => 'Rp50.000 - Rp100.000'],
            ['value' => '100000-200000', 'label' => 'Rp100.000 - Rp200.000']
        ];
    }

    public function getProductJoinCategories()
    {
        return $this->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id',);
    }
}

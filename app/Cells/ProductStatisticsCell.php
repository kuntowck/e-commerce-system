<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class ProductStatisticsCell extends Cell
{
    public $salesTrends;
    public $inventoryLevels;

    public function mount($salesTrends, $inventoryLevels)
    {
        $this->salesTrends = $salesTrends;
        $this->inventoryLevels = $inventoryLevels;
    }

    public function getSalesTrendsProperty()
    {
        return $this->salesTrends;
    }

    public function getInventoryLevelsProperty()
    {
        return $this->inventoryLevels;
    }
}

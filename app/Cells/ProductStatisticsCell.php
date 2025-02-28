<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class ProductStatisticsCell extends Cell
{
    protected $growthPercentage;

    public function mount($growthPercentage)
    {
        $this->growthPercentage = $growthPercentage;
    }

    public function getGrowthPercentageProperty()
    {
        return $this->growthPercentage;
    }
}

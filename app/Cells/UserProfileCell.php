<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class UserProfileCell extends Cell
{
    protected $text, $date;

    public function getTextProperty()
    {
        return $this->text;
    }

    public function getDateProperty()
    {
        return $this->date;
    }
}

<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class BadgeCell extends Cell
{
    protected $text, $theme;

    public function mount()
    {
        if ($this->text === 'new' || $this->text === 'New' || $this->text === 'active') {
            $this->theme = 'green';
        } else if ($this->text === 'sale' || $this->text === 'Sale' || $this->text === 'inactive') {
            $this->theme = 'red';
        }
    }

    public function getTextProperty()
    {
        return $this->text;
    }
    public function getThemeProperty()
    {
        return $this->theme;
    }
}

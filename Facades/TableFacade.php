<?php


namespace LKozlova\Widgets\Facades;

use Illuminate\Support\Facades\Facade;
use LKozlova\Widgets\TableWidget;

class TableFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return TableWidget::class;
    }
}

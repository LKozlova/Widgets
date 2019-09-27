<?php


namespace LKozlova\Widgets\Facades;

use Illuminate\Support\Facades\Facade;
use LKozlova\Widgets\Table;

class TableFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Table::class;
    }
}

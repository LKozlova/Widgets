<?php


namespace LKozlova\Widgets\Facades;

use Illuminate\Support\Facades\Facade;
use LKozlova\Widgets\ListWidget;

class ListFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ListWidget::class;
    }
}
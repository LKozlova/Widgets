<?php


namespace LKozlova\Widgets\Facades;

use Illuminate\Support\Facades\Facade;
use LKozlova\Widgets\Html;

class HtmlFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Html::class;
    }
}

<?php


namespace LKozlova\Widgets\Facades;

use Illuminate\Support\Facades\Facade;
use LKozlova\Widgets\HtmlWidget;

class HtmlFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return HtmlWidget::class;
    }
}

<?php


namespace LKozlova\Widgets;

use Illuminate\Support\ServiceProvider;
use LKozlova\Widgets\Facades\HtmlFacade;
use LKozlova\Widgets\Facades\TableFacade;

/**
 * Class WidgetsServiceProvider
 * @package LKozlova\Widgets
 */
class WidgetsServiceProvider extends ServiceProvider
{
    /**
     *
     */
    public function register()
    {
        $this->loadViewsFrom(__DIR__.'/views/', 'widgets');
    }
}

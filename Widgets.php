<?php


namespace LKozlova\Widgets;

use Illuminate\Support\HtmlString;

/**
 * Class WidgetsManager
 * @package LKozlova\Widgets
 */
abstract class Widgets
{
    protected $html;

    /**
     * @param Widgets $widget
     * @param $widgetFunction
     * @return HtmlString
     */
    protected function run(Widgets $widget, $widgetFunction)
    {
        $widget->$widgetFunction();

        return $widget->generateHtml();
    }

    /**
     * @return HtmlString
     */
    protected function generateHtml()
    {
        return new HtmlString($this->html);
    }

    /**
     * @param string $tag
     * @param array|null $params
     */
    protected function addTagToHtml(string $tag, array $params = null)
    {
        $this->html .= $this->renderHtml('widgets::_tag', [
            'tag' => $tag,
            'params' => $params ?? [],
        ]);
    }

    /**
     * @param string $data
     */
    protected function addStringToHtml(string $data = '')
    {
        $this->html .= $data;
    }

    /**
     * @param string $view
     * @param array $params
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    protected function renderHtml(string $view, array $params)
    {
        return view($view, $params);
    }
}

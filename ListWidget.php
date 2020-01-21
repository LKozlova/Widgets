<?php


namespace LKozlova\Widgets;


use LKozlova\Widgets\Exceptions\InvalidWidgetsException;

class ListWidget extends Widgets
{
    private $config;
    private $collection;

    /**
     * Table constructor.
     * @param array|null $config
     * @param null $collection
     */
    public function __construct(array $config = null, $collection = null)
    {
        $this->config = $config;
        $this->collection = $collection;
    }

    /**
     * @param array $config
     * @param $collection
     * @return HtmlString
     */
    public function list(array $config, $collection)
    {
        return parent::run(
            new $this($config, $collection),
            'listCreate'
        );
    }

    /**
     * @throws InvalidWidgetsException
     */
    protected function listCreate()
    {
        $this->addTagToHtml('div', ['class'=>'list-group']);

        $this->renderList();

        $this->addTagToHtml('/div');
    }

    /**
     * @throws InvalidWidgetsException
     */
    protected function renderList()
    {
        foreach ($this->collection as $item) {
            
            if (isset($item->{$this->config['params']['attribute']})) {
                throw new InvalidWidgetsException('Attrubute'. $this->config['params']['attribute'] . 'not found');
            }
            
            $this->addTagToHtml('a', [
                'href' => $this->renderConfigHref($this->config['params']['href'], $item),
                'class' => 'list-group-item list-group-item-action',
            ]);
            
            $this->addStringToHtml($item->{$this->config['params']['attribute']});

            $this->addTagToHtml('/a');
        }
    }

    /**
     * @param $href
     * @param $data
     * @return string|string[]
     * @throws InvalidWidgetsException
     */
    protected function renderConfigHref($href, $data)
    {
        if (is_array($href)) {
            $href_link = (string)$href[0];

            if (!is_array($href[1])) {
                throw new InvalidWidgetsException( 'Array \'href\' not valid');
            }

            foreach ($href[1] as $attribute => $value) {
                $result = str_replace(".'$attribute'", $data->{$value}, $href_link);
            }
            return $result;
        }

        return $href;
    }
}

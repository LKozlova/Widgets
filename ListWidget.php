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
            
            if (isset($item->{$config['params']['attribute']})) {
                throw new InvalidWidgetsException('Attrubute'. $config['params']['attribute'] . 'not found');
            }
            
            $this->addTagToHtml('a', [
                'href' => $this->renderConfigHref($this->config['params']['href'], $item),
                'class' => 'list-group-item list-group-item-action',
            ]);
            
            $this->addStringToHtml($item->{$config['params']['attribute']});

            $this->addTagToHtml('/a');
        }
    }

    /**
     * @param $config
     * @param $data
     * @return string|string[]
     */
    protected function renderConfigHref($config, $data)
    {
        if (is_array($config)) {
            $href = (string)$config[0];
            foreach ($config[1] as $attribute => $value) {
                $href = str_replace(".'$attribute'", $data->{$value}, $href);
            }
            return $href;
        }

        return $config;
    }
}

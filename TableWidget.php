<?php


namespace LKozlova\Widgets;

use Illuminate\Support\HtmlString;
use LKozlova\Widgets\Exceptions\InvalidWidgetsException;

/**
 * Class TableWidget
 * @package LKozlova\Widgets
 *
 * {{TableWidget::table([
 *      'params' => [
 *          'class' => 'table  table-striped',
 *      ],
 *      'columns' => [
 *          'id',
 *          'created_at',
 *          'status',
 *          'error_message',
 *          'event',
 *          [
 *              'label' => 'action',
 *              'value' => [
 *                  HtmlWidget::tag('form', [
 *                      'value' => HtmlWidget::tag('button', [
 *                          'params' => [
 *                              'formaction' => "logs/.'id_value'",
 *                          ]
 *                          'value' => 'See more',
 *                       ])
 *                  ]),
 *                  [
 *                      'id_value' => 'id',
 *                  ]
 *              ],
 *          ],
 *      ],
 * ], $queuelogs)}}
 */
class TableWidget extends Widgets
{
    private $config;
    private $collection;

    /**
     * TableWidget constructor.
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
    public function table(array $config, $collection)
    {
        return parent::run(
            new $this($config, $collection),
            'tableCreate'
        );
    }

    /**
     * @throws InvalidWidgetsException
     */
    protected function tableCreate()
    {
        $this->addTagToHtml('table', $this->config['params'] ?? null);

        $this->renderTableHeader();
        $this->renderTableBody();

        $this->addTagToHtml('/table');
    }

    /**
     * @throws InvalidWidgetsException
     */
    protected function renderTableHeader()
    {
        $this->addTagToHtml('thead');
        $this->addTagToHtml('tr');

        if (!empty($this->config)) {
            foreach ($this->config['columns'] as $key => $column) {
                $this->addTagToHtml('th');
                if (is_array($column)) {
                    if(!isset($column['label']) && !isset($column['attribute']) && !isset($column['value'])){
                        throw new InvalidWidgetsException("Column data not found");
                    }

                    $this->addStringToHtml($column['label'] ?? $column['attribute'] ?? $column['value']);

                } else {
                    $this->addStringToHtml($column);
                }
                $this->addTagToHtml('/th');
            }
        }

        $this->addTagToHtml('/tr');
        $this->addTagToHtml('/thead');
    }

    /**
     * @throws InvalidWidgetsException
     */
    protected function renderTableBody()
    {
        $this->addTagToHtml('tbody');

        if (!empty($this->collection)) {
            if (is_object($this->collection[0])) {
                foreach ($this->collection as $data) {
                    $this->renderTableRow($data);
                }
            } else {
                $this->renderTableRow($this->collection);
            }
        }

        $this->addTagToHtml('/tbody');
    }

    private function renderTableRow($data)
    {
        $this->addTagToHtml('tr');
        foreach ($this->config['columns'] as $column) {
            $this->addTagToHtml('td');

            if(is_array($column)) {
                if (!isset($column['attribute']) && !isset($column['value'])) {
                    throw new InvalidWidgetsException("Column data not found");
                }

                $this->addStringToHtml(
                    (isset($column['attribute'])) ?
                        (string)$this->renderTableAttribute($data->{$column['attribute']}) :
                        (string)$this->renderTableValue($column['value'], $data)
                );

                $this->addTagToHtml('/td');
            } else {
                $this->addStringToHtml((string)$data->{$column});
            }
        }
        $this->addTagToHtml('/tr');
    }

    /**
     * @param $attribute
     * @return mixed
     */
    protected function renderTableAttribute($attribute)
    {
        return $attribute;
    }

    /**
     * @param $value
     * @param $data
     * @return array|mixed|string
     */
    protected function renderTableValue($value, $data)
    {
        if (is_array($value)) {
            $tableElem = (string)$value[0];
            foreach ($value[1] as $attribute => $value) {
                $tableElem = str_replace(".'$attribute'", $data->{$value}, $tableElem);
            }
            return $tableElem;
        }

        return $value;
    }
}

<?php


namespace LKozlova\Widgets;

/**
 * Class Html
 * @package LKozlova\Widgets
 */
class Html extends Widgets
{
    private $tagName;
    private $config;
    private $endTag;

    /**
     * Html constructor.
     * @param string|null $tagName
     * @param array|null $config
     * @param $endTag
     */
    public function __construct(string $tagName = null, array $config = null, $endTag = true)
    {
        $this->tagName = $tagName;
        $this->config = $config;
        $this->endTag = $endTag ?? $this->checkTagName();
    }

    /**
     * @param string $tagName
     * @param null $config
     * @param bool $endTag
     * @return \Illuminate\Support\HtmlString
     */
    public function tag(string $tagName, $config = null, $endTag = true)
    {
        return parent::run(
            new $this($tagName, $config, $endTag),
            "tagCreate"
        );
    }

    /**
     *
     */
    protected function tagCreate()
    {
        $this->addTagToHtml($this->tagName, $this->config['params'] ?? null);
        $this->addStringToHtml(
            (isset($this->config['value'])) ?
                (string)$this->config['value'] :
                ''
        );
        !($this->endTag) ?: $this->addTagToHtml('/'.$this->tagName);
    }

    private function checkTagName()
    {
        return !($this->tagName[0] === "/");
    }
}

<?php

namespace Framework\Template;

class PhpRenderer implements TemplateRenderer
{
    private $path;
    private $extend;
    private $params = [];

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function render($name, array $params = []): string
    {
        $templateFile = $this->path . '/' . $name . '.php';
        ob_start();
        extract($params, EXTR_OVERWRITE);
        $this->extend = null;
        require $templateFile;
        $content = ob_get_clean();

        if (!$this->extend) {
            return $content;
        }

        return $this->render($this->extend, [
            'content' => $content,
        ]);
    }

    public function extend($view): void
    {
        $this->extend = $view;
    }
}

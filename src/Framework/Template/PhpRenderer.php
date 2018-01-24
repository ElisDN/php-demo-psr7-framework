<?php

namespace Framework\Template;

class PhpRenderer implements TemplateRenderer
{
    private $path;
    private $extend;
    private $blocks = [];
    private $blockNames;

    public function __construct($path)
    {
        $this->path = $path;
        $this->blockNames = new \SplStack();
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
        return $this->render($this->extend);
    }

    public function extend($view): void
    {
        $this->extend = $view;
    }

    public function block($name, $content): void
    {
        if ($this->hasBlock($name)) {
            return;
        }
        $this->blocks[$name] = $content;
    }

    public function ensureBlock($name): bool
    {
        if ($this->hasBlock($name)) {
            return false;
        }
        $this->beginBlock($name);
        return true;
    }

    public function beginBlock($name): void
    {
        $this->blockNames->push($name);
        ob_start();
    }

    public function endBlock(): void
    {
        $content =  ob_get_clean();
        $name = $this->blockNames->pop();
        if ($this->hasBlock($name)) {
            return;
        }
        $this->blocks[$name] = $content;
    }

    public function renderBlock($name): string
    {
        $block = $this->blocks[$name] ?? null;

        if ($block instanceof \Closure) {
            return $block();
        }

        return $block ?? '';
    }

    private function hasBlock($name): bool
    {
        return array_key_exists($name, $this->blocks);
    }
}

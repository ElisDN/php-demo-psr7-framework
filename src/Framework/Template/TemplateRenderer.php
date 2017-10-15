<?php

namespace Framework\Template;

interface TemplateRenderer
{
    public function render($name, array $params = []): string;
}

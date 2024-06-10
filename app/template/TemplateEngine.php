<?php

namespace blog\template;

class TemplateEngine
{
    protected $vars = [];

    public function set($key, $value)
    {
        $this->vars[$key] = $value;
    }

    public function render($template)
    {
        $templatePath = __DIR__ . '/../views/' . $template . '.php';

        if (!file_exists($templatePath)) {
            throw new \Exception("Template file not found: $templatePath");
        }

        extract($this->vars);
        ob_start();
        include($templatePath);
        return ob_get_clean();
    }

    public static function loadPartial($subdir, $file, $data = [])
    {
        $partialPath = __DIR__ . '/../views/partials/' . $subdir . '/' . $file . '.php';

        if (!file_exists($partialPath)) {
            throw new \Exception("Partial file not found: $partialPath");
        }

        extract($data);
        ob_start();
        include($partialPath);
        return ob_get_clean();
    }
}

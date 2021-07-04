<?php
namespace Base;

class View
{
    private $templatePath;
    private $data;

    public function setTemplatePath(string $path)
    {
        $this->templatePath = $path;
    }

    public function __get($name)
    {
        if (!$name) {
            return ERROR_INDEX;
        }

        return $this->data[$name];
    }

    public function render(string $tpl, $data = []): string
    {
        foreach ($data as $key => $value) {
            $this->data[$key] = $value;
        }
        ob_start();
        include $this->templatePath . '/' . $tpl;
        $data = ob_get_clean();
        return $data;
    }
}
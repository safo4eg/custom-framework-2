<?php
namespace Src;
use Exception;
class View
{
    private string $view = '';
    private array $data = [];
    private string $root = '';
    private array $webroot = [];
    private string $layout = DIRECTORY_SEPARATOR.'layouts'.DIRECTORY_SEPARATOR.'main.php';

    public function __construct(string $view = '', array $data = [])
    {
        $this->root = $this->getRoot();
        $this->view = $view;
        $this->data = $data;
    }

    private function getRoot(): string
    {
        global $app;
        $root = $app->settings->getRootPath();
        $path = $app->settings->getViewsPath();

        $this->webroots = $app->settings->getWebrootsPath();

        return $_SERVER['DOCUMENT_ROOT'] . $root . $path;
    }

    private function getPathToMain(): string
    {
        return $this->root . $this->layout;
    }

    private function getPathToWebrootLayout(): string
    {
        global $app;
        return $_SERVER['DOCUMENT_ROOT'] . $app->settings->getRootPath() . DIRECTORY_SEPARATOR . "core" .
            DIRECTORY_SEPARATOR . "layouts" .
            DIRECTORY_SEPARATOR . "webroot.php";
    }

    private function getPathToView(string $view = ''): string
    {
        $view = str_replace('.', DIRECTORY_SEPARATOR, $view);
        return $this->getRoot() . DIRECTORY_SEPARATOR . "$view.php";
    }

    public function render(string $view = '', array $data = []): string
    {
        $path = $this->getPathToView($view);
        if(file_exists($this->getPathToMain()) && file_exists($path)) {
            extract($data, EXTR_PREFIX_SAME, '');
            ob_start();
            require $path;
            $content = ob_get_clean();

            ob_start();
            $webroots = $this->webroots;
            require $this->getPathToWebrootLayout();
            $webroots = ob_get_clean();

            return require($this->getPathToMain());
        }

        throw new Exception('Не найдено представление/базовый шаблон');
    }

    public function __toString(): string
    {
        return $this->render($this->view, $this->data);
    }

}
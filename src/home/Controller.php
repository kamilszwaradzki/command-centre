<?php
namespace Modules\Home;

use Core\View;

class Controller
{
    private View $view;

    public function __construct()
    {
        $this->view = new View();
    }

    public function index(): void
    {
        $this->view
            ->show('home');
    }
}
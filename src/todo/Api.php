<?php
namespace Todo;
require_once __DIR__ . '/../../vendor/autoload.php';

class Api {

    private $model;

    public function __construct()
    {
        $this->model = new Model();
    }

    public function getUnfinishedTodo()
    {
        header('Content-type: application/json; charset=utf-8');
        echo json_encode($this->model->getAll(['status' => ['$ne' => 'on']])->toArray());
    }
}

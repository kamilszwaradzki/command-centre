<?php
namespace Hobby;
require_once __DIR__ . '/../../vendor/autoload.php';

class Controller {

    private $model;

    public function __construct()
    {
        $this->model = new Model();
    }

    public function add()
    {
        $data = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'date_added' => date('Y-m-d'),
            'progress' => $_POST['progress']
        ];
        $this->model->add($data);
    }

    public function copy()
    {
        $collection = $this->model->getOne(['_id' => $_POST['id']]);
        $data = [
            'title' => $collection->title,
            'description' => $collection->description,
            'date_added' => date('Y-m-d'),
            'progress' => $collection->progress
        ];
        $this->model->add($data);
    }

    public function update()
    {
        $data = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'progress' => $_POST['progress']
        ];
        $this->model->update(['_id' => $_POST['id']], $data);
    }

    public function delete()
    {
        $this->model->delete(['_id' => $_POST['id']]);
    }
}

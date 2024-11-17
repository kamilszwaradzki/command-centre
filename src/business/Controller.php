<?php
namespace Business;
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
            'category' => $_POST['category'],
            'date_added' => date('Y-m-d'),
            'amount' => $_POST['amount'],
        ];
        $this->model->add($data);
    }

    public function copy()
    {
        $collection = $this->model->getOne(['_id' => $_POST['id']]);
        $data = [
            'title' => $collection->title,
            'category' => $collection->category,
            'date_added' => date('Y-m-d'),
            'amount' => $collection->amount
        ];
        $this->model->add($data);
    }

    public function update()
    {
        $data = [
            'title' => $_POST['title'],
            'category' => $_POST['category'],
            'amount' => $_POST['amount'],
        ];
        $this->model->update(['_id' => $_POST['id']], $data);
    }

    public function delete()
    {
        $this->model->delete(['_id' => $_POST['id']]);
    }
}

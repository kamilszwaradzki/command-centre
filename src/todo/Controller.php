<?php
namespace Todo;
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
            'content' => $_POST['content'],
            'date_added' => date('Y-m-d'),
            'estimated_finish_date' => $_POST['estimated_finish_date'],
            'date_finish' => '',
            'status' => $_POST['status']
        ];
        $this->model->add($data);
    }

    public function copy()
    {
        $collection = $this->model->getOne(['_id' => $_POST['id']]);
        $data = [
            'title' => $collection->title,
            'content' => $collection->content,
            'estimated_finish_date' => $collection->estimated_finish_date,
            'date_added' => date('Y-m-d'),
            'date_finish' => $collection->date_finish,
            'status' => $collection->status
        ];
        $this->model->add($data);
    }

    public function update()
    {
        $data = [
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'estimated_finish_date' => $_POST['estimated_finish_date'],
            'date_finish' => $_POST['date_finish'],
            'status' => $_POST['status']
        ];
        $this->model->update(['_id' => $_POST['id']], $data);
    }

    public function delete()
    {
        $this->model->delete(['_id' => $_POST['id']]);
    }
}

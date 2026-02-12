<?php
namespace Modules\Todo;

use Core\View;
use Exception;

class Controller
{
    private View $view;
    private Model $model;

    public function __construct()
    {
        $this->view = new View();
        $this->model = new Model();
    }

    public function index(): void
    {
        $todo = $this->model->getAll()->toArray();
        $this->view
            ->with(['todo_collection' => $todo])
            ->show('todo');
    }

    public function add(): void
    {
        try {
            $this->validatePost([
                'title', 'content', 'date_added', 'estimated_finish_date', 'date_finish', 'status'
            ]);

            $data = $this->prepareData(null);
            $this->model->add($data);

            $this->redirect('/todo?success=added');
        } catch (Exception $e) {
            // Możesz przekazać błąd do widoku przez sesję lub GET
            $this->redirect('/todo/add?error=' . urlencode($e->getMessage()));
        }
    }

    public function copy(): void
    {
        try {
            $this->validatePost(['id']);

            $original = $this->model->getOne(['_id' => $_POST['id']]);
            if (!$original) {
                throw new Exception('Dokument nie znaleziony');
            }

            $data = (array) $original;
            unset($data['_id']);
            $data['date_added']    = date('Y-m-d');
            $data['date_modified'] = date('Y-m-d');

            $this->model->add($data);
            $this->redirect('/todo?success=copied');
        } catch (Exception $e) {
            $this->redirect('/todo?error=' . urlencode($e->getMessage()));
        }
    }

    public function update(): void
    {
        try {
            $this->validatePost(['id', 'title', 'content', 'estimated_finish_date']);

            $data = $this->prepareData(null);
            unset($data['date_added']); // nie nadpisujemy daty utworzenia

            $this->model->update(['_id' => $_POST['id']], $data);
            $this->redirect('/todo?success=updated');
        } catch (Exception $e) {
            $this->redirect('/todo/edit?id=' . ($_POST['id'] ?? '') . '&error=' . urlencode($e->getMessage()));
        }
    }

    public function delete(): void
    {
        try {
            $this->validatePost(['id']);
            $this->model->delete(['_id' => $_POST['id']]);
            $this->redirect('/todo?success=deleted');
        } catch (Exception $e) {
            $this->redirect('/todo?error=' . urlencode($e->getMessage()));
        }
    }

    private function redirect(string $to = '/business'): never
    {
        header("Location: $to");
        exit;
    }

    private function validatePost(array $required): void
    {
        foreach ($required as $key) {
            if (!isset($_POST[$key]) || trim($_POST[$key]) === '') {
                throw new Exception("Brak wymaganego pola: $key");
            }
        }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new Exception("Dozwolone tylko żądania POST");
        }
    }

    private function prepareData(array|null $source): array
    {
        $input = $source ?? $_POST;

        return [
            'title'                 => trim($input['title'] ?? ''),
            'content'               => trim($input['content'] ?? ''),
            'status'                => trim($input['status'] ?? ''),
            'estimated_finish_date' => trim($input['estimated_finish_date'] ?? ''),
            'date_finish'           => trim($input['date_finish'] ?? ''),

            'date_added'            => date('Y-m-d'),
            'date_modified'         => date('Y-m-d'),
        ];
    }
}

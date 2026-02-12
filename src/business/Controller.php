<?php
namespace Modules\Business;

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
        $business = $this->model->getAll()->toArray();
        $this->view
            ->with(['business_collection' => $business])
            ->show('business');
    }

    public function add(): void
    {
        try {
            $this->validatePost([
                'title', 'category', 'date_added', 'amount',
            ]);

            $data = $this->prepareData(null);
            $this->model->add($data);

            $this->redirect('/business?success=added');
        } catch (Exception $e) {
            // Możesz przekazać błąd do widoku przez sesję lub GET
            $this->redirect('/business/add?error=' . urlencode($e->getMessage()));
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

            // Kopiujemy, ale resetujemy niektóre pola
            $data = (array) $original;
            unset($data['_id']);
            $data['title']       .= ' (kopia)';
            $data['date_added']    = date('Y-m-d');
            $data['date_modified'] = date('Y-m-d');
            // ewentualnie nowy numer – tu możesz mieć logikę generowania

            $this->model->add($data);
            $this->redirect('/business?success=copied');
        } catch (Exception $e) {
            $this->redirect('/business?error=' . urlencode($e->getMessage()));
        }
    }

    public function update(): void
    {
        try {
            $this->validatePost(['id', 'title', 'category', 'amount']);

            $data = $this->prepareData(null);
            unset($data['date_added']); // nie nadpisujemy daty utworzenia

            $this->model->update(['_id' => $_POST['id']], $data);
            $this->redirect('/business?success=updated');
        } catch (Exception $e) {
            $this->redirect('/business/edit?id=' . ($_POST['id'] ?? '') . '&error=' . urlencode($e->getMessage()));
        }
    }

    public function delete(): void
    {
        try {
            $this->validatePost(['id']);
            $this->model->delete(['_id' => $_POST['id']]);
            $this->redirect('/business?success=deleted');
        } catch (Exception $e) {
            $this->redirect('/business?error=' . urlencode($e->getMessage()));
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

        $amount = floatval(str_replace(',', '.', $input['amount'] ?? '0'));

        return [
            'title'            => trim($input['title'] ?? ''),
            'category'         => trim($input['category'] ?? ''),
            'amount'           => $amount,

            'date_added'        => date('Y-m-d'),
            'date_modified'     => date('Y-m-d'),
        ];
    }
}

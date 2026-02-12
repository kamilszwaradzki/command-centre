<?php
namespace Modules\Resume;

use Core\View;
use Exception;

/**
 * 'index'
 * 'print'
 * 'add'
 * 'copy'
 * 'update'
 * 'delete'
 */
class Controller
{
    private View $view;
    private Model $model;

    /*
    {
        "_id": ObjectId("..."),
        "owner_id": "user123", 
        "personal": {
            "first_name": "Jan",
            "last_name": "Kowalski",
            "email": "jan.kowalski@example.com",
            "phone": "+48 123 456 789",
            "summary": "Programista PHP z 5-letnim doświadczeniem..."
        },
        "experience": [
            {
            "position": "Backend Developer",
            "company": "TechCorp",
            "start_date": "2021-01",
            "end_date": "2023-06",
            "description": "Tworzenie i utrzymanie API w PHP i Symfony."
            },
            {
            "position": "Junior Developer",
            "company": "WebSolutions",
            "start_date": "2019-03",
            "end_date": "2020-12",
            "description": "Rozwój modułów e-commerce."
            }
        ],
        "education": [
            {
            "school": "Politechnika Warszawska",
            "degree": "Inżynier Informatyki",
            "start_date": "2015-10",
            "end_date": "2019-02"
            }
        ],
        "projects": [
            {
            "name": "System zarządzania zadaniami",
            "description": "Aplikacja webowa do zarządzania projektami.",
            "link": "https://github.com/user/project"
            }
        ],
        "skills": [
            { "name": "PHP", "level": "Advanced" },
            { "name": "JavaScript", "level": "Intermediate" },
            { "name": "MongoDB", "level": "Intermediate" }
        ],
        "languages": [
            { "name": "Polski", "level": "Native" },
            { "name": "Angielski", "level": "B2" }
        ],
        "template": "modern"
    }
    */
    public function __construct()
    {
        $this->view = new View();
        $this->model = new Model();
    }

    public function index(): void
    {
        $resume = $this->model->getAll()->toArray();
        $this->view
            ->with(['resume_collection' => $resume])
            ->show('resume');
    }

    public function add(): void
    {
        try {
            $this->validatePost([
                'personal', 'experience', 'education', 'projects', 'skills', 'languages', 'template'
            ]);

            $data = $this->prepareData(null);
            $this->model->add($data);

            $this->redirect('/resume?success=added');
        } catch (Exception $e) {
            // Możesz przekazać błąd do widoku przez sesję lub GET
            $this->redirect('/resume/add?error=' . urlencode($e->getMessage()));
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
            $this->redirect('/business?success=copied');
        } catch (Exception $e) {
            $this->redirect('/business?error=' . urlencode($e->getMessage()));
        }
    }

    public function update(): void
    {
        try {
            $this->validatePost(['id', 'personal', 'experience', 'education', 'projects', 'skills', 'languages', 'template']);

            $data = $this->prepareData(null);
            unset($data['date_added']); // nie nadpisujemy daty utworzenia

            $this->model->update(['_id' => $_POST['id']], $data);
            $this->redirect('/resume?success=updated');
        } catch (Exception $e) {
            $this->redirect('/resume/edit?id=' . ($_POST['id'] ?? '') . '&error=' . urlencode($e->getMessage()));
        }
    }

    public function delete(): void
    {
        try {
            $this->validatePost(['id']);
            $this->model->delete(['_id' => $_POST['id']]);
            $this->redirect('/resume?success=deleted');
        } catch (Exception $e) {
            $this->redirect('/resume?error=' . urlencode($e->getMessage()));
        }
    }

    public function print(): void
    {
        try {
            if (empty($_GET['id'])) {
                throw new Exception('Brak ID');
            }

            $resume = $this->model->getOne(['_id' => $_GET['id']]);
            if (!$resume) {
                throw new Exception('Faktura nie znaleziona');
            }

            // Konwertujemy BSONDocument → czysta tablica (łatwiej w widoku)
            $data = json_decode(json_encode($resume), true);

            $this->view
                ->with(['resume' => $data])
                ->show('resume_print');   // lub layout('print') jeśli masz szablon do druku
        } catch (Exception $e) {
            // Można pokazać stronę błędu lub przekierować
            http_response_code(404);
            $this->view->show('error', ['message' => $e->getMessage()]);
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
            'personal'           => trim($input['personal'] ?? ''),
            'experience'         => trim($input['experience'] ?? ''),
            'education'          => trim($input['education'] ?? ''),
            'projects'           => trim($input['projects'] ?? ''),
            'skills'             => trim($input['skills'] ?? ''),
            'languages'          => trim($input['languages'] ?? ''),
            'template'           => trim($input['template'] ?? 'modern'),

            'date_added'        => date('Y-m-d'),
            'date_modified'     => date('Y-m-d'),
        ];
    }
}

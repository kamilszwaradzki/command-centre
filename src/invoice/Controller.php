<?php
namespace Modules\Invoice;

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
        $invoices = $this->model->getAll()->toArray();
        $this->view
            ->with(['invoice_collection' => $invoices])
            ->show('invoice');
    }

    public function print(): void
    {
        try {
            if (empty($_GET['id'])) {
                throw new Exception('Brak ID');
            }

            $invoice = $this->model->getOne(['_id' => $_GET['id']]);
            if (!$invoice) {
                throw new Exception('Faktura nie znaleziona');
            }

            // Konwertujemy BSONDocument → czysta tablica (łatwiej w widoku)
            $data = json_decode(json_encode($invoice), true);

            $this->view
                ->with(['invoice_collection' => $data])
                ->show('invoice_view');   // lub layout('print') jeśli masz szablon do druku
        } catch (Exception $e) {
            // Można pokazać stronę błędu lub przekierować
            http_response_code(404);
            $this->view->show('error', ['message' => $e->getMessage()]);
        }
    }

    public function add(): void
    {
        try {
            $this->validatePost([
                'number', 'seller_name', 'buyer_name', 'gross_price' // minimalny zestaw – dodaj więcej wg potrzeb
            ]);

            $data = $this->prepareData();
            $this->model->add($data);

            $this->redirect('/invoice?success=added');
        } catch (Exception $e) {
            // Możesz przekazać błąd do widoku przez sesję lub GET
            $this->redirect('/invoice/add?error=' . urlencode($e->getMessage()));
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
            $data['number']       .= ' (kopia)';
            $data['date_added']    = date('Y-m-d');
            $data['date_modified'] = date('Y-m-d');
            // ewentualnie nowy numer – tu możesz mieć logikę generowania

            $this->model->add($data);
            $this->redirect('/invoice?success=copied');
        } catch (Exception $e) {
            $this->redirect('/invoice?error=' . urlencode($e->getMessage()));
        }
    }

    public function update(): void
    {
        try {
            $this->validatePost(['id', 'number', 'gross_price']);

            $data = $this->prepareData();
            unset($data['date_added']); // nie nadpisujemy daty utworzenia

            $this->model->update(['_id' => $_POST['id']], $data);
            $this->redirect('/invoice?success=updated');
        } catch (Exception $e) {
            $this->redirect('/invoice/edit?id=' . ($_POST['id'] ?? '') . '&error=' . urlencode($e->getMessage()));
        }
    }

    public function delete(): void
    {
        try {
            $this->validatePost(['id']);
            $this->model->delete(['_id' => $_POST['id']]);
            $this->redirect('/invoice?success=deleted');
        } catch (Exception $e) {
            $this->redirect('/invoice?error=' . urlencode($e->getMessage()));
        }
    }

    private function redirect(string $to = '/invoice'): never
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

    private function prepareData(array $source = null): array
    {
        $input = $source ?? $_POST;

        $gross = floatval(str_replace(',', '.', $input['gross_price'] ?? '0'));

        return [
            'number'            => trim($input['number'] ?? ''),
            'seller_name'       => trim($input['seller_name'] ?? ''),
            'seller_address'    => trim($input['seller_address'] ?? ''),
            'seller_postcode'   => trim($input['seller_postcode'] ?? ''),
            'seller_city'       => trim($input['seller_city'] ?? ''),
            'seller_country'    => trim($input['seller_country'] ?? 'PL'),
            'seller_nipcode'    => trim($input['seller_nipcode'] ?? ''),

            'buyer_name'        => trim($input['buyer_name'] ?? ''),
            'buyer_address'     => trim($input['buyer_address'] ?? ''),
            'buyer_postcode'    => trim($input['buyer_postcode'] ?? ''),
            'buyer_city'        => trim($input['buyer_city'] ?? ''),
            'buyer_country'     => trim($input['buyer_country'] ?? 'PL'),
            'buyer_nipcode'     => trim($input['buyer_nipcode'] ?? ''),

            'price'             => floatval(str_replace(',', '.', $input['price'] ?? '0')),
            'vat_amount'        => floatval(str_replace(',', '.', $input['vat_amount'] ?? '0')),
            'gross_price'       => $gross,

            // Kwota słownie – tylko brutto (najczęściej wymagane na fakturach PL)
            'price_spellout_pl' => \NumberFormatter::create('pl_PL', \NumberFormatter::SPELLOUT)->format($gross),
            'price_spellout_en' => \NumberFormatter::create('en_US', \NumberFormatter::SPELLOUT)->format($gross),

            'assigned_date'     => $input['assigned_date'] ?? date('Y-m-d'),
            'selled_date'       => $input['selled_date'] ?? date('Y-m-d'),
            'due_date'          => $input['due_date'] ?? date('Y-m-d', strtotime('+14 days')),

            'notes'             => trim($input['notes'] ?? ''),
            'not_zen_vat'       => !empty($input['not_zen_vat']),
            'vat_23'            => !empty($input['vat_23']),

            'date_added'        => date('Y-m-d'),
            'date_modified'     => date('Y-m-d'),
        ];
    }
}

<?php
namespace Invoice;
require_once __DIR__ . '/../../vendor/autoload.php';

class Controller {

    private $model;
    public function __construct()
    {
        $this->model = new Model();
    }
        // 'en' => NumberFormatter::create('en', NumberFormatter::SPELLOUT)->format($price * 1.23),
        // 'pl' => NumberFormatter::create('pl', NumberFormatter::SPELLOUT)->format($price * 1.23),

    public function add()
    {
        $data = [
            'number' => $_POST['number'],
            'seller_name' => $_POST['seller_name'],
            'seller_address' => $_POST['seller_address'],
            'seller_postcode' => $_POST['seller_postcode'],
            'seller_city' => $_POST['seller_city'],
            'seller_country' => $_POST['seller_country'],
            'seller_nipcode' => $_POST['seller_nipcode'],
            'buyer_name' => $_POST['buyer_name'],
            'buyer_address' => $_POST['buyer_address'],
            'buyer_postcode' => $_POST['buyer_postcode'],
            'buyer_city' => $_POST['buyer_city'],
            'buyer_country' => $_POST['buyer_country'],
            'buyer_nipcode' => $_POST['buyer_nipcode'],
            'price' => $_POST['price'],
            'vat_amount' => $_POST['vat_amount'],
            'gross_price' => $_POST['gross_price'],
            'price_spellout_en' => \NumberFormatter::create('en', \NumberFormatter::SPELLOUT)->format(floatval(str_replace(",", ".", $_POST['gross_price']))),
            'price_spellout_pl' => \NumberFormatter::create('pl', \NumberFormatter::SPELLOUT)->format(floatval(str_replace(",", ".", $_POST['gross_price']))),
            'assigned_date' => $_POST['assigned_date'],
            'selled_date' => $_POST['selled_date'],
            'due_date' => $_POST['due_date'],
            'notes' => $_POST['notes'],
            'not_zen_vat' => $_POST['not_zen_vat'],
            'vat_23' => $_POST['vat_23'],
            'date_added' => date('Y-m-d'),
        ];
        $this->model->add($data);
    }

    public function copy()
    {
        $collection = $this->model->getOne(['_id' => $_POST['id']]);
        $data = [
            'number' => $collection->number,
            'seller_name' => $collection->seller_name,
            'seller_address' => $collection->seller_address,
            'seller_postcode' => $collection->seller_postcode,
            'seller_city' => $collection->seller_city,
            'seller_country' => $collection->seller_country,
            'seller_nipcode' => $collection->seller_nipcode,
            'buyer_name' => $collection->buyer_name,
            'buyer_address' => $collection->buyer_address,
            'buyer_postcode' => $collection->buyer_postcode,
            'buyer_city' => $collection->buyer_city,
            'buyer_country' => $collection->buyer_country,
            'buyer_nipcode' => $collection->buyer_nipcode,
            'price' => $collection->price,
            'vat_amount' => $collection->vat_amount,
            'gross_price' => $collection->gross_price,
            'price_spellout_en' => $collection->price_spellout_en,
            'price_spellout_pl' => $collection->price_spellout_pl,
            'assigned_date' => $collection->assigned_date,
            'selled_date' => $collection->selled_date,
            'due_date' => $collection->due_date,
            'notes' => $collection->notes,
            'not_zen_vat' => $collection->not_zen_vat,
            'vat_23' => $collection->vat_23,
            'date_added' => date('Y-m-d'),
        ];
        $this->model->add($data);
    }

    public function update()
    {
        $data = [
            'number' => $_POST['number'],
            'seller_name' => $_POST['seller_name'],
            'seller_address' => $_POST['seller_address'],
            'seller_postcode' => $_POST['seller_postcode'],
            'seller_city' => $_POST['seller_city'],
            'seller_country' => $_POST['seller_country'],
            'seller_nipcode' => $_POST['seller_nipcode'],
            'buyer_name' => $_POST['buyer_name'],
            'buyer_address' => $_POST['buyer_address'],
            'buyer_postcode' => $_POST['buyer_postcode'],
            'buyer_city' => $_POST['buyer_city'],
            'buyer_country' => $_POST['buyer_country'],
            'buyer_nipcode' => $_POST['buyer_nipcode'],
            'price' => $_POST['price'],
            'vat_amount' => $_POST['vat_amount'],
            'gross_price' => $_POST['gross_price'],
            'price_spellout_en' => \NumberFormatter::create('en', \NumberFormatter::SPELLOUT)->format(floatval(str_replace(",", ".", $_POST['gross_price']))),
            'price_spellout_pl' => \NumberFormatter::create('pl', \NumberFormatter::SPELLOUT)->format(floatval(str_replace(",", ".", $_POST['gross_price']))),
            'assigned_date' => $_POST['assigned_date'],
            'selled_date' => $_POST['selled_date'],
            'due_date' => $_POST['due_date'],
            'notes' => $_POST['notes'],
            'not_zen_vat' => $_POST['not_zen_vat'],
            'vat_23' => $_POST['vat_23'],
            'date_modified'         => date('Y-m-d'),
        ];
        $this->model->update(['_id' => $_POST['id']], $data);
    }

    public function delete()
    {
        $this->model->delete(['_id' => $_POST['id']]);
    }

    public function print()
    {
        $collection = $this->model->getOne(['_id' => $_POST['id']]);
        return $collection;
    }
}

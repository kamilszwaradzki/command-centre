<?php
namespace Invoice;
require_once __DIR__ . '/../../vendor/autoload.php';
use Utils\MongoPDO;

class Model {
    private $phpDataObject;

    public function __construct()
    {
        $this->phpDataObject = new MongoPDO('my_db', 'invoice_collection');
    }

    public function getAll($filter = [])
    {
        return $this->phpDataObject->get($filter);
    }

    public function getOne($filter)
    {
        return $this->phpDataObject->getOne($filter);
    }

    public function add($data)
    {
        $this->phpDataObject->add($data);
    }

    public function update($filter, $data)
    {
        $this->phpDataObject->update($filter, $data);
    }

    public function delete($filter)
    {
        $this->phpDataObject->delete($filter);
    }
}

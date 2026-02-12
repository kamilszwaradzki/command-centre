<?php
namespace Modules\Business;
use Utils\MongoPDO;

class Model {
    private $phpDataObject;

    public function __construct()
    {
        $this->phpDataObject = new MongoPDO('my_db', 'business_collection');
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

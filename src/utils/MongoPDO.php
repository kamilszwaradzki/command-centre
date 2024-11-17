<?php
namespace Utils;
require_once __DIR__ . '/../../vendor/autoload.php';
use MongoDB;
use MongoDB\BSON;

class MongoPDO {
    private $client;
    private $database;
    private $collection;

    public function __construct($databaseName = 'test_db', $collectionName = 'test_collection')
    {
        $this->client = new MongoDB\Client("mongodb://localhost:27017");
        $this->database = $this->client->selectDatabase($databaseName);
        $this->collection = $this->database->selectCollection($collectionName);
    }

    public function add($data = [])
    {
        $insertResult = $this->collection->insertOne($data);
        echo "Inserted with Object ID '{$insertResult->getInsertedId()}'";
    }

    public function update($filter = [], $data = [])
    {
        $id = $filter['_id'];
        $filter['_id'] = new MongoDB\BSON\ObjectId("$id");
        $updateResult = $this->collection->updateOne($filter, ['$set' => $data]);
        echo "Updated with Object ID '{$updateResult->getUpsertedId()}'";
    }

    public function delete($filter = [])
    {
        $id = $filter['_id'];
        $filter['_id'] = new MongoDB\BSON\ObjectId("$id");
        $deleteResult = $this->collection->deleteOne($filter);
        echo "Deleted Object count: '{$deleteResult->getDeletedCount()}'";
    }

    public function get($filter = [])
    {
        return $this->collection->find($filter);
    }

    public function getOne ($filter = [])
    {
        $id = $filter['_id'];
        $filter['_id'] = new MongoDB\BSON\ObjectId("$id");
        return $this->collection->findOne($filter);
    }
}

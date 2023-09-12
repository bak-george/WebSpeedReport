<?php

namespace Core;

use Exception;
use PDO;

class Database
{
    public $connection;
    public $statement;

    public function __construct($config, $username, $password)
    {
        $dns = 'mysql:' . http_build_query($config, '', ';');

        $this->connection = new PDO($dns, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }

    public function query($query, $params = [])
    {
        $this->statement = $this->connection->prepare($query);

        $this->statement->execute($params);

        return $this;
    }

    public function fetchAll()
    {
        return $this->statement->fetchAll();
    }

    public function find()
    {
        return $this->statement->fetch();
    }

    /**
     * @throws Exception
     */
    public function findOrFail()
    {
        $result = $this->find();

        if (!$result) {
            throw new Exception('Query failed to return a result.');
        }

        return $result;
    }
}
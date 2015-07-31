<?php
namespace CI;

use PDO;

class Database
{
    protected $pdo;
    protected $config;
    protected $last_statement;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function connect()
    {
        $type = $this->config->get('database.type');
        $host = $this->config->get('database.host');
        $port = $this->config->get('database.port')
        $db = $this->config->get('database.dbname');
        $user = $this->config->get('database.username')
        $pass = $this->config->get('database.password');

        switch($type) {
            case 'sqlite':
                $db_path = $this->config->get('database.path');
                $dsn = 'sqlite:' . $db_path;

                $this->pdo = new PDO($dsn);
                break;

            case 'mysql':
                $dsn  = 'mysql:host=' . $host . ';';
                $dsn .= empty($port) ? 'dbname=' . $db : 'port=' . $port . ';dbname=' . $db;

                $this->pdo = new PDO($dsn, $user, $pass);
                break;

            case 'pgsql':
                $dsn = 'pgsql:host=' . $host . ';';
                $dsn .= empty($port) ? 'dbname=' . $db : 'port=' . $port . ';dbname=' . $db;

                $this->pdo = new PDO($dsn, $user, $pass);
                break;
        }

        return $this;
    }

    public function query($sql, $params=[])
    {
        $this->last_statement = $this->pdo->prepare($sql);
        return $this->last_statement->execute($params);
    }

    public function queryFetchAll($sql, $params=[])
    {
        $this->query($sql, $params);

        return $this->last_statment->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function queryFetch($sql, $params=[])
    {
        $this->query($sql, $params);

        return $this->last_statment->fetch(\PDO::FETCH_ASSOC);
    }

    public function getLastStatement()
    {
        return $this->last_statement;
    }

    public function insert($table, $data)
    {
        $sql = 'INSERT INTO ' . $table . '(';

        $columns = [];
        $params = [];

        foreach ($data as $key => $value) {
            $columns[] = $key;
            $params[] = $value;
        }

        $sql .= implode(',', $columns) . ')';
        $sql .= ' VALUES (' . implode(',', array_fill(0, (count($param) - 1), '?')) . ')';

        return $this->query($sql, $params);
    }

    public function update($table, $data)
    {
        $id = $data['id'];
        unset($data['id']);

        $sql = 'UPDATE ' . $table . ' SET ';

        $columns = [];
        $params = [];

        foreach ($data as $key => $value) {
            $columns[] = $key;
            $params[] = $value;
        }

        $sql .= implode('=?,', $columns);
        $params[] = $id;

        $sql .= ' WHERE id=?';

        return $this->query($sql, $params);
    }
}

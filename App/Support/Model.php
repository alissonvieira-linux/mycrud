<?php

namespace App\Support;

use App\Support\Helpers\Table;
use \PDO;
use \PDOException;
use \Exception;

class Model
{
    private $table;
    private $pdo;

    public function __construct(string $table)
    {
        $this->table = $table;
        $this->pdo = new PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);
    }

    public function execute($query, $params = [])
    {   
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('Error: '.$e->getMessage());
        }
    }

    public function select($fields = '*', $where = null, $order = null, $limit = null)
    {
        $where = strlen($where) ? 'WHERE '.$where : '';
        $order = strlen($order) ? 'ORDER BY '.$order : '';
        $limit = strlen($limit) ? 'LIMIT '.$limit : '';

        $query = 'SELECT '.$fields.' FROM '.$this->table.' '.$where.' '.$order.' '.$limit;
        return $this->execute($query);
    }


    public static function all()
    {
        $sql = 'SELECT * FROM '.$this->table;
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            throw new \Exception('Nenhum registro encontrado.');
        }
    }

    // public static function select($columns, $tableColumn = null, $value = null)
    // {
    //     $string = "";

    //     foreach($columns as $column) {
    //         $string .= "$column, ";
    //     }

    //     $string = substr($string, 0, (strlen($string) -2));

    //     if ($column && $value) {
    //         $sql = "SELECT $string FROM ".self::$table." WHERE ". $tableColumn ." = :value";
    //         $stmt = self::$pdo->prepare($sql);
    //         $stmt->bindValue(':value', $value);
    //         $stmt->execute();

    //         if ($stmt->rowCount() > 0) {
    //             return $stmt->fetch(\PDO::FETCH_ASSOC);
    //         } else {
    //             throw new \Exception('Nenhum registro encontrado.');
    //         }
    //     }

    //     $sql = "SELECT $string FROM ".self::$table;
    //     $stmt = self::$pdo->prepare($sql);
    //     $stmt->execute();

    //     if($stmt->rowCount() > 0) {
    //         return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    //     } else {
    //         throw new \Exception('Nenhum registro encontrado.');
    //     }
    // }

    public static function where($column, $value)
    {
        $sql = 'SELECT * FROM '.self::$table.' WHERE '.$column.' = :value';
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindValue(':value', $value);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } else {
            throw new \Exception('Nenhum registro encontrado.');
        }
    }

    public static function insert(Table $table)
    {
        $fields = $table->getFields();

        if (isset($fields['id'])) {
            unset($fields['id']);
        }

        $columns = '';
        $values = '';

        foreach($fields as $key => $value) {
            $columns .= "$key, ";
            $values .= "?, ";
        }

        // Formatting the strings
        $columns = (substr($columns, -2) == ', ') ? substr($columns, 0, (strlen($columns) -2)) : $columns;
        $values = (substr($values, -2) == ', ') ? substr($values, 0, (strlen($values) -2)) : $values;

        $sql = "INSERT INTO ".self::$table."($columns) VALUES($values)";
        $stmt = self::$pdo->prepare($sql);

        // Bind array values to PDO params
        $count = 1;
        foreach($fields as $key => $value) {
            $stmt->bindValue($count, $value);
            $count++;
        }

        $stmt->execute();
        if($stmt->rowCount() > 0) {
            return 'Registro adicionado com sucesso.';
        } else {
            throw new \Exception('Não foi possível salvar os dados.');
        }
    }

    public static function update(Table $table)
    {
        $data = $table->getFields();
        $string = "";

        foreach($data as $key => $value) {
            $string .= "$key=:$key, ";
        }

        // Formatting the strings
        $string = substr($string, 0, (strlen($string) -2));

        $sql = "UPDATE ".self::$table." SET $string WHERE id = :id";
        $stmt = self::$pdo->prepare($sql);

        // Bind array values to PDO params
        foreach($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        //Bind id param
        $stmt->bindValue(":id", intval($data['id']));
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            return 'Alterações salvas.';
        } else {
            throw new \Exception('Não foi possível salvar as alterações.');
        }
    }

    public function save($table, $flag = null)
    {
        if (!$flag) {
            return self::insert($table);
        }

        // Flag is compatible
        if ($flag !== 'update') {
            throw new \Exception('A flag passada para a classe Model não é compatível.');
        }

        return self::update($table);
    }

    public static function remove($id)
    {
        $stmt = self::$pdo->prepare('DELETE FROM '.self::$table.' WHERE id = :id');
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            return 'Registro removido com sucesso.';
        } else {
            throw new \Exception('Não foi possível remover o registro selecionado.');
        }
    }
}
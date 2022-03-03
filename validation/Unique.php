<?php

namespace app\core\validation;

use app\core\Application;

class Unique extends Rule {

    private $params;

    public function __construct($params)
    {
        $this->params = $params;
    }
    
    
    public function validate($value): bool
    {
        
        $className = new $this->params['class']();
        $attribute = $this->params['unique'] ?? $value;
        $tableName = $className->tableName();

        $statement = Application::$app->db->prepare("SELECT * FROM $tableName WHERE
        $attribute = :attribute");

        $statement->bindValue(":attribute", $value);
        $statement->execute();
        $record = $statement->fetchObject();
        if ($record) {
            return false;
        }

        return true;
    }

    public function message(): string
    {
        return "Record with this " . $this->params['unique'] . " already exists";
    }

}
<?php

namespace ihate\mvc\db;

use ihate\mvc\Model;
use ihate\mvc\Application;

abstract class DbModel extends Model{

    abstract public static function tableName(): string;
    abstract public function attributes(): array;
    abstract public function primaryKey(): string;
    
    public function save() {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attribute) => ":$attribute", $attributes);
        $statement = self::prepare("
        INSERT INTO $tableName ("
        .implode(',', $attributes).")
        VALUES ("
        .implode(',', $params).")
        ");

        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }

        $statement->execute();
        return true;


    }

    public static function findOne($where) {
        $tableName = static::tableName();
        $attributes = array_keys($where);

        $sql = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));

        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $value) {
            $statement->bindValue(":$key", $value);
        }

        $statement->execute();
        return $statement->fetchObject(static::class);

    }

    public static function find() {
        $tableName = static::tableName();
        $statement = self::prepare("SELECT * FROM $tableName");
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function prepare($sql) {
        return Application::$app->db->pdo->prepare($sql);
    }

}
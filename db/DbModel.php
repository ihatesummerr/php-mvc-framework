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

    public function update() {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attribute) => ":$attribute", $attributes);
        $sql = [];
        for ($i = 0; $i < count($attributes); $i++) {
            $sql[] = $attributes[$i] . " = " . $params[$i];
        }
        $statement = self::prepare("UPDATE $tableName SET " . implode(', ', $sql) . " WHERE "
            . $this->primaryKey() . " = '" . $this->{$this->primaryKey()} . "'");

        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }

        var_dump($statement);

        $statement->execute();
        return true;
    }

    public function delete() {
        $tableName = $this->tableName();
        $statement = self::prepare("DELETE FROM $tableName WHERE " . $this->primaryKey() . " = " . "'" . $this->{$this->primaryKey()} . "'");

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
        return $statement->fetchAll(\PDO::FETCH_CLASS, static::class);
    }

    public static function prepare($sql) {
        return Application::$app->db->pdo->prepare($sql);
    }

}
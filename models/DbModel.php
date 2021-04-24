<?php


namespace app\models;

use app\core\Application;

abstract class DbModel extends Model
{
    abstract public function tableName(): string;

    abstract public function attributes(): array;

    abstract public static function getPrimaryKey(): string;

    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $parameters = $this->parameterizeValues($attributes);

        $sql = sprintf("insert into %s(%s) values(%s)",
            $tableName,
            implode(', ', $attributes),
            implode(',', $parameters)
        );

        $statement = self::prepare($sql);

        try {
            foreach ($attributes as $attribute) {
                $statement->bindValue(":$attribute", $this->{$attribute});
            }

            $result = $statement->execute();

            return $result;
        } catch (\PDOException $e) {
            dd($e->getMessage());
        }
    }


    public static function prepare($sql)
    {
        return app('db')->getPdo()->prepare($sql);
    }

    private function parameterizeValues($array)
    {
        return array_map(function ($param) {
            return ":{$param}";
        }, $array);
    }


    public static function find($where=['1'=>1], $separator = "AND"){
        $tableName = (new static)->tableName();
        $attributes = array_keys($where);


        $parameters = implode(
            $separator,
            array_map(fn($attribute) => "$attribute  = :$attribute", $attributes)
        );

        $sql = "SELECT * FROM $tableName WHERE $parameters;";
        $statement = self::prepare($sql);

        foreach ($where as $key => $value) {
            $statement->bindValue(":$key", $value);
        }
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_CLASS, static::class);
    }



    public static function findOne($where)
    {
        $tableName = (new static)->tableName();
        $attributes = array_keys($where);

        $parameters = implode(
            "AND",
            array_map(fn($attribute) => "$attribute  = :$attribute", $attributes)
        );
        $sql = "SELECT * FROM $tableName WHERE $parameters";

        $statement = self::prepare($sql);

        foreach ($where as $key => $value) {
            $statement->bindValue(":$key", $value);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);
    }


    public function update(array $data, array $where, string $separator = "AND")
    {
        $tableName = $this->tableName();
        $attributes = array_keys($where);
        $colums = array_keys($data);

        $values = implode(",",
            array_map(fn($key) => "$key=:$key", $colums)
        );

        $parameters = implode(
            $separator,
            array_map(fn($attribute) => "$attribute=:$attribute", $attributes)
        );

        $sql = "UPDATE $tableName SET $values WHERE $parameters";

        $statement = self::prepare($sql);

        foreach ($where as $key => $value) {
            $statement->bindValue(":$key", $value);
        }
        foreach ($data as $key => $value) {
            $statement->bindValue(":$key", $value);
        }

        try {
            $statement->execute();
            return true;
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        return false;
    }

    public static function delete(array $where, string $separator = 'AND'): bool
    {

        $tableName = (new static)->tableName();
        $attributes = array_keys($where);

        $parameters = implode(
            $separator,
            array_map(fn($attribute) => "$attribute=:$attribute", $attributes)
        );

        $sql = "DELETE FROM $tableName WHERE $parameters";

        $statement = self::prepare($sql);

        foreach ($where as $key => $value) {
            $statement->bindValue(":$key", $value);
        }

        try {
            $statement->execute();
            return true;
        } catch (\Exception $e) {
            $e->getMessage();
        }
        return false;
    }

    public function destroy(): bool
    {

        $tableName = $this->tableName();

        $sql = "DELETE FROM $tableName WHERE id=:id";

        $statement = self::prepare($sql);

        $statement->bindValue(":id", $this->id);

        try {
            $statement->execute();
            return true;
        } catch (\Exception $e) {
            $e->getMessage();
        }
        return false;
    }


    public static function create($data): static
    {
        $instace = new static;

        $instace->loadData($data);

        return $instace;
    }

}
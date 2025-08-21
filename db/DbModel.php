<?php
namespace ahmed14ayman\phpmvc\db;

use ahmed14ayman\phpmvc\Model;
use ahmed14ayman\phpmvc\Application;

abstract class DbModel extends Model {

    abstract public static function tableName():string;

    abstract public function attributes():array;
    
    abstract public static function primaryKey():string;
    
    public function save(){

        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr)=> ":$attr", $attributes);

        $statement = self::prepare("INSERT INTO $tableName (".implode(',', $attributes).") VALUES (".implode(',',$params).")");
    
        foreach($attributes as $attribute){
            $statement -> bindValue(":$attribute",$this->{$attribute});
        }
        $statement->execute();
        return true;

    }

    public static function findOne($where)//[email => ahmed@email.com ,firstname => ahmed]
    { 
        $tableName = static::tableName();
        $attibutes = array_keys($where);
      $sql =  implode("AND", array_map(fn($attr)=> "$attr = :$attr",$attibutes));
        //SELECT * FROM $tableName WHERE  email = :email AND firstname = :firstname
      $statment =   self::prepare("SELECT * FROM $tableName WHERE $sql");

      foreach($where as $key =>$value){
        $statment->bindValue(":$key",$value);
      }
      $statment->execute();
      return $statment->fetchObject(static::class);
    }

    public static function prepare($sql){
        return Application::$app->db->pdo->prepare($sql);
    }

}
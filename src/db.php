<?php

namespace Islam\Eraamvc;

class db{
      private $connection;

      private $sql;

      public function __construct($data)
      {
          $this->connection = mysqli_connect($data[0],$data[1],$data[2],$data[3]);
      }

      public function select(string $table,string $column = "*"):object
      {
          $this->sql = "SELECT $column FROM `$table` ";
          return $this;
      }

      public function where(string $column,string $operator,$value):object
      {
          $this->sql .=  "WHERE `$column` $operator '$value'";
          return $this;
      }

    public function andWhere(string $column,string $operator,$value):object
    {
        $this->sql .=  "AND `$column` $operator '$value'";
        return $this;
    }

    public function orWhere(string $column,string $operator,$value):object
    {
        $this->sql .=  "OR `$column` $operator '$value'";
        return $this;
    }

      public function get():array
      {
          $query =  mysqli_query($this->connection,$this->sql);
          return mysqli_fetch_all($query,MYSQLI_ASSOC);
      }

      public function first():array
      {
          $query =  mysqli_query($this->connection,$this->sql);
          return mysqli_fetch_assoc($query);
      }

      public function delete($table):string
      {
          $this->sql = "DELETE FROM `$table`";
          return $this;
      }

      public function save():int
      {
           $query =  mysqli_query($this->connection,$this->sql);
           return mysqli_affected_rows($this->connection);
      }

      public function insert(string $table,array $data):string
      {
            $columns = '';
            $values = '';
            foreach ($data as $column => $value){
                $columns .=  "`$column`,";
                $values .= "'$value',";
            }
           $columns = rtrim($columns,",");
           $values = rtrim($values,",");

          $this->sql = "INSERT INTO `$table` ($columns) VALUES ($values)";
          return $this;
      }

    public function update(string $table,array $data):object
    {
        $row = '';
        foreach ($data as $column => $value){
            $row .=  "`$column` = '$value',";
        }
        $row = rtrim($row,",");

        $this->sql = "UPDATE `$table`SET $row";
        return $this;
    }

}
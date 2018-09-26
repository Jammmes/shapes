<?php

/**
 * Класс для работы с базой данных, паттерн singleton
 */
class Db 
{
    private static $_instance = null;

    private $Db;

    /**
     * Функция возвращает ссылку на единственный экземпляр класса
     *
     * @return Db
     */
    public static function getInstance()
    {
        if(self::$_instance == null) {
            self::$_instance = new Db();
        }
        return self::$_instance;
    }

    // Защита от создания второго экземпляра класса
    private function __construct(){}
    private function __sleep(){}
    private function __wakeup(){}
    private function __clone(){}

    /**
     * Установление соединения с базой данных
     * 
     * @param string $db_file - путь до файла с БД
     */
    public function Connect($db_file)
    {
      $this->Db = new PDO ("sqlite:" . $db_file);
    }   

    /**
     * Функция для выполнения запроса без возвращения выборки
     *
     * @param string $query - текст запроса
     * @param array $params - параметры

     * @return void
     */
    public function Query($query, $params = [])
    {     
        $res = $this->Db->prepare($query);
        $res->execute($params);
       
        return $res;
    }

    /**
     * Функция для выполнения запроса и возращения выборки
     *
     * @param  string $query - текст запроса
     * @param array $params - параметры
     *
     * @return array - результат выборки
     */
    public function Select($query, $params = [])
    {
        $result = $this->Query($query, $params);
        $assoc_array = $result->fetchAll(PDO::FETCH_ASSOC);

        return $assoc_array;
    }

    /**
     * Начать транзацию
     *
     * @return void
     */
    public function beginTransaction()
    {
      $this->Db->beginTransaction();
    }

    /**
     * Подтвердить транзацию
     *
     * @return void
     */
    public function commit()
    {
      $this->Db->commit();
    }

    /**
     * Откатить транзацию
     *
     * @return void
     */
    public function rollback()
    {
      $this->Db->rollback();
    }

    /**
     * Возвращает ИД последней записи
     *
     * @return int
     */
    public function lastInsertId()
    {
      return  $this->Db->lastInsertId();
    }

}
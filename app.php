<?php
  // Подключение классов
  require_once('autoload.php');
  //Запуск основного модуля
try{
    App::init();
}
catch (PDOException $e){
    echo "DB is not available";
    var_dump($e->getTrace());
}
catch (Exception $e){
    echo $e->getMessage();
}
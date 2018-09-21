<?php

/**
 * Модель для работы со списком фигур
 */
class Catalog extends Model
{
    
    public function getData()        
    {
        $query = "SELECT * FROM params"; 
        
        $shapes = Db::getInstance()->Select($query);
        
        return $shapes;
    }
  
}

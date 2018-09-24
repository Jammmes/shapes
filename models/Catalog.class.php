<?php

/**
 * Модель для работы со списком фигур
 */
class Catalog extends Model
{
    
    public function getData()        
    {
        $query = "SELECT * FROM params"; 
        
        $figures = Db::getInstance()->Select($query);
        
        return $figures;
    }
  
    public function addFigure ($type,$params)
    {
        
    }
    
    
}

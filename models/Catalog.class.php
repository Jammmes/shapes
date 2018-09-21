<?php

/**
 * Модель для работы со списком фигур
 */
class Catalog extends Model
{
    
    public function getData()        
    {

        $db = new SQLite3(Config::get('path_data').'/shapes.db');
        
        $sql="SELECT * FROM figure";  
        
        $result = $db->query($sql);

        while($data = $result->fetchArray(SQLITE3_ASSOC)){ 

        $shapes[] = $data; 

        }
        
   
        return $shapes;
    }
  
}

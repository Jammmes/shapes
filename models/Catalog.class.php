<?php

/**
 * Модель для работы со списком фигур
 */
class Catalog extends Model
{
    
    public function getData()        
    {
        $query = "SELECT * FROM points"; 
        
        $figures = Db::getInstance()->Select($query);
        
        return $figures;
    }
  
    public function addFigure ($type,$params)
    {
        // Определим ID фигуры
        $query = "SELECT id FROM figure WHERE type = ?";
        $id_figure = Db::getInstance()->Select($query,[$type]);

        // Начинаем транзацию 
        Db::getInstance()->beginTransaction();
        // 1 - Добавляем новую запись в список созданных фигур 
        $sql = 'INSERT INTO figurelist (date) VALUES (?)';
        Db::getInstance()->Query($sql,[date('Y-m-d H:i:s')]);
        $id_list = Db::getInstance()->lastInsertId();
       
        // 2 Сохраняем данные в таблицы points и params
        foreach ($params as $param =>$value){
            
            $id_point = $this->savePoint($value); 
            $sql = "INSERT INTO params (id_list,id_figure,type,value)
            VALUES(?,?,?,?)";
            Db::getInstance()->Query($sql,[$id_list,$id_figure,$param,$id_point]);
        }
       
        // Завершаем транзакцию
        Db::getInstance()->commit();   
    }
        
    /**
     * Если координаты точки уже есть в таблице, возвращается ID записи,
     * если нет, то создается новая запись в таблице и возвращается ее ID
     * @param array $point - точка
     * @return int ID записи
     */
    protected function savePoint($point)
    {
        $query = "SELECT id FROM points WHERE (x = ?) AND (Y = ?) LIMIT 1";
        $result = Db::getInstance()->Select($query,[$point['x'],$point['y']]);
        $id = isset($result[0]['id']) ? $result[0]['id'] : 0;
        
        if(!$id){
            $sql = "INSERT INTO points (x,y) VALUES (?,?)";
            Db::getInstance()->Query($sql,[$point['x'],$point['y']]);
            $id = Db::getInstance()->lastInsertId();
        }
        
        return $id;
    }
    
}

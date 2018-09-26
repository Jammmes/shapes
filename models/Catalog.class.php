<?php

/**
 * Модель для работы со списком фигур
 */
class Catalog extends Model
{
    /**
     * Возвращает все данные о фигурах для рендеринга каталога
     * @return array
     */
    public function getData()        
    {
        $query = "SELECT DISTINCT fl.id AS id ,fl.date AS date,f.type AS type
        FROM figurelist fl
        JOIN params p ON p.id_list = fl.id
        JOIN figure f ON f.id = p.id_figure"; 
        
        $figures = Db::getInstance()->Select($query);
        
        // теперь в цикле для каждой фигуры посчитаем площадь
        foreach ($figures as $figure) {
            $modelFigure = ucfirst($figure['type']);
            $area = $modelFigure::getArea($figure['id']);
            
            $type = $figure['type'];
            // если параллелограм является квадратом, переименуем его
            if($modelFigure == 'Parallelogram') {
               $coords = $modelFigure::getCoords($figure['id']);
               $isSquare =  $modelFigure::isSquare($coords);
               if ($isSquare){
                   $type = 'square';
               }
            }
            
            $result_array[]=
                [
                'id'=>$figure['id'],
                'date'=>$figure['date'],
                'type'=>$type,
                'area'=>$area
                ];   
        }
        
        return $result_array;
    }
  
    /**
     * Добавление фигуры
     * @param string $type - тип фигуры
     * @param array $params - координаты
     */
    public function addFigure ($type,$params)
    {
        // Определим ID фигуры по ее типу
        $query = "SELECT id FROM figure WHERE type = ?";
        $id_figure = Db::getInstance()->Select($query,[$type]);

        // Начинаем транзацию 
        Db::getInstance()->beginTransaction();
        // 1 - Добавляем новую запись в список созданных фигур 
        $sql = 'INSERT INTO figurelist (date) VALUES (?)';
        Db::getInstance()->Query($sql,[date('Y-m-d H:i:s')]);
        
        $id_list = Db::getInstance()->lastInsertId();
       
        // 2 Сохраняем данные в таблицы points и params
        foreach ($params as $param =>$value) {
            
            $id_point = $this->savePoint($value); 
            $sql = "INSERT INTO params (id_list,id_figure,type,value)
            VALUES(?,?,?,?)";
            Db::getInstance()->Query($sql,[$id_list,$id_figure[0]['id'],$param,$id_point]);
        }
       
        // Завершаем транзакцию
        Db::getInstance()->commit();   
    }
        
    /**
     * Сохранение координат.Если координаты точки уже есть в таблице, возвращается ID записи,
     * если нет, то создается новая запись в таблице и возвращается ее ID
     * @param array $point - точка
     * @return int ID записи
     */
    protected function savePoint($point)
    {
        $query = "SELECT id FROM points WHERE (x = ?) AND (Y = ?) LIMIT 1";
        $result = Db::getInstance()->Select($query,[$point['x'],$point['y']]);
        $id = isset($result[0]['id']) ? $result[0]['id'] : 0;
        
        if(!$id) {
            $sql = "INSERT INTO points (x,y) VALUES (?,?)";
            Db::getInstance()->Query($sql,[$point['x'],$point['y']]);
            $id = Db::getInstance()->lastInsertId();
        }
        
        return $id;
    }
    
}

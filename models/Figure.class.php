<?php

/**
 *  Абстрактный класс Фигура
 */
abstract class Figure
{   
    /**
     * Метод для получения площади фигуры.
     * Реализован расчет площади треугольника
     * @param int $id
     * @return float
     */
    public static function getArea($id) {
        $fData = self::getCoords($id);

        $point1X = $fData['0']['x'];
        $point1Y = $fData['0']['y'];
        
        $point2X = $fData['1']['x'];
        $point2Y = $fData['1']['y'];
        
        $point3X = $fData['2']['x'];
        $point3Y = $fData['2']['y'];
        
        $left = ($point1X - $point3X) * ($point2Y-$point3Y);
        $right = ($point2X - $point3X) * ($point1Y-$point3Y);
        $area = 1/2 * abs($left - $right);
                
        return $area;
    }
    
    /**
     * Метод для получения координат фигуры по ее ID
     * @param int $id
     * @return array
     */
    public static function getCoords($id){
        
        $query = "SELECT p.x ,p.y
        FROM params pr
        JOIN points p on pr.value = p.id
        JOIN figurelist fl ON fl.id = pr.id_list
        WHERE fl.id = ? ";
        
        $result = Db::getInstance()->Select($query,[$id]);
        
        return $result;
    }   
}

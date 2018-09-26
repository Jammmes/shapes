<?php

/**
 *  Модель фигуры Параллелограм
 */
class Parallelogram extends Figure
{
    /**
     * Определение площади : 
     * т.к. параллелограм, построенный по 3 точкам состоит из 2х одинаковых
     * треугольников, то просто результат родительского метода умножим на 2
     * @param int $id
     * @return float
     */ 
    public static function getArea($id) {
        
        return parent::getArea($id) * 2 ;
    }
   /**
    * Определяет - является ли параллелограм квадратом
    * @param array $coords
    * @return boolean
    */
   public static function isSquare($coords){
       
        $point1X = $coords['0']['x'];
        $point1Y = $coords['0']['y'];
        
        $point2X = $coords['1']['x'];
        $point2Y = $coords['1']['y'];
        
        $point3X = $coords['2']['x'];
        $point3Y = $coords['2']['y'];
       
        // Последовательно проверим все пары отрезков на 
        // совпадение длины и наличие между ними угла в 90 градусов
        //Для этого преобразуем точки в векторы и проверим их
        
        $vector1 = ['x'=>$point2X - $point1X,'y'=>$point2Y - $point1Y];
        $vector2 = ['x'=>$point3X - $point2X,'y'=>$point3Y - $point2Y];
        $vector3 = ['x'=>$point3X - $point1X,'y'=>$point3Y - $point1Y];
        
        $res1 = self::compareVectorsAndAngle($vector1, $vector2);
        $res2 = self::compareVectorsAndAngle($vector1, $vector3);
        $res3 = self::compareVectorsAndAngle($vector3, $vector2);
        
        return ($res1 || $res2 ||$res3); 
   } 
   
   /**
    * Функция проверяет два вектора на совпадение длины и
    * наличие угла между ними = 90 градусов
    * @param array $vector1
    * @param array $vector2
    * @return boolean
    */
   private static function compareVectorsAndAngle($vector1, $vector2) {
            
        // Найдем косинус угла между векторами
       
        $top = ($vector1['x'] * $vector2['x']) + ($vector1['y'] * $vector2['y']);
        
        $down = sqrt(pow($vector1['x'],2) + pow($vector1['y'],2)) * sqrt(pow($vector2['x'],2) + pow($vector2['y'],2));
        
        $cos = $top/$down;
       
        // Найдем длины векторов
        $line1 = sqrt(pow($vector1['x'],2) + pow($vector1['y'],2));
        $line2 = sqrt(pow($vector2['x'],2) + pow($vector2['y'],2));
        
        // Если длины равны и угол = 90 градусов (cos = 0), то это квадрат
        
       return (($cos == 0) && ($line1 === $line2));
   }
   
}


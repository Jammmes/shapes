<?php

/**
 *  Модель фигуры Прямоугольник
 */
class Parallelogram extends Figure
{
     
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
        
        return $area * 2;
        
//        $fData = self::getCoords($id);
//        $isSquare = self::isSquare($fData); 
    }
    
   public static function isSquare($coords){
        $result = 0;
       
        $point1X = $coords['0']['x'];
        $point1Y = $coords['0']['y'];
        
        $point2X = $coords['1']['x'];
        $point2Y = $coords['1']['y'];
        
        $point3X = $coords['2']['x'];
        $point3Y = $coords['2']['y'];
       
        // Найдем косинус угла между векторами
        // Тогда первый вектор x1y1-x2y2, второй вектор x2y2-x3y3
        
        $top = ($point1X * $point2X) + ($point1Y + $point2Y);
        
        $down = sqrt(pow($point1X,2) + pow($point1Y,2)) * sqrt(pow($point2X,2) + pow($point2Y,2));
        
        $cos = $top/$down;
        
        // Теперь найдем арккосинус угла
        $angle = acos($cos);
        
        // Найдем длины отрезков
        $line1 = sqrt(pow(($point2X-$point1X),2) + pow(($point2Y-$point1Y),2));
        $line2 = sqrt(pow(($point3X-$point2X),2) + pow(($point3Y-$point2Y),2));
        
        // Если длины равны и угол = 90 градусов, то это квадрат
        
        if(($angle == 90) && ($line1 == $line2)){
            $result = 1;
        }
        
        return $result; 
   } 
}


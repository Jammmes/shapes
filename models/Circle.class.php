<?php

/**
 *  Модель фигуры Круг
 */
class Circle extends Figure
{
    public static function getArea($id) {
        
        $fData = self::getCoords($id);

        $centerX = $fData['0']['x'];
        $centerY = $fData['0']['y'];
        $radiusX = $fData['1']['x'];
        $radiusY = $fData['1']['y'];
        // Находим радиус по формуле R = корень из (x2-x1)^2+(y2-y1)^2        
        $R = sqrt(pow(($radiusX-$centerX),2) + pow(($radiusY-$centerY),2));
        // Находим площадь по формуле S = pi*R^2
        $area = pi()*pow($R,2);
        
        return round($area,2);
    }
    
   
}

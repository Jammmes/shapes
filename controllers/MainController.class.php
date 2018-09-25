<?php

/**
 * Контроллер карточки фигуры
 */
class MainController extends Controller
{
    public $view = 'v_main';

    public $title = 'Add figure';

   
    public function add()
    {
        $data = isset($_GET) ? $_GET : [];
        
        $type = $data['type'];
        $catalog = new Catalog;
        
        if ($data['type'] === 'circle'){
            $center = ['x'=>$data['centerX'],'y'=>$data['centerY']];
            $radius = ['x'=>$data['radiusX'],'y'=>$data['radiusY']];
            
            $params = ['center'=>$center,'radius'=>$radius];
        }else{
            $point1 = ['x'=>$data['point1X'],'y'=>$data['point1Y']];
            $point2 = ['x'=>$data['point2X'],'y'=>$data['point2Y']];
            $point3 = ['x'=>$data['point3X'],'y'=>$data['point3Y']];
            
            $params = ['point1'=>$point1,'point2'=>$point2,'point3'=>$point3];
        }
        header("location:/");
        return $catalog->addFigure($type, $params);
    }

   

}

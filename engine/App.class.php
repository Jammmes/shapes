<?php
/**
 * Класс основного модуля программы.
 * Содержит методы для инициации соединения с БД
 * а так же роутер, направляющий вызовы на контроллеры
 */
class App 
{
    /**
     * Установка соединения с БД и запуск роутера
     *
     * @return void
     */
    public static function Init()
    {

      // Db::getInstance()->Connect(Config::get('db_user'), Config::get('db_password'), Config::get('db_base'));

        self::router();
    }

    /**
     * Роутер в зависимости от URL определяет какой контроллер должен быть запущен
     * - Формирует и создает контроллер
     * - Выполняет рендер шаблона контроллера
     * - Выводит результат рендера в главный шаблон
     *
     * @return void
     */
    protected static function router()
    {
       //  Анализируем URL, определяем контроллер и его параметры
      $url = isset($_GET['path']) ? $_GET['path'] : '';
      $url = explode("/", $url);

        if (!empty($url[0]))
        {// если явно указана страница в GET запросе, запишем ее в 'page'
            $_GET['page'] = $url[0];

            if (isset($url[1])) 
            {// если кроме страницы в URL указан еще один блок
                if (is_numeric($url[1])) 
                { 
                    $_GET['id'] = $url[1];
                } else 
                { // если не цифровой, значит это действие, запишем его в 'action'
                    $_GET['action'] = $url[1];
                }
                if (isset($url[2])) 
                { // если есть в URL и третий блок, то это только ИД, запишем в 'id'
                    $_GET['id'] = $url[2];
                }
            }
        }
        else
        {// контроллер по умолчанию
            $_GET['page'] = 'catalog';
        }

        if (isset($_GET['page']))
        {
            $controllerName = ucfirst($_GET['page']) . 'Controller';

            $fileController = Config::get('path_controller').'/'. $controllerName.'.class.php';

            $controller = new $controllerName();

            $view = $controller->view.'.html';

            $methodName = isset($_GET['action']) ? $_GET['action'] : 'index';
            
            $data = 
              [
                'content_data' => $controller->$methodName($_GET),
                'title' => $controller->title
              ];                                 
//print_r($data['content_data']);

 
            if (!isset($_POST['AJAX']))
            {
              $loader = new Twig_Loader_Filesystem(Config::get('path_templates'));
  
              $twig = new Twig_Environment($loader);
      
              $template = $twig->loadTemplate($view);
       
              echo $template->render($data);
            }else
            {
              echo json_encode($data['content_data']);
            }

        }
        
    }
}
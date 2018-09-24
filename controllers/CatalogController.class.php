<?php

/**
 * Контроллер списка фигур
 */
class CatalogController extends Controller
{
    public $view = 'v_catalog';

    public $title = 'Figures';

    private $catalog = null;

    public function __construct()
    {
        $this->catalog = new Catalog();
    }

    /**
     * Отрисовка списка фигур
     *
     * @param array $var
     *
     * @return void
     */
    public function index($var)
    {
      return $this->catalog->getData();
    }

}

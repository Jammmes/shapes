<?php
/**
 * Абстрактный класс для описания контроллера
 */
abstract class Controller
{
    public $view = '';
    public $title = 'Page title';

    public function index($var)
    {
        return [];
    }

}
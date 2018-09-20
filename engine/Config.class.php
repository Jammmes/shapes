<?php

/**
 * Класс для работы с параметрами
 */
class Config
{
    private static $configCache = [];

    /**
     * Функция для получения значения параметра по имени
     *
     * @param string $parameter - параметр
     *
     * @return mixed - значение параметра
     */
    public static function get($parameter)
    {
        if (!isset(self::getCurrentConfiguration()[$parameter])) {
            throw new Exception('Parameter ' . $parameter . ' does not exists');
        }
        return self::getCurrentConfiguration()[$parameter];
    }

    /**
     * Функция для работы с сохраненными параметрами конфигурации
     *
     * @return array - массив с параметрами конфигурации
     */
    private static function getCurrentConfiguration()
    {
        if (empty(self::$configCache)) {
            $configDir = __DIR__ . '/../config/';
            $configDefault = $configDir . 'config.default.php';
            if (is_file($configDefault)) {
                require_once $configDefault;
            } else {
                throw new Exception('Unable to find configuration file');
            }
            if (!isset($config) || !is_array($config)) {
                throw new Exception('Unable to load configuration');
            }
            self::$configCache = $config;
        }
        return self::$configCache;
    }
}
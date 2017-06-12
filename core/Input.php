<?php
namespace core;
class Input
{
    public static $filters;
    public static function get()
    {
        $data = $_POST;
        if (empty($data)) {
            $data = $_POST = $_GET;
        }
        if (!empty($data)) {
            $filters[] = 'htmlspecialchars';
            if (is_array($data)) {
                array_walk_recursive($data, 'self::filter', $filters);
            }
            return $data;
        }
    }
    private static function filter(&$value, $key, $filters)
    {
        foreach ($filters as $filter) {
            if (is_callable($filter)) {
                $value = call_user_func($filter, $value);
            } 
        }
    }
}
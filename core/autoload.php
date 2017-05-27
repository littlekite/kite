<?php
namespace core;
spl_autoload_register(function ($class_name) {
      require_once str_replace('\\', DS, $class_name) . '.php';
});
?>
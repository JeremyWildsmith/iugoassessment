<?php

spl_autoload_register(function($className) {
    return include str_replace("\\", DIRECTORY_SEPARATOR, $className) . ".php";
});
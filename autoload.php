<?php 
/**
* Modulo autoload
* @author my name Rogerio L. Sarmento
* @Date 30/01/2023
* @Version 1
*/

spl_autoload_register(function ($class) {
	require_once(str_replace('\\', '/', $class . '.php'));
});

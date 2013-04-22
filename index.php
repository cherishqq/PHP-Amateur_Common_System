<?php

ob_start();
ini_set('date.timezone', 'Asia/Shanghai');
define('THINK_PATH', './ThinkPHP/');
define('APP_NAME', 'Home');
define('APP_PATH', './Home/');
define('APP_DEBUG', TRUE);
define('SITE_PATH', getcwd());//网站当前路径
define("RUNTIME_PATH", SITE_PATH . "/Cache/Runtime/Home/");
define("WEB_ROOT", dirname(__FILE__) . "/");
//define("WEB_HTML_PATH", reset(explode("/", $_SERVER["DOCUMENT_ROOT"])) . "/Html/");
if (!file_exists(WEB_ROOT.'Common/systemConfig.php')) {
    header("Location: install/");
    exit;
}
require(THINK_PATH . "ThinkPHP.php");

?>
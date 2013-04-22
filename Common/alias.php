<?php

if (!defined('THINK_PATH'))
    exit();
// 系统别名定义文件
return array(
    'PHPMailer' => WEB_ROOT . 'Common/Extend/PHPMailer/phpmailer.class.php',
    'CheckCode' => WEB_ROOT . 'Common/Extend/CheckCode/Checkcode.class.php',
    'QRCode' => WEB_ROOT . '/Common/Extend/QRCode.class.php',
    'Category' => WEB_ROOT . '/Common/Extend/Category.class.php',
);
<?php header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_ALL, "pt_BR", "pt_BR.utf-8", "pt_BR.utf-8", "portuguese");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$root = dirname(__FILE__);
$pos = strpos($root, '/');
if ($pos===false) {
	$temp = explode('\painel', $root);
	define('SEP', '\\');
}else{
	$temp = explode('/painel', $root);
	define('SEP', '/');
}

$root = $temp[0];

ini_set('memory_limit', '-1');

define('NAME_SPACE_UPLOAD','uploads');
define('NAME_SPACE_IMAGE','images');
define('NAME_SPACE_ARCHIVE','archives');
define('NAME_SPACE_TEMPLATE','template');
define('NAME_SPACE_ADMIN','painel');

define('PATH', $root);
define('PATH_LANGUAGE', PATH.SEP.'language'.SEP);
define('PATH_CLASS', PATH.SEP.NAME_SPACE_ADMIN.SEP.'class'.SEP);
define('PATH_UPLOADS', PATH.SEP.NAME_SPACE_UPLOAD);
define('PATH_IMAGES', PATH_UPLOADS.SEP.NAME_SPACE_IMAGE.SEP);
define('PATH_ARCHIVES', PATH_UPLOADS.SEP.NAME_SPACE_ARCHIVE.SEP);
define('PATH_PAINEL', PATH.SEP.NAME_SPACE_ADMIN.SEP);
define('PATH_TEMPLATE', PATH.SEP.NAME_SPACE_TEMPLATE.SEP);

define('NUM_PAGENATION', 30);

define('URL_PATH', '');
define('URL_BASE', sprintf("%s://%s", isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http', $_SERVER['SERVER_NAME'] ).'/'.URL_PATH ); 
define('URL_PAINEL_BASE', URL_BASE.NAME_SPACE_ADMIN.'/' );
define('URL_SITE', URL_BASE.'' );
define('URL_PAINEL', URL_PAINEL_BASE.'' ); 

define('URL_UPLOAD_IMAGE', URL_BASE.NAME_SPACE_UPLOAD.'/'.NAME_SPACE_IMAGE.'/' );
define('URL_UPLOAD_ARCHIVE', URL_BASE.NAME_SPACE_UPLOAD.'/'.NAME_SPACE_ARCHIVE.'/' );

define('URL_SITE_TEMPLATE', URL_BASE);
define('URL_PAINEL_TEMPLATE', URL_SITE_TEMPLATE.NAME_SPACE_ADMIN.'/' );


define('NAME_SITE', 'suelopro' );

define('DB_HOST', 'xxxxxxxxxxxxxxx' );
define('DB_USER', 'xxxxxxxxxxxxxxx' );
define('DB_NAME', 'xxxxxxxxxxxxxxx' );
define('DB_PASS', 'xxxxxxxxxxxxxxx' );

define('PREFIX', '' );

define('EMAIL_ADMIN', 'xxxxxxxxxxxxxxx' );
define('USER_ADMIN', 'xxxxxxxxxxxxxxx' );
define('NOME_ADMIN', 'xxxxxxxxxxxxxxx' );
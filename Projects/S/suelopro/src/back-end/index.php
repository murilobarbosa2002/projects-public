<?php session_start();
if (!isset($_COOKIE['cont'])) {
	setcookie('cont', 1, time()+3700);
	$_SESSION['contador'] = true;
}else{
	$_SESSION['contador'] = false;
}
require 'painel/config.php';

require PATH_CLASS.'conn'.SEP.'Conexao.class.php';

$Conexao = new Conexao(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$resultados = $Conexao->select('conteudo, url')->from(PREFIX.'configuracoes')->fetch();
if ($Conexao->affected_rows > 0) {
    foreach ($resultados as $resultado) {
        $configuracoes[$resultado['url']] = $resultado['conteudo'];
        $configuracoes_extract[str_replace('-', '_', $resultado['url'])] = $resultado['conteudo'];
    }
    extract($configuracoes_extract);
} 

$url_atual = $Conexao->getUrl();
$url_atual = preg_replace('/[^\w\/\-\_]/', '', $url_atual);

if (empty($url_atual)) {
    $Conexao->redirect(URL_SITE . 'home');
}

$url_atual = explode('/', $url_atual);
$sistema = $url_atual[0];
$final_url = end($url_atual);

if (in_array('page', $url_atual)) {
    $explode_url_page = explode('/page/', $Conexao->getUrl());
    $explode_url_page = explode('/', $explode_url_page[0]);
    $where = array('url' => end($explode_url_page));
    $check_url = end($explode_url_page);
}else{ 
    $check_url = $final_url;
}

$_SESSION['LANG'] = (empty($_SESSION['LANG']) ? 'bra_' : $_SESSION['LANG']);

if(count($url_atual)==2&&$url_atual[0]=='lng'):
    list($sistema,$parametro) = $url_atual;
    switch ($parametro):
        case 'bra':
            $_SESSION['LANG'] = $parametro.'_';
            break;
        case 'usa':
            $_SESSION['LANG'] = $parametro.'_';
            break;
        case 'esp':
            $_SESSION['LANG'] = $parametro.'_';
            break;
        default: 
            $_SESSION['LANG'] = 'bra_'; 
    endswitch;
    $Conexao->redirect(URL_SITE.'home');
    exit();
endif;

$where = array('status' => 1);

if (file_exists(PATH_LANGUAGE.$_SESSION['LANG'].'/index.php')) {
    require_once(PATH_LANGUAGE.$_SESSION['LANG'].'/index.php'); 
    extract($_);
} 

$menus = array(
    7 => $menu_empresa,
    8 => $menu_produtos,
    9 => $menu_servicos,
    10 => $menu_fotos,
    11 => $menu_clientes,
    12 => $menu_contato
);
if (empty($sistema)) {
    return false;
}else{
    $pagina = $sistema.'.php';
    if ($pagina=='download.php') { 
        require_once(PATH_TEMPLATE.$pagina);  
    }elseif ($Conexao->checarPagina(PATH_TEMPLATE.$pagina)) {
        require_once(PATH_TEMPLATE.'__header.php');
        require_once(PATH_TEMPLATE.$pagina); 
        require_once(PATH_TEMPLATE.'__footer.php');
    }else{
        require_once(PATH_TEMPLATE.'__header.php');
        require_once(PATH_TEMPLATE.'404.php');
        require_once(PATH_TEMPLATE.'__footer.php');
    }
} ?>
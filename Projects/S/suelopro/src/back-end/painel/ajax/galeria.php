<?php session_start(); 
require('../config.php'); 
require(PATH_CLASS.'conn'.SEP.'Conexao.class.php'); 
$Conexao = new Conexao(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($_POST&&isset($_POST['url'])) {
    $url = addslashes(strip_tags($_POST['url']));
    $fotos = $Conexao->select('id')->from(PREFIX.$_SESSION['LANG'].'fotos')->where('url = \''.$url.'\' AND status = 1')->order_by('id','ASC')->fetch_first();
    if ($Conexao->affected_rows > 0){
        extract($fotos,EXTR_OVERWRITE);
        $query = $Conexao->select('legenda,image')->from(PREFIX.$_SESSION['LANG'].'galeriafotos')->where($_SESSION['LANG'].'fotos = '.$id)->fetch();
        if ($Conexao->affected_rows > 0){
            foreach ($query as $index => $base){
                extract($base);
                $data[] = array('pequena' =>  $Conexao->generate_image_src('fotos',100,100,$image,'cortar'), 'grande' =>  $Conexao->generate_image_src('fotos',1000,1000,$image,'redimencionar'), 'legenda' => $legenda  );
            }
        }else{
            $data = array();
        }
    }else{
        $data = array();
    }

    echo json_encode($data);
    exit();
} 
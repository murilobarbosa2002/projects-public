<?php session_start(); 
require('../config.php'); 
require(PATH_CLASS.'conn'.SEP.'Conexao.class.php'); 
$Conexao = new Conexao(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$resultado = $Conexao->select('conteudo')->from(PREFIX.'configuracoes')->where(array('url' => 'e-mail-que-ira-receber-os-formularios-de-contato' ))->fetch_first();
if ($Conexao->affected_rows > 0) {
    $email_to = $resultado['conteudo'];
}else{
    $email_to = '';
}

if ($_POST&&isset($_POST['email'])) {
    $post = $_POST;  
    

    if (empty($post['email'])) {
        $message['error'][] = array('input' => 'email', 'message' => htmlentities('Por favor, digite o seu E-mail !'));
    }

    if (filter_var($post['email'], FILTER_VALIDATE_EMAIL)===false) {
        $message['error'][] = array('input' => 'email', 'message' => htmlentities('Por favor, digite um endereço de E-mail válido !'));
    }

    $rows = $Conexao->select('id')->from(PREFIX.$_SESSION['LANG'].'newsletters')->where(array('email' => $post['email']))->fetch_first();
    if ($Conexao->affected_rows > 0) {
        $message['error'][] = array('input' => 'email', 'message' => htmlentities('Este e-mail já esta registrado !'));
    }
   

    if (!isset($message['error'])) {

        try { 
            $data = $post;  
            extract($data);

            $data['created'] = date('Y-m-d H:i:s');

            $url = $Conexao->url_amigavel($email);

            $verificar = true;
            $cont = 1;
            while ($verificar) {
                $rows = $Conexao->select('id')->from(PREFIX.$_SESSION['LANG'].'newsletters')->where(array('url' => $url))->fetch_first();
                if ($Conexao->affected_rows > 0) {
                    $url = $Conexao->url_amigavel($Conexao->tratarString($data['email'])).'_'.$cont;
                }else{
                    $verificar = false;
                }
                $cont ++;
            }

            $data['url'] = $url;

            $Conexao->insert($_SESSION['LANG'].'newsletters', $data);
 
            $message['success'] = array('message' => htmlentities('Seu e-mail foi cadastrado com sucesso !'));

            
        } catch (Exception $e) {
            $message['error'][] = array('input' => 'email', 'message' => htmlentities('Erro no cadastro, contate o administrador !'));
        }
        
    }

    echo json_encode($message);
    exit();
} 
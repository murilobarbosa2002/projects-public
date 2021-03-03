<?php session_start();
require('../painel/config.php');
require(PATH_CLASS.'conn'.SEP.'Conexao.class.php');
$Conexao = new Conexao(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($_POST && isset($_POST['email'])) {
    $post = array(
        'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL)
    );


    if ( empty($post['email'])) {
        $message['error'][] = array('input' => 'email', 'message' => htmlentities('Por favor, digite seu email !'));
    }

    $rows = $Conexao->select('id')->from(PREFIX.$_SESSION['LANG'].'newsletters')->where(array('email' => $post['email']))->fetch_first();
    if ($Conexao->affected_rows > 0) {
        $message['error'][] = array('input' => 'email', 'message' => htmlentities('O seu E-mail foi registrado com sucesso !'));
    }

    if ( !isset($message['error'])) {

        try {
            $data = $post;
            extract($data);

            $data['created'] = date('Y-m-d H:i:s');
            $data['updated'] = date('Y-m-d H:i:s');

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

            $message['success'][] = array('message' => htmlentities('Seu e-mail foi registrado com sucesso !'));


        } catch (Exception $e) {
            $message['error'][] = array('input' => 'email', 'message' => htmlentities('Erro no envio do e-mail, contate o administrador !'));
        }

    }

    echo json_encode($message);
    exit();
}
<?php session_start();
require('../painel/config.php');
require(PATH_CLASS.'conn'.SEP.'Conexao.class.php');
$Conexao = new Conexao(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$lang = $_SESSION['LANG'];
$query = $Conexao->select('conteudo')->from(PREFIX.'configuracoes')->where(array('url' => 'e-mail-que-recebe-os-dados-do-formulario-contato' ))->fetch_first();
if ($Conexao->affected_rows > 0) {
    $email_to = $query['conteudo'];
}else{
    $email_to = '';
}

$assunto = 'Novo e-mail de contato enviado pelo Blog!';

if ($_POST&&isset($_POST['nome'])&&isset($_POST['email'])&&isset($_POST['mensagem'])) {
    $post = array(
        'nome' => filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING),
        'telefone' => filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING),
        'estado' => filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING),
        'cidade' => filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_STRING),
        'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING),
        'mensagem' => filter_input(INPUT_POST, 'mensagem', FILTER_SANITIZE_STRING)
    );

    if (empty($post['nome'])) {
        $message['error'][] = array('input' => 'nome', 'message' => htmlentities('Por favor, digite o seu Nome !'));
    }


    if (filter_var($post['email'], FILTER_VALIDATE_EMAIL)===false) {
        $message['error'][] = array('input' => 'email', 'message' => htmlentities('Por favor, digite um endereço de E-mail válido !'));
    }


    if (empty($post['telefone'])) {
        $message['error'][] = array('input' => 'telefone', 'message' => htmlentities('Por favor, digite seu telefone!'));
    }


    if (empty($post['cidade'])) {
        $message['error'][] = array('input' => 'cidade', 'message' => htmlentities('Por favor, selecione uma Cidade!'));
    }

    if (empty($post['mensagem'])) {
        $message['error'][] = array('input' => 'mensagem', 'message' => htmlentities('Por favor, digite a sua Mensagem !'));
    }

    if (!isset($message['error'])) {

        try {
            $data = $post;
            extract($data);

            $data['created'] = date('Y-m-d H:i:s');

            $url = $Conexao->url_amigavel($nome);

            $verificar = true;
            $cont = 1;
            while ($verificar) {
                $rows = $Conexao->select('id')->from(PREFIX.$_SESSION['LANG'].'contatos')->where(array('url' => $url))->fetch_first();
                if ($Conexao->affected_rows > 0) {
                    $url = $Conexao->url_amigavel($Conexao->tratarString($data['nome'])).'_'.$cont;
                }else{
                    $verificar = false;
                }
                $cont ++;
            }

            $data['url'] = $url;

            $Conexao->insert($_SESSION['LANG'].'contatos', $data);

            $Body = '<strong>NOME :</strong> '.$nome.'<br/>';
            $Body .= '<strong>E-MAIL :</strong> '.$email.'<br/>';
            $Body .= '<strong>TELEFONE:</strong> '.$telefone.'<br/>';
            $Body .= '<strong>ESTADO:</strong> '.$estado.'<br/>';
            $Body .= '<strong>CIDADE:</strong> '.$cidade.'<br/>';
            $Body .= '<strong>MENSAGEM :</strong> '.$mensagem;

            $email_voucher = $Conexao->voucher_email_site();

            $email_voucher = str_replace(array('[:nomesite:]','[:dados:]'), array(NAME_SITE,$Body), $email_voucher);

            if (!empty($email_to)) {
                $emails = explode(',', $email_to);
                $emails_send = array();
                foreach ($emails as $key => $email) {
                    $emails_send[$email] = $email;
                }

                $retorno = $Conexao->sendEmail('', NAME_SITE, $emails_send, $assunto, $email_voucher, true);
                if ($retorno['status']==1) {
                    $message['success'][] = array('message' => htmlentities('Sua mensagem foi enviada com sucesso !'));
                }else{
                    $message['error'][] = array('input' => 'mensagem', 'message' => htmlentities('Erro no envio do e-mail, contate o administrador !'));
                }
            } else{
                $message['success'][] = array('message' => htmlentities('Sua mensagem foi enviada com sucesso !'));
            }


        } catch (Exception $e) {
            $message['error'][] = array('input' => 'mensagem', 'message' => htmlentities('Erro no envio do e-mail, contate o administrador !'));
        }

    }

    echo json_encode($message);
    exit();
}
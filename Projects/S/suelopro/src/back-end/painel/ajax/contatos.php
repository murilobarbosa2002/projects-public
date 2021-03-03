<?php session_start(); 
require('../config.php'); 
require(PATH_CLASS.'conn'.SEP.'Conexao.class.php'); 
$Conexao = new Conexao(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$resultado = $Conexao->select('conteudo')->from(PREFIX.'configuracoes')->where(array('url' => 'e-mail-que-ira-receber-os-contatos-do-formulario-de-contato' ))->fetch_first();
if ($Conexao->affected_rows > 0) {
    $email_to = $resultado['conteudo'];
}else{
    $email_to = '';
}

$assunto = 'Novo contato enviado pelo site !';

if ($_POST&&isset($_POST['nome'])&&isset($_POST['filtro'])) {
    $post = $_POST;  
    
    if (empty($post['nome'])) {
        $message['error'][] = array('input' => 'nome', 'message' => htmlentities('Por favor, digite o seu Nome !'));
    } 

    if (empty($post['email'])) {
        $message['error'][] = array('input' => 'email', 'message' => htmlentities('Por favor, digite o seu E-mail !'));
    }

    if (filter_var($post['email'], FILTER_VALIDATE_EMAIL)===false) {
        $message['error'][] = array('input' => 'email', 'message' => htmlentities('Por favor, digite um endereço de E-mail válido !'));
    }

    if (empty($post['telefone'])) {
        $message['error'][] = array('input' => 'telefone', 'message' => htmlentities('Por favor, digite o seu Telefone !'));
    } 


    if (empty($post['estado'])) {
        $message['error'][] = array('input' => 'filtro', 'message' => htmlentities('Por favor, selecione seu estado !'));
    } 

    if (empty($post['cidade'])) {
        $message['error'][] = array('input' => 'cidade', 'message' => htmlentities('Por favor, digite sua cidade !'));
    } 

    if (empty($post['mensagem'])) {
        $message['error'][] = array('input' => 'mensagem', 'message' => htmlentities('Por favor, digite sua mensagem !'));
    }  

    if (!isset($message['error'])) {

        try { 
            $data = $post;  
            extract($data);
            unset($data['filtro']);

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
            $Body .= '<strong>TELEFONE :</strong> '.$telefone.'<br/>';   
            $Body .= '<strong>ESTADO :</strong> '.$estado.'<br/>';   
            $Body .= '<strong>CIDADE :</strong> '.$cidade.'<br/>';       
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
                    $message['success'] = array('message' => htmlentities('Sua mensagem foi enviada com sucesso !'));
                }else{
                    $message['warning'] = array('input' => 'mensagem', 'message' => htmlentities('Erro no envio do e-mail, contate o administrador !'));
                }
            } 

            
        } catch (Exception $e) {
            $message['warning'] = array('input' => 'mensagem', 'message' => htmlentities('Erro no envio do e-mail, contate o administrador !'));
        }
        
    }

    echo json_encode($message);
    exit();
} 
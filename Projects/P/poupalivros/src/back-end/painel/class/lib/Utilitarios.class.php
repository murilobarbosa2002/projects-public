<?php
class Utilitarios
{
    public function gerarSenha($tamanho=9, $forca=0) {
        $vogais = 'aeuy';
        $consoantes = 'bdghjmnpqrstvz';
        if ($forca >= 1) {
            $consoantes .= 'BDGHJLMNPQRSTVWXZ';
        }
        if ($forca >= 2) {
            $vogais .= "AEUY";
        }
        if ($forca >= 4) {
            $consoantes .= '23456789';
        }
        if ($forca >= 8 ) {
            $vogais .= '@#$%';
        }

        $senha = '';
        $alt = time() % 2;
        for ($i = 0; $i < $tamanho; $i++) {
            if ($alt == 1) {
                $senha .= $consoantes[(rand() % strlen($consoantes))];
                $alt = 0;
            } else {
                $senha .= $vogais[(rand() % strlen($vogais))];
                $alt = 1;
            }
        }
        return $senha;
    }

    public function redirect($url)
    {
       if (!headers_sent())
            header('Location: '.$url);
        else {
            echo '<script type="text/javascript">';
            echo 'window.location.href="'.$url.'";';
            echo '</script>';
            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
            echo '</noscript>';
        }
    }

    public function getUrl($full=false)
    {
        if ($full) {

            return 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

        }else{

            if (isset($_GET['route'])) {

                $route = $_GET['route'];

                $route = strtolower($route);

                $route = $this->tratarString($route);

                return $route;

            }else{
                return '';
            }

        }

    }

    public function message_system($texto, $status = 'success')
    {
        return '<div class="text-center alert alert-'.$status.'" style="margin-bottom: 0px;">'.$texto.'</div>';
    }

    public function validaEmail($email){
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }else{
            return false;
        }
    }

    public function tratarString($string){
        if (!empty($string)) {
            $string = strip_tags($string,'<a><p><iframe><div><br><strong><img><table><tr><td><th><h1><h2><h3><h4><ul><li><span><blockquote><sub><sup><s><u><script><input><form><textarea><button><b><em><hr><s><i><icon>'); 
        }
        return $string;
    }

    protected function tratarInt($int){
        $int = intval($int);
        return $int;
    }

    public function sendEmail($From, $FromName, $AddAddress, $Subject, $Body, $SMTPAuth=false, $AddAttachment=''){

        if (!defined('SMTP_EMAIL')) define('SMTP_EMAIL', $this->get_custom_by_id('conteudo','configuracoes',1));
        if (!defined('PORT_EMAIL')) define('PORT_EMAIL', $this->get_custom_by_id('conteudo','configuracoes',2));
        if (!defined('EMAIL_LOGIN')) define('EMAIL_LOGIN', $this->get_custom_by_id('conteudo','configuracoes',3));
        if (!defined('EMAIL_PASS')) define('EMAIL_PASS', $this->get_custom_by_id('conteudo','configuracoes',4));


        require_once PATH_CLASS.'lib/PHPMailerAutoload.php';

        $mail = new PHPMailer;

        $mail->CharSet = 'UTF-8';
        $mail->SMTPDebug = 0;
        $mail->Debugoutput = 'html';
        
        if ($SMTPAuth) {
            $mail->isSMTP();
            $mail->Host = SMTP_EMAIL;
            $mail->Port = PORT_EMAIL;
            $mail->SMTPSecure = false;
            $mail->SMTPAutoTLS = false;
            $mail->SMTPAuth = true;
            $mail->Username = EMAIL_LOGIN;
            $mail->Password = EMAIL_PASS;
        }else{
            $mail->isSendmail();
        }

        $mail->setFrom(EMAIL_LOGIN, $FromName);

        foreach ($AddAddress as $Nome => $Email) {
            $mail->addAddress($Email, $Nome);
        }
        
        $mail->Subject = $Subject;
        
        $mail->msgHTML($Body);

        if (!empty($AddAttachment)) {

            foreach ($AddAttachment as $key => $Attachment) {
                $mail->addAttachment($Attachment['tmp_name'], $Attachment['name']);
            }
        }
        

        if (!$mail->send()) {

            return array('status' => 0, 'erro' => $mail->ErrorInfo );

        } else {

            return array('status' => 1 );

        }

    }

    public function comparar_menu_ativo_final($menu, $class){
        $url = $this->getUrl();
        $url = explode('/', $url);
        if (end($url)==$menu) {
            return $class;
        }else{
            return '';
        }
    }

    public function comparar_menu_ativo($menu, $class){
        $url = $this->getUrl();
        $url = explode('/', $url);
        if ($url[0]==$menu) {
            return $class;
        }else{
            return '';
        }
    }

    public function comparar_menu_ativo_full_url($menu, $class){
        $url = $this->getUrl();

        if ($url==$menu) {
            return $class;
        }else{
            return '';
        }
    }

    public function routes(){
        $url = $this->getUrl();
        $url = explode('/', $url);
        if (empty($url[0])) {
            return false;
        }else{
            $pagina = $url[0].'.php';
            if ($this->checarPagina($pagina)) {
                require_once($pagina);
            }
        }
    }

    public function checarPagina($pagina){
        if (file_exists($pagina)) {
            return true;
        }else{
            return false;
        }
    }

    public function url_amigavel($string) {
        $what = array( '�', 'ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û','À','Á','Ã','Â','É','Ê','Í','Ó','Õ','Ô','Ú','ñ','Ñ','ç','Ç',' ','-','(',')',',',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','º','\'','.','--', 'â¡','Ã£','Ã´','Ã©','Ã§','Ã£','Ãµ','Ã³','+',chr(13),'°' );
        $by   = array( '', 'a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u','A','A','A','A','E','E','I','O','O','O','U','n','n','c','C','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','','','-', 'a','a','o','e','c','a','o','o','','-','' );
        $string = str_replace($what, $by, $string);
        $string = str_replace($what, $by, $string);
        $string = str_replace($what, $by, $string);

        $string = strtolower($string);
        
        return $string;
    }

    public function logout(){
        session_destroy();
        $this->redirect(URL_PAINEL);
    }


    public function not_found(){
        $this->redirect(URL_PAINEL.'inicial');
    }

    public function pagination_painel($url,$total,$page){
        $inicio = 1;
        $fim = 10;
        $ultima = ceil($total / NUM_PAGENATION);
        if($page > 4) {
            $inicio = $page - 3;
            $fim = $page + 3;
        }
        if($fim>$ultima) $fim = $ultima;
        if($fim > 7 && $inicio > ($fim-6)) $inicio = $fim - 6;
        if($inicio < $fim) {
            echo '<div class="btn-toolbar pull-right"><div class="btn-group">';
                for ($i=$inicio; $i<=$fim; $i++) {
                    if ($page==$i){
                        $class = ' btn-grey';
                    }else{
                        $class = '';
                    }

                    echo '<a href="'.$url.$i.'" class="btn'.$class.'">'.$i.'</a>';
                }
            echo '</div></div> ';
        }
    }

    public function verificar_existe_imagem_nome($pasta, $arquivo_atual){

        $this->criar_pasta($pasta);

        $files = glob($pasta.'*');
 
        $cont = 1;

        $arquivo_verificar = $arquivo_atual;
        $extensao = $this->capturar_extensao($arquivo_atual);
        $arquivo_atual_name = str_replace('.'.$extensao, '', $arquivo_atual);
        if (is_array($files)) { 
            while (in_array($pasta.$arquivo_verificar, $files)) { 
                $arquivo_verificar = $arquivo_atual_name.'_'.$cont.'.'.$extensao;
                $cont ++;
                if ($cont>120) { break; }
            } 
        }
        return $arquivo_verificar;
    }

    public function capturar_extensao($arquivo){
        $extensao = pathinfo($arquivo, PATHINFO_EXTENSION);
        return $extensao;
    }

    public function deletar_aquivo($nome_arquivo){
        if (!empty($nome_arquivo)) {
            if (file_exists($nome_arquivo)) {
                @unlink($nome_arquivo);
            }
        }
    }

    public function criar_pasta($nome_pasta, $permisao = 0777){
        if(is_dir($nome_pasta)){

        }else{
            mkdir($nome_pasta, $permisao);
        }
    }

    public function validarCSRF(){
        if ($_POST['csrf_token'] == $_SESSION['csrf_token']) {
            $_SESSION['csrf_token'] = md5(uniqid());
            return true;
        }
        return false;
    }

    public function inputCSRF() {
        if (!isset($_SESSION['csrf_token']))
            $_SESSION['csrf_token'] = md5(uniqid());

        echo '<input type="hidden" name="csrf_token" value="' . $_SESSION['csrf_token'] . '">';
    }

    function validaCnpj ( $cnpj ) {
        $cnpj = preg_replace( '/[^0-9]/', '', $cnpj );
        $cnpj = (string)$cnpj;
        $cnpj_original = $cnpj;
        $primeiros_numeros_cnpj = substr( $cnpj, 0, 12 );
        if ( ! function_exists('multiplica_cnpj') ) {
            function multiplica_cnpj( $cnpj, $posicao = 5 ) {
                $calculo = 0;
                for ( $i = 0; $i < strlen( $cnpj ); $i++ ) {
                    $calculo = $calculo + ( $cnpj[$i] * $posicao );
                    $posicao--;
                    if ( $posicao < 2 ) {
                        $posicao = 9;
                    }
                }
                return $calculo;
            }
        }
        $primeiro_calculo = multiplica_cnpj( $primeiros_numeros_cnpj );
        $primeiro_digito = ( $primeiro_calculo % 11 ) < 2 ? 0 :  11 - ( $primeiro_calculo % 11 );
        $primeiros_numeros_cnpj .= $primeiro_digito;
        $segundo_calculo = multiplica_cnpj( $primeiros_numeros_cnpj, 6 );
        $segundo_digito = ( $segundo_calculo % 11 ) < 2 ? 0 :  11 - ( $segundo_calculo % 11 );
        $cnpj = $primeiros_numeros_cnpj . $segundo_digito;
        if ( $cnpj === $cnpj_original ) {
            return true;
        }
    }

    public function validaCpf( $cpf = false ) {
        if ( ! function_exists('calc_digitos_posicoes') ) {
            function calc_digitos_posicoes( $digitos, $posicoes = 10, $soma_digitos = 0 ) {
                for ( $i = 0; $i < strlen( $digitos ); $i++  ) {
                    $soma_digitos = $soma_digitos + ( $digitos[$i] * $posicoes );
                    $posicoes--;
                }
                $soma_digitos = $soma_digitos % 11;
                if ( $soma_digitos < 2 ) {
                    $soma_digitos = 0;
                } else {
                    $soma_digitos = 11 - $soma_digitos;
                }
                $cpf = $digitos . $soma_digitos;
                return $cpf;
            }
        }
        if ( ! $cpf ) {
            return false;
        }
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
        if ( strlen( $cpf ) != 11 ) {
            return false;
        }
        $digitos = substr($cpf, 0, 9);
        $novo_cpf = calc_digitos_posicoes( $digitos );
        $novo_cpf = calc_digitos_posicoes( $novo_cpf, 11 );
        if ( $novo_cpf === $cpf ) {
            return true;
        } else {
            return false;
        }
    }

    public function formatar_valores($valor = 0, $casas = '%.2n'){
        return money_format($casas, $valor);
    }

    public function get_header(){
        require_once(PATH_TEMPLATE.'header.php');
    }

    public function get_footer($footer = 'footer.php'){
        require_once(PATH_TEMPLATE.$footer);
    }

    public function get_sidebar(){
        require_once(PATH_TEMPLATE.'sidebar.php');
    }

    public function index_exists_array($array_index, $array){
        $retono = false;
        foreach ($array_index as $index) {
            if (isset($array[$index])&&array_key_exists($index, $array)&&!empty($array[$index])) {
                $retono = true;
            }
        }
        return $retono;
    }

    public function get_ip(){
        $ip  = !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
        if ($ip=='127.0.0.1') {
            $ip = '131.0.86.92';
        }
        return $ip;
    }

    public function get_address_from_ip(){

        $ip  = $this->get_ip();
        $url = 'http://freegeoip.net/json/'.$ip;
        $ch  = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        $data = curl_exec($ch);
        curl_close($ch);

        if ($data) {
            $location = json_decode($data);

            $latitude = $location->latitude;
            $longitude = $location->longitude;
            $cidade = $location->city;
            $estado = $location->region_name;
            $sigla = $location->region_code;
            $cep = $location->zip_code;

            $info = array('latitude' => $latitude, 'longitude' => $longitude, 'cidade' => $cidade, 'estado' => $estado, 'sigla' => $sigla, 'cep' => $cep);

            return $info;
        }
    }

    public function get_distance_time($endereco1, $endereco2, $key){
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=$endereco1&destinations=$endereco2&key=$key";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response, true);

        $dist = $response_a['rows'][0]['elements']['0']['distance']['text'];
        $time = $response_a['rows'][0]['elements']['0']['duration']['text'];

        return array('distance' => $dist, 'time' => $time);
    }

    public function previsao_tempo($key = 'cff18956'){
        $resposta = file_get_contents('https://api.hgbrasil.com/weather/?format=json&user_ip='.$this->get_ip().'&key='.$key.'');
        $resposta = json_decode($resposta);
        return $resposta;
    }


    public function meses_ano($type='full'){
        if ($type=='full') {
            $arr_meses = array(1 => 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
        }elseif($type='sigla'){
            $arr_meses = array( 1 => 'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez');
        }

        return $arr_meses;
    }

    public function voucher_email_personalizado(){
        $body = '<!DOCTYPE html> 
        <html> 
            <head><title>[:title:]</title></head> 
            <body style="background-color: #eeeeee;"> 
                <div style="width: 600px; max-width: 100%; margin-left: auto; margin-right: auto; margin-top: 30px; margin-bottom: 30px; font-size: 16px; font-family: Arial, Helvetica, Roboto, sans-serif; background-color: #ffffff;"> 
                    <table width="100%" cellspacing="0" cellpadding="0"> 
                        <thead> 
                            <tr> 
                                <th style="padding-top: 10px; padding-right: 10px; padding-left: 10px;"> 
                                    <div style="border-left: 1px solid #9f9f9f; border-right: 1px solid #9f9f9f; border-top: 1px solid #9f9f9f; border-radius: 7px 7px 0 0; padding-bottom: 37px;"> 
                                        <img src="[:url_template:]assets/images/logo-email.png" style="display: block; margin-left: auto; margin-right: auto; margin-top: 37px; border: none; max-width: 100%; height: auto;"> 
                                    </div> 
                                </th> 
                            </tr> 
                        </thead> 
                        <tbody> 
                            <tr> 
                                <td style="padding-right: 10px; padding-left: 10px;"> 
                                    <div style="border-left: 1px solid #9f9f9f; border-right: 1px solid #9f9f9f; padding-left: 23px;padding-right: 23px; padding-bottom: 50px;"> 
                                        <h1 style="font-size: 25px; margin-top: 0;font-weight: 300;">
                                            Bem - Vindo a 
                                            <b style="color: #ff0000; font-weight:700">Scan<span style="color: #02475a;">Photo</span></b>
                                        </h1> 
                                        <table cellpadding="0" cellspacing="0" style="color: #9f9f9f; font-size: 21px;"> 
                                            <tr> 
                                                <td style="padding-right: 15px;"><i>[:data:]</i></td> 
                                                <td style="padding-left: 15px; border-left: 2px solid #9f9f9f;">[:hora:]</td> 
                                            </tr>
                                        </table> 
                                    </div> 
                                </td> 
                            </tr> 
                            <tr> 
                                <td style="padding-right: 10px; padding-left: 10px;"> 
                                    <div style="border-left: 1px solid #9f9f9f; border-right: 1px solid #9f9f9f; padding-left: 23px;padding-right: 23px;"> 
                                        <h2 style="font-size: 21px; font-weight: 300; margin-top: 0; color: #151515;margin-bottom:0">
                                            [:descricao:]
                                        </h2> 
                                    </div> 
                                </td> 
                            </tr> 
                        </tbody> 
                        <tfoot> 
                            <tr> 
                                <td> 
                                    <img src="[:url_template:]assets/images/borda-email.png" style="display:block;margin:0;padding:0;border:none"> 
                                </td> 
                            </tr> 
                            <tr> 
                                <td style="padding-left:10px;padding-right:10px;padding-bottom: 10px;background-color:#d7e4fa">
                                    <div style="padding-top:23px;padding-left: 23px; padding-bottom: 30px; font-size: 21px; color: #024157;border-left:1px solid #9f9f9f;border-right:1px solid #9f9f9f;border-bottom:1px solid #9f9f9f;border-radius: 0 0 7px 7px">
                                        [:descricao_2:] 
                                    </div> 
                                </td> 
                            </tr> 
                        </tfoot> 
                    </table> 
                </div> 
            </body> 
        </html>'; 
        return $body;
    }

    public function voucher_email_site(){
        $body = '<html>
            <head>
                <title>[:nomesite:]</title>
                <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
                <meta http-equiv="content-language" content="pt-BR" />
                <meta name="copyright" content="[:nomesite:]" />
            </head>
            <body>
                <table width="520" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td bgcolor="#CCCCCC" style="padding:10px;">
                            <span style="border: 1px solid #B1B1B1; background-color: #EEEEEE; padding: 4px 6px; display:block; margin-top:10px; margin-bottom:10px;">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #000000; font-family:\'Trebuchet MS\', Tahoma, Verdana, Arial, Helvetica, sans-serif; font-size:11px; background-color:#FFFFFF;">
                                    <tr>
                                        <td style=" padding: 4px 6px;">
                                           [:dados:]
                                        </td>
                                    </tr>
                                </table>
                            </span>
                        </td>
                    </tr>
                </table>
            </body>
        </html>';
        return $body;
    }

    public function voucher_email_produtos(){
        $body = '<html>
            <head>
                <title>[:nomesite:]</title>
                <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
                <meta http-equiv="content-language" content="pt-BR" />
                <meta name="copyright" content="[:nomesite:]" />
            </head>
            <body>
                <table width="520" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td bgcolor="#CCCCCC" style="padding:10px;">
                            <table width="500" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #000000; font-family:\'Trebuchet MS\', Tahoma, Verdana, Arial, Helvetica, sans-serif; font-size:11px; background-color:#FFFFFF;">
                                <tr>
                                    <td style="border-top:3px solid #1E4475; border-bottom:1px solid #B1B1B1; padding:10px;">
                                        <h3 style="color:#CC0000; font-size: 12px; text-align: center; border-bottom:1px solid #CCCCCC;">Confirmação de Orçamento no [:nomesite:]</h3>
                                        Prezado <b>[:nome_cliente:]</b>,
                                        <br><br>
                                        Esta é uma confirmação de que o orçamento de número <b>[:numero_pedido:]</b>&nbsp; foi realizado por você em <b>[:data_pedido:]</b> foi concluído com sucesso. Abaixo, maiores informações sobre seu orçamento:
                                        <br>
                                        <span style="border: 1px solid #B1B1B1; background-color: #EEEEEE; padding: 4px 6px; display:block; margin-top:10px;">[:dados_compra:]</span><br>
                                        <b><u>DADOS DO CLIENTE:</u></b>
                                        <br>
                                        <span style="border: 1px solid #B1B1B1; background-color: #EEEEEE; padding: 4px 6px; display:block; margin-top:10px; margin-bottom:10px;">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #000000; font-family:\'Trebuchet MS\', Tahoma, Verdana, Arial, Helvetica, sans-serif; font-size:11px; background-color:#FFFFFF;">
                                                <tr>
                                                    <td style=" padding: 4px 6px;">
                                                       [:dados:]
                                                    </td>
                                                </tr>
                                            </table>
                                        </span>
                                        Agradecemos a preferência. Esperamos atendê-lo novamente no futuro.
                                        <br><br>
                                        Atenciosamente,<br>
                                        [:nomesite:].
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="border-top:3px solid #D9D9D9; padding:3px 0px; background-color:#EEEEEE;">
                                        Copyright &copy; [:nomesite:] &nbsp; - &nbsp; Todos os Direitos Reservados
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </body>
        </html>';
        return $body;
    }
    public function voucher_produto(){
        $product = '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #000000; font-family:\'Trebuchet MS\', Tahoma, Verdana, Arial, Helvetica, sans-serif; font-size:11px; background-color:#FFFFFF;">
            <tr>
                <td width="110"> <img src="[:url_image:]" width="100" height="100"> </td>
                <td>
                    <b>PRODUTO : </b> [:nome_produto:] <br/> 
                    <b>QUANTIDADE : </b> [:quantidade:] <br/>
                </td>
            </tr>
        </table>';
        return $product;
    }

    public function get_name_by_id($table,$id){
        $Conexao = new Conexao(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $table = (isset($_SESSION['LANG']) ? $_SESSION['LANG'].$table : $table);
        $row = $Conexao->select('nome')->from(PREFIX.$table)->where(array('id' => $id))->fetch_first();
        if ($Conexao->affected_rows > 0) {
            $nome = $row['nome'];
        }
        return $nome;
    }

    public function update_by_id($id,$table,$array){
        $Conexao = new Conexao(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $$Conexao->where('id = '.$id)->update($table, $array)->execute();

    }

    public function get_custom_by_id($camp,$table,$id,$swap=''){
        $titulo = '';
        $Conexao = new Conexao(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $table = ($table == 'configuracoes'||$table == 'administradores'||$table == 'status_pedido'||$table == 'pedidos'||$table == 'pedidos_itens'||$table == 'fotos_pedidos'?$table:(isset($_SESSION['LANG']) ? $_SESSION['LANG'].$table : $table));
        $row = $Conexao->select($camp)->from(PREFIX.$table)->where(array('id' => $id))->fetch_first();
        if ($Conexao->affected_rows > 0) {
            $titulo = $row[$camp];
        }
        if (is_array($swap)) {
            $titulo = str_replace($swap[0], $swap[1], $titulo);
        }
        return $titulo;
    }

    public function get_custom_by($camp,$table,$url='',$swap=''){
        $Conexao = new Conexao(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $table = (isset($_SESSION['LANG']) ? $_SESSION['LANG'].$table : $table);
        $row = $Conexao->select($camp)->from(PREFIX.$table)->where($url)->fetch_first();
        $titulo = '';
        if ($Conexao->affected_rows > 0) {
            $titulo = $row[$camp];
        }
        if (is_array($swap)) {
            $titulo = str_replace($swap[0], $swap[1], $titulo);
        }
        return $titulo;
    }

    public function get_url_by_id($table,$id,$full=true){
        $Conexao = new Conexao(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $table = (isset($_SESSION['LANG']) ? $_SESSION['LANG'].$table : $table);
        $row = $Conexao->select('url')->from(PREFIX.$table)->where(array('id' => $id))->fetch_first();
        if ($Conexao->affected_rows > 0) {
            $url = $row['url'];
        }
        if ($full) {
            return URL_SITE.$url;
        }else{
            return $url;
        }
        
    }

    public function get_archive_link($camp,$table,$id){
        $Conexao = new Conexao(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $table = (isset($_SESSION['LANG']) ? $_SESSION['LANG'].$table : $table);
        $row = $Conexao->select($camp)->from(PREFIX.$table)->where(array('id' => $id))->fetch_first();
        if ($Conexao->affected_rows > 0) {
            $arquivo = $row[$camp];
            if (!empty($arquivo)) {
                $arquivo = URL_UPLOAD_ARCHIVE.$table.'/'.$arquivo;
                return $arquivo;
            }else{
                return ;
            }
        }else{
            return ;
        }
        
    }

    public function get_total($table,$where){
        $Conexao = new Conexao(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $table = (isset($_SESSION['LANG']) ? $_SESSION['LANG'].$table : $table);
        $row = $Conexao->select('*')->from(PREFIX.$table)->where($where)->fetch_first();
        return $Conexao->affected_rows;
    }

    public function get_total_sum($field,$table,$where){
        $Conexao = new Conexao(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $table = (isset($_SESSION['LANG']) ? $_SESSION['LANG'].$table : $table);
        $row = $Conexao->select_sum($field)->from(PREFIX.$table)->where($where)->fetch_first();
        if ($Conexao->affected_rows > 0) {
            $total = intval($row[$field]);
        }else{
            $total = 0;
        }
        return $total;
    }

    public function get_headers($configuracoes,$routes){

        $url = $this->getUrl();
        $url_exploded = explode('/', $url);

        $Conexao = new Conexao(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $ogimage = '';
        $fbapp_id= 0;
        $descricao = '';

        foreach($routes as $originPattern => $functions){

            $pattern = preg_replace('(\{[a-z0-9\-\_]{0,}\})','([a-z0-9\-\_]{0,})',$originPattern);

            if (preg_match('#^('.$pattern.')*$#i',$url,$matches)===1) {
                $argument = array(); 
                array_shift($matches);
                array_shift($matches);

                if (preg_match_all('(\{[a-z0-9\-\_]{0,}\})', $originPattern, $match)) {
                    $argument = preg_replace('(\{|\})', '', $match[0]); 
                } 

                $arguments = array();

                if (!empty($argument)) {
                    foreach ($matches as $index => $match) {
                        if ($argument[$index]=='someurl') { 
                        }else{
                            $arguments[$argument[$index]] = $match;
                        }
                        
                    }
                }
                if (in_array('page', $url_exploded)) { $arguments = ''; }
                
                if ($functions['table']=='configuracoes') {
                    echo '<meta property="og:type" content="website" />';
                    break;
                }elseif (empty($arguments)) {
                    $select = $functions['title'].' AS title, '.$functions['meta'].' AS metadescription, '.$functions['keys'].' AS keywords'.(isset($functions['image'])?', '.$functions['image'].' AS imagem':'');
                    $table = PREFIX.isset($_SESSION['LANG']) ? $_SESSION['LANG'].$functions['table'] : $functions['table'];
                    if (in_array('page', $url_exploded)) {
                        $explode_page = explode('/page/', $url);
                        $explode_page = explode('/', $explode_page[0]);
                        $where = array('url' => end($explode_page));
                    }else{
                        $where = array('url' => end($url_exploded));
                    }
                    
                    break;
                }else{  
                    $select = $functions['title'].' AS title, '.$functions['meta'].' AS metadescription, '.$functions['keys'].' AS keywords'.(isset($functions['image'])?', '.$functions['image'].' AS imagem':'');
                    $table = PREFIX.isset($_SESSION['LANG']) ? $_SESSION['LANG'].$functions['table'] : $functions['table'];
                    $where = $arguments;
                    break;
                }                
                
                break;
            } 
        }

        if (!empty($select)&&!empty($table)&&!empty($where)) {
            $row = $Conexao->select($select)->from($table)->where($where)->fetch_first();
            if ($Conexao->affected_rows > 0) {
                $configuracoes['titulo-do-site'] = $row['title'];
                $configuracoes['pequena-descricao-da-empresa-para-o-google'] = $row['metadescription'];
                $configuracoes['palavras-chaves-para-a-pesquisa-do-google'] = $row['keywords'];
                if (isset($functions['image'])) {
                    $ogimage = URL_UPLOAD_IMAGE.$table.'/'.$row[$functions['image']];
                }
                echo '<meta property="og:type" content="article" />';
            }else{
                $row = $Conexao->select('nome_do_menu,metadescription,keywords')->from($_SESSION['LANG'].'paginas')->where($where)->fetch_first();
                if ($Conexao->affected_rows > 0) {
                    $configuracoes['titulo-do-site'] = $row['nome_do_menu'];
                    $configuracoes['pequena-descricao-da-empresa-para-o-google'] = $row['metadescription'];
                    $configuracoes['palavras-chaves-para-a-pesquisa-do-google'] = $row['keywords'];
                }
                echo '<meta property="og:type" content="website" />';
            }
        }
        
        echo "<meta name=\"twitter:card\" content=\"summary_large_image\">";
        echo "<meta name=\"twitter:site\" content=\"".URL_SITE.$this->getUrl()."\">";
        echo "<meta name=\"twitter:creator\" content=\"".NAME_SITE."\">";
        echo "<meta property=\"og:image\" content=\"{$ogimage}\">";
        echo "<meta name=\"twitter:image\" content=\"{$ogimage}\">";
        echo "<meta property=\"fb:app_id\" content=\"{$fbapp_id}\">";
        echo '<meta property="og:locale" content="pt_BR" />';
        
        if (!empty($configuracoes['titulo-do-site'])) {
            echo '<title>'.$configuracoes['titulo-do-site'].'</title>';
            echo '<meta property="og:title" content="'.$configuracoes['titulo-do-site'].'" />';
            echo '<meta name="twitter:title" content="'.$configuracoes['titulo-do-site'].'" />';
        }
        if (!empty($configuracoes['pequena-descricao-da-empresa-para-o-google'])) {
            echo '<meta content="'.$configuracoes['pequena-descricao-da-empresa-para-o-google'].'" name="description">';
            echo '<meta property="og:description" content="'.$configuracoes['pequena-descricao-da-empresa-para-o-google'].'" />';
            echo '<meta name="twitter:description" content="'.$configuracoes['pequena-descricao-da-empresa-para-o-google'].'" />';
        }
        if (!empty($configuracoes['palavras-chaves-para-a-pesquisa-do-google'])) {
            echo '<meta content="'.$configuracoes['palavras-chaves-para-a-pesquisa-do-google'].'" name="keywords">';
        }

        echo '<meta property="og:url" content="'.URL_SITE.$this->getUrl().'" />';
        echo '<meta property="og:site_name" content="'.NAME_SITE.'" />';
        echo "<meta property=\"twitter:domain\" content=\"".URL_SITE."\">";
    }

    public function get_code_body($configuracoes){
        if (!empty($configuracoes['codigo-do-chat'])) {
            echo '<!-- Chat -->'. html_entity_decode($configuracoes['codigo-do-chat']) .'<!-- End Chat -->';
        }
        if (!empty($configuracoes['codigo-do-google-analitcs'])) {
            echo '<!-- Google Analytics -->'. html_entity_decode($configuracoes['codigo-do-google-analitcs']) .'<!-- End Google Analytics -->';
        }
    }

    public function comparar_menu_ativo_by_id($table,$id,$class){
        $Conexao = new Conexao(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $row = $Conexao->select('url')->from(PREFIX.$table)->where(array('id' => $id))->fetch_first();
        if ($Conexao->affected_rows > 0) {
            $url_page = $row['url'];
        }

        $url = explode('/',$this->getUrl());

        if (current($url)==$url_page) {
            return $class;
        }else{
            return '';
        }
    }

    public function comparar_submenu_ativo_by_id($table,$id,$class){
        $Conexao = new Conexao(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $row = $Conexao->select('url')->from(PREFIX.$table)->where(array('id' => $id))->fetch_first();
        if ($Conexao->affected_rows > 0) {
            $url_page = $row['url'];
        }

        $url = explode('/',$this->getUrl());

        if (next($url)==$url_page) {
            return $class;
        }else{
            return '';
        }
    }

    public function get_estados_brasil(){
        $estados = array('AC'=>'Acre', 'AL'=>'Alagoas', 'AP'=>'Amapá', 'AM'=>'Amazonas', 'BA'=>'Bahia', 'CE'=>'Ceará', 'DF'=>'Distrito Federal', 'ES'=>'Espírito Santo', 'GO'=>'Goiás', 'MA'=>'Maranhão', 'MT'=>'Mato Grosso', 'MS'=>'Mato Grosso do Sul', 'MG'=>'Minas Gerais', 'PA'=>'Pará', 'PB'=>'Paraíba', 'PR'=>'Paraná', 'PE'=>'Pernambuco', 'PI'=>'Piauí', 'RJ'=>'Rio de Janeiro', 'RN'=>'Rio Grande do Norte', 'RS'=>'Rio Grande do Sul', 'RO'=>'Rondônia', 'RR'=>'Roraima', 'SC'=>'Santa Catarina', 'SP'=>'São Paulo', 'SE'=>'Sergipe', 'TO'=>'Tocantins');
        return $estados;
    }

    public function get_meses_pt_br(){
        $meses = array(
            1 => 'Janeiro',
            'Fevereiro',
            'Março',
            'Abril',
            'Maio',
            'Junho',
            'Julho',
            'Agosto',
            'Setembro',
            'Outubro',
            'Novembro',
            'Dezembro'
        );

        return $meses;
    }

    public function is_home(){
        $url = current(explode('/',$this->getUrl()));
        if ($url=='home') {
            return true;
        }else{
            return false;
        }
    }

    public function createwebp($path,$imagemoriginal,$extensao){

        echo $path.$imagemoriginal;

        if ($extensao=='jpg'||$extensao=='jpeg') {
            $imagemcriada = imagecreatefromjpeg($path.$imagemoriginal);
        }elseif ($extensao=='png') {
            $imagemcriada = imagecreatefrompng($path.$imagemoriginal);
        }elseif ($extensao=='gif') {
            $imagemcriada = imagecreatefromgif($path.$imagemoriginal);
        }
        echo $imagemcriada;

        imagewebp($imagemcriada, 'teste','100');

        imagedestroy($imagemcriada);

        return str_replace($extensao, 'webp', $imagemoriginal);
    }

    public function get_logo($configuracoes,$class='',$classA='',$link=true,$alt='',$style_img = ''){

        if (!empty($alt)) {
            $alt = ' alt = "'.$alt.'"';
        }

        if (!empty($class)) {
            $class = ' class = "'.$class.'"';
        }

        if (!empty($classA)) {
            $classA = ' class = "'.$classA.'"';
        }

        if (!empty($style_img)) {
            $style_img = ' style = "'.$style_img.'"';
        }

        if ($link==true) {
            $logo = '<a href="'.URL_SITE.'home"'.$classA.'>';
                if ($this->index_exists_array(array('logo'), $configuracoes)) {
                    $logo .= '<img src="'.URL_UPLOAD_IMAGE.'configuracoes/'.$configuracoes['logo'].'"'.$alt.$class.$style_img.'>';
                }
            $logo .= '</a>';
        }else{
            if ($this->index_exists_array(array('logo'), $configuracoes)) {
                $logo .= '<img src="'.URL_UPLOAD_IMAGE.'configuracoes/'.$configuracoes['logo'].'"'.$alt.$class.$style_img.'>';
            }
        }

        echo $logo;
    }

    public function criar_menu_painel_item($nome_menu,$sub_item,$sistemas,$nivel_de_acesso){
        if (is_array($nivel_de_acesso) && in_array($_SESSION['admin_nivel_acesso'], $nivel_de_acesso)){
            if ($sub_item) {
                $class = '';
                foreach ($sistemas as $posicao => $sistema) {
                    extract($sistema); 
                    if ($page) {
                        $class .= $this->comparar_menu_ativo_full_url('paginas/atualizar/'.$url,' class="active open"');  
                    }else{
                        $class .= $this->comparar_menu_ativo($url,' class="active open"');
                        $url = URL_PAINEL.$url;
                    }
                } 
                echo '<li'.$class.'>
                    <a href="#" class="dropdown-toggle"><span class="menu-text"> '.$nome_menu.'</span></a>
                    <ul class="submenu">';
                        $class = '';
                        foreach ($sistemas as $posicao => $sistema) {
                            extract($sistema);
                            if ($page) {
                                $class = $this->comparar_menu_ativo_full_url('paginas/atualizar/'.$url,' class="active"');
                                if (empty($nome)) { 
                                    $nome = $this->get_custom_by('nome','paginas',array('url' => $url));
                                }
                                $url = URL_PAINEL.'paginas/atualizar/'.$url;
                            }else{
                                $class = $this->comparar_menu_ativo($url,' class="active"');
                                $url = URL_PAINEL.$url;
                            }  
                            echo '<li'.$class.'> 
                                <a href="'.$url.'"><i class="icon-double-angle-right"></i> '.$nome.'</a> 
                            </li>';
                        }
                    echo '</ul>
                </li>';
            }else{
                extract($sistemas);
                if ($page) {
                    $class = $this->comparar_menu_ativo_full_url('paginas/atualizar/'.$url,' class="active"');
                    if (empty($nome)) { 
                        $nome = $this->get_custom_by('nome','paginas',array('url' => $url));
                    }
                    $url = URL_PAINEL.'paginas/atualizar/'.$url;
                }else{
                    $class = $this->comparar_menu_ativo($url,' class="active"');
                    $url = URL_PAINEL.$url;
                    $nome = $nome_menu;
                }
                echo '<li'.$class.'>
                    <a href="'.$url.'" class="dropdown-toggle">
                        <span class="menu-text"> '.$nome.'</span>
                    </a> 
                </li>';
            }
        } 
    } 
    public function calculaFrete(
        $cod_servico, /* codigo do servico desejado */ 
        $cep_origem,  /* cep de origem, apenas numeros */ 
        $cep_destino, /* cep de destino, apenas numeros */ 
        $peso,        /* valor dado em Kg incluindo a embalagem. 0.1, 0.3, 1, 2 ,3 , 4 */ 
        $altura,      /* altura do produto em cm incluindo a embalagem */ 
        $largura,     /* altura do produto em cm incluindo a embalagem */ 
        $comprimento, /* comprimento do produto incluindo embalagem em cm */ 
        $valor_declarado='0' /* indicar 0 caso nao queira o valor declarado */ 
    ){
        $cod_servico = strtoupper( $cod_servico ); 
        if( $cod_servico == 'SEDEX10' ) $cod_servico = 40215 ; 
        if( $cod_servico == 'SEDEXACOBRAR' ) $cod_servico = 40045 ; 
        if( $cod_servico == 'SEDEX' ) $cod_servico = 40010 ; 
        if( $cod_servico == 'PAC' ) $cod_servico = 41106 ; 

        # ########################################### 
        # Código dos Principais Serviços dos Correios 
        # 41106 PAC sem contrato 
        # 40010 SEDEX sem contrato 
        # 40045 SEDEX a Cobrar, sem contrato 
        # 40215 SEDEX 10, sem contrato 
        # ########################################### 

        $correios = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=&sDsSenha=&sCepOrigem=".$cep_origem."&sCepDestino=".$cep_destino."&nVlPeso=".$peso."&nCdFormato=1&nVlComprimento=".$comprimento."&nVlAltura=".$altura."&nVlLargura=".$largura."&sCdMaoPropria=n&nVlValorDeclarado=".$valor_declarado."&sCdAvisoRecebimento=n&nCdServico=".$cod_servico."&nVlDiametro=0&StrRetorno=xml"; 
        $xml = simplexml_load_file($correios); 
        $_arr_ = array(); 
        if($xml->cServico->Erro == '0'): 
            $_arr_['codigo'] = $xml -> cServico -> Codigo ; 
            $_arr_['valor'] = $xml -> cServico -> Valor ; 
            $_arr_['prazo'] = $xml -> cServico -> PrazoEntrega .' Dias' ; 
            // return $xml->cServico->Valor; 
            return $_arr_ ; 
        else: 
            return false; 
        endif; 
    } 

    public function image($image_name,$width_new,$height_new,$path,$type,$quality,$src_image){

        $path_default = $path.$image_name;
        $image_name_resized = $type.'-'.$width_new.'-'.$height_new.'-'.$image_name;
        $path_resized = $path.$image_name_resized;

        if (file_exists($path_resized)) {
            return $src_image.$image_name_resized;
        }else{
            if(!strstr($path_default,"http") && !file_exists($path_default)){
                return "Arquivo de origem da imagem inexistente"; 
            }

            $extension = pathinfo($path_default, PATHINFO_EXTENSION);
            $extension = strtolower($extension);

            if($extension == "jpg" || $extension == "jpeg"){
                $imagecreatefrom = imagecreatefromjpeg($path_default);
            }elseif ($extension == "gif"){
                $imagecreatefrom = imagecreatefromgif($path_default);
            }elseif ($extension == "png"){
                $imagecreatefrom = imagecreatefrompng($path_default);
            }else{
                return "Formato nao suportado !"; 
            }

            if(!$imagecreatefrom){ 
                return 'Erro ao carregar a imagem, talvez formato nao suportado'; 
            }

            $height_default = imagesy($imagecreatefrom); 
            $width_default = imagesx($imagecreatefrom);

            $destination_x = 0; 
            $destination_y = 0;

            if ($type=='redimencionar') {   

                $scale = min($height_new/$height_default, $width_new/$width_default);

                if ($scale < 1) {
                    $height_resized = floor($scale*$height_default);
                    $width_resized = floor($scale*$width_default);
                }else{
                    $height_resized = $height_default;
                    $width_resized = $width_default;
                } 

                $imagecreatetruecolor = imagecreatetruecolor($width_resized,$height_resized);

            }elseif ($type=='cortar') {

                $minimum = 20; 

                do { 

                    $scale = min($minimum/$height_default, $minimum/$width_default); 

                    $height_resized = round($scale*$height_default); 
                    $width_resized = round($scale*$width_default);  

                    $minimum ++;

                } while( $height_resized <= $height_new or $width_resized <= $width_new);

                $destination_y = round((((50*$height_resized)/100))-round($height_new/2));  
                $destination_x = round((((50*$width_resized)/100))-round($width_new/2)); 

                $imagecreatetruecolor = imagecreatetruecolor($width_new,$height_new);
            }elseif ($type=='cortar_por_dentro') {

                $scale = min($height_new/$height_default, $width_new/$width_default);

                if ($scale < 1) {
                    $height_resized = round($scale*$height_default);
                    $width_resized = round($scale*$width_default);
                }else{
                    $height_resized = $height_default;
                    $width_resized = $width_default;
                }  
                $imagecreatetruecolor = imagecreatetruecolor($width_resized,$height_resized);
            } 

            switch ($extension) {
                case 'gif':
                case 'png': 
                    $background = imagecolorallocate($imagecreatetruecolor , 0, 0, 0);
                    imagecolortransparent($imagecreatetruecolor, $background);
                case 'png':
                    imagealphablending($imagecreatetruecolor, false);
                    imagesavealpha($imagecreatetruecolor, true);
                    break;
                case 'jpg':
                    $background = imagecolorallocate($imagecreatetruecolor , 0, 0, 0);
                    imagecolortransparent($imagecreatetruecolor, $background);
                    imagealphablending($imagecreatetruecolor, false);
                    imagesavealpha($imagecreatetruecolor, true);
                    break;
                default:
                    break;
            }

            if ($type=='redimencionar') {  
                imagecopyresampled($imagecreatetruecolor, $imagecreatefrom, $destination_x, $destination_y, 0, 0, $width_resized, $height_resized, $width_default, $height_default);
            }elseif ($type=='cortar') {
                imagecopyresampled($imagecreatetruecolor, $imagecreatefrom, -$destination_x, -$destination_y, 0, 0, $width_resized, $height_resized, $width_default, $height_default);
            }elseif($type=='cortar_por_dentro'){
                imagecopyresampled($imagecreatetruecolor, $imagecreatefrom, $destination_x, $destination_y, 0, 0, $width_resized, $height_resized, $width_default, $height_default); 


                if ($width_resized==$width_new){
                    $x = 0;
                    $y = round(($height_new - $height_resized) / 2);
                }elseif ($height_resized==$height_new){
                    $x = round(($width_new - $width_resized) /2);
                    $y = 0;
                }else{
                    $x = 0;
                    $y = 0;
                } 

                $img = imagecreatetruecolor($width_new, $height_new);
                $bkg = imagecolorallocate($img, 79, 79, 79);
                imagefill($img, 0, 0, $bkg); 

                imagecopymerge($img, $imagecreatetruecolor , $x , $y , 0 , 0 , $width_new ,$height_new , 100 );
                imagedestroy($imagecreatetruecolor);
                $imagecreatetruecolor = $img;
            } 

            imagedestroy($imagecreatefrom);

            if($extension == "jpg" || $extension == "jpeg"){
                imagejpeg($imagecreatetruecolor,$path_resized,$quality);
                return $src_image.$image_name_resized;
            }elseif ($extension == "gif"){
                imagepng($imagecreatetruecolor,$path_resized);
                return $src_image.$image_name_resized;
            }elseif ($extension == "png"){
                imagepng($imagecreatetruecolor,$path_resized);
                return $src_image.$image_name_resized;
            }else { 
                return 'Formato de destino nao suportado';
            }

        } 

    }

    public function delete_images_from_path($path, $image_name){
 
        $directory = dir($path); 

        while($real_image_name = $directory -> read()){
            $image = '';
            $tmp = explode('-', $real_image_name);
            foreach ($tmp as $key => $value) {
                if ($key==3) {
                    $image = $value;
                }elseif ($key>3) {
                    $image .= '-'.$value;
                }
            } 

            if ($image === $image_name) { 
                $this->deletar_aquivo($path.$real_image_name);
            } 
        }
        $directory -> close(); 

        $this->deletar_aquivo($path.$image_name);
    }

    public function generate_lazy_image($sistema,$width,$height,$imagem,$type,$alt){
        
        $real_path = ($sistema=='configuracoes' ? PATH_IMAGES.$sistema.SEP:PATH_IMAGES.$_SESSION['LANG'].$sistema.SEP); 
        $src_path = ($sistema=='configuracoes'?URL_UPLOAD_IMAGE.$sistema.'/':URL_UPLOAD_IMAGE.$_SESSION['LANG'].$sistema.'/');

        $src = $this->image($imagem,$width,$height,$real_path,$type,100,$src_path);
        $src_tmp = explode('/', $src);

        list($width, $height, $type, $attr) = getimagesize($real_path.end($src_tmp));

        return '<lazy-image src="'.$src.'" style="--width: '.$width.'; --height: '.$height.'"></lazy-image>';
    }

    public function generate_lazy_image_old($sistema,$width,$height,$imagem,$type,$alt){
        
        $real_path = ($sistema=='configuracoes' ? PATH_IMAGES.$sistema.SEP:PATH_IMAGES.$_SESSION['LANG'].$sistema.SEP); 
        $src_path = ($sistema=='configuracoes'?URL_UPLOAD_IMAGE.$sistema.'/':URL_UPLOAD_IMAGE.$_SESSION['LANG'].$sistema.'/');

        $src = $this->image($imagem,$width,$height,$real_path,$type,100,$src_path);
        $src_tmp = explode('/', $src);

        list($width, $height, $type, $attr) = getimagesize($real_path.end($src_tmp));

        return '<lazy-image src="'.$src.'" width="'.$width.'" height="'.$height.'"></lazy-image>';
    }

    public function generate_image($sistema,$width,$height,$imagem,$type='redimencionar',$alt='',$class='',$misc=''){

        $real_path = ($sistema=='configuracoes' ? PATH_IMAGES.$sistema.SEP:PATH_IMAGES.$_SESSION['LANG'].$sistema.SEP); 
        $src_path = ($sistema=='configuracoes'?URL_UPLOAD_IMAGE.$sistema.'/':URL_UPLOAD_IMAGE.$_SESSION['LANG'].$sistema.'/');

        $src = $this->image($imagem,$width,$height,$real_path,$type,100,$src_path);
        $src_tmp = explode('/', $src);

        list($width, $height, $type, $attr) = getimagesize($real_path.end($src_tmp));

        $width = (empty($width)?'':' width="'.$width.'"');
        $height = (empty($height)?'':' height="'.$height.'"');
        $alt = (empty($alt)?'':' alt="'.$alt.'"');
        $class = (empty($class)?'':' class="'.$class.'"');

        return '<img src="'.$src.'"'.$width.$height.$alt.$class.$misc.' />';
    }

    public function generate_image_src($sistema,$width,$height,$imagem,$type='redimencionar'){
        
        $real_path = ($sistema=='configuracoes' ? PATH_IMAGES.$sistema.SEP:PATH_IMAGES.$_SESSION['LANG'].$sistema.SEP); 
        $src_path = ($sistema=='configuracoes'?URL_UPLOAD_IMAGE.$sistema.'/':URL_UPLOAD_IMAGE.$_SESSION['LANG'].$sistema.'/');

        $src = $this->image($imagem,$width,$height,$real_path,$type,100,$src_path); 

        return $src;
    }
} ?>
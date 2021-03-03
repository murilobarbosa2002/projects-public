<?php require(PATH_CLASS.'conn'.SEP.'Conexao.class.php');

class Administradores extends Conexao {

	private $usuario;
	private $senha;
	private $email;
	private $nome;
	private $nivel_acesso;
	private $url;
	private $id;

	public function setUsuario($usuario){
		$this->usuario = $this->tratarString($usuario);
	}

	public function setSenha($senha){
		$this->senha = $this->tratarString($senha);
		$this->senha = md5($this->senha);
	}

	public function setEmail($email){
		$this->email = $this->tratarString($email);
	}

	public function setNome($nome){
		$this->nome = $this->tratarString($nome);
	}

	public function setNivelAcesso($nivel_acesso){
		$this->nivel_acesso = $this->tratarInt($nivel_acesso);
	}

	public function setUrl($url){
		$this->url = $this->tratarString($url);
	}

	public function setId($id){
		$this->id = $this->tratarInt($id);
	}

	public function instalar(){

		$sql = 'DROP TABLE IF EXISTS '.PREFIX.'administradores;';
		$this->query($sql)->execute();

		$sql = 'CREATE TABLE IF NOT EXISTS '.PREFIX.'administradores (
			id int(10) NOT NULL AUTO_INCREMENT,
			nome varchar(150) COLLATE utf8_bin NOT NULL DEFAULT 0,
			url varchar(150) COLLATE utf8_bin NOT NULL DEFAULT 0,
			email varchar(150) COLLATE utf8_bin NOT NULL DEFAULT 0,
			created date NOT NULL,
			usuario varchar(20) COLLATE utf8_bin NOT NULL DEFAULT 0,
			senha varchar(50) COLLATE utf8_bin NOT NULL DEFAULT 0,
			nivel_acesso varchar(1) COLLATE utf8_bin NOT NULL DEFAULT 0,
			status varchar(1) COLLATE utf8_bin NOT NULL DEFAULT 0,
			PRIMARY KEY (id)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1;';

		$this->query($sql)->execute();

		$senha = $this->gerarSenha(12, 8);
		$data = array(
		    'nome' => NOME_ADMIN,
		    'email' => EMAIL_ADMIN,
		    'url' => $this->url_amigavel(USER_ADMIN),
		    'created' => 'NOW()',
		    'usuario' => USER_ADMIN,
		    'senha' => md5($senha),
		    'nivel_acesso' => 1,
		    'status' => 1
		);

		$this->insert(PREFIX.'administradores', $data);
		
		$mensagem = 'Instalação efetuada com sucesso !<br/>Segue os dados para acesso :<br/><strong>Login:</strong> '.USER_ADMIN.'<br/><strong>Senha:</strong> '.$senha;
		$_SESSION['SYSTEM_MENSSAGE'] = $mensagem;
		$_SESSION['SYSTEM_STATUS'] = 'success';
		$this->redirect(URL_PAINEL);

	}

	public function logar(){

		$rows = $this->select('id, nome, email, nivel_acesso, status')->from(PREFIX.'administradores')->where(array('usuario' => $this->usuario, 'senha' => $this->senha, 'status' => 1))->fetch_first();
		if ($this->affected_rows > 0) {

			$_SESSION['admin_id'] = $rows['id'];
			$_SESSION['admin'] = $rows['nome'];
			$_SESSION['admin_email'] = $rows['email'];
			$_SESSION['admin_nivel_acesso'] = $rows['nivel_acesso'];
			$_SESSION['admin_status'] = $rows['status'];

			$_SESSION['SYSTEM_MENSSAGE'] = 'Logado com sucesso !';
			$_SESSION['SYSTEM_STATUS'] = 'success';

			return $this->redirect(URL_PAINEL.'inicial');

		}else{

			return array('status' => 0, 'mensagem' => 'Login ou senha inválidos !</br>Tente novamente ou utlilize o esqueci minha senha.' );

		}

	}

	public function esqueci_senha(){

		$rows = $this->select('id, usuario, nome')->from(PREFIX.'administradores')->where(array('email' => $this->email))->fetch_first();

		if ($this->affected_rows > 0) {

			$id = $rows['id'];
			$usuario = $rows['usuario'];
			$nome = $rows['nome'];

			$where = array('email' => $this->email, 'id' => $id );
			$senha = $this->gerarSenha(12, 8);
			$data = array('senha' => md5($senha));
			$this->where($where)->update(PREFIX.'administradores', $data);


			$Body = 'Olá '.$nome.',<br/> Uma nova senha foi gerada para seu login, segue seus dados abaixo :<br/><strong>Usuario :</strong> '.$usuario.'<br/><strong>Senha :</strong> '.$senha;

			$retorno = $this->sendEmail(EMAIL_LOGIN, NAME_SITE, array($nome => $this->email), '[+] Recuperação de senha', $Body, true );

			if ($retorno['status'] = 1) {

				return array('status' => 1, 'mensagem' => 'Mensagem foi enviada com sucesso !');


			}else{
				return array('status' => 0, 'mensagem' => 'Opsss ! Algo deu errado .<br/>Erro ao enviar o e-mail !');
			}

		}else{

			return array('status' => 2, 'mensagem' => 'Email não encontrado !</br>Contate o administrador.');

		}

	}

	private function validar_dados(){

		if (empty($this->nome)) {
			$_SESSION['SYSTEM_MENSSAGE'] = 'Por favor, digite o nome !';
			$_SESSION['SYSTEM_STATUS'] = 'danger';
			return false;
			exit();
		}

		if (empty($this->email)) {
			$_SESSION['SYSTEM_MENSSAGE'] = 'Por favor, digite o email !';
			$_SESSION['SYSTEM_STATUS'] = 'danger';
			return false;
			exit();
		}

		if ($this->validaEmail($this->email)==false) {
			$_SESSION['SYSTEM_MENSSAGE'] = 'Por favor, digite um email valido !';
			$_SESSION['SYSTEM_STATUS'] = 'danger';
			return false;
			exit();
		}


		if (empty($this->id)) {
			$rows = $this->select('id')->from(PREFIX.'administradores')->where(array('email' => $this->email))->fetch_first();
			if ($this->affected_rows > 0) {
				$_SESSION['SYSTEM_MENSSAGE'] = 'Este e-mail já esta em uso, tente outro!';
				$_SESSION['SYSTEM_STATUS'] = 'danger';
				return false;
				exit();
			}

		}else{

			$rows = $this->select('id')->from(PREFIX.'administradores')->where(array('email' => $this->email, 'id !=' => $this->id))->fetch_first();
			if ($this->affected_rows > 0) {
				$_SESSION['SYSTEM_MENSSAGE'] = 'Este e-mail já esta em uso, tente outro!';
				$_SESSION['SYSTEM_STATUS'] = 'danger';
				return false;
				exit();
			}

		}

		if (empty($this->usuario)) {
			$_SESSION['SYSTEM_MENSSAGE'] = 'Por favor, digite o usuário !';
			$_SESSION['SYSTEM_STATUS'] = 'danger';
			return false;
			exit();
		}

		if (empty($this->id)) {

			$rows = $this->select('id')->from(PREFIX.'administradores')->where(array('usuario' => $this->usuario))->fetch_first();
			if ($this->affected_rows > 0) {
				$_SESSION['SYSTEM_MENSSAGE'] = 'Este usuário já esta em uso, tente outro!';
				$_SESSION['SYSTEM_STATUS'] = 'danger';
				return false;
				exit();
			}

		}else{

			$rows = $this->select('id')->from(PREFIX.'administradores')->where(array('usuario' => $this->usuario, 'id !=' => $this->id))->fetch_first();
			if ($this->affected_rows > 0) {
				$_SESSION['SYSTEM_MENSSAGE'] = 'Este usuário já esta em uso, tente outro!';
				$_SESSION['SYSTEM_STATUS'] = 'danger';
				return false;
				exit();
			}

		}

		if (empty($this->id)) {


			if (empty($this->senha)) {
				$_SESSION['SYSTEM_MENSSAGE'] = 'Por favor, digite a senha !';
				$_SESSION['SYSTEM_STATUS'] = 'danger';
				return false;
				exit();
			}


		}

		return true;

	}

	public function cadastrar(){
		if ($this->validar_dados()) {

			$data = array(
			    'nome' => $this->nome,
			    'url' => $this->url_amigavel($this->usuario),
			    'email' => $this->email,
			    'created' => 'NOW()',
			    'usuario' => $this->usuario,
			    'senha' => $this->senha,
			    'nivel_acesso' => $this->nivel_acesso,
			    'status' => 1

			);

			$this->insert(PREFIX.'administradores', $data) ;

			$_SESSION['SYSTEM_MENSSAGE'] = 'Cadastro efetuado com sucesso !';
			$_SESSION['SYSTEM_STATUS'] = 'success';

			$this->redirect(URL_PAINEL.'administradores');

			exit();
		}
	}

	public function atualizar(){

		if ($this->validar_dados()) {

			if (empty($this->senha)) {
				$data = array(
				    'nome' => $this->nome,
				    'url' => $this->url_amigavel($this->usuario),
				    'email' => $this->email,
				    'created' => 'NOW()',
				    'usuario' => $this->usuario,
				    'nivel_acesso' => $this->nivel_acesso,
				    'status' => 1

				);
			}else{
				$data = array(
				    'nome' => $this->nome,
				    'url' => $this->url_amigavel($this->usuario),
				    'email' => $this->email,
				    'created' => 'NOW()',
				    'usuario' => $this->usuario,
				    'senha' => $this->senha,
				    'nivel_acesso' => $this->nivel_acesso,
				    'status' => 1

				);
			}

			$this->where(array('id' => $this->id))->update(PREFIX.'administradores', $data);

			$_SESSION['SYSTEM_MENSSAGE'] = 'Cadastro atualizado com sucesso !';
			$_SESSION['SYSTEM_STATUS'] = 'success';

			$this->redirect(URL_PAINEL.'administradores/atualizar/'.$this->url_amigavel($this->usuario));

			exit();

		}
	}

} ?>
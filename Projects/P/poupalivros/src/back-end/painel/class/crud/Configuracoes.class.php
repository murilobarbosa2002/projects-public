<?php
class Configuracoes extends Conexao  {

	private $tipo;
	private $conteudo;
	private $nome;
	private $url;
	private $show_field;
	private $id;

	public function setTipo($tipo){
		$this->tipo = $this->tratarString($tipo);
	}

	public function setConteudo($conteudo){
		if($this->tipo == 'image'){
			if (is_array($conteudo)) {
				$this->conteudo = $conteudo;
			}
		}else{
			$this->conteudo = htmlspecialchars($conteudo);
			$this->conteudo = $this->tratarString($conteudo);
		}
	}

	public function setNome($nome){
		$this->nome = $this->tratarString($nome);
	}

	public function setUrl($url){
		$this->url = $this->url_amigavel($this->tratarString($url));
		$verificar = true;
		$cont = 1;
		while ($verificar) {
			if (empty($this->id)) {
				$rows = $this->select('id')->from(PREFIX.'configuracoes')->where(array('url' => $this->url))->fetch_first();
				if ($this->affected_rows > 0) {
					$this->url = $this->url_amigavel($this->tratarString($url)).'_'.$cont;
				}else{
					$verificar = false;
				}
			}else{
				$rows = $this->select('id')->from(PREFIX.'configuracoes')->where(array('url' => $this->url, 'id !=' => $this->id))->fetch_first();
				if ($this->affected_rows > 0) {
					$this->url = $this->url_amigavel($this->tratarString($url)).'_'.$cont;
				}else{
					$verificar = false;
				}
			}
		}
	}

	public function setId($id){
		$this->id = $this->tratarInt($id);
	}

	public function setShowField($show_field){
		$this->show_field = $this->tratarInt($show_field);
	}

	public function instalar(){

		$sql = 'DROP TABLE IF EXISTS '.PREFIX.'configuracoes;';
		$this->query($sql)->execute();

		$sql = 'CREATE TABLE IF NOT EXISTS '.PREFIX.'configuracoes (
			id int(10) NOT NULL AUTO_INCREMENT,
			nome varchar(150) COLLATE utf8_bin NOT NULL DEFAULT 0,
			show_field int(1) NOT NULL DEFAULT 0,
			url varchar(150) COLLATE utf8_bin NOT NULL DEFAULT 0,
			tipo varchar(150) COLLATE utf8_bin NOT NULL DEFAULT 0,
			conteudo text COLLATE utf8_bin NOT NULL,
			created date NOT NULL,
			PRIMARY KEY (id)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1;';

		$this->query($sql)->execute();

		$cadastros[0] = array('nome' => 'Smtp para autenticar o envio de email', 'show_field' => 0, 'url' => 'smtp-para-autenticar-o-envio-de-email', 'tipo' => 'campo_menor', 'conteudo' => '' );
		$cadastros[] = array('nome' => 'Porta para autenticar o envio de email', 'show_field' => 0, 'url' => 'porta-para-autenticar-o-envio-de-email', 'tipo' => 'campo_menor', 'conteudo' => '' );
		$cadastros[] = array('nome' => 'Email para autenticar o envio de email', 'show_field' => 0, 'url' => 'email-para-autenticar-o-envio-de-email', 'tipo' => 'campo_menor', 'conteudo' => '' );
		$cadastros[] = array('nome' => 'Senha para autenticar o envio de email', 'show_field' => 0, 'url' => 'senha-para-autenticar-o-envio-de-email', 'tipo' => 'campo_menor', 'conteudo' => '' );
		$cadastros[] = array('nome' => 'Logo', 'show_field' => 0, 'url' => 'logo', 'tipo' => 'image', 'conteudo' => '' );
		$cadastros[] = array('nome' => 'Codigo do chat', 'show_field' => 0, 'url' => 'codigo-do-chat', 'tipo' => 'codigo', 'conteudo' => '' );
		$cadastros[] = array('nome' => 'Codigo do Google analitcs', 'show_field' => 0, 'url' => 'codigo-do-google-analitcs', 'tipo' => 'codigo', 'conteudo' => '' );
		$cadastros[] = array('nome' => 'Titulo do site', 'show_field' => 0, 'url' => 'titulo-do-site', 'tipo' => 'text', 'conteudo' => '' );
		$cadastros[] = array('nome' => 'Pequena descrição da empresa para o google', 'show_field' => 0, 'url' => 'pequena-descricao-da-empresa-para-o-google', 'tipo' => 'textarea', 'conteudo' => '' );
		$cadastros[] = array('nome' => 'Palavras chaves para a pesquisa do google', 'show_field' => 0, 'url' => 'palavras-chaves-para-a-pesquisa-do-google', 'tipo' => 'textarea', 'conteudo' => '' );

		foreach ($cadastros as $valores) {
			$this->setNome($valores['nome']); 
	        $this->setShowField($valores['show_field']);
	        $this->setUrl($valores['url']);
	        $this->setTipo($valores['tipo']);
	        $this->setConteudo($valores['conteudo']);
	        $this->cadastrar();
		}

		$mensagem = 'Instalação efetuada com sucesso !';
		$_SESSION['SYSTEM_MENSSAGE'] = $mensagem;
		$_SESSION['SYSTEM_STATUS'] = 'success';

		$this->criar_pasta(PATH_UPLOADS);
		$this->criar_pasta(PATH_IMAGES); 
		$this->criar_pasta(PATH_IMAGES.'configuracoes');

		$this->redirect(URL_PAINEL.'configuracoes');

	}

	private function validar_dados(){

		if (empty($this->nome)) {
			$_SESSION['SYSTEM_MENSSAGE'] = 'Por favor, digite o nome !';
			$_SESSION['SYSTEM_STATUS'] = 'danger';
			$this->redirect(URL_PAINEL.'configuracoes');
			exit();
		}

		if (empty($this->tipo)) {
			$_SESSION['SYSTEM_MENSSAGE'] = 'Por favor, selecione o tipo !';
			$_SESSION['SYSTEM_STATUS'] = 'danger';
			$this->redirect(URL_PAINEL.'configuracoes');
			exit();
		}

		if ($this->tipo=='image') {

			if (!empty($this->conteudo['tmp_name'])) {

				$tmp_name = $this->conteudo['tmp_name'];
				$name = $this->conteudo['name'];
				$temp = explode('.', $name);
				$name = $temp[0];
				$extension = end($temp);

				$name = $this->url_amigavel($name).'.'.$extension; 

	            $name = $this->verificar_existe_imagem_nome(PATH_IMAGES.'configuracoes', $name);

	            move_uploaded_file($tmp_name, PATH_IMAGES.'configuracoes'.SEP.$name);

	            $this->conteudo = $name;

			}else{
				$this->conteudo = '';
			}

		}else{

		}



		return true;

	}

	public function cadastrar(){

		if ($this->validar_dados()) {



			$data = array(
			    'nome' => $this->nome,
			    'url' => $this->url,
			    'tipo' => $this->tipo,
			    'conteudo' => $this->conteudo,
			    'show_field' => $this->show_field,
			    'created' => 'NOW()'

			);

			$this->insert(PREFIX.'configuracoes', $data);

		}
	}



} ?>

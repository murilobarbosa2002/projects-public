<?php
class Images extends Conexao  {

	private $nome;
	private $imagem;
	private $url;
	private $id;
	private $dimensoes;

	public function setNome($nome){
		$this->nome = $this->tratarString($nome);
	}

	public function setImagem($imagem){
		$this->imagem = $imagem;
	}

	public function setDimensoes($dimensoes){
		$this->dimensoes = $dimensoes;
	}

	public function setUrl($url){
		$this->url = $this->url_amigavel($this->tratarString($url));
		$verificar = true;
		$cont = 1;
		while ($verificar) {
			if (empty($this->id)) {
				$rows = $this->select('id')->from(PREFIX.'images')->where(array('url' => $this->url))->fetch_first();
				if ($this->affected_rows > 0) {
					$this->url = $this->url_amigavel($this->tratarString($url)).'_'.$cont;
				}else{
					$verificar = false;
				}
			}else{
				$rows = $this->select('id')->from(PREFIX.'images')->where(array('url' => $this->url, 'id !=' => $this->id))->fetch_first();
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

	public function instalar(){

		$sql = 'DROP TABLE IF EXISTS '.PREFIX.'images;';
		$this->query($sql)->execute();

		$sql = 'CREATE TABLE IF NOT EXISTS '.PREFIX.'images (
			id int(10) NOT NULL AUTO_INCREMENT, 
			nome varchar(150) COLLATE utf8_bin NOT NULL DEFAULT 0,
			url varchar(150) COLLATE utf8_bin NOT NULL DEFAULT 0, 
			imagem text COLLATE utf8_bin NOT NULL,
			created date NOT NULL, 
			PRIMARY KEY (id) 
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1;';

		$this->query($sql)->execute();

		
		$mensagem = 'Instalação efetuada com sucesso !';
		$_SESSION['SYSTEM_MENSSAGE'] = $mensagem;
		$_SESSION['SYSTEM_STATUS'] = 'success';

		$this->criar_pasta(PATH_UPLOADS);
		$this->criar_pasta(PATH_IMAGES);
		$this->criar_pasta(PATH_IMAGES.'editor');

		$this->redirect(URL_PAINEL.'images');

	}

	private function validar_dados(){

		if (empty($this->nome)) {
			$_SESSION['SYSTEM_MENSSAGE'] = 'Por favor, digite o nome !';
			$_SESSION['SYSTEM_STATUS'] = 'danger';
			$this->redirect(URL_PAINEL.'images');
			exit();
		}

		if (empty($this->id)) {
			if (empty($this->imagem['tmp_name'])) {

				$_SESSION['SYSTEM_MENSSAGE'] = 'Por favor, digite a imagem !';
				$_SESSION['SYSTEM_STATUS'] = 'danger';
				$this->redirect(URL_PAINEL.'images');
				exit();

			}
		}

		return true;
		
	}

	public function cadastrar(){

		if ($this->validar_dados()) {

			$tmp_name = $this->imagem['tmp_name'];
            $name = $this->imagem['name'];
            $temp = explode('.', $name);
            $name = $temp[0];
            $extension = end($temp); 

            $name = $this->url_amigavel($name).'.'.$extension;

            $name = $this->verificar_existe_imagem_nome(PATH_IMAGES.'editor', $name);

            move_uploaded_file($tmp_name, PATH_IMAGES.'editor'.SEP.$name);

            $this->imagem = $name;
			
			$data = array(
			    'nome' => $this->nome,
			    'url' => $this->url,
			    'imagem' => $this->imagem,
			    'created' => 'NOW()'

			);

			$this->insert(PREFIX.'images', $data) ;

			$_SESSION['SYSTEM_MENSSAGE'] = 'Cadastro efetuado com sucesso !';
			$_SESSION['SYSTEM_STATUS'] = 'success';

			$this->redirect(URL_PAINEL.'images');

			exit();
		}
	}

	public function atualizar(){

		if ($this->validar_dados()) {

			if (!empty($this->imagem['tmp_name'])) {

				$rows = $this->select('imagem')->from(PREFIX.'images')->where(array('id' => $this->id))->fetch_first();
		        if ($this->affected_rows > 0) { 
		        	$this->delete_images_from_path(PATH_IMAGES.'editor'.SEP,$rows['imagem']);
		        }

				$tmp_name = $this->imagem['tmp_name'];
	            $name = $this->imagem['name'];
	            $temp = explode('.', $name);
	            $name = $temp[0];
	            $extension = end($temp); 

	            $name = $this->url_amigavel($name).'.'.$extension;

	            $name = $this->verificar_existe_imagem_nome(PATH_IMAGES.'editor', $name);

	            move_uploaded_file($tmp_name, PATH_IMAGES.'editor'.SEP.$name);

	            $this->imagem = $name;
				
				$data = array(
				    'nome' => $this->nome,
				    'url' => $this->url,
				    'imagem' => $this->imagem,
				    'created' => 'NOW()'

				);

			}else{

				$data = array(
				    'nome' => $this->nome,
				    'url' => $this->url,
				    'created' => 'NOW()'

				);

			}

			$this->where(array('id' => $this->id))->update(PREFIX.'images', $data); 

			$_SESSION['SYSTEM_MENSSAGE'] = 'Cadastro atualizado com sucesso !';
			$_SESSION['SYSTEM_STATUS'] = 'success';

			$this->redirect(URL_PAINEL.'images');

			exit();
		}
	}


} ?>
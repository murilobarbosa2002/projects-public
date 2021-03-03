<?php
class Funcoes extends Conexao {

	private $files;
	private $data;
	private $sistema;
	private $id;

	public function setFiles($files){
		$this->files = $files;
	}

	public function setFilesGalerias($files_galerias){
		$this->files_galerias = $files_galerias;
	}

	public function setData($data){
		$this->data = $data;
	}

	public function setDataMulti($data_multi){
		$this->data_multi = $data_multi;
	}

	public function setDataGalerias($data_galerias){
		$this->data_galerias = $data_galerias;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function setIdGaleria($id_galeria){
		$this->id_galeria = $id_galeria;
	}

	public function setSistema($sistema){
		$this->sistema = $sistema;
	}

	public function getData(){
		return $this->data;
	}

	public function setGaleriaName($galeria_name){
		$this->galeria_name = $galeria_name;
	}


	public function instalar(){

		if (PREFIX.$this->sistema['export_func']) {
			$this->criar_pasta(PATH_ARCHIVES);
			$this->criar_pasta(PATH_ARCHIVES.$this->sistema['bd']);
			$this->criar_pasta(PATH_ARCHIVES.$this->sistema['bd'].SEP.'export');
		}
 		$Tables_container = array();
		$result = $this->query('show tables;')->fetch();
		foreach ($result as $key => $tables) {
			$litle_key = key($tables);
			$valor = $tables[$litle_key];
			$Tables_container[] = $valor;
		}
		if (in_array(PREFIX.$this->sistema['bd'], $Tables_container)) {
			$Fields_container = array();
			$mysql_query = $this->query('SHOW COLUMNS FROM '.PREFIX.$this->sistema['bd'])->fetch();
			if ($this->affected_rows) {
				foreach ($mysql_query as $key => $fields_base) {
					extract($fields_base);  
					$Fields_container[] = $Field;
				}
			} 
			if (!empty($Fields_container)) {
				foreach ($this->sistema['campos'] as $campos) {
					if (in_array($campos['name'], $Fields_container)) {
					}else{
						if ($campos['input']=='image') { 
							$this->criar_pasta(PATH_UPLOADS);
							$this->criar_pasta(PATH_IMAGES);
							$this->criar_pasta(PATH_IMAGES.$this->sistema['bd']);
						}

						if ($campos['input']=='archive') {
							$this->criar_pasta(PATH_UPLOADS);
							$this->criar_pasta(PATH_ARCHIVES);
							$this->criar_pasta(PATH_ARCHIVES.$this->sistema['bd']);

						}

						if ($campos['input'] == 'multiselect') {

							$multiselect = true;

						}else{

							$sql = 'ALTER TABLE '.PREFIX.$this->sistema['bd'].' ADD ';
							$sql .= $campos['name'].' '.$campos['type'].'';

							if (!empty($campos['amount'])) {
								$sql .= '('.$campos['amount'].') ';
							}
							$sql .= $campos['colation'].' '.$campos['null'].' '.$campos['default'].'; ';

							$this->query($sql)->execute();
						
							
						} 
					}
				} 
			} 
		}else{
			$sql = 'CREATE TABLE IF NOT EXISTS '.PREFIX.$this->sistema['bd'].' (';
			$multiselect = false;

			foreach ($this->sistema['campos'] as $campos) {

				if ($campos['input']=='image') {
					$this->criar_pasta(PATH_UPLOADS);
					$this->criar_pasta(PATH_IMAGES);
					$this->criar_pasta(PATH_IMAGES.$this->sistema['bd']); 
				}

				if ($campos['input']=='archive') {
					$this->criar_pasta(PATH_UPLOADS);
					$this->criar_pasta(PATH_ARCHIVES);
					$this->criar_pasta(PATH_ARCHIVES.$this->sistema['bd']);

				}

				if ($campos['input'] != 'multiselect') {
					$sql .= $campos['name'].' '.$campos['type'].'';

					if (!empty($campos['amount'])) {
						$sql .= '('.$campos['amount'].') ';
					}
					$sql .= $campos['colation'].' '.$campos['null'].' '.$campos['default'].', ';
				}else{
					$multiselect = true;
				}

			}

			$sql .= 'PRIMARY KEY ('.$this->sistema['primary'].')';
			$sql .= ') '.$this->sistema['engine'].'  DEFAULT CHARSET=utf8 COLLATE=utf8_bin '.$this->sistema['start_autoincrement'].';'; 
			$this->query($sql)->execute();
		}
 
		


		if (isset($multiselect)&&$multiselect==true) {

			foreach ($this->sistema['campos'] as $campos) {

				if ($campos['input'] == 'multiselect') {

					if (in_array(PREFIX.$this->sistema['bd'].'_'.PREFIX.$campos['category'], $Tables_container)) {
					}else{
						$this->query('DROP TABLE IF EXISTS '.PREFIX.$this->sistema['bd'].'_'.PREFIX.$campos['category'].';')->execute(); 
						$this->query('CREATE TABLE IF NOT EXISTS '.PREFIX.$this->sistema['bd'].'_'.PREFIX.$campos['category'].' ( '.$campos['name'].' INT(11), '.$campos['parametros']['campo'].' INT(11) );')->execute();
					}
					

				}

			}

		}

		if (isset($this->sistema['galeria'])) {
			foreach ($this->sistema['galeria'] as $galeria) {

				if (in_array(PREFIX.$galeria['bd'], $Tables_container)) {
				}else{
					$sql = 'DROP TABLE IF EXISTS '.PREFIX.$galeria['bd'].';';

					$this->query($sql)->execute();

					$sql = 'CREATE TABLE IF NOT EXISTS '.PREFIX.$galeria['bd'].' (';

					foreach ($galeria['campos'] as $campo) {

						if ($campo['input']=='image') {
							$this->criar_pasta(PATH_UPLOADS);
							$this->criar_pasta(PATH_IMAGES);
							$this->criar_pasta(PATH_IMAGES.$this->sistema['bd']); 
						}
						if ($campo['input']=='archive') {
							$this->criar_pasta(PATH_ARCHIVES);
							$this->criar_pasta(PATH_ARCHIVES.$this->sistema['bd']);
							$this->criar_pasta(PATH_ARCHIVES.$this->sistema['bd'].SEP.$galeria['bd']);
						}

						if ($campo['input']=='multi_image') {
							$this->criar_pasta(PATH_UPLOADS);
							$this->criar_pasta(PATH_IMAGES);
							$this->criar_pasta(PATH_IMAGES.$this->sistema['bd']);
						}
						if ($campo['input']=='multi_archive') {
							$this->criar_pasta(PATH_ARCHIVES);
							$this->criar_pasta(PATH_ARCHIVES.$this->sistema['bd']);
							$this->criar_pasta(PATH_ARCHIVES.$this->sistema['bd'].SEP.$galeria['bd']);
						}

						$sql .= $campo['name'].' '.$campo['type'].' ';
						if (!empty($campo['amount'])) {
							$sql .= '('.$campo['amount'].') ';
						}

						$sql .= ' '.$campo['colation'].' '.$campo['null'].' '.$campo['default'].', ';

					}

					$sql .= $this->sistema['bd'].' int(11) NOT NULL, ';
					$sql .= 'PRIMARY KEY ('.$galeria['primary'].')';
					$sql .= ') '.$galeria['engine'].'  DEFAULT CHARSET=utf8 COLLATE=utf8_bin '.$galeria['start_autoincrement'].';';

					$this->query($sql)->execute();
				}

			}

		}

		$mensagem = 'Instalação efetuada com sucesso !';
		$_SESSION['SYSTEM_MENSSAGE'] = $mensagem;
		$_SESSION['SYSTEM_STATUS'] = 'success';

		$this->redirect(URL_PAINEL.$this->sistema['url']);

	}


	public function preparar_dados($data){
		foreach ($this->sistema['campos'] as $campos) {
			if ($campos['mostrar_campo']) {

				if ($campos['input']=='image'||$campos['input']=='archive') {

				}elseif($campos['input']=='checkbox'){
					if (empty($data[$campos['name']])) {
						$data[$campos['name']] = 0;
					}
					$data[$campos['name']] = $this->tratarInt($data[$campos['name']]);
				}elseif($campos['input']=='date'){
					$data[$campos['name']] = explode(' ', $data[$campos['name']]); 
					$data[$campos['name']] = implode("-",array_reverse(explode("/", $data[$campos['name']][0])));
				}elseif($campos['input']=='money'){
					$data[$campos['name']] = str_replace(array('R$ ','.' , ',' ), array('','','.'), $data[$campos['name']]);
				}elseif($campos['input']=='multiselect'){
					unset($data[$this->sistema['bd'].'_'.$campos['category']]);
				}elseif ($campos['input']=='dropdown_plus_more_options') {
				
				}else{
					if (isset($data[$campos['name']])) {
						$data[$campos['name']] = $this->tratarString($data[$campos['name']]);
					}
				}
				if (isset($campos['tipo_validacao']) && is_array($campos['tipo_validacao'])) {

					foreach ($campos['tipo_validacao'] as $validacao) {

						if ($validacao=='vazio') {

							if (empty($data[$campos['name']])) {

								$_SESSION['SYSTEM_MENSSAGE'] = 'Por favor preencha o campo '.$campos['titulo'].' !';
								$_SESSION['SYSTEM_STATUS'] = 'danger';
								return false;
								exit();

							}

						}

						if ($validacao=='email') {

							if ($this->validaEmail($data[$campos['name']])==false) {

								$_SESSION['SYSTEM_MENSSAGE'] = 'Por favor, digite um email válido !';
								$_SESSION['SYSTEM_STATUS'] = 'danger';
								return false;
								exit();
							}
						}

						if ($validacao=='cnpj') {

							if ($this->validaCnpj($data[$campos['name']])==false) {

								$_SESSION['SYSTEM_MENSSAGE'] = 'Por favor, digite um cnpj válido !';
								$_SESSION['SYSTEM_STATUS'] = 'danger';
								return false;
								exit();
							}
						}

						if ($validacao=='cpf') {

							if ($this->validaCpf($data[$campos['name']])==false) {

								$_SESSION['SYSTEM_MENSSAGE'] = 'Por favor, digite um cpf válido !';
								$_SESSION['SYSTEM_STATUS'] = 'danger';
								return false;
								exit();
							}
						}

						if ($validacao=='exist') {

							if (empty($this->id)) {
								$rows = $this->select('id')->from(PREFIX.$this->sistema['bd'])->where(array($campos['name'] => $data[$campos['name']]))->fetch_first();
								if ($this->affected_rows > 0) {
									$_SESSION['SYSTEM_MENSSAGE'] = 'Este '.$campos['titulo'].' já esta em uso, tente outro !';
									$_SESSION['SYSTEM_STATUS'] = 'danger';
									return false;
									exit();
								}
							}else{
								$rows = $this->select('id')->from(PREFIX.$this->sistema['bd'])->where(array($campos['name'] => $data[$campos['name']], 'id !=' => $this->id))->fetch_first();
								if ($this->affected_rows > 0) {
									$_SESSION['SYSTEM_MENSSAGE'] = 'Este '.$campos['titulo'].' já esta em uso, tente outro !';
									$_SESSION['SYSTEM_STATUS'] = 'danger';
									return false;
									exit();
								}
							}

						}

						if (empty($this->id) && $validacao=='image') {

							if (empty($this->files[$campos['name']]['tmp_name'])) {

								$_SESSION['SYSTEM_MENSSAGE'] = 'Por favor insira a imagem para o campo '.$campos['titulo'].' !';
								$_SESSION['SYSTEM_STATUS'] = 'danger';
								return false;
								exit();
							}
						}

						if ($campos['input']=='image') {

							if (!empty($this->files[$campos['name']]['tmp_name'])&&empty($this->id)) {

								$tmp_name = $this->files[$campos['name']]['tmp_name'];
					            $name = $this->files[$campos['name']]['name'];
					            $temp = explode('.', $name);
					            $name = $temp[0];
					            $extension = end($temp);

					            $name_arquivo = $this->url_amigavel($name).'.'.$extension;
					            $name_arquivo = $this->verificar_existe_imagem_nome(PATH_IMAGES.$this->sistema['bd'].SEP, $name_arquivo);

					            move_uploaded_file($tmp_name, PATH_IMAGES.$this->sistema['bd'].SEP.$name_arquivo);  

					            $data[$campos['name']] = $name_arquivo;

							}else{

								if (!empty($this->files[$campos['name']]['tmp_name'])) {

									$rows = $this->select($campos['name'])->from(PREFIX.$this->sistema['bd'])->where(array('id' => $this->id))->fetch_first();
				                    if ($this->affected_rows > 0) {
				                    	if (!empty($rows[$campos['name']])) {
				                    		$this->delete_images_from_path(PATH_IMAGES.$this->sistema['bd'].SEP,$rows[$campos['name']]);
				                    	}
				                    }

									$tmp_name = $this->files[$campos['name']]['tmp_name'];
						            $name = $this->files[$campos['name']]['name'];
						            $temp = explode('.', $name);
						            $name = $temp[0];
						            $extension = end($temp);

						            $name_arquivo = $this->url_amigavel($name).'.'.$extension;
						            $name_arquivo = $this->verificar_existe_imagem_nome(PATH_IMAGES.$this->sistema['bd'].SEP, $name_arquivo);

						            move_uploaded_file($tmp_name, PATH_IMAGES.$this->sistema['bd'].SEP.$name_arquivo);  

						            $data[$campos['name']] = $name_arquivo;

								}

							}
						}

						if (empty($this->id) && $validacao=='archive') {

							if (empty($this->files[$campos['name']]['tmp_name'])) {

								$_SESSION['SYSTEM_MENSSAGE'] = 'Por favor insira o arquivo para o campo '.$campos['titulo'].' !';
								$_SESSION['SYSTEM_STATUS'] = 'danger';
								return false;
								exit();
							}
						}

						if ($campos['input']=='archive') {

							if (!empty($this->files[$campos['name']]['tmp_name'])&&empty($this->id)) {

								$tmp_name = $this->files[$campos['name']]['tmp_name'];
					            $name = $this->files[$campos['name']]['name'];
					            $temp = explode('.', $name);
					            $name = $temp[0];
					            $extension = end($temp);

					            $name_tmp = $this->url_amigavel($name).'.'.$extension; 
					            $name_tmp = $this->verificar_existe_imagem_nome(PATH_ARCHIVES.$this->sistema['bd'].SEP, $name_tmp);

					            move_uploaded_file($tmp_name, PATH_ARCHIVES.$this->sistema['bd'].SEP.$name_tmp);

					            $data[$campos['name']] = $name_tmp;
							}else{

								if (!empty($this->files[$campos['name']]['tmp_name'])) {

									$rows = $this->select($campos['name'])->from(PREFIX.$this->sistema['bd'])->where(array('id' => $this->id))->fetch_first();
				                    if ($this->affected_rows > 0) {
				                    	if (!empty($rows[$campos['name']])) {
				                    		$this->deletar_aquivo(PATH_ARCHIVES.$this->sistema['bd'].SEP.$rows[$campos['name']]);
				                    	}
				                    }

				                    $tmp_name = $this->files[$campos['name']]['tmp_name'];
						            $name = $this->files[$campos['name']]['name'];
						            $temp = explode('.', $name);
						            $name = $temp[0];
						            $extension = end($temp);
						            $name_tmp = $this->url_amigavel($name).'.'.$extension;
						            $name_tmp = $this->verificar_existe_imagem_nome(PATH_ARCHIVES.$this->sistema['bd'].SEP, $name_tmp);
						            move_uploaded_file($tmp_name, PATH_ARCHIVES.$this->sistema['bd'].SEP.$name_tmp);

						            $data[$campos['name']] = $name_tmp;

					       		}
							}
						}


					}
				}

			}elseif ($campos['name']=='url') {
				if (isset($this->sistema['url_amigavel_por'])) {
					if (empty($data[$this->sistema['url_amigavel_por']])) {
						$rows = $this->select('url')->from(PREFIX.$this->sistema['bd'])->where(array('id' => $this->id))->fetch_first();
						if ($this->affected_rows > 0) {
							$data['url'] = $rows['url'];
						}
					}else{
						$data['url'] = $this->url_amigavel($this->tratarString($data[$this->sistema['url_amigavel_por']]));
					} 
				}else{
					if (empty($this->id)) {
						$rows = $this->select('id')->from(PREFIX.$this->sistema['bd'])->where(array('id' => $this->id))->fetch_first();
						if ($this->affected_rows > 0) {
							$data['url'] = $rows['id'];
						}
					}else{
						$rows = $this->select('url')->from(PREFIX.$this->sistema['bd'])->where(array('id' => $this->id))->fetch_first();
						if ($this->affected_rows > 0) {
							$data['url'] = $rows['url'];
						}
					}

				}
			}elseif (empty($this->id) && $campos['name']=='created') {
				$data['created'] = date('Y-m-d H:i:s');
			}elseif ($campos['name']=='updated') {
				$data['updated'] = date('Y-m-d H:i:s');
			}

			if ($campos['required']==false&&$campos['input']=='archive') {

				if (!empty($this->files[$campos['name']]['tmp_name'])&&empty($this->id)) {
					$tmp_name = $this->files[$campos['name']]['tmp_name'];
		            $name = $this->files[$campos['name']]['name'];
		            $temp = explode('.', $name);
		            $name = $temp[0];
		            $extension = end($temp);

		            $name_tmp = $this->url_amigavel($name).'.'.$extension;
		            $name_tmp = $this->verificar_existe_imagem_nome(PATH_ARCHIVES.$this->sistema['bd'].SEP, $name_tmp);

		            move_uploaded_file($tmp_name, PATH_ARCHIVES.$this->sistema['bd'].SEP.$name_tmp);

		            $data[$campos['name']] = $name_tmp;
				}else{

					if (!empty($this->files[$campos['name']]['tmp_name'])) {

						$rows = $this->select($campos['name'])->from(PREFIX.$this->sistema['bd'])->where(array('id' => $this->id))->fetch_first();
	                    if ($this->affected_rows > 0) {
	                    	if (!empty($rows[$campos['name']])) {
	                    		$this->deletar_aquivo(PATH_ARCHIVES.$this->sistema['bd'].SEP.$rows[$campos['name']]);
	                    	}
	                    }

	                    $tmp_name = $this->files[$campos['name']]['tmp_name'];
			            $name = $this->files[$campos['name']]['name'];
			            $temp = explode('.', $name);
			            $name = $temp[0];
			            $extension = end($temp);
			            $name_tmp = $this->url_amigavel($name).'.'.$extension;
			            $name_tmp = $this->verificar_existe_imagem_nome(PATH_ARCHIVES.$this->sistema['bd'].SEP, $name_tmp);
			            move_uploaded_file($tmp_name, PATH_ARCHIVES.$this->sistema['bd'].SEP.$name_tmp);

			            $data[$campos['name']] = $name_tmp;

		       		}
				}

			}

			if ($campos['required']==false&&$campos['input']=='image') {
				if (!empty($this->files[$campos['name']]['tmp_name'])&&empty($this->id)) {

					$tmp_name = $this->files[$campos['name']]['tmp_name'];
		            $name = $this->files[$campos['name']]['name'];
		            $temp = explode('.', $name);
		            $name = $temp[0];
		            $extension = end($temp);

		            $name_arquivo = $this->url_amigavel($name).'.'.$extension;
		            $name_arquivo = $this->verificar_existe_imagem_nome(PATH_IMAGES.$this->sistema['bd'].SEP, $name_arquivo);

		            move_uploaded_file($tmp_name, PATH_IMAGES.$this->sistema['bd'].SEP.$name_arquivo);  

		            $data[$campos['name']] = $name_arquivo;

				}else{


					if (!empty($this->files[$campos['name']]['tmp_name'])) {

						$rows = $this->select($campos['name'])->from(PREFIX.$this->sistema['bd'])->where(array('id' => $this->id))->fetch_first();
	                    if ($this->affected_rows > 0) {
	                    	if (!empty($rows[$campos['name']])) {
	                    		$this->delete_images_from_path(PATH_IMAGES.$this->sistema['bd'].SEP,$rows[$campos['name']]);
	                    	}
	                    }

						$tmp_name = $this->files[$campos['name']]['tmp_name'];
			            $name = $this->files[$campos['name']]['name'];
			            $temp = explode('.', $name);
			            $name = $temp[0];
			            $extension = end($temp);

			            $name_arquivo = $this->url_amigavel($name).'.'.$extension;
			            $name_arquivo = $this->verificar_existe_imagem_nome(PATH_IMAGES.$this->sistema['bd'].SEP, $name_arquivo);

			            move_uploaded_file($tmp_name, PATH_IMAGES.$this->sistema['bd'].SEP.$name_arquivo);  

			            $data[$campos['name']] = $name_arquivo; 

					}

				}
			}
		}


		return $data;
	}


	private function preparar_dados_galeria($id=0){



		foreach ($this->sistema['galeria'] as $galeria) {

			$multi_upload = false;
			$total_upload = 0;
			foreach ($galeria['campos'] as $campo) {

				if ($campo['input']=='multi_image'||$campo['input']=='multi_archive') {
					$multi_upload = true;
				}

			}


			if ($multi_upload) {


				foreach ($galeria['campos'] as $campo) {
					if ($campo['input']=='multi_image'||$campo['input']=='multi_archive') {
						if (isset($this->files_galerias[$galeria['bd']][$campo['name']]['tmp_name'])) {
							$contar = count($this->files_galerias[$galeria['bd']][$campo['name']]['tmp_name']);
						}else{
							$contar = 0;
						}
						
					}else{
						$contar = 0;
					}

					if ($total_upload < $contar) {
						$total_upload = $contar;
					}
				}

				for ($i=0; $i < $total_upload; $i++) {


                    foreach ($galeria['campos'] as $campos) {

                        if ($campos['mostrar_campo']) {

                            if ($campos['input']=='image'||$campos['input']=='archive') {

                            }elseif($campos['input']=='checkbox'){

                                if (empty($this->data_galerias[$galeria['bd']][$campos['name']])) {
                                    $this->data_galerias[$galeria['bd']][$campos['name']] = 0;
                                }

                                $this->data_galerias[$galeria['bd']][$campos['name']] = $this->tratarInt($this->data_galerias[$galeria['bd']][$campos['name']]);

                            }elseif($campos['input']=='date'){
                            	$this->data_galerias[$galeria['bd']][$campos['name']] = implode("-",array_reverse(explode("/", $this->data_galerias[$galeria['bd']][$campos['name']])));
                            }elseif($campos['input']=='money'){

                            	$this->data_galerias[$galeria['bd']][$campos['name']] = str_replace(array('.' , ',' ), array('','.'), floatval($this->data_galerias[$galeria['bd']][$campos['name']]));
                                 
                            }elseif($campos['input']=='text'||$campos['input']=='textarea'||$campos['input']=='editor'){
                                $this->data_galerias[$galeria['bd']][$campos['name']] = $this->tratarString($this->data_galerias[$galeria['bd']][$campos['name']]);
                            }

                            foreach ($campos['tipo_validacao'] as $validacao) {

                                if ($validacao=='vazio') {

                                    if (empty($this->data_galerias[$galeria['bd']][$campos['name']])) {

                                        $_SESSION['SYSTEM_MENSSAGE'] = 'Por favor preencha o campo '.$campos['titulo'].' !';
                                        $_SESSION['SYSTEM_STATUS'] = 'danger';
                                        return false;
                                        exit();

                                    }

                                }

                                if ($validacao=='email') {

                                    if ($this->validaEmail($this->data_galerias[$galeria['bd']][$campos['name']])==false) {

                                        $_SESSION['SYSTEM_MENSSAGE'] = 'Por favor, digite um email válido !';
                                        $_SESSION['SYSTEM_STATUS'] = 'danger';
                                        return false;
                                        exit();
                                    }
                                }

                                if ($validacao=='cnpj') {

                                    if ($this->validaCnpj($this->data_galerias[$galeria['bd']][$campos['name']])==false) {

                                        $_SESSION['SYSTEM_MENSSAGE'] = 'Por favor, digite um cnpj válido !';
                                        $_SESSION['SYSTEM_STATUS'] = 'danger';
                                        return false;
                                        exit();
                                    }
                                }

                                if ($validacao=='cpf') {

                                    if ($this->validaCpf($this->data_galerias[$galeria['bd']][$campos['name']])==false) {

                                        $_SESSION['SYSTEM_MENSSAGE'] = 'Por favor, digite um cpf válido !';
                                        $_SESSION['SYSTEM_STATUS'] = 'danger';
                                        return false;
                                        exit();
                                    }
                                }

                                if ($validacao=='exist') {

                                    $rows = $this->select('id')->from(PREFIX.$galeria['bd'])->where(array($campos['name'] => $this->data_galerias[$galeria['bd']][$campos['name']]))->fetch_first();
                                    if ($this->affected_rows > 0) {
                                        $_SESSION['SYSTEM_MENSSAGE'] = 'Este '.$campos['titulo'].' já esta em uso, tente outro !';
                                        $_SESSION['SYSTEM_STATUS'] = 'danger';
                                        return false;
                                        exit();
                                    }

                                }

                                if ($validacao=='image') {

                                	if (empty($this->files_galerias[$galeria['bd']][$campos['name']]['tmp_name'][$i])) {

                                		$_SESSION['SYSTEM_MENSSAGE'] = 'Por favor insira a imagem para o campo '.$campos['titulo'].' !';
                                        $_SESSION['SYSTEM_STATUS'] = 'danger';
                                        return false;
                                        exit();
                                    }
                                }

                                
                            }

                            if ($campos['input']=='multi_image') {

                                if (!empty($this->files_galerias[$galeria['bd']][$campos['name']]['tmp_name'][$i])) {
                                	$tmp_name = $this->files_galerias[$galeria['bd']][$campos['name']]['tmp_name'][$i];
						            $name = $this->files_galerias[$galeria['bd']][$campos['name']]['name'][$i];
						            
						            $temp = explode('.', $name);
						            $name = $temp[0];
						            $extension = end($temp);

						            $name_arquivo = $this->url_amigavel($name).'.'.$extension;
						            $name_arquivo = $this->verificar_existe_imagem_nome(PATH_IMAGES.$this->sistema['bd'].SEP, $name_arquivo);

						            move_uploaded_file($tmp_name, PATH_IMAGES.$this->sistema['bd'].SEP.$name_arquivo);   

                                    $this->data_galerias[$galeria['bd']][$campos['name']][$i] = $name_arquivo;

                                }
                            }

                        }elseif ($campos['name']=='created') {
                        	$this->data_galerias[$galeria['bd']][$this->sistema['bd']] = $id;
                            $this->data_galerias[$galeria['bd']]['created'] = date('Y-m-d H:i:s');
                        }
                    }

                }

			}else{

			}
		}
    }


    public function preparar_dados_galeria_alterar($data){


        foreach ($this->sistema['galeria'] as $galerias) {

            if ($galerias['bd']==$this->galeria_name) {

                foreach ($galerias['campos'] as $campos) {

                    if ($campos['mostrar_campo']) {

                        if ($campos['input']=='image'||$campos['input']=='multi_image'||$campos['input']=='archive') {

                        }elseif($campos['input']=='checkbox'){
                            if (empty($data[$campos['name']])) {
                                $data[$campos['name']] = 0;
                            }
                            $data[$campos['name']] = $this->tratarInt($data[$campos['name']]);
                        }elseif($campos['input']=='date'){
                        	$data[$campos['name']] = explode(' ', $data[$campos['name']]); 
                        	$data[$campos['name']] = implode("-",array_reverse(explode("/", $data[$campos['name']][0]))); 
                        }elseif($campos['input']=='money'){
                        	$data[$campos['name']] = str_replace(array('.' , ',' ), array('','.'), floatval($data[$campos['name']]));
                        }else{
                            $data[$campos['name']] = $this->tratarString($data[$campos['name']]);
                        }

                        foreach ($campos['tipo_validacao'] as $validacao) {

                            if ($validacao=='vazio') {

                                if (empty($data[$campos['name']])) {

                                    $_SESSION['SYSTEM_MENSSAGE'] = 'Por favor preencha o campo '.$campos['titulo'].' !';
                                    $_SESSION['SYSTEM_STATUS'] = 'danger';
                                    return false;
                                    exit();

                                }

                            }

                            if ($validacao=='email') {

                                if ($this->validaEmail($data[$campos['name']])==false) {

                                    $_SESSION['SYSTEM_MENSSAGE'] = 'Por favor, digite um email válido !';
                                    $_SESSION['SYSTEM_STATUS'] = 'danger';
                                    return false;
                                    exit();
                                }
                            }

                            if ($validacao=='cnpj') {

                                if ($this->validaCnpj($data[$campos['name']])==false) {

                                    $_SESSION['SYSTEM_MENSSAGE'] = 'Por favor, digite um cnpj válido !';
                                    $_SESSION['SYSTEM_STATUS'] = 'danger';
                                    return false;
                                    exit();
                                }
                            }

                            if ($validacao=='cpf') {

                                if ($this->validaCpf($data[$campos['name']])==false) {

                                    $_SESSION['SYSTEM_MENSSAGE'] = 'Por favor, digite um cpf válido !';
                                    $_SESSION['SYSTEM_STATUS'] = 'danger';
                                    return false;
                                    exit();
                                }
                            }

                            if ($validacao=='exist') {

                                if (empty($this->id)) {
                                    $rows = $this->select('id')->from(PREFIX.$galerias['bd'])->where(array($campos['name'] => $data[$campos['name']]))->fetch_first();
                                    if ($this->affected_rows > 0) {
                                        $_SESSION['SYSTEM_MENSSAGE'] = 'Este '.$campos['titulo'].' já esta em uso, tente outro !';
                                        $_SESSION['SYSTEM_STATUS'] = 'danger';
                                        return false;
                                        exit();
                                    }
                                }else{
                                    $rows = $this->select('id')->from(PREFIX.$galerias['bd'])->where(array($campos['name'] => $data[$campos['name']], 'id !=' => $this->id))->fetch_first();
                                    if ($this->affected_rows > 0) {
                                        $_SESSION['SYSTEM_MENSSAGE'] = 'Este '.$campos['titulo'].' já esta em uso, tente outro !';
                                        $_SESSION['SYSTEM_STATUS'] = 'danger';
                                        return false;
                                        exit();
                                    }
                                }

                            }

                        }

                    }elseif ($campos['name']=='url') {
                        if (!empty($data['nome'])) {
                        	if ($this->sistema['url_amigavel_por']) {
								$data['url'] = $this->url_amigavel($this->tratarString($data[$this->sistema['url_amigavel_por']]));
							}else{
								$data['url'] = $this->url_amigavel($this->tratarString($data['nome']));
							} 
                        }else{
                            if ($this->id!=0) {
                                $rows = $this->select('url')->from(PREFIX.$galerias['bd'])->where(array('id' => $this->id))->fetch_first();
                                if ($this->affected_rows > 0) {
                                    $data['url'] = $rows['url'];
                                }
                            }

                        }
                    }elseif ($campos['name']=='created') {
                        $data['created'] = date('Y-m-d H:i:s');
                    }

                    if ($campos['input']=='multi_image') {

                        if (!empty($this->files[$campos['name']]['tmp_name'])) {

                            $tmp_name = $this->files[$campos['name']]['tmp_name'];
				            $name = $this->files[$campos['name']]['name'];  

				            $rows = $this->select($campos['name'])->from(PREFIX.$galerias['bd'])->where(array('id' => $this->id))->fetch_first();
                            if ($this->affected_rows > 0) {
                                if (!empty($rows[$campos['name']])) { 
                                    $this->delete_images_from_path(PATH_IMAGES.$this->sistema['bd'].SEP, $rows[$campos['name']]);
                                }
                            } 

				            $temp = explode('.', $name);
				            $name = $temp[0];
				            $extension = end($temp);

				            $name_arquivo = $this->url_amigavel($name).'.'.$extension;
				            $name_arquivo = $this->verificar_existe_imagem_nome(PATH_IMAGES.$this->sistema['bd'].SEP, $name_arquivo);

				            move_uploaded_file($tmp_name, PATH_IMAGES.$this->sistema['bd'].SEP.$name_arquivo);     

                            $data[$campos['name']] = $name_arquivo;

                        }

                    }

                }

            }


        }


        return $data;
    }

    public function cadastrar_multiselect($id = 0){

    	foreach ($this->sistema['campos'] as $campos) {

    		if ($campos['input']=='multiselect') {

    			foreach ($this->data_multi as $bd => $array) {

    				if ($this->sistema['bd'].'_'.$campos['category'] == $bd) {

	    				$this->delete()->from(PREFIX.$this->sistema['bd'].'_'.PREFIX.$campos['category'])->where($campos['name'], intval($id))->execute();

		    			foreach ($array as $id_multi) {

			    			$this->insert(PREFIX.$this->sistema['bd'].'_'.PREFIX.$campos['category'], array($campos['name'] => $id, $campos['parametros']['campo'] => $id_multi )) ;

			    		}

		    		}

		    	}
	    	}

	    }

    }

	public function cadastrar(){

		$data = $this->preparar_dados($this->data);
		if ($data==false) {
			return false;
		}else{


			$verificar = true;
			$cont = 1;
			while ($verificar) {
				$rows = $this->select('id')->from(PREFIX.$this->sistema['bd'])->where(array('url' => $data['url']))->fetch_first();
				if ($this->affected_rows > 0) {
					if ($this->sistema['url_amigavel_por']) { 
						$data['url'] = $this->url_amigavel($this->tratarString($data[$this->sistema['url_amigavel_por']])).'_'.$cont;
					}else{ 
						$data['url'] = $this->url_amigavel($this->tratarString($data['nome'])).'_'.$cont;
					} 
				}else{
					$verificar = false;
				}
				$cont ++;
			}

			$id = $this->insert(PREFIX.$this->sistema['bd'], $data);

			if (!empty($this->data_multi)) {
				$this->cadastrar_multiselect($id);
			}

			if (isset($this->sistema['galeria'])) {
				$retorno = $this->preparar_dados_galeria($id);

				$array = array();

				foreach ($this->data_galerias as $nome_galeria => $galerias) {
					$maior = 0;

					foreach ($galerias as $nome_camp => $camp) {

						if (is_array($camp)) {
							if ($maior < count($camp)) {
								$maior = count($camp);
							}
						}
					}

					for ($i=0; $i < $maior; $i++) {

						$array = array();

						foreach ($galerias as $nome_camp => $camp) {

							if (is_array($camp)) {
								if (isset($camp[$i])) {
									$array[$nome_camp] = $camp[$i];
								}
							}else{
								$array[$nome_camp] = $camp;
							}
						}

						$this->insert(PREFIX.$nome_galeria, $array);

					}

				}

				if ($retorno==false) {

					$this->redirect(URL_PAINEL.$this->sistema['url'].'/atualizar/'.$data['url']);
					exit();
				}else{
					$_SESSION['SYSTEM_MENSSAGE'] = 'Cadastro incluido com sucesso !';
					$_SESSION['SYSTEM_STATUS'] = 'success';

					$this->redirect(URL_PAINEL.$this->sistema['url'].'/atualizar/'.$data['url']);
					exit();
				}
			}else{

				$_SESSION['SYSTEM_MENSSAGE'] = 'Cadastro incluido com sucesso !';
				$_SESSION['SYSTEM_STATUS'] = 'success';
				$this->redirect(URL_PAINEL.$this->sistema['url']);
				exit();

			}

		}
	}

	public function atualizar(){

		$data = $this->preparar_dados($this->data);
		if ($data==false) {

		}else{
			$verificar = true;
			$cont = 1;
			while ($verificar) {
				$rows = $this->select('id')->from(PREFIX.$this->sistema['bd'])->where(array('url' => $data['url'], 'id !=' => $this->id))->fetch_first();
				if ($this->affected_rows > 0) {
					if ($this->sistema['url_amigavel_por']) { 
						$data['url'] = $this->url_amigavel($this->tratarString($data[$this->sistema['url_amigavel_por']])).'_'.$cont;
					}else{ 
						$data['url'] = $this->url_amigavel($this->tratarString($data['nome'])).'_'.$cont;
					}
				}else{
					$verificar = false;
				}
				$cont ++;
			}

			$this->where(array('id' => $this->id))->update(PREFIX.$this->sistema['bd'], $data);

			if (!empty($this->data_multi)) {
				$this->cadastrar_multiselect($this->id);
			}

			if (isset($this->sistema['galeria'])) {


				$retorno = $this->preparar_dados_galeria($this->id);


				$maior = 0;
				foreach ($this->data_galerias as $nome_galeria => $galerias) {
					

					foreach ($galerias as $nome_camp => $camp) {

						if (is_array($camp)) {
							if ($maior < count($camp)) {
								$maior = count($camp);
							}
						}
					}

					for ($i=0; $i < $maior; $i++) {

						$array = array();

						foreach ($galerias as $nome_camp => $camp) {

							if (is_array($camp)) {
								if (isset($camp[$i])) {
									$array[$nome_camp] = $camp[$i];
								}
							}else{
								$array[$nome_camp] = $camp;
							}
						}

						$this->insert(PREFIX.$nome_galeria, $array);

					}

				}

				if ($retorno==false) {

					$this->redirect(URL_PAINEL.$this->sistema['url'].'/atualizar/'.$data['url']);
					exit();

				}else{
					$_SESSION['SYSTEM_MENSSAGE'] = 'Cadastro atualizado com sucesso !';
					$_SESSION['SYSTEM_STATUS'] = 'success';

					$this->redirect(URL_PAINEL.$this->sistema['url'].'/atualizar/'.$data['url']);
					exit();

				}
			}else{

				$_SESSION['SYSTEM_MENSSAGE'] = 'Cadastro atualizado com sucesso !';
				$_SESSION['SYSTEM_STATUS'] = 'success';
				$this->redirect(URL_PAINEL.$this->sistema['url'].'/atualizar/'.$data['url']);
				exit();

			}

		}

	}

	public function atualizar_galeria(){

		$data = $this->preparar_dados_galeria_alterar($this->data);
		if ($data==false) {
			return false;
		}else{

			$this->where(array('id' => $this->id))->update(PREFIX.$this->galeria_name, $data);
			return true;

		}

	}

} ?>
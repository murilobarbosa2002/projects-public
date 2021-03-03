<?php include(PATH_CLASS.'crud'.SEP.'Configuracoes.class.php');
$Configuracoes = new Configuracoes(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$url_get = explode('/', $Configuracoes->getUrl());
if(empty($_SESSION['admin'])){
    $Administradores->redirect(URL_PAINEL);
    exit();
}
if (!isset($url_get[1])) {  ?>
	<script type="text/javascript">

		function trocar(valor){

			if (valor=='text') {
				document.getElementById('conteudo_html').innerHTML = '<input type="text" class="col-xs-12 col-sm-7" name="conteudo" id="conteudo">';
			}else if(valor=='textarea'){
				document.getElementById('conteudo_html').innerHTML = '<textarea type="text" class="col-xs-12 col-sm-7" name="conteudo" id="conteudo"></textarea>';
			}else if(valor=='image'){
				document.getElementById('conteudo_html').innerHTML = '<input type="file" id="conteudo" name="conteudo">';
			}else if(valor=='telefone'){
				document.getElementById('conteudo_html').innerHTML = '<input type="text" class="col-xs-8 col-sm-5" name="conteudo" id="conteudo">';
			}else if(valor=='email'){
				document.getElementById('conteudo_html').innerHTML = '<input type="text" class="col-xs-8 col-sm-5" name="conteudo" id="conteudo">';
			}else if(valor=='url'){
				document.getElementById('conteudo_html').innerHTML = '<input type="text" class="col-xs-8 col-sm-5" name="conteudo" id="conteudo" value="http://">';
			}else if(valor=='iframe'){
				document.getElementById('conteudo_html').innerHTML = '<textarea type="text" class="col-xs-12 col-sm-7" name="conteudo" id="conteudo"></textarea>';
			}else if(valor=='campo_menor'){
				document.getElementById('conteudo_html').innerHTML = '<textarea type="text" class="col-xs-4 col-sm-4" name="conteudo" id="conteudo"></textarea>';
			}else if(valor=='codigo'){
				document.getElementById('conteudo_html').innerHTML = '<textarea type="text" class="col-xs-12 col-sm-7" name="conteudo" id="conteudo"></textarea>';
			}else if(valor=='checkbox'){
				document.getElementById('conteudo_html').innerHTML = '<label><input name="conteudo" id="conteudo" class="ace ace-switch ace-switch-6" type="checkbox" value="1" /><span class="lbl"></span></label>';
			}
		}

	</script>

	<div class="col-xs-12">
		<div class="page-header">
			<h1>Configurações <small><i class="icon-double-angle-right"></i>Informações gerais utilizadas no site.</small></h1>
		</div>
	</div>
	<div class="col-xs-12">
		<?php if ($_SESSION['SYSTEM_MENSSAGE']!='') {
		    echo $Configuracoes->message_system($_SESSION['SYSTEM_MENSSAGE'], $_SESSION['SYSTEM_STATUS']);
		    $_SESSION['SYSTEM_MENSSAGE'] = '';
		} ?>
	</div>
	<?php if($_SESSION['admin_nivel_acesso'] == 1){ ?>
		<div class="col-xs-12">
			<form class="form-horizontal panel panel-default" action="<?=URL_PAINEL?>configuracoes/cadastrar" method="post" enctype="multipart/form-data">
				<div class="panel-heading"><h5>Incluir configuração</h5></div>
				<div class="panel-body">
					<div class="form-group">
						<label for="nome" class="col-sm-3 control-label">Nome:</label>
						<div class="col-sm-9"><input type="text" class="col-xs-12 col-sm-7" name="nome" id="nome"></div>
					</div>
					<div class="form-group">
						<label for="tipo" class="col-sm-3 control-label">Tipo:</label>
						<div class="col-sm-9">
							<select name="tipo" id="tipo" class="col-xs-12 col-sm-2" onchange="trocar(this.value);">
								<option value="text">Texto</option>
								<option value="textarea">Area de texto</option>
								<option value="image">Imagem</option>
								<option value="telefone">Telefone</option>
								<option value="email">Email</option>
								<option value="url">Url</option>
								<option value="iframe">Iframe</option>
                                <option value="campo_manor">Campo menor</option>
                                <option value="codigo">Código</option>
                                <option value="checkbox">Checkbox</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="show_field" class="col-sm-3 control-label">Mostrar para usuário:</label>
						<div class="col-sm-1">
							<select name="show_field"> 
								<option value="1">Sim</option>
								<option  value="0">Não</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="conteudo" class="col-sm-3 control-label">Conteudo:</label>
						<div class="col-sm-9" id="conteudo_html"><input type="text" class="col-xs-12 col-sm-7" name="conteudo" id="conteudo"></div>
					</div>
				</div>
				<div class="panel-footer"><div class="col-sm-offset-3 col-sm-9"><button type="submit" class="btn btn-success btn-sm">Cadastrar</button></div><div class="clearfix"></div></div>
			</form>
		</div>
	<?php }
    if($_SESSION['admin_nivel_acesso'] != 1){
        $Configuracoes->where(array('show_field' => 1));
    }
	$resultados = $Configuracoes->select('url, nome, tipo, conteudo, id, show_field')->from(PREFIX.'configuracoes')->fetch();
	if ($Configuracoes->affected_rows > 0) { ?>
		<div class="col-xs-12">
			<form class="form-horizontal panel panel-default" action="<?=URL_PAINEL?>configuracoes/atualizar" method="post" enctype="multipart/form-data">
				<div class="panel-body">
					<?php $path_image_config = URL_UPLOAD_IMAGE.'configuracoes/';
					$real_path_image_config = PATH_IMAGES.'configuracoes'.SEP;
					foreach($resultados as $resultado){
						extract($resultado); ?>
						<div class="form-group">
							<label for="<?=$url;?>" class="col-sm-3 control-label"><?=$nome;?></label>
							<div class="col-sm-8">
								<?php if ($tipo=='text') {
									echo '<input type="text" class="col-xs-11 col-sm-7" name="'.$url.'" id="'.$id.'" value="'.$conteudo.'">';
								}elseif ($tipo=='textarea') {
									echo '<textarea type="text" class="col-xs-11 col-sm-10" rows="12" name="'.$url.'" id="'.$id.'">'.$conteudo.'</textarea>';
								}elseif ($tipo=='image') {
									if (!empty($conteudo)) {
										echo('<div class="col-sm-12"><img src="'.$Configuracoes->image($conteudo,220,220,$real_path_image_config,'redimencionar',80,$path_image_config).'"></div>');
										echo '<div class="col-sm-12"><a href="'.URL_PAINEL.'configuracoes/remover/'.$url.'">Remover imagem</a></div>';
									}
									echo '<input type="file" id="'.$id.'" name="'.$url.'" class="col-xs-11 col-sm-7">';
								}elseif ($tipo=='telefone') {
									echo '<input type="text" class="col-xs-7 col-sm-4" name="'.$url.'" id="'.$id.'" value="'.$conteudo.'">';
								}elseif ($tipo=='email') {
									echo '<input type="text" class="col-xs-7 col-sm-4" name="'.$url.'" id="'.$id.'" value="'.$conteudo.'">';
								}elseif ($tipo=='url') {
									echo '<input type="text" class="col-xs-7 col-sm-4" name="'.$url.'" id="'.$id.'" value="'.$conteudo.'">';
								}elseif ($tipo=='iframe') {
									if (!empty($conteudo)) { echo '<div class="col-sm-12">'.htmlspecialchars_decode(stripslashes($conteudo)).'</div>'; }
									echo '<textarea type="text" class="col-xs-11 col-sm-7" name="'.$url.'" id="'.$id.'">'.stripslashes ($conteudo).'</textarea>';
								}elseif ($tipo=='campo_menor') {
									echo '<input type="text" class="col-xs-4 col-sm-4" name="'.$url.'" id="'.$id.'" value="'.$conteudo.'">';
								}elseif ($tipo=='codigo') {
									echo '<textarea type="text" class="col-xs-11 col-sm-7" name="'.$url.'" id="'.$id.'" rows="20">'.$conteudo.'</textarea>';
								}elseif ($tipo=='checkbox') {
									$checked = ($conteudo==1?' checked':'');
									echo '<label><input name="'.$url.'" id="'.$id.'" class="ace ace-switch ace-switch-6"'.$checked.' type="checkbox" value="1" /><span class="lbl"></span></label>';
								}
								if($_SESSION['admin_nivel_acesso'] == 1){  ?>
									<div class="col-sm-1"> 
										<a class="label label-danger" href="<?=URL_PAINEL?>configuracoes/excluir/<?=$url;?>" title="Excluir" alt="Excluir">
											<i class="icon-bolt bigger-120"></i>
										</a>
									</div> 
									<div class="col-sm-1">
										<select name="show_field-<?php echo $url; ?>">
											<option value="1"<?php echo ($show_field==1?' selected':'') ?>>Sim</option>
											<option  value="0"<?php echo ($show_field==0?' selected':'') ?>>Não</option>
										</select>
									</div>  
								<?php } ?>
							</div>
						</div>
					<?php } ?>
				</div>
				<div class="panel-footer"><div class="col-sm-offset-3 col-sm-9"><button type="submit" class="btn btn-success btn-sm">Atualizar</button></div><div class="clearfix"></div></div>
			</form>
		</div>
	<?php }
}elseif ($url_get[1]=='cadastrar') {
	if (!empty($_POST)) {

        $nome = $_POST['nome'];
        $tipo = $_POST['tipo'];
        $show_field = $_POST['show_field'];

        if ($tipo == 'image') {
        	$conteudo = $_FILES['conteudo'];
        }else{
        	$conteudo = $_POST['conteudo'];
        }

        $Configuracoes->setNome($nome);
        $Configuracoes->setUrl($nome);
        $Configuracoes->setTipo($tipo);
        $Configuracoes->setConteudo($conteudo);
        $Configuracoes->setShowField($show_field);
        $Configuracoes->cadastrar();

        $_SESSION['SYSTEM_MENSSAGE'] = 'Cadastro efetuado com sucesso !';
        $_SESSION['SYSTEM_STATUS'] = 'success';

        $this->redirect(URL_PAINEL.'configuracoes');

        exit();
    }else{
        $this->redirect(URL_PAINEL.'configuracoes');
		exit();
    }
}elseif ($url_get[1]=='excluir') {

	if (isset($url_get[2])) {

		$rows = $Configuracoes->select('conteudo,tipo')->from(PREFIX.'configuracoes')->where(array('url' => $url_get[2]))->fetch_first();
		if ($Configuracoes->affected_rows > 0) {
			extract($rows);
			if ($tipo=='image') {
				$Configuracoes->delete_images_from_path(PATH_IMAGES.'configuracoes'.SEP,$conteudo);
			}
		}

		$Configuracoes->delete()->from(PREFIX.'configuracoes')->where('url', $url_get[2])->limit(1)->execute();

        $_SESSION['SYSTEM_MENSSAGE'] = 'Cadastro excluído com sucesso !';
        $_SESSION['SYSTEM_STATUS'] = 'success';

        $this->redirect(URL_PAINEL.'configuracoes');

	}else{

		$this->redirect(URL_PAINEL.'configuracoes');

	}

	exit();

}elseif ($url_get[1]=='instalar') {

	$Configuracoes->instalar();

}elseif ($url_get[1]=='remover') {

	if (isset($url_get[2])) {

		$rows = $Configuracoes->select('conteudo,tipo')->from(PREFIX.'configuracoes')->where(array('url' => $url_get[2]))->fetch_first();
		if ($Configuracoes->affected_rows > 0) {
			extract($rows);
			if ($tipo=='image') {
				$Configuracoes->delete_images_from_path(PATH_IMAGES.'configuracoes'.SEP,$conteudo);
			}
		}

		$Configuracoes->where(array('url' => $url_get[2]))->update(PREFIX.'configuracoes', array('conteudo' => ''));

	}

	$Configuracoes->redirect(URL_PAINEL.'configuracoes');

}elseif ($url_get[1]=='atualizar') {
	if (!empty($_POST)) {

        if($_SESSION['admin_nivel_acesso'] != 1){
	        $Configuracoes->where(array('show_field' => 1));
	    }

        $resultados = $Configuracoes->select('url, nome, tipo, conteudo, id')->from(PREFIX.'configuracoes')->fetch();
		if ($Configuracoes->affected_rows > 0) {
			foreach($resultados as $resultado){
				if ($resultado['tipo']=='image') {

					$conteudo = $resultado['conteudo'];
					$new_conteudo = $_FILES[$resultado['url']];

					if (!empty($new_conteudo['tmp_name'])) {

						if (!empty($conteudo)) {
							$Configuracoes->delete_images_from_path(PATH_IMAGES.'configuracoes'.SEP,$conteudo);
						}

						$conteudo = $new_conteudo;

						$tmp_name = $conteudo['tmp_name'];
        				$name = $conteudo['name'];
        				$temp = explode('.', $name);
        				$name = $temp[0];
        				$extension = end($temp);
        				
        				$name = $this->url_amigavel($name).'.'.$extension;

			            $name = $Configuracoes->verificar_existe_imagem_nome(PATH_IMAGES.'configuracoes', $name);

			            move_uploaded_file($tmp_name, PATH_IMAGES.'configuracoes'.SEP.$name); 
			            $return = true;

			            if (!empty($name)) {
			            	$Configuracoes->deletar_aquivo(PATH_IMAGES_TMP.$name);
			            } 

			            $conteudo = $name; 
					}else{
						$conteudo = $conteudo;
					}

                }elseif ($resultado['tipo']=='codigo'||$resultado['tipo']=='iframe') {
                    $conteudo = $_POST[$resultado['url']];
                    $conteudo = $Configuracoes->tratarString($conteudo);
                    $conteudo = @htmlentities($conteudo); 
					
				}else{

                    $conteudo = $_POST[$resultado['url']];
                    $conteudo = $Configuracoes->tratarString($conteudo);

				}
				$show_field = $_POST['show_field-'.$resultado['url']];
				$data_base = array('conteudo' => $conteudo);
				if($_SESSION['admin_nivel_acesso'] == 1){ $data_base['show_field'] = $show_field; }
				$Configuracoes->where(array('url' => $resultado['url']))->update(PREFIX.'configuracoes', $data_base);
			}

		}

		$_SESSION['SYSTEM_MENSSAGE'] = 'Condigurações atualizadas com sucesso !';
		$_SESSION['SYSTEM_STATUS'] = 'success';

		$this->redirect(URL_PAINEL.'configuracoes');

    }else{
        $this->redirect(URL_PAINEL.'configuracoes');
		exit();
    }
} ?>
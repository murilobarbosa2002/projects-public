<?php session_start();
require('config.php');
require(PATH_CLASS.'crud'.SEP.'Administradores.class.php');
$Administradores = new Administradores(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$url = explode('/', $Administradores->getUrl()); 

if (isset($url[0])) {
	if ($url[0]=='instalar') {
		$Administradores->instalar();
		exit();
	}
	if ($url[0]=='sair') {
		$Administradores->logout();
		exit();
	}
}
if (empty($_SESSION['SYSTEM_MENSSAGE'])) {
	$_SESSION['SYSTEM_MENSSAGE'] = '';
}
if(empty($_SESSION['admin'])){
	if (!empty($_POST)) {
		if (isset($_POST['usuario'])&&isset($_POST['senha'])) {
			if ($Administradores->validarCSRF()) {
				$Administradores->setUsuario($_POST['usuario']);
				$Administradores->setSenha($_POST['senha']);
				$retorno = $Administradores->logar();
				if ($retorno['status']==0) {
					$_SESSION['SYSTEM_MENSSAGE'] = $retorno['mensagem'];
					$_SESSION['SYSTEM_STATUS'] = 'danger';
				}elseif($retorno['status']==1){
					exit();
				}else{
					$_SESSION['SYSTEM_MENSSAGE'] = 'Ops algo deu erro !';
					$_SESSION['SYSTEM_STATUS'] = 'warning';
				}
			}
		}
		if (isset($_POST['email'])) {
			if ($Administradores->validarCSRF()) {
				$Administradores->setEmail($_POST['email']);
				$retorno = $Administradores->esqueci_senha();
				if ($retorno['status']==0) {
					$_SESSION['SYSTEM_MENSSAGE'] = $retorno['mensagem'];
					$_SESSION['SYSTEM_STATUS'] = 'danger';
				}elseif($retorno['status']==1){
					$_SESSION['SYSTEM_MENSSAGE'] = $retorno['mensagem'];
					$_SESSION['SYSTEM_STATUS'] = 'success';
				}else{
					$_SESSION['SYSTEM_MENSSAGE'] = $retorno['mensagem'];
					$_SESSION['SYSTEM_STATUS'] = 'warning';
				}
			}
		}
	} ?>
	<!DOCTYPE html>
	<html lang="pt-br">
		<head>
			<meta charset="utf-8" />
			<title>Faça seu Login</title>
			<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	        <meta name="robots" content="noindex, nofollow">
	        <link rel="stylesheet" href="<?=URL_PAINEL_TEMPLATE?>assets/css/ace-fonts.min.css" />
			<link href="<?=URL_PAINEL_TEMPLATE?>assets/css/bootstrap.min.css" rel="stylesheet" />
			<link rel="stylesheet" href="assets/css/font-awesome.min.css" />
			<!--[if IE 7]> <link rel="stylesheet" href="<?=URL_PAINEL_TEMPLATE?>assets/css/font-awesome-ie7.min.css" /> <![endif]-->
			<link rel="stylesheet" href="<?=URL_PAINEL_TEMPLATE?>assets/css/ace.min.css" />
			<link rel="stylesheet" href="<?=URL_PAINEL_TEMPLATE?>assets/css/ace-rtl.min.css" />
			<link rel="stylesheet" href="<?=URL_PAINEL_TEMPLATE?>assets/css/main.min.css" />
			<!--[if lte IE 8]> <link rel="stylesheet" href="<?=URL_PAINEL_TEMPLATE?>assets/css/ace-ie.min.css" /> <![endif]-->
			<!--[if lt IE 9]> <script src="<?=URL_PAINEL_TEMPLATE?>assets/js/html5shiv.min.js"></script> <script src="<?=URL_PAINEL_TEMPLATE?>assets/js/respond.min.js"></script> <![endif]-->
		</head>
		<body class="login-layout">
			<div class="main-container">
				<div class="main-content">
					<div class="row">
						<div class="col-sm-10 col-sm-offset-1">
							<div class="login-container">
								<div class="center"> <i class="logo"></i> </div>
								<div class="space-6"></div>
								<div class="position-relative">
									<div id="login-box" class="login-box visible widget-box no-border">
										<div class="widget-body">
											<div class="widget-main">
												<h4 class="header lighter bigger center"> Entre com seu usuário e senha </h4>
												<?php if ($_SESSION['SYSTEM_MENSSAGE']!='') {
													echo $Administradores->message_system($_SESSION['SYSTEM_MENSSAGE'], $_SESSION['SYSTEM_STATUS']);
													$_SESSION['SYSTEM_MENSSAGE'] = '';
												} ?>
												<div class="space-6"></div>
												<form method="post">
													<?php $Administradores->inputCSRF(); ?>
													<fieldset>
														<label class="block clearfix">
															<span class="block input-icon input-icon-right">
																<input type="text" class="form-control" placeholder="Usuário" name="usuario" /> <i class="icon-user"></i>
															</span>
														</label>
														<label class="block clearfix">
															<span class="block input-icon input-icon-right">
																<input type="password" class="form-control" placeholder="Senha" name="senha"/> <i class="icon-lock"></i>
															</span>
														</label>
														<div class="space"></div>
														<div class="clearfix"><button type="submit" class="width-100 btn btn-success">Entrar</button></div>
														<div class="space-4"></div>
													</fieldset>
												</form>
											</div>
											<div class="toolbar clearfix">
												<div><a href="#" onclick=" show_box('forgot-box'); return false;" class="forgot-password-link">Esqueci minha senha</a></div>
											</div>
										</div>
									</div>
									<div id="forgot-box" class="forgot-box widget-box no-border">
										<div class="widget-body">
											<div class="widget-main">
												<h4 class="header red lighter bigger"> <i class="icon-key"></i> Recupere sua senha </h4>
												<form method="post">
													<?php $Administradores->inputCSRF(); ?>
													<fieldset>
														<label class="block clearfix">
															<span class="block input-icon input-icon-right">
																<input type="email" class="form-control" placeholder="Digite seu e-mail" name="email"/>
																<i class="icon-envelope"></i>
															</span>
														</label>
														<div class="clearfix">
															<button class="pull-right btn btn-sm btn-danger"> <i class="icon-lightbulb"></i> Enviar nova senha </button>
														</div>
													</fieldset>
												</form>
											</div>
											<div class="toolbar center">
												<a href="#" onclick="show_box('login-box'); return false;" class="back-to-login-link"> Voltar ao login <i class="icon-arrow-right"></i> </a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--[if !IE]> --><script type="text/javascript"> window.jQuery || document.write("<script src='<?=URL_PAINEL_TEMPLATE?>assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>"); </script><!-- <![endif]-->
			<!--[if IE]> <script type="text/javascript"> window.jQuery || document.write("<script src='<?=URL_PAINEL_TEMPLATE?>assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>"); </script> <![endif]-->
			<script type="text/javascript"> if("ontouchend" in document) document.write("<script src='<?=URL_PAINEL_TEMPLATE?>assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>"); </script>
			<script type="text/javascript"> function show_box(id) {jQuery('.widget-box.visible').removeClass('visible'); jQuery('#'+id).addClass('visible'); } </script>
		</body>
	</html>
<?php }else{
	$_SESSION['LANG'] = (empty($_SESSION['LANG']) ? 'bra_' : $_SESSION['LANG']);
	$url_explode = explode('/', $Administradores->getUrl());
	if(count($url_explode)==2&&$url_explode[0]=='lang'):
		list($sistema,$parametro) = $url_explode;
		switch ($parametro):
		    case 'bra':
		       	$_SESSION['LANG'] = $parametro.'_';
		        break;
		    case 'usa':
		        $_SESSION['LANG'] = $parametro.'_';
		        break;
		    case 'esp':
		        $_SESSION['LANG'] = $parametro.'_';
		        break;
		    default: 
		    	$_SESSION['LANG'] = 'bra_'; 
		endswitch;
		$Administradores->redirect(URL_PAINEL);
	endif; ?>
	<!DOCTYPE html>
	<html lang="pt-br">
		<head>
			<meta charset="utf-8" />
			<title>GV8 CMS</title>
			<meta name="viewport" content="width=device-width, initial-scale=1.0" />
			<link rel="stylesheet" href="<?=URL_PAINEL_TEMPLATE?>assets/css/ace-fonts.min.css" />
			<link href="<?=URL_PAINEL_TEMPLATE?>assets/css/bootstrap.min.css" rel="stylesheet" />
			<link rel="stylesheet" href="<?=URL_PAINEL_TEMPLATE?>assets/css/font-awesome.min.css" />
			<!--[if IE 7]> <link rel="stylesheet" href="<?=URL_PAINEL_TEMPLATE?>assets/css/font-awesome-ie7.min.css" /> <![endif]-->
			<link rel="stylesheet" href="<?=URL_PAINEL_TEMPLATE?>assets/css/ace.min.css" />
			<link rel="stylesheet" href="<?=URL_PAINEL_TEMPLATE?>assets/css/ace-rtl.min.css" />
			<link rel="stylesheet" href="<?=URL_PAINEL_TEMPLATE?>assets/css/ace-skins.min.css" />
			<link rel="stylesheet" href="<?=URL_PAINEL_TEMPLATE?>assets/css/main.min.css" />
			<!--[if lte IE 8]> <link rel="stylesheet" href="<?=URL_PAINEL_TEMPLATE?>assets/css/ace-ie.min.css" /> <![endif]-->
			<!--[if lt IE 9]> <script src="<?=URL_PAINEL_TEMPLATE?>assets/js/html5shiv.min.js"></script> <script src="<?=URL_PAINEL_TEMPLATE?>assets/js/respond.min.js"></script> <![endif]-->
			<!--[if !IE]> --> <script type="text/javascript"> window.jQuery || document.write("<script src='<?=URL_PAINEL_TEMPLATE?>assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>"); </script> <!-- <![endif]-->
			<!--[if IE]> <script type="text/javascript"> window.jQuery || document.write("<script src='assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>"); </script> <![endif]-->
			<script type="text/javascript"> if("ontouchend" in document) document.write("<script src='<?=URL_PAINEL_TEMPLATE?>assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>"); </script>
			<script src="<?=URL_PAINEL_TEMPLATE?>assets/js/bootstrap.min.js"></script>
			<script src="<?=URL_PAINEL_TEMPLATE?>assets/js/typeahead-bs2.min.js"></script>
			<!--[if lte IE 8]> <script src="<?=URL_PAINEL_TEMPLATE?>assets/js/excanvas.min.js"></script> <![endif]-->
			<script src="<?=URL_PAINEL_TEMPLATE?>assets/js/jquery-ui-1.10.3.custom.min.js"></script>
			<script src="<?=URL_PAINEL_TEMPLATE?>assets/js/ace-elements.min.js"></script>
			<script src="<?php echo URL_PAINEL_TEMPLATE; ?>assets/js/jquery.form.min.js"></script>
			<script src="<?=URL_PAINEL_TEMPLATE?>assets/js/ace.min.js"></script>
			<script type="text/javascript" src="<?=URL_PAINEL_TEMPLATE?>ckeditor/ckeditor.js"></script>
		</head>
		<body>
			<div class="navbar navbar-default" id="navbar">
				<div class="navbar-container" id="navbar-container">
					<div class="navbar-header pull-left"><a href="<?=URL_PAINEL?>inicial" class="navbar-brand"><i class="logo-menor"></i></a></div>
					<div class="navbar-header pull-right" role="navigation">
						<ul class="nav ace-nav">
							<li style="border:none;"><a class="no-bg" style="border:none;"><span class="user-info" style="border:none;"><small>Muito bem vindo</small> <?php echo $_SESSION['admin']; ?>!</span></a></li>
							<li style="border:none;"><a class="no-bg" title="Sair do Painel" href="<?=URL_PAINEL?>sair"><div class="btn btn-xs btn-danger"><i class="icon icon-sign-out"></i></div></a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="main-container" id="main-container">
				<div class="main-container-inner">
					<a class="menu-toggler" id="menu-toggler" href="#"><span class="menu-text"></span></a>
					<div class="sidebar" id="sidebar">
						<ul class="nav nav-list">
							
							<?php $sistemas = array(); 
							$sistemas[] = array('url' => 'administradores', 'nome' => 'Administradores', 'page' => false ); 
							$sistemas[] = array('url' => 'configuracoes', 'nome' => 'Configurações do site', 'page' => false ); 
							$sistemas[] = array('url' => 'images', 'nome' => 'Imagens para o editor', 'page' => false ); 
							$Administradores->criar_menu_painel_item('Administração',true,$sistemas,array(1,2,3));  ?>   

							<?php $sistemas = array(); 
							$sistemas[] = array('url' => 'banners', 'nome' => 'Banners', 'page' => false );  
							$sistemas[] = array('url' => 'texto-1', 'nome' => 'Texto 1', 'page' => true );   
							$sistemas[] = array('url' => 'newsletters', 'nome' => 'Newsletters', 'page' => false );
							$sistemas[] = array('url' => 'texto-2', 'nome' => 'Texto 2', 'page' => true );   
							$sistemas[] = array('url' => 'texto-3', 'nome' => 'Texto 3', 'page' => true );   
							$sistemas[] = array('url' => 'texto-4', 'nome' => 'Texto 4', 'page' => true );   
							$sistemas[] = array('url' => 'texto-5', 'nome' => 'Texto 5', 'page' => true );
							$sistemas[] = array('url' => 'texto-6', 'nome' => 'Texto 6', 'page' => true );   
							$Administradores->criar_menu_painel_item('Pagina inicial',true,$sistemas,array(1,2,3)); ?>

							<?php $sistemas = array('url' => 'empresa', 'nome' => 'Empresa', 'page' => true );
							$Administradores->criar_menu_painel_item('Empresa',false,$sistemas,array(1,2,3)); ?>

							<?php $sistemas = array();   
							$sistemas[] = array('url' => 'produtos', 'nome' => 'Texto', 'page' => true );    
							$sistemas[] = array('url' => 'produtos', 'nome' => 'Cadastros', 'page' => false );   
							$Administradores->criar_menu_painel_item('Produtos',true,$sistemas,array(1,2,3)); ?> 

							<?php $sistemas = array();   
							$sistemas[] = array('url' => 'servicos', 'nome' => 'Texto', 'page' => true );    
							$sistemas[] = array('url' => 'servicos', 'nome' => 'Cadastros', 'page' => false );   
							$Administradores->criar_menu_painel_item('Serviços',true,$sistemas,array(1,2,3)); ?> 

							<?php $sistemas = array();   
							$sistemas[] = array('url' => 'fotos', 'nome' => 'Texto', 'page' => true );    
							$sistemas[] = array('url' => 'fotos', 'nome' => 'Cadastros', 'page' => false );   
							$Administradores->criar_menu_painel_item('Fotos',true,$sistemas,array(1,2,3)); ?> 

							<?php $sistemas = array();   
							$sistemas[] = array('url' => 'clientes', 'nome' => 'Texto', 'page' => true );    
							$sistemas[] = array('url' => 'clientes', 'nome' => 'Cadastros', 'page' => false );   
							$Administradores->criar_menu_painel_item('Clientes',true,$sistemas,array(1,2,3)); ?>

							<?php $sistemas = array();   
							$sistemas[] = array('url' => 'contato', 'nome' => 'Texto', 'page' => true );     
							$sistemas[] = array('url' => 'contatos', 'nome' => 'E-mails', 'page' => false );    
							$Administradores->criar_menu_painel_item('Contato',true,$sistemas,array(1,2,3)); ?>
							
						</ul>
					</div>
					<div class="main-content">
						<div class="breadcrumbs" id="breadcrumbs">
							<ul class="breadcrumb"> </ul>
							<div class="data-atual"><?php echo strftime("%A, %d de %B de %Y", strtotime( date("Y/m/d") )); ?></div>
						</div>
						<div class="page-content">
							<div class="row">
	                        	<?php $Administradores->routes(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</body>
	</html>
<?php } ?>
<!DOCTYPE html> 
<html lang="pt-br"> 
    <head> 
        <meta charset="utf-8"> 
        <meta http-equiv="x-ua-compatible" content="ie=edge"> 
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <meta name="description" content="WSK"> 
        <meta name="msapplication-tap-highlight" content="no"> 
        <meta name="msapplication-TileColor" content="#bd1e33"> 
        <meta name="theme-color" content="#bd1e33"> 
        <meta name="apple-mobile-web-app-status-bar-style" content="#bd1e33"> 
        <meta name="mobile-web-app-capable" content="yes"> 
        <meta name="application-name" content="<?php echo $titulo_do_site ?>"> 
        <meta name="apple-mobile-web-app-capable" content="yes"> 
        <meta name="apple-mobile-web-app-title" content="<?php echo $titulo_do_site ?>"> 
        <link rel="apple-touch-icon" href="<?php echo $Conexao->generate_image_src('configuracoes',180,180,$favicon,'redimencionar'); ?>"> 
        <link rel="canonical" href="<?php echo NAME_SITE; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo URL_SITE_TEMPLATE; ?>assets/css/estilos.css"> 
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo $Conexao->generate_image_src('configuracoes',30,30,$favicon,'redimencionar'); ?>"> 
        <?php $routes = array();
        $routes['home'] = array('table' => 'configuracoes');  

        $routes['empresa'] = array('table' => 'paginas', 'title' => 'nome_do_menu'); 

        $routes['produtos'] = array('table' => 'paginas', 'title' => 'nome_do_menu'); 
        $routes['produtos/page/{number}'] = array('table' => 'paginas', 'title' => 'nome_do_menu'); 
        $routes['produtos/{url}'] = array('table' => 'produtos', 'title' => 'nome');

        $routes['servicos'] = array('table' => 'paginas', 'title' => 'nome_do_menu'); 
        $routes['servicos/page/{number}'] = array('table' => 'paginas', 'title' => 'nome_do_menu'); 
        $routes['servicos/{url}'] = array('table' => 'servicos', 'title' => 'nome');        

        $routes['fotos'] = array('table' => 'paginas', 'title' => 'nome_do_menu'); 
        $routes['fotos/page/{number}'] = array('table' => 'paginas', 'title' => 'nome_do_menu'); 
        $routes['fotos/{url}'] = array('table' => 'fotos', 'title' => 'nome');  

        $routes['clientes'] = array('table' => 'paginas', 'title' => 'nome_do_menu'); 
        $routes['clientes/page/{number}'] = array('table' => 'paginas', 'title' => 'nome_do_menu');

        $routes['contato'] = array('table' => 'paginas', 'title' => 'nome_do_menu'); 

        $Conexao->get_headers($configuracoes, $routes); ?>
        <link rel="stylesheet" type="text/css" href="<?php echo URL_PAINEL_TEMPLATE?>assets/css/stylesbackend.css">
    </head> 
    <body> 
        <?php $Conexao->get_code_body($configuracoes); ?> 
        <noscript> 
            <style> .alert-warning {border-radius: 0; background: #FFB300; position: sticky; z-index: 1000; top: 0; } </style> 
            <div class="alert alert-warning text-center alert-noscript" role="alert"> 
                <h1>Seu navegador está com os scripts desabilitados!</h1> 
                <p>Para melhor funcionamento do site, habilite-os.</p> 
            </div> 
        </noscript> 
        <!-- [if lt IE 9]> <style>.msg-ie{border-radius:0; background: #FFB300; position: sticky; z-index:1000; top:0;}</style> <div class="alert alert-warning msg-ie text-center" role="alert"> <button class="close" type="button" aria-label="Close" data-dismiss="alert"> <span aria-hidden="true">&times;</span> </button> <h4 class="h1 alert-heading">Atenção!!!</h4> <p> O seu navegador está desatualizado! Para melhor funcionamento do site clique <a href="https://support.microsoft.com/pt-br/help/17621/internet-explorer-downloads" class="alert-link">aqui</a> para atualizar, ou instale o <a href="https://www.google.com/chrome/browser/desktop/index.html" class="alert-link">Google Chrome</a> </p> </div> <![endif] --> 
        <div id="app"> 
            <header class="topo">
                <?php if (!empty($telefone_1_do_topo) || !empty($telefone_2_do_topo) || !empty($e_mail_do_topo)): ?>
                    <div class="faixa-topo"> 
                        <div class="container"> 
                            <?php if (!empty($telefone_1_do_topo)): ?>
                                <div class="telefone"><i class="fas fa-phone"></i> <?php echo $telefone_1_do_topo; ?></div> 
                            <?php endif; ?>
                            <?php if (!empty($telefone_2_do_topo)): ?>
                                <div class="whatsapp"><i class="fab fa-whatsapp"></i> <?php echo $telefone_2_do_topo; ?></div> 
                            <?php endif; ?>
                            <?php if (!empty($e_mail_do_topo)): ?>
                                <div class="email"><i class="fas fa-envelope"></i> <a href="mailto:<?php echo $e_mail_do_topo; ?>"><?php echo $e_mail_do_topo; ?></a></div> 
                            <?php endif; ?>
                        </div> 
                    </div> 
                <?php endif; ?>
                <nav class="mobile-controls"> 
                    <button class="btn btn-toggle-menu" data-toggle="menu" aria-label="Menu" type="button">
                        <i class="bars"></i>
                        <span class="sr-only">MENU</span>
                    </button>
                    <a class="brand" href="<?php echo(URL_SITE); ?>">
                        <img class="img-fluid" src="<?php echo $Conexao->generate_image_src('configuracoes',326,130,$logo,'redimencionar'); ?>" alt="Logo">
                    </a> 
                </nav> 
                <nav class="main-menu"> 
                    <div class="content"> 
                        <figure class="brand">
                            <a class="brand" href="<?php echo(URL_SITE); ?>">
                                <img class="img-fluid" src="<?php echo $Conexao->generate_image_src('configuracoes',326,130,$logo,'redimencionar'); ?>" alt="Logo">
                            </a>
                        </figure> 
                        <ul class="menu"> 
                            <li<?php echo ($Conexao->is_home()?' class="active"':''); ?>><a href="<?php echo URL_SITE.'home' ?>">HOME</a></li>
                            <?php $query = $Conexao->query('SELECT nome_do_menu,url,id FROM '.$_SESSION['LANG'].'paginas WHERE id IN (7,8,9,10,11,12)')->fetch();
                            if ($Conexao->affected_rows > 0): 
                                foreach ($query as $index => $data):
                                    extract($data);
                                    if ($menus[$id]): ?>
                                        <li<?php echo ($sistema==$url)?' class="active"':'' ?>>
                                            <a href="<?php echo URL_SITE.$url; ?>"> 
                                                <?php echo mb_convert_case($nome_do_menu, MB_CASE_UPPER, "UTF-8"); ?>
                                            </a>
                                        </li>  
                                    <?php endif;
                                endforeach;
                            endif; ?> 
                        </ul> 
                    </div> 
                </nav> 
            </header> 
            <div class="wrapper">
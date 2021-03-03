<?php $id = 7;
if ($menus[$id]):
    $query_paginas = $Conexao->select('nome_do_menu,titulo,subtitulo,resumo,outro_titulo,descricao')->from(PREFIX.$_SESSION['LANG'].'paginas')->where('id='.$id)->order_by('id','ASC')->fetch_first();
    if ($Conexao->affected_rows > 0): 
        extract($query_paginas); ?> 
        <main class="empresa" id="modelo-2"> 
            <div class="page-header"> 
                <div class="container"> 
                    <h1><?php echo $titulo; ?></h1> 
                    <ol class="breadcrumb"> 
                        <li><a href="<?php echo URL_SITE.'home' ?>">Home</a></li> 
                        <li class="active"><span><?php echo mb_convert_case($nome_do_menu, MB_CASE_TITLE, "UTF-8"); ?></span></li> 
                    </ol> 
                </div> 
            </div> 
            <div class="container"> 
                <div class="row justify-content-between"> 
                    <div class="col-xl-12 mgb-30"> 
                        <h2><?php echo $subtitulo; ?></h2> 
                        <?php echo $resumo; ?>
                    </div> 
                </div> 
            </div> 
            <?php if (!empty($outro_titulo)||!empty($descricao)): ?>
                <section class="nossa-equipe"> 
                    <div class="container"> 
                        <h2><?php echo nl2br($outro_titulo); ?></h2> 
                        <?php echo $descricao; ?>
                    </div> 
                </section> 
            <?php endif; ?>
        </main>
    <?php else:
        require_once(PATH_TEMPLATE.'404.php');
    endif; 
else:
        require_once(PATH_TEMPLATE.'404.php');
endif; ?>
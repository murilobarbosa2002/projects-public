<main class="wrapper">
    <div class="internas empresa" id="modelo-2">
        <div class="page-header">
            <div class="container">
                <h1>EMPRESA</h1>
                <ol class="breadcrumbs">
                    <li>
                        <a href="<?=URL_SITE.'home'?>">HOME</a>
                    </li>
                    <li>
                        <span>EMPRESA</span>
                    </li>
                </ol>
            </div>
        </div>
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-xl-7 mgb-30">
                    <h2><?=$Conexao->get_custom_by('titulo','paginas',array('url' => 'empresa'))?></h2>
                    <p>&nbsp;</p>
                    <p style="text-align:justify;"><?=$Conexao->get_custom_by('descricao_sobre_nos','paginas',array('url' => 'empresa'))?></p>
                </div>
                <div class="col-xl-5 align-self-end img-girl">


                    <?php $pegaImagem = $Conexao->get_custom_by('imagem','paginas',array('url' => 'empresa'));
                    if (!empty($pegaImagem)): ?>
                    <lazyimage src="<?php echo $Conexao->generate_image_src('paginas',436,464,$pegaImagem,'redimencionar'); ?>" width="436" height="464"></lazyimage>
                    <?php endif; ?>

                </div>
            </div>
        </div>
        <section class="nossa-equipe">
            <div class="container">

                <h2><?=$Conexao->get_custom_by('titulo_dois_empresa','paginas',array('url' => 'empresa'))?></h2>

                <?=$Conexao->get_custom_by('descricao_dois_sobre','paginas',array('url' => 'empresa'))?>
            </div>
        </section>
    </div>
</main>
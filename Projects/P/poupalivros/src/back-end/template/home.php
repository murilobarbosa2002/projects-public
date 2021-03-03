<main class="wrapper">

    <?php $query = $Conexao->select('nome,href,target,imagem')->from(PREFIX.$_SESSION['LANG'].'banners')->where('status=1')->order_by('ABS(ordem)','ASC')->fetch();
    if ($Conexao->affected_rows > 0):  ?>
    <div class="carousel slide carousel-fade" id="banner" data-interval="5000" data-ride="carousel">
        <div class="carousel-inner">
            <?php foreach ($query as $key => $base):
            extract($base,EXTR_OVERWRITE);
            if (!empty($imagem)):
            if (!empty($href)):
            $href = ' href="'.$href.'"';
            if (!empty($target)) {
                $href .= ' target="'.$target.'"';
            } ?>
            <!-- manifest-->
            <div class="carousel-item<?php echo($key==0?' active':''); ?>">
                <a <?=$href;?>>
                <lazy-image src="<?php echo $Conexao->generate_image_src('banners',1110,663,$imagem,'cortar'); ?>" style="--width: 1110;--height: 663;" alt="Banner"></lazy-image>
                </a>
            </div>
            <?php else: ?>
            <!-- add to home screen (ios)-->
            <!-- add to home screen (chrome)-->
            <div class="carousel-item<?php echo($key==0?' active':''); ?>">
                <a <?=$href;?>>
                <lazy-image src="<?php echo $Conexao->generate_image_src('banners',1110,663,$imagem,'cortar'); ?>" style="--width: 1110;--height: 663;" alt="Banner"></lazy-image>
                </a>
            </div>
            <!-- Tile icon for Win8 (144x144 + tile color)-->
            <?php endif;
            endif;
            endforeach; ?>
        </div>


        <div class="controles">
           <?php if ($Conexao->affected_rows >=2):  ?>
            <a class="prev" href="#banner" role="button" aria-label="Anterior" arai-controls="#banner" data-slide="prev">
                <i class="fas fa-chevron-left"></i>
            </a>
            <a class="next" href="#banner" role="button" aria-label="Próximo" arai-controls="#banner" data-slide="next">
                <i class="fas fa-chevron-right"></i>
            </a>
            <?php endif; ?>
        </div>

    </div>
    <?php endif; ?>

    <section class="ultimas-noticias">
        <div class="container">
            <hgroup class="title-section">
                <h1><?=$Conexao->get_custom_by('titulo','paginas',array('url' => 'texto-1-home'))?></h1>
                <h2><?=$Conexao->get_custom_by('titulo_dois_empresa','paginas',array('url' => 'texto-1-home'))?></h2>
            </hgroup>




            <div class="owl-carousel" data-lg="3" data-md="2" data-autoplay="true" data-nav="true" data-margin="30" data-loop="true">


                <?php $resultados = $Conexao->select('categoria,categoria,nome,url,imagem,descritivo,data')->from(PREFIX . $_SESSION['LANG'] . 'noticias')->where('status = 1')->order_by('ABS(id)', 'DESC')->fetch();
                if($Conexao->affected_rows>0){ ?>
                <?php foreach($resultados as $resultado){
                extract($resultado);?>

                <?php $query = $Conexao->select('nome')->from(PREFIX.$_SESSION['LANG'].'cadastrar_categoria')->where('id = '.$categoria)->order_by('id','ASC')->fetch_first();
                if (isset($query)) {
                extract($query, EXTR_PREFIX_ALL, 'cat'); } ?>

                <article class="post-thumbnail">
                    <div class="foto">
                        <lazy-image src="<?php echo $Conexao->generate_image_src('noticias',350,350,$imagem,'cortar'); ?>" alt="<?=$nome;?>" style="--width: 350;--height: 350;"></lazy-image>
                    </div>
                    <div class="content">
                        <h3 class="nome"><?=$nome;?></h3>
                        <div class="details">
                            <div class="data">
                                <time datatime="07-10-2019"><?=$data;?></time>
                            </div>
                            <div class="tags">
                                <span aria-label="categoria post"><?=$cat_nome;?></span>
                            </div>
                        </div>
                        <div class="desc"><?=$descritivo;?></div>
                        <a class="ver-detalhes" href="<?php echo URL_SITE.'categoria-detalhe/'.$url; ?>">LEIA MAIS
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </article>
                    <?php }
                } ?>

            </div>




        </div>
    </section>



    <section class="posts-importantes">
        <div class="container">
            <hgroup class="title-section">
                <h1><?=$Conexao->get_custom_by('titulo','paginas',array('url' => 'texto-2-home'))?></h1>
                <h2><?=$Conexao->get_custom_by('titulo_dois_empresa','paginas',array('url' => 'texto-2-home'))?></h2>
            </hgroup>

            <div class="row">
                <div class="col-xl-6 mgb-30">

                    <?php $resultados = $Conexao->query('SELECT * FROM '.$_SESSION['LANG'].'noticias WHERE destaque = 1 AND status = 1  ORDER BY ABS(ordem) ASC LIMIT 0,1')->fetch();
                    if($Conexao->affected_rows>0){ ?>
                    <?php foreach($resultados as $resultado){
                    extract($resultado); ?>

                    <?php $query = $Conexao->select('nome')->from(PREFIX.$_SESSION['LANG'].'cadastrar_categoria')->where('id = '.$categoria)->order_by('id','ASC')->fetch_first();
                    if (isset($query)) {
                        extract($query, EXTR_PREFIX_ALL, 'cat');
                    } ?>
                    <article class="post-thumbnail post-g">
                        <div class="foto">
                            <lazy-image src="<?php echo $Conexao->generate_image_src('noticias',540,540,$imagem,'cortar'); ?>" alt="Titulo da noticia" style="--width: 540;--height: 540;"></lazy-image>
                        </div>
                        <div class="content">
                            <h3 class="nome"><?=$nome;?></h3>
                            <div class="details">
                                <div class="data">
                                    <time datatime="07-10-2019"><?=$data;?></time>
                                </div>
                                <div class="tags">
                                    <span aria-label="categoria post"><?=$cat_nome;?></span>
                                </div>
                            </div>
                            <div class="desc"><?=$descritivo;?></div>
                            <a class="ver-detalhes" href="<?php echo URL_SITE.'categoria-detalhe/'.$url; ?>">LEIA MAIS
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </article>
                        <?php }?>
                    <?php }?>

                </div>


                <div class="col-xl-6 mgb-30">


                    <?php $resultados = $Conexao->query('SELECT * FROM '.$_SESSION['LANG'].'noticias WHERE destaque = 1 AND status = 1  LIMIT 1,100')->fetch();
                    if($Conexao->affected_rows>0){ ?>
                    <?php foreach($resultados as $resultado){
                    extract($resultado); ?>

                    <?php $query = $Conexao->select('nome')->from(PREFIX.$_SESSION['LANG'].'cadastrar_categoria')->where('id = '.$categoria)->order_by('id','ASC')->fetch_first();
                    if (isset($query)) {
                        extract($query, EXTR_PREFIX_ALL, 'cat');
                    } ?>
                    <article class="media post-thumbnail-horizontal">
                        <div class="foto">
                            <lazy-image src="<?php echo $Conexao->generate_image_src('noticias',160,160,$imagem,'cortar'); ?>" alt="Titulo do post" style="--width: 160;--height: 160"></lazy-image>
                        </div>
                        <div class="media-body">
                            <h3 class="nome"><?=$nome;?></h3>
                            <div class="details">
                                <div class="data">
                                    <time datatime="07-10-2019"><?=$data;?></time>
                                </div>
                                <div class="tags">
                                    <span aria-label="categoria post"><?=$cat_nome;?></span>
                                </div>
                            </div>
                            <div class="desc"><?=$descritivo;?></div>
                            <a class="ver-detalhes" href="<?php echo URL_SITE.'categoria-detalhe/'.$url; ?>">LEIA MAIS
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </article>
                    <?php } ?>
                <?php } ?>

                </div>


            </div>


        </div>
    </section>


    <div class="fique-por-dentro">
        <div class="container">
            <div class="row">
                <section class="col-xl-8">
                    <hgroup class="title-section">
                        <h1><?=$Conexao->get_custom_by('titulo','paginas',array('url' => 'texto-3-home'))?></h1>
                        <h2><?=$Conexao->get_custom_by('titulo_dois_empresa','paginas',array('url' => 'texto-3-home'))?></h2>
                    </hgroup>



                    <div class="row">


                        <?php $resultados = $Conexao->query('SELECT * FROM '.$_SESSION['LANG'].'noticias WHERE destaque_bloco_2 = 1 AND status = 1')->fetch();
                        if($Conexao->affected_rows>0){ ?>
                        <?php foreach($resultados as $resultado){
                        extract($resultado); ?>

                        <?php $query = $Conexao->select('nome')->from(PREFIX.$_SESSION['LANG'].'cadastrar_categoria')->where('id = '.$categoria)->order_by('id','ASC')->fetch_first();
                        if (isset($query)) {
                            extract($query, EXTR_PREFIX_ALL, 'cat');
                        } ?>
                        <div class="col-md-6 mgb-30">
                            <article class="post-thumbnail">
                                <div class="foto">
                                    <lazy-image src="<?php echo $Conexao->generate_image_src('noticias',350,350,$imagem,'cortar'); ?>" alt="<?=$nome;?>" style="--width: 350;--height: 350;"></lazy-image>
                                </div>
                                <div class="content">
                                    <h3 class="nome"><?=$nome;?></h3>
                                    <div class="details">
                                        <div class="data">
                                            <time datatime="07-10-2019"><?=$data;?></time>
                                        </div>
                                        <div class="tags">
                                            <span aria-label="categoria post"><?=$cat_nome;?></span>
                                        </div>
                                    </div>
                                    <div class="desc"><?=$descritivo;?></div>
                                    <a class="ver-detalhes" href="<?php echo URL_SITE.'categoria-detalhe/'.$url; ?>">LEIA MAIS
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </article>
                        </div>
                            <?php } ?>
                        <?php } ?>

                    </div>



                </section>
                <div class="col-xl-4">
                    <aside class="sidebar">
                        <div class="block">
                            <div class="block-head"><?=$Conexao->get_custom_by('titulo','paginas',array('url' => 'titulo-categorias'))?></div>


                            <div class="block-body">
                                <ol class="categorias">

                                    <?php $resultados = $Conexao->query("SELECT $_SESSION[LANG]cadastrar_categoria.nome, $_SESSION[LANG]cadastrar_categoria.url, count($_SESSION[LANG]cadastrar_categoria.id) as quantidade FROM $_SESSION[LANG]cadastrar_categoria, $_SESSION[LANG]noticias WHERE $_SESSION[LANG]cadastrar_categoria.status = 1 AND $_SESSION[LANG]cadastrar_categoria.id = $_SESSION[LANG]noticias.categoria AND $_SESSION[LANG]noticias.status = 1 GROUP BY $_SESSION[LANG]cadastrar_categoria.id")->fetch();
                                    if($Conexao->affected_rows>0){
                                        foreach($resultados as $resultado){
                                            extract($resultado);?>
                                    <li>
                                        <a href="<?php echo URL_SITE.'categoria/'.$url; ?>">
                                            <span class="badge"><?=$quantidade;?></span><?=$nome;?></a>
                                    </li>
                                    <?php }
                                    }?>
                                </ol>
                            </div>


                        </div>
                        <div class="block newsletter">
                            <div class="block-head"><?=$Conexao->get_custom_by('titulo','paginas',array('url' => 'titulo-newsletter'))?></div>
                            <div class="block-body">

                                <form id="newsletters" method="post" action="<?php echo URL_SITE.'ajax/newsletter.php' ?>">
                                    <p><?=$Conexao->get_custom_by('descritivo','paginas',array('url' => 'titulo-newsletter'))?></p>
                                    <label class="sr-only" for="newsletter">Seu email</label>
                                    <div class="input-group">
                                        <input class="form-control" type="email" name="email" id="email" placeholder="Seu email..." />
                                        <button class="btn btn-newsletter" role="button" aria-label="Cadastrar">
                                            <span class="sr-only">Cadastrar</span>
                                            <svg class="svg-icon">
                                                <use xlink:href="#send-button"></use>
                                            </svg>
                                        </button>
                                    </div>
                                </form>


                            </div>
                        </div>



                        <?php $resultados = $Conexao->query("SELECT ano,id FROM $_SESSION[LANG]noticias WHERE status = 1 GROUP BY ano ORDER BY ano ASC")->fetch();
                        if($Conexao->affected_rows>0){?>
                        <div class="block">
                            <div class="block-head"><?=$Conexao->get_custom_by('titulo','paginas',array('url' => 'titulo-arquivos'))?></div>
                            <div class="block-body">
                                <ol class="categorias">


                                    <?php foreach($resultados as $key => $resultado){
                                        extract($resultado);?>
                                    <li>
                                        <a role="button" data-toggle="collapse" data-target="#arquivos-<?=$key;?>" aria-expanded="false" aria-label="Arquivos de <?=$ano;?>"><?=$ano;?></a>
                                        <ol class="collapse" id="arquivos-<?=$key;?>">


                                        <?php
                                        $where = 'ano='.$ano.' AND YEAR(data) <= DATE(NOW())';
                                        $resultados = $Conexao->select('data,COUNT(id) AS total')->from(PREFIX.$_SESSION['LANG'].'noticias')->where($where)->group_by('MONTH(data)')->order_by('data','DESC')->fetch();
                                        if ($Conexao->affected_rows > 0) : ?>
                                            <?php foreach ($resultados as $key => $resultado) {
                                            extract($resultado);
                                            $nome = utf8_encode(strftime("%B", strtotime($data))); 
                                            if ($nome == 'março'){
                                                $url = 'marco';
                                            }
                                            ?>
                                            <li>
                                                <a href="<?php echo URL_SITE.'arquivos'.'/'.$ano.'/'.strtolower($url); ?>">
                                                    <span class="badge"><?=$total;?></span><?php echo ucfirst($nome); ?></a>
                                            </li>
                                            <?php } ?>
                                        <?php endif; ?>
                                        </ol>
                                    </li>
                                    <?php }?>


                                </ol>
                            </div>
                        </div>
                        <?php }?>

                    </aside>
                    <div class="banner">
                        <?php $query_paginas = $Conexao->select('imagem_dois,href')->from(PREFIX.$_SESSION['LANG'].'paginas')->where('url = "publicidade"')->fetch();
                        if (isset($query_paginas[0])):
                            extract($query_paginas[0],EXTR_OVERWRITE);   ?>
                        <?php if (!empty($href)):?>
                        <a href="<?=$href;?>">
                        <lazy-image src="<?php echo $Conexao->generate_image_src('paginas',350,206,$imagem_dois,'redimencionar'); ?>" style="--width: 350;--height: 206;"></lazy-image>
                        </a>
                        <?php endif;?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
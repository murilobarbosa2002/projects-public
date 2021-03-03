<?php if ($_SERVER["REQUEST_URI"]=='/blog/categoria'or$_SERVER["REQUEST_URI"]=='/blog/categoria/page/1'or$_SERVER["REQUEST_URI"]=='/blog/categoria/page/2'or$_SERVER["REQUEST_URI"]=='/blog/categoria/page/3'or$_SERVER["REQUEST_URI"]=='/blog/categoria/page/4'or$_SERVER["REQUEST_URI"]=='/blog/categoria/page/5'or$_SERVER["REQUEST_URI"]=='/blog/categoria/page/6'or$_SERVER["REQUEST_URI"]=='/blog/categoria/page/7'or$_SERVER["REQUEST_URI"]=='/blog/categoria/page/8'or$_SERVER["REQUEST_URI"]=='/blog/categoria/page/9'or$_SERVER["REQUEST_URI"]=='/blog/categoria/page/10'or$_SERVER["REQUEST_URI"]=='/blog/categoria/page/11'or$_SERVER["REQUEST_URI"]=='/blog/categoria/page/12'or$_SERVER["REQUEST_URI"]=='/blog/categoria/page/13'or$_SERVER["REQUEST_URI"]=='/blog/categoria/page/14'or$_SERVER["REQUEST_URI"]=='/blog/categoria/page/15'or$_SERVER["REQUEST_URI"]=='/blog/categoria/page/16'or$_SERVER["REQUEST_URI"]=='/blog/categoria/page/17'or$_SERVER["REQUEST_URI"]=='/blog/categoria/page/18'or$_SERVER["REQUEST_URI"]=='/blog/categoria/page/19'or$_SERVER["REQUEST_URI"]=='/blog/categoria/page/20'): ?>

<main class="wrapper">
    <div class="internas">
        <div class="page-header">
            <div class="container">
                <h1>CATEGORIA</h1>
                <ol class="breadcrumbs">
                    <li>
                        <a href="<?php echo URL_SITE.'home' ?>">HOME</a>
                    </li>
                    <li>
                        <span>CATEGORIA</span>
                    </li>
                </ol>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <section class="col-lg-8 mgb-30">

                    <?php $where = '';
                    $Conexao->select('id')->from(PREFIX.$_SESSION['LANG'].'noticias')->where('status=1')->fetch();
                    $num_row = $Conexao->affected_rows;
                    $numero_items = 4;
                    $urlpagination = URL_SITE.'categoria/';
                    $total_pages = round($num_row / $numero_items);
                    $page_actual = 1;
                    $page = $final_url;
                    if (isset($page) && is_numeric($page)) $page_actual = intval($page);
                    $begin = ($page_actual-1) * $numero_items;
                    $query = $Conexao->select('categoria,nome,descritivo, url, imagem, data')->from($_SESSION['LANG'].'noticias')->where('status = 1')->limit($numero_items,$begin)->order_by('id','ASC')->fetch();
                    if ($Conexao->affected_rows > 0) : ?>
                    <div class="row">
                        <?php foreach ($query as $data):
                            extract($data); ?>


                            <?php $query = $Conexao->select('nome')->from(PREFIX.$_SESSION['LANG'].'cadastrar_categoria')->where('id = '.$categoria)->order_by('id','ASC')->fetch_first();
                            if (isset($query)) {
                                extract($query, EXTR_PREFIX_ALL, 'cat');
                            } ?>


                        <div class="col-md-6 mgb-30">
                            <article class="post-thumbnail">
                                <div class="foto">
                                    <lazy-image src="<?php echo $Conexao->generate_image_src('noticias',350,350,$imagem,'cortar'); ?>" alt="Titulo da noticia" style="--width: 350;--height: 350;"></lazy-image>
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
        <?php endforeach; ?>

                    </div>
                    <?php endif; ?>

                    <?php if ($total_pages>=1) {
                        $inicio = 1;
                        $fim = 10;
                        $ultima = ceil($num_row / $numero_items);
                        if($page_actual > 4) {
                            $inicio = $page_actual - 3;
                            $fim = $page_actual + 3;
                        }
                        if($fim>$ultima) $fim = $ultima;
                        if($fim > 7 && $inicio > ($fim-6)) $inicio = $fim - 6;
                        if($inicio < $fim) {?>
                            <paginacao>
                            <?php
                            $urlpagination = URL_SITE.'categoria/';

                            if($page_actual-1<1){
                                $prev=1;
                            }else{
                                $prev=$page_actual-1;
                            }

                            if($page_actual+1>$ultima){
                                $next=$ultima;
                            }else{
                                $next=$page_actual+1;
                            }?>
                            <page-item aria-label="Página anterior"><a href="<?=$urlpagination.'page/'.$prev;?>"><i class="fas fa-chevron-left"></i></a></page-item>
                            <?php for ($i=$inicio; $i<=$fim; $i++) {
                                if ($page_actual==$i){
                                    $class = 'active';
                                    $spanum = 'page-item';
                                    $spandois = 'page-item';
                                }else{
                                    $class = '';
                                    $spanum = 'page-item';
                                    $spandois = 'page-item';
                                }?>
                                <<?=$spanum;?>  <?=$class;?>><a href="<?=$urlpagination.'page/'.$i;?>"><?=$i;?></a></<?=$spanum;?>>
                            <?php }?>
                            <page-item aria-label="Próxima página"><a href="<?=$urlpagination.'page/'.$next;?>"><i class="fas fa-chevron-right"></i></a></page-item>
                            </paginacao>
                        <?php }
                    } ?>




                </section>
                <div class="col-lg-4 mgb-30">
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
                                                            $nome = utf8_encode(strftime("%B", strtotime($data))); ?>
                                                            <li>
                                                                <a href="<?php echo URL_SITE.'arquivos'.'/'.$ano.'/'.strtolower($nome); ?>">
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




<?php else: ?>





    <?php if (count($url_atual)==2||(in_array('page', $url_atual) && count($url_atual)==4)):
        $query = $Conexao->select('id,nome,url')->from(PREFIX.$_SESSION['LANG'].'cadastrar_categoria')->where('url = \''.$url_atual[1].'\' AND status = 1')->order_by('id','ASC')->fetch_first();
        if (isset($query)) {
            extract($query,EXTR_PREFIX_ALL,'cat');

        }else{
            require(PATH_TEMPLATE.'404.php');
            exit();
        } ?>
    <?php endif; ?>


    <?php $index_paginas = 0;
    $query_paginas = $Conexao->select('url')->from(PREFIX.$_SESSION['LANG'].'cadastrar_categoria')->where('url = \''.$url_atual[1].'\'')->fetch();
    if (isset($query_paginas[$index_paginas])):
        extract($query_paginas[$index_paginas],EXTR_OVERWRITE);   ?>
        <?php $nomeCat = $url; ?>
    <?php endif; ?>

<main class="wrapper">
    <div class="internas">
        <div class="page-header">
            <div class="container">
                <h1>CATEGORIA</h1>
                <ol class="breadcrumbs">
                    <li>
                        <a href="<?php echo URL_SITE.'home' ?>">HOME</a>
                    </li>
                    <li>
                        <span>CATEGORIA</span>
                    </li>
                </ol>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <section class="col-lg-8 mgb-30">




    <?php $where = '';
    $Conexao->select('id')->from(PREFIX.$_SESSION['LANG'].'noticias')->where('status=1 AND categoria='.$cat_id)->fetch();
    $num_row = $Conexao->affected_rows;
    $numero_items = 4;
    $total_pages = round($num_row / $numero_items);
    $page_actual = 1;
    $page = $final_url;
    if (isset($page) && is_numeric($page)) $page_actual = intval($page);
    $begin = ($page_actual-1) * $numero_items;
    $query_string = 'SELECT p.nome, p.descritivo, p.imagem, p.url, p.data, CONCAT("'.URL_SITE.'categoria/", c.url, "/", p.url) AS link FROM '.$_SESSION['LANG'].'noticias p LEFT JOIN '.$_SESSION['LANG'].'cadastrar_categoria c ON (c.id = p.categoria) WHERE p.status = 1 AND p.categoria='.$cat_id.' ORDER BY p.nome ASC LIMIT '.$begin.','.$numero_items;
    $query = $Conexao->query($query_string)->fetch();
    if ($Conexao->affected_rows > 0) : ?>
                    <div class="row">
        <?php foreach ($query as $data):
            extract($data); ?>

            <div class="col-md-6 mgb-30">
                <article class="post-thumbnail">
                    <div class="foto">
                        <lazy-image src="<?php echo $Conexao->generate_image_src('noticias',350,350,$imagem,'cortar'); ?>" alt="Titulo da noticia" style="--width: 350;--height: 350;"></lazy-image>
                    </div>
                    <div class="content">
                        <h3 class="nome"><?=$nome;?></h3>
                        <div class="details">
                            <div class="data">
                                <time datatime="07-10-2019"><?=$data;?></time>
                            </div>
                            <div class="tags">
                                <span aria-label="categoria post"><?php echo $nomeCat ?></span>
                            </div>
                        </div>
                        <div class="desc"><?=$descritivo;?></div>
                        <a class="ver-detalhes" href="<?php echo URL_SITE.'categoria-detalhe/'.$url; ?>">LEIA MAIS
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </article>
            </div>
        <?php endforeach; ?>

                    </div>
    <?php endif; ?>

                    <?php if ($total_pages>=1) {
                        $inicio = 1;
                        $fim = 10;
                        $ultima = ceil($num_row / $numero_items);
                        if($page_actual > 4) {
                            $inicio = $page_actual - 3;
                            $fim = $page_actual + 3;
                        }
                        if($fim>$ultima) $fim = $ultima;
                        if($fim > 7 && $inicio > ($fim-6)) $inicio = $fim - 6;
                        if($inicio < $fim) {?>
                            <paginacao>
                            <?php
                            $urlpagination = URL_SITE.'categoria/';

                            if($page_actual-1<1){
                                $prev=1;
                            }else{
                                $prev=$page_actual-1;
                            }

                            if($page_actual+1>$ultima){
                                $next=$ultima;
                            }else{
                                $next=$page_actual+1;
                            }?>
                            <page-item aria-label="Página anterior"><a href="<?=$urlpagination.$nomeCat.'/page/'.$prev;?>"><i class="fas fa-chevron-left"></a></i></page-item>
                            <?php for ($i=$inicio; $i<=$fim; $i++) {
                                if ($page_actual==$i){
                                    $class = 'active';
                                    $spanum = 'page-item';
                                    $spandois = 'page-item';
                                }else{
                                    $class = '';
                                    $spanum = 'page-item';
                                    $spandois = 'page-item';
                                }?>
                                <<?=$spanum;?>  <?=$class;?>><a href="<?=$urlpagination.$nomeCat.'/page/'.$i;?>"><?=$i;?></a></<?=$spanum;?>>
                            <?php }?>
                            <page-item aria-label="Próxima página"><a href="<?=$urlpagination.$nomeCat.'/page/'.$next;?>"><i class="fas fa-chevron-right"></i></a></page-item>
                            </paginacao>
                        <?php }
                    } ?>




                </section>
                <div class="col-lg-4 mgb-30">
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
                                                            $nome = utf8_encode(strftime("%B", strtotime($data))); ?>
                                                            <li>
                                                                <a href="<?php echo URL_SITE.'arquivos'.'/'.$ano.'/'.strtolower($nome); ?>">
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


<?php endif; ?>
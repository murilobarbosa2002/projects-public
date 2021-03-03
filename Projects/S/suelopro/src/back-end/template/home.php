<h1 class="sr-only"><?php echo $titulo_do_site; ?></h1> 
<?php $query = $Conexao->select('nome,href,target,imagem')->from(PREFIX.$_SESSION['LANG'].'banners')->where('status=1')->order_by('ABS(ordem)','ASC')->fetch(); 
if ($Conexao->affected_rows > 0):  ?> 
    <section class="banner-area"> 
        <div class="carousel slide carousel-fade" data-interval="5000" data-ride="carousel" id="banner"> 
            <div class="carousel-inner"> 
                <?php foreach ($query as $key => $base):
                    extract($base,EXTR_OVERWRITE);
                    if (!empty($imagem)):
                        if (!empty($href)): 
                            $href = ' href="'.$href.'"'; 
                            if (!empty($target)) { 
                                $href .= ' target="'.$target.'"'; 
                            } ?>
                            <div class="carousel-item<?php echo($key==0?' active':''); ?>">
                                <a<?php echo $href; ?> role="link" title="Detalhes">  
                                    <?php echo $Conexao->generate_lazy_image('banners',1140,680,$imagem,'redimencionar',$nome); ?> 
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="carousel-item<?php echo($key==0?' active':''); ?>"> 
                                <?php echo $Conexao->generate_lazy_image('banners',1140,680,$imagem,'redimencionar',$nome); ?>
                            </div>
                        <?php endif;
                    endif;
                endforeach; ?>                
            </div>
            <a class="ctrls prev fas fa-chevron-left" href="#banner" data-slide="prev" aria-label="Prev"></a>
            <a class="ctrls next fas fa-chevron-right" href="#banner" data-slide="next" aria-label="Next"></a>
            <ol class="carousel-indicators"> 
                <?php foreach ($query as $key => $base):
                    extract($base,EXTR_OVERWRITE);
                    if (!empty($imagem)): ?>
                         <li<?php echo($key==0?' class="active"':''); ?> data-slide-to="<?php echo $key; ?>" data-target="#banner"></li>
                    <?php endif;
                endforeach; ?> 
            </ol> 
        </div> 
    </section>
<?php endif; ?>
<?php $index_paginas = 0; 
$where = 'id >= 1 AND id <= 5';
$query_paginas = $Conexao->select('titulo,subtitulo,descritivo,descricao,imagem,nome_do_botao,href,target,sessao,sistema')->from(PREFIX.$_SESSION['LANG'].'paginas')->where($where)->order_by('id','ASC')->fetch();
if (isset($query_paginas[$index_paginas])):
    extract($query_paginas[$index_paginas],EXTR_PREFIX_ALL,'newsletter');
    if ((!empty($newsletter_titulo) || !empty($newsletter_descritivo)) && $newsletter_sessao == false): ?> 
        <section class="newsletter"> 
            <div class="container"> 
                <?php if (!empty($newsletter_titulo)): ?><h2><span><?php echo $newsletter_titulo; ?></span></h2><?php endif; ?>
                <div class="row"> 
                    <?php if (!empty($newsletter_descritivo)): ?>
                        <div class="col-lg-6"><?php echo $newsletter_descritivo; ?></div>
                    <?php endif; ?>
                    <div class="<?php echo empty($newsletter_descritivo)?'col-lg-12':'col-lg-6'; ?>"> 
                        <form action="<?php echo(URL_PAINEL_TEMPLATE.'ajax/newsletters.php') ?>"> 
                            <label class="sr-only" for="email">E-mail</label> 
                            <div class="input-group"> 
                                <input class="form-control" type="email" name="email" id="email" placeholder="E-mail"> 
                                <div class="input-group-append"> 
                                    <button class="btn btn-newsletter"><span class="sr-only">Enviar</span><i class="fas fa-paper-plane"></i></button> 
                                </div> 
                            </div> 
                        </form> 
                    </div> 
                </div> 
            </div> 
        </section>
    <?php endif; ?>
<?php endif;
$index_paginas ++; ?>
<?php if (isset($query_paginas[$index_paginas])):
    extract($query_paginas[$index_paginas],EXTR_PREFIX_ALL,'empresa');
    if ((!empty($empresa_titulo) || !empty($empresa_subtitulo) || !empty($empresa_imagem) || !empty($empresa_descricao) || !empty($empresa_nome_do_botao)) && $empresa_sessao == false): ?> 
        <section class="sobre"> 
            <div class="container"> 
                <div class="row"> 
                    <?php if (!empty($empresa_titulo) || !empty($empresa_subtitulo) || !empty($empresa_descricao) || !empty($empresa_nome_do_botao) || !empty($empresa_href) ): ?>
                        <div class="col-lg mgb-30"> 
                            <?php if (!empty($empresa_titulo)): ?><h2 class="titulo"><?php echo $empresa_titulo; ?></h2><?php endif; ?>
                            <?php if (!empty($empresa_subtitulo) || !empty($empresa_descricao)): ?>
                                <div class="mgb-30 clearfix">
                                    <?php if (!empty($empresa_subtitulo)): ?>
                                        <h3 class="subtitulo"><?php echo $empresa_subtitulo; ?></h3><br>
                                    <?php endif; ?>
                                    <?php echo $empresa_descricao; ?>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($empresa_nome_do_botao)): ?>
                                <?php if (!empty($empresa_href)){
                                    $empresa_href = ' href="'.$empresa_href.'"'; 
                                    if (!empty($empresa_target)) { 
                                        $empresa_href .= ' target="'.$empresa_target.'"'; 
                                    }
                                } ?>
                                <a class="btn btn-site"<?php echo $empresa_href; ?>>
                                    <?php echo $empresa_nome_do_botao; ?>
                                </a> 
                            <?php endif; ?>
                        </div> 
                    <?php endif; ?>
                    <?php if (!empty($empresa_imagem) ): ?>
                        <div class="col-lg mgb-30 text-center">
                            <?php echo $Conexao->generate_lazy_image('paginas',536,511,$empresa_imagem,'cortar',$empresa_titulo); ?>
                        </div> 
                    <?php endif; ?>
                </div> 
            </div> 
        </section>
    <?php endif;
endif;
$index_paginas ++; ?>
<?php if (isset($query_paginas[$index_paginas])):
    extract($query_paginas[$index_paginas],EXTR_PREFIX_ALL,'produtos_servicos');
    $conteudo = false;
    if (!empty($produtos_servicos_sistema)) {

        $sys = $produtos_servicos_sistema;
        $sys_f = $_SESSION['LANG'].$produtos_servicos_sistema;
        $concat = ', CONCAT("'.URL_SITE.$sys.'/", '.$sys_f.'.url) AS href';
        $pasta = ', ("'.$sys.'") AS pasta';

        $query_imagem = ', (SELECT '.$sys_f.'fotos.image FROM '.$sys_f.'fotos WHERE '.$sys_f.'fotos.'.$sys_f.' = '.$sys_f.'.id ORDER BY ABS(ordem) ASC LIMIT 1) AS image'; 
        $query_produtos_servicos = 'SELECT  '.$sys_f.'.nome'.$concat.$query_imagem.$pasta.' FROM '.$sys_f.' WHERE '.$sys_f.'.status = 1 AND '.$sys_f.'.destaque = 1';

        $query = $Conexao->query($query_produtos_servicos)->fetch(); 
        if ($Conexao->affected_rows > 0){
            $conteudo = true;
        }
    }
    if ((!empty($produtos_servicos_titulo) || !empty($produtos_servicos_subtitulo) || !empty($produtos_servicos_nome_do_botao)) && $produtos_servicos_sessao == false || $conteudo == true): ?> 
        <section class="produtos-index">
            <div class="container"> 
                <?php if (!empty($produtos_servicos_titulo) || !empty($produtos_servicos_subtitulo)): ?> 
                    <div class="text-center mgb-40"> 
                        <?php if (!empty($produtos_servicos_titulo)): ?> 
                        <h2 class="titulo"><?php echo $produtos_servicos_titulo; ?></h2> 
                            <?php endif; ?>
                        <?php if (!empty($produtos_servicos_subtitulo)): ?> 
                            <h3 class="subtitulo"><?php echo $produtos_servicos_subtitulo; ?></h3> 
                        <?php endif; ?>
                    </div> 
                <?php endif; ?> 
                <?php if ($conteudo == true): ?> 
                    <div class="owl-carousel mgb-30" id="produtos" data-xl="4" data-md="2" data-nav="true" data-prev="fas fa-chevron-left" data-next="fas fa-chevron-right" data-margin="30"> 
                        <?php foreach ($query as $key => $base):
                            extract($base,EXTR_OVERWRITE); ?>
                            <div class="produto"> 
                                <?php if (!empty($image)): ?>
                                    <div class="foto"> 
                                        <?php echo $Conexao->generate_lazy_image($pasta,260,260,$image,'cortar',$nome); ?> 
                                    </div> 
                                <?php endif; ?>
                                <a class="btn btn-block btn-site" href="<?php echo $href ?>">SAIBA MAIS</a> 
                                <div class="descricao"><?php echo $nome ?></div> 
                            </div> 
                        <?php endforeach; ?>
                    </div> 
                <?php endif; ?> 
                <?php if (!empty($produtos_servicos_nome_do_botao)): ?>
                    <?php if (!empty($produtos_servicos_href)){
                        $produtos_servicos_href = ' href="'.$produtos_servicos_href.'"'; 
                        if (!empty($produtos_servicos_target)) { 
                            $produtos_servicos_href .= ' target="'.$produtos_servicos_target.'"'; 
                        }
                    } ?>
                    <div class="text-center">
                        <a class="btn-site-outline btn"<?php echo $produtos_servicos_href; ?>>
                            <?php echo $produtos_servicos_nome_do_botao; ?>
                        </a> 
                    </div>
                <?php endif; ?> 
            </div> 
        </section>
    <?php endif;
endif;
$index_paginas ++; ?>
<?php if (isset($query_paginas[$index_paginas])):
    extract($query_paginas[$index_paginas],EXTR_PREFIX_ALL,'fotos');
    if ((!empty($fotos_titulo) || !empty($fotos_subtitulo) || !empty($fotos_nome_do_botao)) && $fotos_sessao == false): ?> 
        <section class="fotos-index">
            <div class="container"> 
                <?php if (!empty($fotos_titulo) || !empty($fotos_subtitulo)): ?> 
                    <div class="text-center mgb-40"> 
                        <?php if (!empty($fotos_titulo)): ?> 
                        <h2 class="titulo"><?php echo $fotos_titulo; ?></h2> 
                            <?php endif; ?>
                        <?php if (!empty($fotos_subtitulo)): ?> 
                            <h3 class="subtitulo"><?php echo $fotos_subtitulo; ?></h3> 
                        <?php endif; ?>
                    </div> 
                <?php endif; ?> 
                <?php $sys = 'fotos';
                $sys_g = $_SESSION['LANG'].'fotos';
                $sys_f = $_SESSION['LANG'].'galeriafotos';
                $concat = ', CONCAT("'.URL_SITE.$sys.'/", '.$sys_g.'.url) AS href';
                $pasta = ', ("'.$sys.'") AS pasta';

                $query_imagem = ', (SELECT '.$sys_f.'.image FROM '.$sys_f.' WHERE '.$sys_f.'.'.$sys_g.' = '.$sys_g.'.id ORDER BY ABS(ordem) ASC LIMIT 1) AS image'; 
                $query_fotos = 'SELECT  '.$sys_g.'.nome'.$concat.$query_imagem.$pasta.' FROM '.$sys_g.' WHERE '.$sys_g.'.status = 1 AND '.$sys_g.'.destaque = 1';

                $query = $Conexao->query($query_fotos)->fetch(); 
                if ($Conexao->affected_rows > 0): ?> 
                    <div class="owl-carousel mgb-30" id="produtos" data-xl="4" data-md="2" data-nav="true" data-prev="fas fa-chevron-left" data-next="fas fa-chevron-right" data-margin="30"> 
                        <?php foreach ($query as $key => $base):
                            extract($base,EXTR_OVERWRITE); ?>
                            <div class="fotos">
                                <a href="<?php echo $href ?>">
                                    <span class="btn btn-site">
                                        <i class="fas fa-plus"></i>
                                        <span class="sr-only">VER FOTO</span>
                                    </span> 
                                    <?php if (!empty($image)): ?> 
                                        <?php echo $Conexao->generate_lazy_image($pasta,260,260,$image,'cortar',$nome); ?>
                                    <?php endif; ?> 
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div> 
                <?php endif; ?> 
                <?php if (!empty($fotos_nome_do_botao)): ?>
                    <?php if (!empty($fotos_href)){
                        $fotos_href = ' href="'.$fotos_href.'"'; 
                        if (!empty($fotos_target)) { 
                            $fotos_href .= ' target="'.$fotos_target.'"'; 
                        }
                    } ?>
                    <div class="text-center">
                        <a class="btn-site-outline btn"<?php echo $fotos_href; ?>>
                            <?php echo $fotos_nome_do_botao; ?>
                        </a> 
                    </div>
                <?php endif; ?> 
            </div> 
        </section>
    <?php endif;
endif;
$index_paginas ++; ?>
<?php if (isset($query_paginas[$index_paginas])):
    extract($query_paginas[$index_paginas],EXTR_PREFIX_ALL,'clientes');
    if ((!empty($clientes_titulo) || !empty($clientes_subtitulo) || !empty($clientes_nome_do_botao)) && $clientes_sessao == false ): ?> 
        <section class="clientes-index">
            <div class="container">
                <?php if (!empty($clientes_titulo) || !empty($clientes_subtitulo)): ?> 
                    <div class="text-center mgb-40"> 
                        <?php if (!empty($clientes_titulo)): ?> 
                        <h2 class="titulo"><?php echo $clientes_titulo; ?></h2> 
                            <?php endif; ?>
                        <?php if (!empty($clientes_subtitulo)): ?> 
                            <h3 class="subtitulo"><?php echo $clientes_subtitulo; ?></h3> 
                        <?php endif; ?>
                    </div> 
                <?php endif; ?> 
                <?php $query = $Conexao->select('nome,href,target,imagem')->from(PREFIX.$_SESSION['LANG'].'clientes')->where('status=1')->fetch(); 
                if ($Conexao->affected_rows > 0):  ?>
                    <div class="owl-carousel mgb-30" id="produtos" data-xl="6" data-lg="5" data-md="4" data-sm="3" data-xs="2" data-nav="true" data-prev="fas fa-chevron-left" data-next="fas fa-chevron-right" data-margin="30">
                        <?php foreach ($query as $key => $base):
                            extract($base,EXTR_OVERWRITE);
                            if (!empty($imagem)):
                                if (!empty($href)): 
                                    $href = ' href="'.$href.'"'; 
                                    if (!empty($target)) { 
                                        $href .= ' target="'.$target.'"'; 
                                    } ?>
                                    <div class="cliente">
                                        <a<?php echo $href; ?>> 
                                            <?php echo $Conexao->generate_lazy_image('clientes',160,160,$imagem,'redimencionar',$nome); ?> 
                                        </a>
                                    </div> 
                                <?php else: ?>
                                    <div class="cliente"> 
                                        <?php echo $Conexao->generate_lazy_image('clientes',160,160,$imagem,'redimencionar',$nome); ?>
                                    </div> 
                                <?php endif;
                            endif;
                        endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    <?php endif;
endif; ?>
<script type="text/javascript">
    var callback = function(data){ 
        if (data.success) {
            var context = '<div class="has-success control-label"> '+data.success.message+'</div> '; 
            $('.newsletter form').after(context);
        }
        if (data.error) {
            $.each(data.error, function() {
                var context = '<label class="has-error control-label label-margin" for="'+this.input+'"> '+this.message+'</label> ';
                $('input[name="'+this.input+'"]').parent().before(context); 
                $('select[name="'+this.input+'"]').parent().before(context);
                
            }); 
        }
    }
</script>
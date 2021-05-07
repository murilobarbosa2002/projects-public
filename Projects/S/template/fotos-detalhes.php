<?php $service_href = $urlpagination.'/'.$url;
$query = $Conexao->select('legenda,image')->from(PREFIX.$_SESSION['LANG'].'galeriafotos')->where($_SESSION['LANG'].'fotos = '.$id)->fetch(); ?>
<main class="galeria-fotos" id="modelo-3"> 
    <div class="page-header"> 
        <div class="container"> 
            <h1><?php echo $titulo; ?></h1> 
            <ol class="breadcrumb">  
                <li><a href="<?php echo URL_SITE.'home' ?>">Home</a></li> 
                <li><a href="<?php echo $urlpagination ?>"><?php echo mb_convert_case($nome_do_menu, MB_CASE_TITLE, "UTF-8"); ?></a></li> 
                <li class="active"><span><?php echo $nome ?></span></li> 
            </ol> 
        </div> 
    </div> 
    <div class="container"> 
        <?php if ($Conexao->affected_rows > 0):  ?> 
            <div class="row">
                <?php foreach ($query as $index => $base): 
                    extract($base); ?> 
                    <div class="col-md-4 col-sm-6"> 
                        <div class="album-fotografia">
                            <a href="<?php echo $Conexao->generate_image_src('fotos',1500,1500,$image) ?>" data-lightbox="fotos" title="<?php echo $legenda ?>"> 
                                <div class="foto"> 
                                    <?php echo $Conexao->generate_lazy_image('fotos',350,220,$image,'cortar',$legenda); ?>
                                </div> 
                                <div class="album-caption"> 
                                    <div class="nome"><i class="fas fa-search fa-2x"></i></div> 
                                    <div class="description">VISUALIZAR ÁLBUM [+]</div> 
                                </div> 
                            </a>
                        </div> 
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div> 
</main>
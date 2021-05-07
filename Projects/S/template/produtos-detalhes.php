<?php $product_href = $urlpagination.'/'.$url;
$query = $Conexao->select('legenda,image')->from(PREFIX.$_SESSION['LANG'].'produtosfotos')->where($_SESSION['LANG'].'produtos = '.$id)->fetch();
$socials_share = array(
    'f' => '<a href="https://www.facebook.com/sharer.php?u='.$product_href.'" target="_blank"><i class="fa fa-facebook"></i></a>',
    't' => '<a href="https://twitter.com/intent/tweet?url='.$product_href.'&text='.$nome.'" target="_blank"><i class="fa fa-twitter"></i></a>',
    'l' => '<a href="https://www.linkedin.com/shareArticle?mini=true&url='.$product_href.'" target="_blank"><i class="fa fa-linkedin"></i></a>',
    'g' => '<a href="https://plus.google.com/share?url='.$product_href.'" target="_blank"><i class="fa fa-google-plus"></i></a>'
); ?>
<main class="produtos-servicos detalhes" id="produtos-mod-3"> 
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
        <div class="row"> 
            <div class="col-lg-6 order-lg-2 mgb-30"> 
                <div class="box box-white"> 
                    <?php echo $descricao ?>
                    <hr> 
                    <p><i style="font-size:18px">Gostou? Então compartilhe!</i></p> 
                    <div class="midias-sociais">
                        <?php foreach ($socials_share as $key => $midia) {
                            echo $midia;
                        } ?>
                    </div> 
                </div> 
            </div> 
            <div class="col-lg-6 order-lg-1 mgb-30"> 
                <p><?php echo $nome ?> <i class="fa fa-angle-double-right"></i> Especificações</p>
                <?php if ($Conexao->affected_rows > 0):  ?>
                    <div class="box box-white" id="imagens-produto"> 
                        <?php foreach ($query as $index => $base): 
                            extract($base); ?>
                            <?php if ($index==0): ?>
                                <div class="image-g">
                                    <a href="<?php echo $Conexao->generate_image_src('produtos',1500,1500,$image) ?>" data-lightbox="produto" title="<?php echo $legenda ?>"> 
                                        <?php echo $Conexao->generate_lazy_image('produtos',515,515,$image,'cortar',$legenda); ?> 
                                    </a> 
                                </div>
                            <?php endif; ?>
                            <?php if ($index==1): ?>
                                <div class="album">
                                    <a class="fa fa-chevron-left owl-ctrls" href="#album" data-owl="prev"></a>
                                    <div class="owl-carousel" id="album" data-sm="2" data-md="3" data-lg="5" data-margin="10">
                            <?php endif; ?>
                                <?php if ($index>0): ?>
                                    <a href="<?php echo $Conexao->generate_image_src('produtos',1500,1500,$image) ?>" data-lightbox="produto" title="<?php echo $legenda ?>"> 
                                        <?php echo $Conexao->generate_lazy_image('produtos',61,61,$image,'cortar',$legenda); ?>
                                    </a>
                                <?php endif; ?>
                            <?php if ($index>0 && ($index+1)==$Conexao->affected_rows): ?>
                                    </div> 
                                    <a class="fa fa-chevron-right owl-ctrls" href="#album" data-owl="next"></a>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div> 
                <?php endif; ?>
            </div> 
        </div> 
    </div> 
</main>
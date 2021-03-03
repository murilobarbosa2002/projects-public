<!-- ICONS-->
<footer class="rodape">
    <div class="container">
        <div class="brand">

            <?php if (!empty($logo_rodape)): ?>
            <lazy-image src="<?php echo $Conexao->generate_image_src('configuracoes',186,108,$logo_rodape,'redimencionar'); ?>" alt="Seu Logo" style="--width: 326;--height: 45;"></lazy-image>
            <?php endif; ?>

        </div>
        <div class="row justify-content-center">



            <?php if (!empty($primeira_opcao_de_telefone||$segunda_opcao_de_telefone)): ?>
            <div class="col-xl-6 televendas mgb-30">

                <h2 class="title-footer">TELEVENDAS:</h2>
                <ul class="telefones">
                    <?php if (!empty($primeira_opcao_de_telefone)): ?>
                    <li>
                        <a href="tel:<?php echo preg_replace('/\D/', '', $primeira_opcao_de_telefone) ?>"><?php echo $primeira_opcao_de_telefone ?></a>
                    </li>
                    <?php endif; ?>

                    <?php if (!empty($segunda_opcao_de_telefone)): ?>
                    <li>
                        <a href="tel:<?php echo preg_replace('/\D/', '', $segunda_opcao_de_telefone) ?>"><?php echo $segunda_opcao_de_telefone ?></a>
                    </li>
                    <?php endif; ?>

                </ul>
            </div>
            <?php endif; ?>



            <?php if (!empty($e_mail)): ?>
            <div class="col-xl-6 atendimento mgb-30">
                <h2 class="title-footer">ATENDIMENTO:</h2>
                <ul class="emails">
                    <li>
                        <a href="mailto:<?=$e_mail;?>"><?=$e_mail;?></a>
                    </li>
                </ul>
            </div>
            <?php endif; ?>


        </div>



        <div class="redes-sociais">

            <?php if (!empty($link_facebook||$id_do_instagram||$link_pinterest||$link_do_twitter)): ?>
            <div class="title">SIGA-NOS:</div>
            <?php endif; ?>


            <div class="content">

                <?php if (!empty($link_facebook)): ?>
                <a class="fab fa-facebook-f" href="<?php echo $link_facebook ?>" target="_blank" rel="noopener" title="Facebook"></a>
                <?php endif; ?>
                <?php if (!empty($id_do_instagram)): ?>
                <a class="fab fa-instagram" href="http://instagram.com/<?php echo preg_replace('/[@]/ui', '', $id_do_instagram); ?>" target="_blank" rel="noopener" title="Instagram"></a>
                <?php endif; ?>
                <?php if (!empty($link_pinterest)): ?>
                <a class="fab fa-pinterest-p" href="<?php echo $link_pinterest ?>" target="_blank" rel="noopener" title="Pinterest"></a>
                <?php endif; ?>
                <?php if (!empty($link_do_twitter)): ?>
                <a class="fab fa-twitter" href="<?php echo $link_do_twitter ?>" target="_blank" rel="noopener" title="Twitter"></a>
                <?php endif; ?>

            </div>
        </div>



    </div>
    <div class="creditos">
        <div class="container">MARITATIKIDS © Todos os direitos reservados. Implementação de conteúdo e material fornecidos pelo administrador.
            <br />Criação de Sites:
            <a href="https://www.gv8.com.br/" target="_blank" rel="noopener">GV8 Agência Digital
                    <lazy-image src="<?php echo URL_SITE ?>uploads/images/configuracoes/logo-interna.png" alt="Seu Logo" style="--width: 326;--height: 45;"></lazy-image>
            </a>
        </div>
    </div>
</footer>
</div>



<!--/#app-->
<script src="<?php echo URL_SITE_TEMPLATE; ?>assets/js/jquery.min.js"></script>
<script src="<?php echo URL_SITE_TEMPLATE; ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo URL_SITE_TEMPLATE; ?>assets/js/scripts.min.js"></script>
<script src="<?php echo URL_PAINEL_TEMPLATE; ?>assets/js/jquery.maskedinput.min.js"></script>
<script src="<?php echo URL_PAINEL_TEMPLATE; ?>assets/js/scriptsbackend.js?v=1"></script>
</body>

</html>
            </div>
            <footer class="rodape">
                <?php $where = 'id = 6'; 
                $query = $Conexao->select('titulo,subtitulo,endereco,telefone,email,facebook,twitter,instagram,pinterest,mail')->from(PREFIX.$_SESSION['LANG'].'paginas')->where($where)->order_by('id','ASC')->fetch_first();
                if ($Conexao->affected_rows > 0):
                    extract($query);
                    if (!empty($titulo)||!empty($subtitulo)||!empty($endereco)||!empty($telefone)||!empty($email)||!empty($facebook)||!empty($twitter)||!empty($instagram)||!empty($pinterest)||!empty($mail)): ?>
                        <div class="container">
                            <?php if (!empty($titulo)||!empty($subtitulo)): ?>
                                <div class="text-center mgb-30">
                                    <?php if (!empty($titulo)): ?>
                                        <h2 class="titulo"><?php echo $titulo; ?></h2>
                                    <?php endif; ?>
                                    <?php if (!empty($subtitulo)): ?>
                                        <h3 class="subtitulo"><?php echo $subtitulo; ?></h3>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($endereco)||!empty($telefone)||!empty($email)||!empty($facebook)||!empty($twitter)||!empty($instagram)||!empty($pinterest)||!empty($mail)): ?>
                                <div class="row">
                                    <?php if (!empty($endereco)): ?>
                                        <div class="col-sm-6 col-md-4 col-lg-3 mgb-30 dados-footer">
                                            <div class="mgb-20 text-center">
                                                <i class="fas fa-map-marker circle-icon"></i>
                                            </div>
                                            <p><?php echo nl2br($endereco); ?></p>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($telefone)): ?>
                                        <div class="col-sm-6 col-md-4 col-lg-3 mgb-30 dados-footer">
                                            <div class="mgb-20 text-center">
                                                <i class="fas fa-phone circle-icon"></i>
                                            </div> 
                                            <p><?php echo nl2br($telefone); ?></p>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($email)): ?>
                                        <div class="col-sm-6 col-md-4 col-lg-3 mgb-30 dados-footer">
                                            <div class="mgb-20 text-center">
                                                <i class="fas fa-envelope circle-icon"></i>
                                            </div>
                                            <?php foreach (explode(chr(13), $email) as $item):?>
                                                <p><a href="mailto:<?php echo $item; ?>"><?php echo $item; ?></a></p> 
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($facebook)||!empty($twitter)||!empty($instagram)||!empty($pinterest)||!empty($mail)): ?>
                                        <div class="col-sm-6 col-lg-3 mgb-30">
                                            <div class="title-footer">SIGA-NOS</div>
                                            <div class="redes-sociais">
                                                <?php if (!empty($facebook)): ?>
                                                    <a class="fab fa-facebook-f" href="<?php echo $facebook; ?>" target="_blank" title="Facebook"></a>
                                                <?php endif; ?>
                                                <?php if (!empty($twitter)): ?>
                                                    <a class="fab fa-twitter" href="<?php echo $twitter; ?>" target="_blank" title="Twitter"></a>
                                                <?php endif; ?>
                                                <?php if (!empty($instagram)): ?>
                                                    <a class="fab fa-instagram" href="<?php echo $instagram; ?>" target="_blank" title="Instagram"></a>
                                                <?php endif; ?>
                                                <?php if (!empty($pinterest)): ?>
                                                    <a class="fab fa-pinterest-p" href="<?php echo $pinterest; ?>" target="_blank" title="Pinterest"></a>
                                                <?php endif; ?>
                                                <?php if (!empty($mail)): ?>
                                                    <a class="fas fa-envelope" href="<?php echo $mail; ?>" target="_blank" title="Email"></a>
                                                <?php endif; ?>
                                            </div>
                                        </div> 
                                    <?php endif; ?>
                                </div> 
                            <?php endif; ?>
                        </div>
                    <?php endif;
                endif; ?>
                <div class="creditos">
                    <div class="container">
                        <?php echo $titulo_do_site ?> © Todos os direitos reservados. Implementação de conteúdo e material fornecidos pelo administrador.
                        <br>Criação de Sites: 
                        <a href="https://gv8.com.br" target="_blank">
                            GV8 Sites & Sitemas 
                            <img src="<?php echo URL_SITE_TEMPLATE; ?>assets/images/logo-gv8.png" alt="logo GV8 Sites &amp; Sitemas">
                        </a>
                    </div>
                </div>
            </footer>
        </div>
        <script src="<?php echo URL_SITE_TEMPLATE; ?>assets/js/jquery.min.js"></script>
        <script src="<?php echo URL_SITE_TEMPLATE; ?>assets/js/bootstrap.min.js"></script>
        <script src="<?php echo URL_SITE_TEMPLATE; ?>assets/js/scripts.js"></script>

        <script src="<?php echo URL_PAINEL_TEMPLATE; ?>assets/js/jquery.maskedinput.min.js"></script> 
        <script src="<?php echo URL_PAINEL_TEMPLATE; ?>assets/js/scriptsbackend.js"></script>
    </body>
</html>
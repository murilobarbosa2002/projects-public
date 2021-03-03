<?php $id = 12;
if ($menus[$id]):
    $query_paginas = $Conexao->select('nome_do_menu,titulo,subtitulo,google_maps,endereco,telefone,email,atendimento,descricao')->from(PREFIX.$_SESSION['LANG'].'paginas')->where('id='.$id)->order_by('id','ASC')->fetch_first();
    if ($Conexao->affected_rows > 0): 
        extract($query_paginas); ?> 
        <main class="contato-page" id="contato2"> 
            <div class="page-header"> 
                <div class="container"> 
                    <h1><?php echo $titulo; ?></h1> 
                    <ol class="breadcrumb"> 
                        <li><a href="<?php echo URL_SITE.'home' ?>">Home</a></li> 
                        <li class="active"><span><?php echo mb_convert_case($nome_do_menu, MB_CASE_TITLE, "UTF-8"); ?></span></li> 
                    </ol> 
                </div> 
            </div> 
            <?php if (!empty($google_maps)): ?>
                <div id="mapa-contato"> 
                    <script> 
                        var mapa = '<?php echo(html_entity_decode($google_maps)) ?>'; 
                        var mapaContainer = document.getElementById('mapa-contato'); 
                        window.addEventListener('load', function() 
                        {
                            mapaContainer.insertAdjacentHTML('afterbegin', mapa); 
                        }); 
                    </script> 
                </div>
            <?php endif;  ?> 
            <div class="container pdt-40"> 
                <div class="row justify-content-between"> 
                    <div class="col-lg-5 mgb-30"> 
                        <?php if (!empty($subtitulo)): ?><h2><?php echo $subtitulo; ?></h2><?php endif; ?>
                        <?php if (!empty($endereco)): ?><address class="mgb-30 info-block"><h3>Endereço</h3><p><?php echo nl2br($endereco); ?></p></address><?php endif; ?>
                        <?php if (!empty($telefone)||!empty($email)||!empty($atendimento)):?>
                            <h3 class="media mgb-30 align-items-center">
                                <i class="icon telemarketing-sm mr-3"></i> 
                                <div class="media-body">Central de Relacionamento com o Cliente</div> 
                            </h3> 
                            <?php if (!empty($telefone)):?>
                                <div class="mgb-30 info-block"> 
                                    <h4>Telefone:</h4> 
                                    <p><?php echo nl2br($telefone); ?></p> 
                                </div> 
                            <?php endif; ?>
                            <?php if (!empty($email)):?>
                                <div class="mgb-30 info-block"> 
                                    <h4>E-mail</h4> 
                                    <p><?php echo nl2br($email); ?></p> 
                                </div> 
                            <?php endif; ?>
                            <?php if (!empty($atendimento)):?>
                                <div class="mgb-30 info-block"> 
                                    <h4>Horário de Atendimento</h4> 
                                    <p><?php echo nl2br($atendimento); ?></p> 
                                </div> 
                            <?php endif; ?>
                        <?php endif; ?>
                    </div> 
                    <div class="col-lg-6 mgb-30"> 
                        <form action="<?php echo(URL_PAINEL_TEMPLATE.'ajax/contatos.php') ?>"> 
                            <?php echo $descricao ?> 
                            <div class="form-group"> 
                                <label class="sr-only" for="nome">Digite seu nome...</label> 
                                <input class="form-control" type="text" name="nome" id="nome" placeholder="Digite seu nome..." value=""> 
                            </div> 
                            <div class="form-group"> 
                                <label class="sr-only" for="email">Digite seu email...</label> 
                                <input class="form-control" type="email" name="email" id="email" placeholder="Digite seu email..." value=""> 
                            </div> 
                            <div class="form-group"> 
                                <label class="sr-only" for="telefone">Digite seu telefone...</label> 
                                <input class="form-control" type="tel" name="telefone" id="telefone" placeholder="Digite seu telefone..."> 
                            </div> 
                            <div class="row"> 
                                <div class="col-md-6"> 
                                    <div class="form-group select-custom"> 
                                        <label class="sr-only" for="estado">Estado</label> 
                                        <label class="form-control output" for="estado">Estado</label> 
                                        <div class="drop-options"> 
                                            <input type="text" name="filtro" data-target="#options-estado" id="estado"> 
                                            <ul class="options-list" id="options-estado"> 
                                                <li> 
                                                    <input type="radio" id="estado-option-AC" name="estado" value="AC"> 
                                                    <label for="estado-option-AC">Acre</label> 
                                                </li> 
                                                <li> 
                                                    <input type="radio" id="estado-option-AP" name="estado" value="AP"> 
                                                    <label for="estado-option-AP">Amapá</label> 
                                                </li> 
                                                <li> 
                                                    <input type="radio" id="estado-option-AM" name="estado" value="AM"> 
                                                    <label for="estado-option-AM">Amazonas</label> 
                                                </li> 
                                                <li> 
                                                    <input type="radio" id="estado-option-PA" name="estado" value="PA"> 
                                                    <label for="estado-option-PA">Pará</label> 
                                                </li> 
                                                <li> 
                                                    <input type="radio" id="estado-option-RO" name="estado" value="RO"> 
                                                    <label for="estado-option-RO">Roraima</label> 
                                                </li> 
                                                <li> 
                                                    <input type="radio" id="estado-option-RR" name="estado" value="RR"> 
                                                    <label for="estado-option-RR">Rondônia</label> 
                                                </li> 
                                                <li> 
                                                    <input type="radio" id="estado-option-TO" name="estado" value="TO"> 
                                                    <label for="estado-option-TO">Tocantins</label> 
                                                </li> 
                                                <li> 
                                                    <input type="radio" id="estado-option-AL" name="estado" value="AL"> 
                                                    <label for="estado-option-AL">Alagoas</label> 
                                                </li> 
                                                <li> 
                                                    <input type="radio" id="estado-option-BA" name="estado" value="BA"> 
                                                    <label for="estado-option-BA">Bahia</label> 
                                                </li> 
                                                <li> 
                                                    <input type="radio" id="estado-option-CE" name="estado" value="CE"> 
                                                    <label for="estado-option-CE">Ceará</label> 
                                                </li> 
                                                <li> 
                                                    <input type="radio" id="estado-option-MA" name="estado" value="MA"> 
                                                    <label for="estado-option-MA">Maranhao</label> 
                                                </li> 
                                                <li> 
                                                    <input type="radio" id="estado-option-PB" name="estado" value="PB"> 
                                                    <label for="estado-option-PB">Paraíba</label> 
                                                </li> 
                                                <li> 
                                                    <input type="radio" id="estado-option-PE" name="estado" value="PE"> 
                                                    <label for="estado-option-PE">Pernambuco</label> 
                                                </li> 
                                                <li> 
                                                    <input type="radio" id="estado-option-PI" name="estado" value="PI"> 
                                                    <label for="estado-option-PI">Piauí</label> 
                                                </li> 
                                                <li> 
                                                    <input type="radio" id="estado-option-RN" name="estado" value="RN"> 
                                                    <label for="estado-option-RN">Rio Grande do Norte</label> 
                                                </li> 
                                                <li> 
                                                    <input type="radio" id="estado-option-SE" name="estado" value="SE"> 
                                                    <label for="estado-option-SE">Sergipe</label> 
                                                </li> 
                                                <li> 
                                                    <input type="radio" id="estado-option-DF" name="estado" value="DF"> 
                                                    <label for="estado-option-DF">Distrito Federal</label> 
                                                </li> 
                                                <li> 
                                                    <input type="radio" id="estado-option-GO" name="estado" value="GO"> 
                                                    <label for="estado-option-GO">Goiás</label> 
                                                </li> 
                                                <li> 
                                                    <input type="radio" id="estado-option-MT" name="estado" value="MT"> 
                                                    <label for="estado-option-MT">Mato Grosso</label> 
                                                </li> 
                                                <li> 
                                                    <input type="radio" id="estado-option-MS" name="estado" value="MS"> 
                                                    <label for="estado-option-MS">Mato grosso do Sul</label> 
                                                </li> 
                                                <li> 
                                                    <input type="radio" id="estado-option-ES" name="estado" value="ES"> 
                                                    <label for="estado-option-ES">Espirito Santo</label> 
                                                </li> 
                                                <li> 
                                                    <input type="radio" id="estado-option-MG" name="estado" value="MG"> 
                                                    <label for="estado-option-MG">Minas Gerais</label> 
                                                </li> 
                                                <li> 
                                                    <input type="radio" id="estado-option-RJ" name="estado" value="RJ"> 
                                                    <label for="estado-option-RJ">Rio de Janeiro</label> 
                                                </li> 
                                                <li> 
                                                    <input type="radio" id="estado-option-SP" name="estado" value="SP"> 
                                                    <label for="estado-option-SP">São Paulo</label> 
                                                </li> 
                                                <li> 
                                                    <input type="radio" id="estado-option-PR" name="estado" value="PR"> 
                                                    <label for="estado-option-PR">Paraná</label> 
                                                </li> 
                                                <li> 
                                                    <input type="radio" id="estado-option-RS" name="estado" value="RS"> 
                                                    <label for="estado-option-RS">Rio Grande do Sul</label> 
                                                </li> 
                                                <li> 
                                                    <input type="radio" id="estado-option-SC" name="estado" value="SC"> 
                                                    <label for="estado-option-SC">Santa Catarina</label> 
                                                </li> 
                                            </ul> 
                                        </div> 
                                    </div> 
                                </div> 
                                <div class="col-md-6"> 
                                    <div class="form-group"> 
                                        <label class="sr-only" for="cidade">Cidade</label> 
                                        <input class="form-control" type="text" name="cidade" id="cidade" placeholder="Cidade"> 
                                    </div> 
                                </div> 
                            </div> 
                            <div class="form-group"> 
                                <label class="sr-only" for="mensagem">Mensagem</label> 
                                <textarea class="form-control" name="mensagem" id="mensagem" placeholder="Mensagem" rows="5"></textarea> 
                            </div> 
                            <button class="btn btn-enviar btn-block">ENVIAR FORMULÁRIO</button> 
                        </form> 
                    </div> 
                </div> 
            </div> 
        </main>
    <?php else:
        require_once(PATH_TEMPLATE.'404.php');
    endif; 
else:
        require_once(PATH_TEMPLATE.'404.php');
endif; ?>
<script type="text/javascript">
    var callback = function(data){ 
        if (data.success) {
            var context = '<div class="has-success control-label"> '+data.success.message+'</div> '; 
            $('.btn.btn-enviar.btn-block').after(context);
        }
        if (data.warning) {
            var context = '<div class="has-warning control-label"> '+data.warning.message+'</div> '; 
            $('.btn.btn-enviar.btn-block').after(context);
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
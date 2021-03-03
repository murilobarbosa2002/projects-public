<main class="wrapper">
    <div class="internas contato-page" id="contato2">
        <div class="page-header">
            <div class="container">
                <h1>CONTATO</h1>
                <ol class="breadcrumbs">
                    <li>
                        <a href="<?=URL_SITE.'home'?>">HOME</a>
                    </li>
                    <li>
                        <span>Contato</span>
                    </li>
                </ol>
            </div>
        </div>
        <div id="mapa-contato">

            <?=$Conexao->get_custom_by('maps','paginas',array('url' => 'contato'))?>

        </div>
        <div class="container pdt-40">
            <div class="row justify-content-between">
                <div class="col-lg-5 mgb-30">
                    <h2><?=$Conexao->get_custom_by('titulo','paginas',array('url' => 'contato'))?></h2>


                    <?php
                    $validaEndereco = $Conexao->get_custom_by('endereco','paginas',array('url' => 'contato'));
                    if (!empty($validaEndereco)): ?>
                    <address class="mgb-30 info-block">
                        <h3>Endereço</h3>
                        <?=$Conexao->get_custom_by('endereco','paginas',array('url' => 'contato'))?>
                    </address>
                    <?php endif; ?>


                    <?php if (!empty($primeira_opcao_de_telefone||$segunda_opcao_de_telefone)): ?>
                    <h3 class="media mgb-30 align-items-center">
                        <i class="icon telemarketing-sm mr-3"></i>
                        <div class="media-body">Central de Relacionamento com o Cliente</div>
                    </h3>


                    <div class="mgb-30 info-block">
                        <h4>Telefone:</h4>
                        <p>
                            <?php echo $primeira_opcao_de_telefone ?>

                            <?php if (!empty($segunda_opcao_de_telefone)): ?>
                            -
                            <?php endif; ?>

                            <?php echo $segunda_opcao_de_telefone ?>
                        </p>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($e_mail)): ?>
                    <div class="mgb-30 info-block">
                        <h4>E-mail</h4>
                        <p><?=$e_mail;?></p>
                    </div>
                    <?php endif; ?>


                    <?php
                    $validaHorario = $Conexao->get_custom_by('horario_atendimento','paginas',array('url' => 'contato'));
                    if (!empty($validaHorario)): ?>
                    <div class="mgb-30 info-block">
                        <h4>Horário de Atendimento</h4>
                        <?=$Conexao->get_custom_by('horario_atendimento','paginas',array('url' => 'contato'))?>
                    </div>
                    <?php endif; ?>


                </div>
                <div class="col-lg-6 mgb-30">




                    <form id="contatos" method="POST" action="<?php echo URL_SITE_TEMPLATE.'ajax/contato.php' ?>">
                        <p><?=$Conexao->get_custom_by('frase_contato','paginas',array('url' => 'contato'))?></p>
                        <div class="form-group ">
                            <label class="sr-only" for="nome-contato">Digite seu nome...</label>
                            <input class="form-control" type="text" name="nome" id="nome" placeholder="Digite seu nome..." />
                        </div>
                        <div class="form-group ">
                            <label class="sr-only" for="email-contato">Digite seu email...</label>
                            <input class="form-control" type="email" name="email" id="email" placeholder="Digite seu email..." />
                        </div>
                        <div class="form-group ">
                            <label class="sr-only" for="tel-contato">Digite seu telefone...</label>
                            <input class="form-control" type="tel" name="telefone" id="telefone" placeholder="Digite seu telefone..." />
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group select-custom">
                                    <label class="sr-only" for="uf-orcamento">Estado</label>
                                    <label class="form-control output" for="uf-orcamento">Estado</label>
                                    <div class="drop-options">
                                        <input type="text" name="UFS" data-target="#options-uf-orcamento" id="uf-orcamento" />
                                        <ul class="options-list" id="options-uf-orcamento">
                                            <li>
                                                <input id="uf-orcamento-option-AC" type="radio" name="estado" value="AC" />
                                                <label for="uf-orcamento-option-AC">Acre</label>
                                            </li>
                                            <li>
                                                <input id="uf-orcamento-option-AP" type="radio" name="estado" value="AP" />
                                                <label for="uf-orcamento-option-AP">Amap&aacute;</label>
                                            </li>
                                            <li>
                                                <input id="uf-orcamento-option-AM" type="radio" name="estado" value="AM" />
                                                <label for="uf-orcamento-option-AM">Amazonas</label>
                                            </li>
                                            <li>
                                                <input id="uf-orcamento-option-PA" type="radio" name="estado" value="PA" />
                                                <label for="uf-orcamento-option-PA">Par&aacute;</label>
                                            </li>
                                            <li>
                                                <input id="uf-orcamento-option-RO" type="radio" name="estado" value="RO" />
                                                <label for="uf-orcamento-option-RO">Roraima</label>
                                            </li>
                                            <li>
                                                <input id="uf-orcamento-option-RR" type="radio" name="estado" value="RR" />
                                                <label for="uf-orcamento-option-RR">Rond&ocirc;nia</label>
                                            </li>
                                            <li>
                                                <input id="uf-orcamento-option-TO" type="radio" name="estado" value="TO" />
                                                <label for="uf-orcamento-option-TO">Tocantins</label>
                                            </li>
                                            <li>
                                                <input id="uf-orcamento-option-AL" type="radio" name="estado" value="AL" />
                                                <label for="uf-orcamento-option-AL">Alagoas</label>
                                            </li>
                                            <li>
                                                <input id="uf-orcamento-option-BA" type="radio" name="estado" value="BA" />
                                                <label for="uf-orcamento-option-BA">Bahia</label>
                                            </li>
                                            <li>
                                                <input id="uf-orcamento-option-CE" type="radio" name="estado" value="CE" />
                                                <label for="uf-orcamento-option-CE">Cear&aacute;</label>
                                            </li>
                                            <li>
                                                <input id="uf-orcamento-option-MA" type="radio" name="estado" value="MA" />
                                                <label for="uf-orcamento-option-MA">Maranhao</label>
                                            </li>
                                            <li>
                                                <input id="uf-orcamento-option-PB" type="radio" name="estado" value="PB" />
                                                <label for="uf-orcamento-option-PB">Para&iacute;ba</label>
                                            </li>
                                            <li>
                                                <input id="uf-orcamento-option-PE" type="radio" name="estado" value="PE" />
                                                <label for="uf-orcamento-option-PE">Pernambuco</label>
                                            </li>
                                            <li>
                                                <input id="uf-orcamento-option-PI" type="radio" name="estado" value="PI" />
                                                <label for="uf-orcamento-option-PI">Piau&iacute;</label>
                                            </li>
                                            <li>
                                                <input id="uf-orcamento-option-RN" type="radio" name="estado" value="RN" />
                                                <label for="uf-orcamento-option-RN">Rio Grande do Norte</label>
                                            </li>
                                            <li>
                                                <input id="uf-orcamento-option-SE" type="radio" name="estado" value="SE" />
                                                <label for="uf-orcamento-option-SE">Sergipe</label>
                                            </li>
                                            <li>
                                                <input id="uf-orcamento-option-DF" type="radio" name="estado" value="DF" />
                                                <label for="uf-orcamento-option-DF">Distrito Federal</label>
                                            </li>
                                            <li>
                                                <input id="uf-orcamento-option-GO" type="radio" name="estado" value="GO" />
                                                <label for="uf-orcamento-option-GO">Goi&aacute;s</label>
                                            </li>
                                            <li>
                                                <input id="uf-orcamento-option-MT" type="radio" name="estado" value="MT" />
                                                <label for="uf-orcamento-option-MT">Mato Grosso</label>
                                            </li>
                                            <li>
                                                <input id="uf-orcamento-option-MS" type="radio" name="estado" value="MS" />
                                                <label for="uf-orcamento-option-MS">Mato grosso do Sul</label>
                                            </li>
                                            <li>
                                                <input id="uf-orcamento-option-ES" type="radio" name="estado" value="ES" />
                                                <label for="uf-orcamento-option-ES">Espirito Santo</label>
                                            </li>
                                            <li>
                                                <input id="uf-orcamento-option-MG" type="radio" name="estado" value="MG" />
                                                <label for="uf-orcamento-option-MG">Minas Gerais</label>
                                            </li>
                                            <li>
                                                <input id="uf-orcamento-option-RJ" type="radio" name="estado" value="RJ" />
                                                <label for="uf-orcamento-option-RJ">Rio de Janeiro</label>
                                            </li>
                                            <li>
                                                <input id="uf-orcamento-option-SP" type="radio" name="estado" value="SP" />
                                                <label for="uf-orcamento-option-SP">S&atilde;o Paulo</label>
                                            </li>
                                            <li>
                                                <input id="uf-orcamento-option-PR" type="radio" name="estado" value="PR" />
                                                <label for="uf-orcamento-option-PR">Paran&aacute;</label>
                                            </li>
                                            <li>
                                                <input id="uf-orcamento-option-RS" type="radio" name="estado" value="RS" />
                                                <label for="uf-orcamento-option-RS">Rio Grande do Sul</label>
                                            </li>
                                            <li>
                                                <input id="uf-orcamento-option-SC" type="radio" name="estado" value="SC" />
                                                <label for="uf-orcamento-option-SC">Santa Catarina</label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="sr-only" for="cidade-contato">Cidade</label>
                                    <input class="form-control" type="text" name="cidade" id="cidade" placeholder="Cidade" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="msg-contato">Mensagem</label>
                            <textarea class="form-control" name="mensagem" id="mensagem" placeholder="Mensagem" rows="5"></textarea>
                        </div>
                        <button class="btn btn-enviar btn-block"><?=$Conexao->get_custom_by('nome_do_botao','paginas',array('url' => 'contato'))?></button>
                    </form>






                </div>
            </div>
        </div>
    </div>
</main>
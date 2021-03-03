<?php $Funcoes->setSistema($sistema);

if (isset($sistema['limit_only_user'])) {

    if (!in_array($_SESSION['admin_nivel_acesso'], $sistema['limit_only_user'])) {

        $sistema['limitar'] = false;
        $sistema['limitar'] = false;

    }

}

$url = explode('/', $Funcoes->getUrl());

if(empty($_SESSION['admin'])){ $Funcoes->redirect(URL_PAINEL); exit(); }

if (!isset($url[1])||$url[1]=='page') {

    if (!empty($_POST)) {



        if (isset($_POST['busca'])||isset($_POST['cidade'])||isset($_POST['estado'])) {

            $_SESSION['busca_'.$sistema['bd']] = $_POST['busca'];

            $_SESSION['cidade_'.$sistema['bd']] = isset($_POST['cidade'])?$_POST['cidade']:'';

            $_SESSION['estado_'.$sistema['bd']] = isset($_POST['estado'])?$_POST['estado']:'';

        }



        if (isset($_POST['acao'])) {

            foreach ($_POST['acao'] as $url) {

                foreach ($sistema['campos'] as $campo) {

                    if ($campo['input']=='image') {

                        foreach ($campo['parametros'] as $parametro) {

                            $rows = $Funcoes->select($campo['name'])->from(PREFIX.$sistema['bd'])->where(array('url' => $url))->fetch_first();

                            if ($Funcoes->affected_rows > 0) {

                                if (!empty($rows[$campo['name']])) {

                                    $Funcoes->deletar_aquivo(PATH_IMAGES.$sistema['bd'].SEP.$parametro['pasta'].SEP.$rows[$campo['name']]);

                                }

                            }

                        }

                    }

                }

                $Funcoes->delete()->from(PREFIX.$sistema['bd'])->where('url', $url)->limit(1)->execute();

            }

            $_SESSION['SYSTEM_MENSSAGE'] = 'Cadastro[s] excluído[s] com sucesso !';

            $_SESSION['SYSTEM_STATUS'] = 'success';

            $Funcoes->redirect(URL_PAINEL.$sistema['url']);

            exit();

        }

    }

    if (empty($_SESSION['busca_'.$sistema['bd']])&&empty($_SESSION['cidade_'.$sistema['bd']])&&empty($_SESSION['estado_'.$sistema['bd']])) {

        $_SESSION['busca_'.$sistema['bd']] = '';

        $_SESSION['cidade_'.$sistema['bd']] = '';

        $_SESSION['estado_'.$sistema['bd']] = '';

        $like = '';

    }else{

        $like = array();

        foreach ($sistema['serch'] as $campo) {

            $like[$campo] = $_SESSION['busca_'.$sistema['bd']];

        }

    }

    if (!empty($_SESSION['cidade_'.$sistema['bd']])) {

        $Funcoes->where('cidade = \''.$_SESSION['cidade_'.$sistema['bd']].'\'');

    }

    if (!empty($_SESSION['estado_'.$sistema['bd']])) {

        $Funcoes->where('estado = \''.$_SESSION['estado_'.$sistema['bd']].'\'');

    }

    if (isset($sistema['limitar_where'])) {

        if (isset($sistema['limitar_where']['nivel_de_acesso'])){

            if (isset($sistema['limitar_where']['where'])){

                $Funcoes->where($sistema['limitar_where']['where']);

            }

        }else{

            if (isset($sistema['limitar_where']['where'])){

                $Funcoes->where($sistema['limitar_where']['where']);

            }

        }

    }

    if (!empty($like)) {

        $Funcoes->or_like($like);

    }

    $Funcoes->select($sistema['primary'])->from(PREFIX.$sistema['bd'])->fetch();

    $num_row = $Funcoes->affected_rows;

    $num_row  = intval($num_row);

    if ($sistema['limitar']==true) {

        if ($num_row >= $sistema['quatidade_limite']) {

            $sistema['mostar_incluir'] = false;

        }else{

            $sistema['mostar_incluir'] = true;

        }

        $Funcoes->limit($sistema['quatidade_limite']);

        $total_pages = 0;

    }else{

        $total_pages = round($num_row / NUM_PAGENATION);

        $page_actual = 1;

        if (isset($url[2]) && is_numeric($url[2])) $page_actual = intval($url[2]);

        $begin = ($page_actual-1) * NUM_PAGENATION;

        $Funcoes->limit(NUM_PAGENATION,$begin);

    }

    if (isset($_SESSION['cidade_'.$sistema['bd']]) && !empty($_SESSION['cidade_'.$sistema['bd']])) {

        $Funcoes->where('cidade = \''.$_SESSION['cidade_'.$sistema['bd']].'\'');

    }

    if (isset($_SESSION['estado_'.$sistema['bd']]) && !empty($_SESSION['estado_'.$sistema['bd']])) {

        $Funcoes->where('estado = \''.$_SESSION['estado_'.$sistema['bd']].'\'');

    }

    if (isset($sistema['limitar_where'])) {

        if (isset($sistema['limitar_where']['nivel_de_acesso'])){

            if (in_array($_SESSION['admin_nivel_acesso'], $sistema['limitar_where']['nivel_de_acesso'])) {

                if (isset($sistema['limitar_where']['where'])){

                    $Funcoes->where($sistema['limitar_where']['where']);

                }

            }

        }else{

            if (isset($sistema['limitar_where']['where'])){

                $Funcoes->where($sistema['limitar_where']['where']);

            }

        }

    }

    if (!empty($like)) {

        $Funcoes->or_like($like);

    } ?>

    <div class="page-content">

        <div class="row">

            <div class="col-xs-12">

                <div class="page-header"><h1> <?php echo $sistema['titulo']; ?> </h1></div>

                <?php if ($_SESSION['SYSTEM_MENSSAGE']!='') {

                    echo $Funcoes->message_system($_SESSION['SYSTEM_MENSSAGE'], $_SESSION['SYSTEM_STATUS']);

                    $_SESSION['SYSTEM_MENSSAGE'] = '';

                } ?>

                <form id="busca" class="form-horizontal panel panel-default" method="POST">

                    <div class="panel-body">

                        <div class="col-xs-3">

                            <input type="search" class="form-control" placeholder="Buscar cadastros" name="busca" value="<?=$_SESSION['busca_'.$sistema['bd']]?>">

                        </div>

                        <?php if ($sistema['search_custom']): ?>

                            <div class="col-xs-4">

                                <select name="estado" id="estado"<?php echo(empty($_SESSION['estado_'.$sistema['bd']])?' data-uf="true" data-target="cidade"':' data-togle="true" data-target="cidade"'); ?>>

                                    <option value="">ESTADO</option>

                                    <?php if (!empty($_SESSION['estado_'.$sistema['bd']])): ?>

                                        <?php $url_webservice = 'https://ibge.herokuapp.com/estado/UF';

                                        $ch = curl_init();

                                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                                        curl_setopt($ch, CURLOPT_URL, $url_webservice);

                                        $result = curl_exec($ch);

                                        curl_close($ch);

                                        $array = array();

                                        $array = json_decode($result, true);

                                        foreach ($array as $key => $value) {

                                            if ($_SESSION['estado_'.$sistema['bd']] == $key) {

                                                $selected = ' selected="selected"';

                                            }else{

                                                $selected = '';

                                            }?>

                                            <option value="<?=$key?>"<?=$selected;?>><?=$key?></option>

                                        <?php } ?>

                                    <?php endif; ?>

                                </select>

                                <select name="cidade" id="cidade">

                                    <option value="">CIDADE</option>

                                    <?php if (!empty($_SESSION['estado_'.$sistema['bd']])): ?>

                                        <?php $url_webservice = 'https://ibge.herokuapp.com/municipio/?val='.$_SESSION['estado_'.$sistema['bd']];

                                        $ch = curl_init();

                                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                                        curl_setopt($ch, CURLOPT_URL, $url_webservice);

                                        $result = curl_exec($ch);

                                        curl_close($ch);

                                        $array = array();

                                        $array = json_decode($result, true);

                                        foreach ($array as $key => $value) {

                                            if ($_SESSION['cidade_'.$sistema['bd']] == $key) {

                                                $selected = ' selected="selected"';

                                            }else{

                                                $selected = '';

                                            }?>

                                            <option value="<?=$key?>"<?=$selected;?>><?=$key?></option>

                                        <?php } ?>

                                    <?php endif; ?>

                                </select>

                            </div>

                        <?php endif; ?>

                        <div class="col-xs-offset-1 col-xs-4">

                            <button type="submit" class="btn btn-default btn-sm"><i class="icon-search"></i> Buscar</button>

                            <?php if (!empty($_SESSION['busca_'.$sistema['bd']])||!empty($_SESSION['cidade_'.$sistema['bd']])||!empty($_SESSION['estado_'.$sistema['bd']])) { ?>

                                <a href="<?=URL_PAINEL.$sistema['url'];?>/limpar" class="btn btn-sm btn-primary"><i class="icon-asterisk"></i>Limpar</a>

                            <?php } ?>

                        </div>

                        <?php if ($_SESSION['admin_nivel_acesso']==1) { ?>

                            <a href="<?=URL_PAINEL.$sistema['url']?>/cadastrar" class="btn btn-sm btn-success pull-right"><i class="icon-asterisk"></i>Incluir</a>

                        <?php }else{

                            if ($sistema['mostar_incluir']) { ?>

                                <a href="<?=URL_PAINEL.$sistema['url']?>/cadastrar" class="btn btn-sm btn-success pull-right"><i class="icon-asterisk"></i>Incluir</a>

                            <?php }

                        }

                        if ($sistema['export_func']) { ?>

                            <a href="<?=URL_PAINEL.$sistema['url']?>/exportar" class="btn btn-sm btn-warning pull-left"><i class="icon-upload"></i>Exportar</a>

                            <?php if (!empty($_SESSION['csv_name_'.$sistema['bd']])) { ?>

                                <a href="<?=URL_PAINEL_BASE.'export/'.$_SESSION['csv_name_'.$sistema['bd']]?>" class="btn btn-sm btn-primary pull-left">

                                    <i class="icon-download"></i>Download

                                </a>

                            <?php }

                        } ?>

                    </div>

                </form>

                <div class="table-responsive">

                    <form action="<?=URL_PAINEL.$sistema['url']?>" method="POST" name="lista">

                        <button type="submit" class="btn btn-danger btn-sm pull-right" onclick=" return confirm('Deseja realmente excluir esse(s) Cadastro(s)?')">

                            <i class="icon-trash"></i>

                            Excluir cadastros selecionados

                        </button>

                        <table id="sample-table-2" class="table table-striped table-bordered table-hover">

                            <thead>

                                <tr>

                                    <th class="center">

                                        <label>

                                            <input type="checkbox" class="ace" name="checkall" id="checkall" onclick="check(document.getElementsByName('acao[]'),document.lista.checkall);" />

                                            <span class="lbl"></span>

                                        </label>

                                    </th>

                                    <?php $select = ' url, ';

                                    foreach ($sistema['list'] as $nome) {

                                        if (isset($nome['nivel_de_acesso'])&& in_array($_SESSION['admin_nivel_acesso'], $nome['nivel_de_acesso']) ) {

                                            echo '<th class="center">'.$nome['nome'].'</th>';

                                            $select .= $nome['bd'].', ';

                                        }

                                    }

                                    $select = substr($select, 0, -2); ?>

                                    <th class="center"></th>

                                </tr>

                            </thead>

                            <tbody id="conteudo_body">

                                <?php $resultados = $Funcoes->select($select)->from(PREFIX.$sistema['bd'])->order_by($sistema['order_by'],$sistema['ordem'])->fetch();

                                if ($Funcoes->affected_rows > 0) {

                                    foreach($resultados as $resultado){ ?>

                                        <tr>

                                            <td class="center">

                                                <label>

                                                    <input type="checkbox" class="ace" id="acao-<?=$resultado['url'];?>" name="acao[]" value="<?=$resultado['url'];?>" />

                                                    <span class="lbl"></span>

                                                </label>

                                            </td>

                                            <?php foreach ($sistema['list'] as $nome) {

                                                if (isset($nome['nivel_de_acesso'])&& in_array($_SESSION['admin_nivel_acesso'], $nome['nivel_de_acesso']) ) {



                                                    if ($nome['type']=='text') {

                                                        echo '<td class="center">'.$resultado[$nome['bd']].'</td>';

                                                    }elseif ($nome['type']=='incrementador') {

                                                        $resultado[$nome['bd']] = str_pad($resultado[$nome['bd']], 10, 0, STR_PAD_LEFT);

                                                        echo '<td class="center">'.$resultado[$nome['bd']].'</td>';

                                                    }elseif ($nome['type']=='code') {

                                                        echo '<td class="center">'.str_pad($resultado[$nome['bd']], $nome['category'], "0", STR_PAD_LEFT).'</td>';

                                                    }elseif ($nome['type']=='category') {

                                                        $name_bd_buscar = 'nome';

                                                        foreach ($sistema['campos'] as $value) {

                                                            if ($value['name']==$nome['bd']) {

                                                                if (empty($value['parametros'])) {

                                                                    $name_bd_buscar = 'nome';

                                                                }else{

                                                                    $name_bd_buscar = $value['parametros'];

                                                                }



                                                            }

                                                        }

                                                        $row = $Funcoes->select($name_bd_buscar)->from($nome['category'])->where(array('id' => $resultado[$nome['bd']] ))->fetch_first();

                                                        if ($Funcoes->affected_rows > 0) {

                                                            echo '<td class="center">'.$row[$name_bd_buscar].'</td>';

                                                        }else{

                                                            echo '<td class="center"></td>';

                                                        }

                                                    }elseif ($nome['type']=='category_plus_category') {

                                                        $name_bd_buscar = 'nome';

                                                        foreach ($sistema['campos'] as $value) {

                                                            if ($value['name']==$nome['bd']) {

                                                                $name_bd_buscar = $value['parametros']['name'];

                                                                $cat_name = $value['parametros']['name_category'];

                                                                $cat_table = $value['parametros']['category'];

                                                                $where_cat = $value['parametros']['where'];



                                                            }

                                                        }

                                                        $row = $Funcoes->select($where_cat.','.$name_bd_buscar)->from($nome['category'])->where(array('id' => $resultado[$nome['bd']] ))->fetch_first();

                                                        if ($Funcoes->affected_rows > 0) {



                                                            echo '<td class="center">'.$Funcoes->get_custom_by_id($cat_name,$cat_table,$row[$where_cat]).' - '.$row[$name_bd_buscar].'</td>';

                                                        }else{

                                                            echo '<td class="center"></td>';

                                                        }

                                                    }elseif ($nome['type']=='subcategory') {

                                                        $name_bd_buscar = 'nome';



                                                        foreach ($sistema['campos'] as $value) {

                                                            if ($value['name']==$nome['bd']) {

                                                                if (empty($value['parametros']['name'])) {

                                                                    $name_bd_buscar = 'nome';

                                                                }else{

                                                                    $name_bd_buscar = $value['parametros']['name'];

                                                                }



                                                            }

                                                        }



                                                        $row = $Funcoes->select($name_bd_buscar)->from($nome['category'])->where(array('id' => $resultado[$nome['bd']] ))->fetch_first();

                                                        if ($Funcoes->affected_rows > 0) {

                                                            echo '<td class="center">'.$row[$name_bd_buscar].'</td>';

                                                        }else{

                                                            echo '<td class="center"></td>';

                                                        }

                                                    }elseif ($nome['type']=='checkbox') {

                                                        if ($resultado[$nome['bd']]==1) {

                                                            $resultado[$nome['bd']] = '<span class="label label-sm label-success">Liberado</span>';

                                                        }else{

                                                            $resultado[$nome['bd']] = '<span class="label label-sm label-danger">Bloqueado</span>';

                                                        }

                                                        echo '<td class="center">'.$resultado[$nome['bd']].'</td>';

                                                    }elseif ($nome['type']=='image') {



                                                        $imagem = $resultado[$nome['bd']];

                                                        echo '<td class="center">';

                                                            if (!empty($resultado[$nome['bd']])) {



                                                                $real_path = PATH_IMAGES.$sistema['bd'].SEP;

                                                                $src_path = URL_UPLOAD_IMAGE.$sistema['bd'].'/';



                                                                echo '<img src="'.$Funcoes->image($imagem,300,200,$real_path,'redimencionar',100,$src_path).'" style="max-width:220px;max-height:110px;">';

                                                            }

                                                        echo '</td>';



                                                    }elseif ($nome['type']=='money') {

                                                        echo '<td class="center">'.$Funcoes->formatar_valores($resultado[$nome['bd']]).'</td>';

                                                    }elseif ($nome['type']=='date') {



                                                        $date = $resultado[$nome['bd']];

                                                        $date = strftime('%d/%m/%Y',strtotime($date));

                                                        echo '<td class="center">'.$date.'</td>';





                                                    }elseif ($nome['type']=='datetime') {

                                                        $datahora = $resultado[$nome['bd']];

                                                        $datahora = explode(' ', $datahora);

                                                        $data = $datahora[0];

                                                        $horas = $datahora[1];

                                                        $horas = explode(':', $horas);

                                                        $hora = $horas[0].':'.$horas[1];

                                                        echo '<td class="center">'.implode("/",array_reverse(explode("-", $data))).' as '.$hora.'</td>';

                                                    }

                                                }

                                            } ?>

                                            <td class="center">

                                                <?php if ($sistema['mostrar_alterar']) {  ?>

                                                    <a class="green" href="<?=URL_PAINEL.$sistema['url']?>/atualizar/<?=$resultado['url'];?>"><i class="icon-pencil bigger-130"></i></a>

                                                <?php } ?>

                                                <?php if ($sistema['mostrar_excluir']) {  ?>

                                                    <a class="red" href="<?=URL_PAINEL.$sistema['url']?>/excluir/<?=$resultado['url'];?>" onclick="return confirm('Deseja excluir esse cadastro?')">

                                                        <i class="icon-trash bigger-130"></i>

                                                    </a>

                                                <?php } ?>

                                                <?php if ($sistema['mostrar_clone']) {  ?>

                                                    <a class="orange" href="<?=URL_PAINEL.$sistema['url']?>/clone/<?=$resultado['url'];?>">

                                                        <i class="icon-files-o bigger-130"></i>

                                                    </a>

                                                <?php } ?>

                                            </td>

                                        </tr>

                                    <?php }

                                }else{ ?>

                                    <tr>

                                        <td colspan="99" class="center">

                                            Nenhum cadastro no momento

                                        </td>

                                    </tr>

                                <?php } ?>

                            </tbody>

                            <?php if ($total_pages>=1 && $num_row > NUM_PAGENATION ) { ?>

                                <tfoot>

                                    <tr>

                                        <td colspan="99" class="center">

                                            <?php $Funcoes->pagination_painel(URL_PAINEL.$sistema['url'].'/page/',$num_row,$page_actual); ?>

                                        </td>

                                    </tr>

                                </tfoot>

                            <?php } ?>

                        </table>

                    </form>

                </div>

            </div>

        </div>

    </div>

    <script type="text/javascript">

        function check(check_list,check){

            if (check.checked==true) {

                for (i = 0; i < check_list.length; i++)

                    check_list[i].checked = true ;

            }else{

                for (i = 0; i < check_list.length; i++)

                    check_list[i].checked = false ;

            }

        }

    </script>

<?php }elseif ($url[1]=='cadastrar') {

    if (isset($sistema['limitar_where'])) {

        if (isset($sistema['limitar_where']['nivel_de_acesso'])){

            if (isset($sistema['limitar_where']['where'])){

                $Funcoes->where($sistema['limitar_where']['where']);

            }

        }else{

            if (isset($sistema['limitar_where']['where'])){

                $Funcoes->where($sistema['limitar_where']['where']);

            }

        }

    }

    $Funcoes->select($sistema['primary'])->from(PREFIX.$sistema['bd'])->fetch();

    $num_row = $Funcoes->affected_rows;

    $num_row  = intval($num_row);

    if ($sistema['limitar']==true) {



        if ($num_row >= $sistema['quatidade_limite']) {

            $Funcoes->redirect(URL_PAINEL.$sistema['url']);

        }

    }

    if (!empty($_POST)) {

        if (isset($sistema['enviar_dados_por_email'])) {

            $message = '';

            foreach ($sistema['campos'] as $campo) {

                if ($campo['mostrar_campo']) {

                    if (is_array($campo['swap_reference'])) {

                        $input = $campo['swap_reference']['input'];

                        $value = $campo['swap_reference']['value'];

                        if ($_POST[$input]==$value) {

                            $message .= '<b>'.$campo['titulo'].'</b> '.$_POST[$campo['name']].'<br/>';

                        }

                    }elseif($campo['input']=='multiselect'){

                        $table = $campo['category'];

                        $parametros = $campo['parametros'];

                        $input = $sistema['bd'].'_'.$table;

                        $item = '';

                        foreach ($_POST[$input] as $index => $id) {

                            if ($index==0) {

                                $item = $Funcoes->get_custom_by_id($parametros['bd_select'],str_replace($_SESSION['LANG'], '', $table),$id);

                            }else{

                                $item .= ', '.$Funcoes->get_custom_by_id($parametros['bd_select'],str_replace($_SESSION['LANG'], '', $table),$id);

                            }

                        }

                        $message .= '<b>'.$campo['titulo'].'</b> '.$item.'<br/>';



                    }elseif($campo['input']=='dropdown_plus_more_options'){

                        $parametros = $campo['parametros'];

                        $post = $_POST[$parametros['fields'][0]['name']];

                        foreach ($post as $index => $valores) {

                            foreach ($parametros['fields'] as $key => $field) {

                                if($field['type']['input']=='category'){

                                    $table = $field['type']['parameters']['bd'];

                                    $name = $field['type']['parameters']['field'];

                                    $value = $Funcoes->get_custom_by_id($name,str_replace($_SESSION['LANG'], '', $table),$_POST[$field['name']][$index]);

                                    $message .= '<b>'.$field['label'].'</b> '.$value.' ';

                                }elseif($field['type']['input']=='money'){

                                    $message .= '<b>'.$field['label'].'</b> '.$_POST[$field['name']][$index].' ';

                                }elseif($field['type']['input']=='textarea'){

                                    $message .= '<b>'.$field['label'].'</b> '.$_POST[$field['name']][$index].' ';

                                }elseif($field['type']['input']=='text'){

                                    $message .= '<b>'.$field['label'].'</b> '.$_POST[$field['name']][$index].' ';

                                }elseif($field['type']['input']=='checkbox'){

                                    $message .= '<b>'.$field['label'].'</b> '.$_POST[$field['name']][$index].' ';

                                }

                            }

                            $message .= '<br/>';

                        }

                    }elseif($campo['input']=='category'){

                        $table = $campo['category'];

                        $parametros = $campo['parametros'];

                        $message .= '<b>'.$campo['titulo'].'</b> '.$Funcoes->get_custom_by_id($parametros,str_replace($_SESSION['LANG'], '', $table),$_POST[$campo['name']]).'<br/>';

                    }else{

                        if (isset($_POST[$campo['name']])) {

                            $message .= '<b>'.$campo['titulo'].'</b> '.$_POST[$campo['name']].'<br/>';

                        }



                    }



                }

            }

            if (isset($sistema['enviar_dados_por_email']['emails'])) {



                $select = $sistema['enviar_dados_por_email']['emails']['field'];

                $from = $sistema['enviar_dados_por_email']['emails']['tabela'];

                $where = $sistema['enviar_dados_por_email']['emails']['where'];



                $query = $Funcoes->select($select)->from($from)->where($where)->fetch_first();

                $emails = $query[$select];



                if (!empty($emails)) {

                    $emails = explode(chr(13), $emails);

                    $emails_send = array();

                    foreach ($emails as $key => $email) {

                        $emails_send[$email] = $email;

                    }

                    $Funcoes->sendEmail(EMAIL_LOGIN, NAME_SITE, $emails_send, $sistema['enviar_dados_por_email']['assunto'], $message, true);

                }



            }

        }



        foreach ($sistema['campos'] as $campo) {

            if ($campo['mostrar_campo']&&$campo['input']!='multiselect') {



                if ($campo['input'] == 'image'||$campo['input'] == 'archive') {

                    $files[$campo['name']] = $_FILES[$campo['name']];

                }else{

                    if (isset($_POST[$campo['name']])) {

                        $data[$campo['name']] = $_POST[$campo['name']];

                    }

                }

            }

            if ($campo['input']=='multiselect') {

                if (!empty($_POST[$sistema['bd'].'_'.$campo['category']])) {

                    $data_multi[$sistema['bd'].'_'.$campo['category']] = $_POST[$sistema['bd'].'_'.$campo['category']];

                }

            }

            if($campo['input']=='dropdown_plus_more_options'){

                $parametros = $campo['parametros'];

                $post = $_POST[$parametros['fields'][0]['name']];

                $multi_post = array();

                foreach ($post as $index => $valores) {

                    foreach ($parametros['fields'] as $key => $field) {

                        if ($field['type']['input']=='image'||$field['type']['input']=='archive') {



                            $tmp_name = $_FILES[$field['name']]['tmp_name'][$index];

                            $name = $_FILES[$field['name']]['name'][$index];

                            $temp = explode('.', $name);

                            $name = $temp[0];

                            $extension = end($temp);



                            $name_arquivo = $Funcoes->url_amigavel($name).'.'.$extension;

                            if ($field['type']['input']=='image') {

                                $Funcoes->criar_pasta(PATH_IMAGES);

                                $Funcoes->criar_pasta(PATH_IMAGES.$sistema['bd']);

                                $name_arquivo = $Funcoes->verificar_existe_imagem_nome(PATH_IMAGES.$sistema['bd'].SEP, $name_arquivo);

                                move_uploaded_file($tmp_name, PATH_IMAGES.$sistema['bd'].SEP.$name_arquivo);

                            }elseif ($field['type']['input']=='archive') {

                                $Funcoes->criar_pasta(PATH_ARCHIVES);

                                $Funcoes->criar_pasta(PATH_ARCHIVES.$sistema['bd']);

                                $name_arquivo = $Funcoes->verificar_existe_imagem_nome(PATH_ARCHIVES.$sistema['bd'].SEP, $name_arquivo);

                                move_uploaded_file($tmp_name, PATH_ARCHIVES.$sistema['bd'].SEP.$name_arquivo);

                            }

                            $multi_post[$index][$field['name']] = $name_arquivo;

                        }else{

                            if (!empty($_POST[$field['name']][$index])) {

                                $multi_post[$index][$field['name']] = $_POST[$field['name']][$index];

                            }

                        }

                    }

                }

                $data[$campo['name']] = json_encode($multi_post);

            }

        }



        $Funcoes->setData($data);



        if (!empty($data_multi)) {

            $Funcoes->setDataMulti($data_multi);

        }



        if (!empty($files)) { $Funcoes->setFiles($files); }

        if (isset($sistema['galeria'])) {

            foreach ($sistema['galeria'] as $galeria) {

                foreach ($galeria['campos'] as $campo) {

                    if ($campo['mostrar_campo']) {

                        if ($campo['input'] == 'image'||$campo['input'] == 'archive'||$campo['input'] == 'multi_image'||$campo['input'] == 'multi_archive') {

                            $files_galerias[$galeria['bd']][$campo['name']] = $_FILES[$galeria['bd'].'_'.$campo['name']];

                        }else{

                            $data_galerias[$galeria['bd']][$campo['name']] = $_POST[$galeria['bd'].'_'.$campo['name']];

                        }

                    }

                }

            }

            $Funcoes->setDataGalerias($data_galerias);

            $Funcoes->setFilesGalerias($files_galerias);

        }

        $Funcoes->cadastrar();

    }

    $data = $Funcoes->getData(); ?>

    <div class="page-header"><h1><?php echo $sistema['titulo_cadastro']; ?></h1></div>

    <div class="col-xs-12 form-group">

        <?php if ($_SESSION['admin_nivel_acesso']==1) { ?>

            <a href="<?=URL_PAINEL.$sistema['url']?>" class="btn btn-sm btn-default pull-right"><i class="icon-double-angle-left"></i>Voltar</a>

        <?php }else{

            if ($sistema['mostar_voltar']) { ?>

                <a href="<?=URL_PAINEL.$sistema['url']?>" class="btn btn-sm btn-default pull-right"><i class="icon-double-angle-left"></i>Voltar</a>

            <?php }

        } ?>

    </div>

    <div class="col-xs-12 form-group">

        <?php if ($_SESSION['SYSTEM_MENSSAGE']!='') {

            echo $Funcoes->message_system($_SESSION['SYSTEM_MENSSAGE'], $_SESSION['SYSTEM_STATUS']);

            $_SESSION['SYSTEM_MENSSAGE'] = '';

        }?>

    </div>

    <form method="post" enctype="multipart/form-data">

        <div class="col-xs-12">

            <?php foreach ($sistema['campos'] as $campo) {

                $show = true;

                if ($campo['mostrar_campo']) {

                    if ($campo['input']=='dropdown_plus_more_options') {

                        echo '<div class="row" id="area_multi_'.$campo['name'].'">'; ?>

                            <div class="col-md-3" style="outline: 5px solid #e3e3e3; padding: 25px;">

                                <div class="text-center"> <label><?php echo $campo['titulo']; ?></label> </div>

                                <?php foreach ($campo['parametros']['fields'] as $index => $field): ?>

                                    <div style="margin-bottom: 10px;">

                                        <?php if ($field['type']['input'] == 'money') { ?>

                                            <div class="input-group full-width">

                                                <div class="input-group bootstrap-timepicker">

                                                    <input name="<?php echo $field['name'] ?>[]" type="text" class="form-control input-mask-money" value="" placeholder="<?php echo $field['label'] ?>" />

                                                    <span class="input-group-addon"><i class="icon-money bigger-110"></i></span>

                                                </div>

                                            </div>

                                        <?php } ?>

                                        <?php if ($field['type']['input'] == 'textarea') { ?>

                                            <textarea type="text" class="full-width" name="<?php echo $field['name'] ?>[]" style="height:200px;" placeholder="<?php echo $field['label'] ?>" ></textarea>

                                        <?php } ?>

                                        <?php if ($field['type']['input'] == 'image') { ?>

                                            <label>

                                                <?php echo $field['label'] ?>

                                                <input type="file" name="<?php echo $field['name'];?>[]">

                                            </label>

                                        <?php } ?>

                                        <?php if ($field['type']['input'] == 'archive') { ?>

                                            <label>

                                                <?php echo $field['label'] ?>

                                                <input type="file" name="<?php echo $field['name'];?>[]">

                                            </label>

                                        <?php } ?>

                                        <?php if ($field['type']['input'] == 'text') { ?>

                                            <input name="<?php echo $field['name'] ?>[]" type="text" class="full-width" value="" placeholder="<?php echo $field['label'] ?>" />

                                        <?php } ?>

                                        <?php if ($field['type']['input'] == 'checkbox') { ?>

                                            <label>

                                                <?php echo $field['label'] ?>

                                                <input name="<?php echo $field['name'] ?>[0]" id="<?php echo $field['name'] ?>[0]" class="ace ace-switch ace-switch-6" type="checkbox" value="1" />

                                                <span class="lbl"></span>

                                            </label>

                                        <?php } ?>

                                        <?php if ($field['type']['input'] == 'category') { ?>

                                            <select name="<?php echo $field['name'] ?>[]" class="full-width">

                                                <option value=""><?php echo $field['label'] ?></option>

                                                <?php $Funcoes->select('id,'.$field['type']['parameters']['field']);

                                                $query = $Funcoes->from($field['type']['parameters']['bd'])->fetch();

                                                if ($Funcoes->affected_rows > 0) {

                                                    foreach($query as $base){  ?>

                                                        <option value="<?php echo $base['id']; ?>"<?php echo $selected; ?>>

                                                            <?php echo $base[$field['type']['parameters']['field']]; ?>

                                                        </option>

                                                    <?php }

                                                } ?>

                                            </select>

                                        <?php } ?>

                                    </div>

                                <?php endforeach; ?>

                                <button type="remove-this-<?php echo $campo['name'];?>" class="btn btn-danger btn-sm pull-right">Remover</button>

                            </div>

                        <?php echo '</div>'; ?>

                        <div class="col-md-12">

                            <button type="add-more-<?php echo $campo['name'];?>" class="btn btn-success btn-sm pull-right">Adicionar mais <?php echo $campo['titulo']; ?></button>

                        </div>

                    <?php }else{

                        if ($campo['div']['abertura']) { ?>

                            <div class="row">

                        <?php } ?>

                            <?php if (@$campo['swap_reference']) {

                                $swap_reference_input = $campo['swap_reference']['input'];

                                $swap_reference_value = $campo['swap_reference']['value'];

                                $attr_data = 'data-troca-'.$swap_reference_input.'="true" data-swap-'.$swap_reference_input.'="'.$swap_reference_value.'"';

                                if ($data[$swap_reference_input]==$swap_reference_value) {

                                    $attr_style =' style="margin-bottom: 10px;"';

                                }else{

                                    $attr_style =' style="margin-bottom: 10px; display:none;"';

                                }

                            }else{

                                $attr_data = '';

                                $attr_style = ' style="margin-bottom: 10px;"';

                            } ?>

                            <?php if (isset($campo['pre_select_logado'])){

                                if (isset($campo['pre_select_logado']['nivel_de_acesso'])&&$campo['pre_select_logado']['nivel_de_acesso']==$_SESSION['admin_nivel_acesso']) {

                                    $show = (isset($campo['pre_select_logado']['show'])?$campo['pre_select_logado']['show']:true);

                                }



                            }

                            if ($show==false){

                                $attr_style =' style="margin-bottom: 10px; display:none;"';

                            } ?>

                            <div class="<?php echo $campo['class_titulo'];?>"<?php echo $attr_data.$attr_style; ?>>

                                <label><?php echo $campo['titulo'];?></label>

                            </div>

                            <div class="<?php echo $campo['class'];?>"<?php echo $attr_data.$attr_style; ?>>

                                <?php if ($campo['input'] == 'text') { ?>

                                    <input type="text" name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>" class="full-width" maxlength="<?php echo $campo['amount'];?>" value="<?=isset($data[$campo['name']])?$data[$campo['name']]:'';?>">

                                <?php }

                                if ($campo['input'] == 'cep') { ?>

                                    <input type="cep" name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>" class="full-width" maxlength="<?php echo $campo['amount'];?>" value="<?=isset($data[$campo['name']])?$data[$campo['name']]:'';?>">

                                <?php }

                                if ($campo['input'] == 'incrementador') {

                                    $query = $Funcoes->select($campo['name'])->from(PREFIX.$sistema['bd'])->order_by('id','DESC')->fetch_first();

                                    if ($Funcoes->affected_rows > 0){

                                        $incrementador = $query[$campo['name']];

                                        $incrementador = preg_replace('/[^0-9]/', '', $incrementador);

                                        $incrementador = str_replace(0, '', $incrementador);

                                        $incrementador ++;

                                    }



                                    if ($incrementador<1) { $incrementador = 1; }



                                    $incrementador = str_pad($incrementador, 10, 0, STR_PAD_LEFT); ?>

                                    <input type="text" name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>" class="full-width text-center" maxlength="<?php echo $campo['amount'];?>" value="<?=$incrementador;?>" readonly>

                                <?php }

                                if ($campo['input'] == 'int') { ?>

                                    <input type="text" name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>" class="full-width input-mask-int text-center" maxlength="<?php echo $campo['amount'];?>" value="<?=$data[$campo['name']];?>">

                                <?php }

                                if ($campo['input'] == 'select') {   ?>

                                    <select name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>">

                                        <option value=""></option>

                                        <?php $dados_conteudo = end($campo['parametros']);

                                        foreach ($dados_conteudo['conteudo'] as $key => $value) {

                                            if ($data[$campo['name']]==$key) {

                                                $select = ' selected';

                                            }else{

                                                $select = '';

                                            } ?>

                                            <option value="<?php echo $key; ?>"<?php echo $select; ?>><?php echo $value; ?></option>

                                        <?php } ?>

                                    </select>

                                <?php }

                                if ($campo['input'] == 'color') { ?>

                                    <input type="color" name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>" class="full-width" maxlength="<?php echo $campo['amount'];?>" value="<?=$data[$campo['name']];?>">

                                <?php }

                                if ($campo['input'] == 'cpf') { ?>

                                    <input type="cpf" name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>" class="full-width text-center" maxlength="<?php echo $campo['amount'];?>" value="<?=$data[$campo['name']];?>">

                                <?php }

                                if ($campo['input'] == 'cnpj') { ?>

                                    <input type="cnpj" name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>" class="full-width text-center" maxlength="<?php echo $campo['amount'];?>" value="<?=$data[$campo['name']];?>">

                                <?php }

                                if ($campo['input'] == 'date') {

                                    $data[$campo['name']] = explode(' ', $data[$campo['name']]); ?>

                                    <div class="input-group">

                                        <div class="input-group">

                                            <input class="form-control input-mask-date date-picker" type="text" id="<?php echo $campo['name'];?>" name="<?php echo $campo['name'];?>" value="<?=$data[$campo['name']][0];?>" />

                                            <span class="input-group-addon"><i class="icon-calendar bigger-110"></i></span>

                                        </div>

                                    </div>

                                <?php }

                                if ($campo['input'] == 'datetime') {

                                    $data[$campo['name']] = str_replace(' ', 'T', $data[$campo['name']]); ?>

                                    <div class="input-group">

                                        <div class="input-group">

                                            <input class="form-contro" type="datetime-local" id="<?php echo $campo['name'];?>" name="<?php echo $campo['name'];?>" value="<?=$data[$campo['name']];?>" />

                                            <span class="input-group-addon"><i class="icon-calendar bigger-110"></i></span>

                                        </div>

                                    </div>

                                <?php }

                                if ($campo['input'] == 'time') { ?>

                                    <div class="input-group">

                                        <div class="input-group bootstrap-timepicker">

                                            <input class="form-control time-picker" type="text" id="<?php echo $campo['name'];?>" name="<?php echo $campo['name'];?>" value="<?=$data[$campo['name']];?>" />

                                            <span class="input-group-addon"><i class="icon-time bigger-110"></i></span>

                                        </div>

                                        <small class="text-success">hh:mm:ss</small>

                                    </div>

                                <?php }

                                if ($campo['input'] == 'money') { ?>

                                    <div class="input-group">

                                        <div class="input-group bootstrap-timepicker">

                                            <input id="<?php echo $campo['name'];?>" name="<?php echo $campo['name'];?>" type="text" class="form-control input-mask-money" value="<?=$data[$campo['name']];?>" />

                                            <span class="input-group-addon"><i class="icon-money bigger-110"></i></span>

                                        </div>

                                    </div>

                                <?php }

                                if ($campo['input'] == 'image') { ?>

                                    <input type="file" id="<?php echo $campo['name'];?>" name="<?php echo $campo['name'];?>">

                                <?php }

                                if ($campo['input'] == 'estados') { ?>

                                    <select name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>" data-uf="true" data-target="<?=$campo['parametros']?>">

                                        <option value=""></option>

                                        <?php if (!empty($data[$campo['name']])) {

                                            $url_webservice = 'https://ibge.herokuapp.com/municipio/?val='.$resultado[$campo['parametros']];

                                            $ch = curl_init();

                                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                                            curl_setopt($ch, CURLOPT_URL, $url_webservice);

                                            $result = curl_exec($ch);

                                            curl_close($ch);

                                            $array = array();

                                            $array = json_decode($result, true);

                                            foreach ($array as $key => $value) {

                                                if ($data[$campo['name']] == $key) {

                                                    $selected = ' selected="selected"';

                                                }else{

                                                    $selected = '';

                                                }?>

                                                <option value="<?=$key?>"<?=$selected;?>><?=$key?></option>

                                            <?php }

                                        }else{ ?>

                                            <script type="text/javascript">

                                                $(function() {

                                                    $.getJSON("https://ibge.herokuapp.com/estado/UF", function(result){

                                                        $.each(result, function(sigla, code){

                                                            $('select[data-uf="true"]').append($('<option>', {

                                                                value: sigla,

                                                                text: sigla

                                                            }));

                                                        });

                                                    });

                                                });

                                            </script>

                                        <?php } ?>

                                    </select>

                                <?php }

                                if ($campo['input'] == 'cidades') { ?>

                                    <select name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>">

                                        <option value=""></option>

                                        <?php if (!empty($data[$campo['parametros']])) {

                                            $url_webservice = 'https://ibge.herokuapp.com/municipio/?val='.$resultado[$campo['parametros']];

                                            $ch = curl_init();

                                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                                            curl_setopt($ch, CURLOPT_URL, $url_webservice);

                                            $result = curl_exec($ch);

                                            curl_close($ch);

                                            $array = array();

                                            $array = json_decode($result, true);

                                            foreach ($array as $key => $value) {

                                                if ($data[$campo['name']] == $key) {

                                                    $selected = ' selected="selected"';

                                                }else{

                                                    $selected = '';

                                                }?>

                                                <option value="<?=$key?>"<?=$selected;?>><?=$key?></option>

                                            <?php }

                                        } ?>

                                    </select>

                                <?php }

                                if ($campo['input'] == 'category') {

                                    $where = 'status = 1';

                                    if (isset($campo['pre_select_logado'])){

                                        if (isset($campo['pre_select_logado']['nivel_de_acesso'])&&$campo['pre_select_logado']['nivel_de_acesso']==$_SESSION['admin_nivel_acesso']) {

                                            $data[$campo['name']] = $campo['pre_select_logado']['id'];

                                            if (isset($campo['pre_select_logado']['where'])) {

                                                $where .= ' AND '.$campo['pre_select_logado']['where'];

                                            }

                                        }

                                    } ?>

                                    <select name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>">

                                        <option value=""></option>

                                        <?php $resultados = $Funcoes->select('id, '.$campo['parametros'])->from($campo['category'])->where($where)->fetch();

                                        if ($Funcoes->affected_rows > 0) {

                                            foreach($resultados as $resultado){

                                                if ($data[$campo['name']] == $resultado['id']) {

                                                    $selected = ' selected="selected"';

                                                }else{

                                                    $selected = '';

                                                }  ?>

                                                <option value="<?php echo $resultado['id']; ?>"<?php echo $selected; ?>><?php echo $resultado[$campo['parametros']]; ?></option>

                                            <?php }

                                        } ?>

                                    </select>

                                <?php }

                                if ($campo['input'] == 'category_plus_category') { ?>

                                    <select name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>">

                                        <option value=""></option>

                                        <?php $resultados = $Funcoes->select('id,'.$campo['parametros']['name'].','.$campo['parametros']['where'])->from($campo['category'])->where(array('status' => 1 ))->fetch();

                                        if ($Funcoes->affected_rows > 0) {

                                            foreach($resultados as $resultado){

                                                if ($data[$campo['name']] == $resultado['id']) {

                                                    $selected = ' selected="selected"';

                                                }else{

                                                    $selected = '';

                                                }  ?>

                                                <option value="<?php echo $resultado['id']; ?>"<?php echo $selected; ?>><?php echo $Funcoes->get_custom_by_id($campo['parametros']['name_category'],$campo['parametros']['category'],$resultado[$campo['parametros']['where']]).' - '.$resultado[$campo['parametros']['name']]; ?></option>

                                            <?php }

                                        } ?>

                                    </select>

                                <?php }

                                if ($campo['input'] == 'subcategory') { ?>

                                    <select name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>">

                                        <option value=""></option>

                                    </select>

                                <?php }

                                if ($campo['input'] == 'multiselect_subcategory') { ?>

                                    <select name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>">

                                        <option value=""></option>

                                    </select>

                                <?php }

                                if ($campo['input'] == 'archive') { ?>

                                    <input type="file" id="<?php echo $campo['name'];?>" name="<?php echo $campo['name'];?>">

                                <?php }

                                if ($campo['input'] == 'textarea') { ?>

                                    <textarea type="text" class="full-width" rows="<?php echo $campo['parametros']['rows']; ?>" maxlength="<?php echo $campo['amount'];?>" name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>" style="height:200px;"><?= isset($data[$campo['name']])?html_entity_decode($data[$campo['name']]):'';?></textarea>

                                <?php }

                                if ($campo['input'] == 'editor') { ?>

                                    <textarea type="text" class="full-width" name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>"><?=isset($data[$campo['name']])?$data[$campo['name']]:'';?></textarea>

                                <?php }

                                if ($campo['input'] == 'checkbox') {

                                    if (isset($data[$campo['name']])) {

                                        if ($data[$campo['name']]==1) {

                                            $data[$campo['name']] = ' checked="checked"';

                                        }

                                    } ?>

                                    <label>

                                        <input name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>" class="ace ace-switch ace-switch-6" type="checkbox"<?php echo(isset($data[$campo['name']])?$data[$campo['name']]:'');?> value="1" />

                                        <span class="lbl"></span>

                                    </label>

                                <?php }

                                if ($campo['input'] == 'multiselect') {



                                    $resultados = $Funcoes->select('id, '.$campo['parametros']['bd_select'])->from(PREFIX.$campo['category'])->fetch();

                                    if ($Funcoes->affected_rows > 0) {

                                        foreach($resultados as $resultado){

                                            $id = $resultado['id'];

                                            $nome = $resultado[$campo['parametros']['bd_select']]; ?>

                                            <label>

                                                <input type="checkbox" class="ace ace-checkbox-2" name="<?php echo $sistema['bd'].'_'.$campo['category']; ?>[]" value="<?php echo $id; ?>">

                                                <span class="lbl"><?php echo $nome; ?></span>

                                            </label>

                                            <?php

                                        }

                                    }



                                } ?>

                            </div>

                        <?php if ($campo['div']['fechamento']) { ?>

                            </div>

                        <?php }

                    }

                }

            } ?>

            <?php if (isset($sistema['galeria'])) {



                 foreach ($sistema['galeria'] as $galeria) {



                    echo '<div class="col-xs-12"><h4 class="header smaller">'.$galeria['titulo'].'</h4></div> ';



                    foreach ($galeria['campos'] as $campo) {

                        if ($campo['mostrar_campo']) { ?>

                            <div class="row">

                                <div class="col-xs-3 align-r">

                                    <label><?php echo $campo['titulo'];?></label>

                                </div>

                                <div class="<?php echo $campo['class'];?>">

                                    <?php if ($campo['input'] == 'text') { ?>

                                        <input type="text" name="<?php echo $galeria['bd'].'_'.$campo['name'];?>" id="<?php echo $galeria['bd'].'_'.$campo['name'];?>" class="full-width" maxlength="<?php echo $campo['amount'];?>" value="<?=isset($data[$galeria['bd'].'_'.$campo['name']])?$data[$galeria['bd'].'_'.$campo['name']]:'';?>">

                                    <?php }

                                    if ($campo['input'] == 'category') { ?>

                                        <select name="<?php echo $galeria['bd'].'_'.$campo['name'];?>" id="<?php echo $galeria['bd'].'_'.$campo['name'];?>">

                                            <option value=""></option>

                                            <?php $rows = $Funcoes->select('id, '.$campo['parametros'])->from($campo['category'])->where(array('status' => 1 ))->fetch();

                                            if ($Funcoes->affected_rows > 0) {

                                                foreach($rows as $row){

                                                    if ($resultado[$campo['name']]==$row['id']) {

                                                        $selected = ' selected="selected"';

                                                    }else{

                                                        $selected = '';

                                                    } ?>

                                                    <option value="<?php echo $row['id']; ?>"<?php echo $selected; ?>><?php echo $row[$campo['parametros']]; ?></option>

                                                <?php }

                                            } ?>

                                        </select>

                                    <?php }

                                    if ($campo['input'] == 'image') { ?>

                                        <input type="file" id="<?php echo $galeria['bd'].'_'.$campo['name'];?>" name="<?php echo $galeria['bd'].'_'.$campo['name'];?>">

                                    <?php }

                                    if ($campo['input'] == 'multi_image') { ?>

                                        <input type="file" id="<?php echo $galeria['bd'].'_'.$campo['name'];?>" name="<?php echo $galeria['bd'].'_'.$campo['name'];?>[]" multiple>

                                    <?php }

                                    if ($campo['input'] == 'archive') { ?>

                                        <input type="file" id="<?php echo $galeria['bd'].'_'.$campo['name'];?>" name="<?php echo $galeria['bd'].'_'.$campo['name'];?>">

                                    <?php }

                                    if ($campo['input'] == 'multi_archive') { ?>

                                        <input type="file" id="<?php echo $galeria['bd'].'_'.$campo['name'];?>" name="<?php echo $galeria['bd'].'_'.$campo['name'];?>[]" multiple>

                                    <?php }

                                    if ($campo['input'] == 'textarea') { ?>

                                        <textarea type="text" style="height:200px;" class="full-width" rows="<?php echo $campo['parametros']['rows']; ?>" maxlength="<?php echo $campo['amount'];?>" name="<?php echo $galeria['bd'].'_'.$campo['name'];?>" id="<?php echo $galeria['bd'].'_'.$campo['name'];?>">

                                            <?= html_entity_decode($data[$galeria['bd'].'_'.$campo['name']]) ;?>

                                        </textarea>

                                    <?php }

                                    if ($campo['input'] == 'editor') { ?>

                                        <textarea type="text" class="full-width" name="<?php echo $galeria['bd'].'_'.$campo['name'];?>" id="<?php echo $galeria['bd'].'_'.$campo['name'];?>"><?=$data[$galeria['bd'].'_'.$campo['name']];?></textarea>

                                    <?php }

                                    if ($campo['input'] == 'checkbox') {

                                        if ($data[$galeria['bd'].'_'.$campo['name']]==1) {

                                            $data[$galeria['bd'].'_'.$campo['name']] = ' checked="checked"';

                                         } ?>

                                        <label>

                                            <input name="<?php echo $galeria['bd'].'_'.$campo['name'];?>" id="<?php echo $galeria['bd'].'_'.$campo['name'];?>" class="ace ace-switch ace-switch-6" type="checkbox"<?=$data[$galeria['bd'].'_'.$campo['name']];?> value="1" />

                                            <span class="lbl"></span>

                                        </label>

                                    <?php } ?>

                                </div>

                            </div>

                            <br>

                        <?php }

                    }

                }

            } ?>

            <div class="clearfix form-actions">

                <div class="col-sm-12 text-center">

                    <button type="submit" class="btn btn-success btn-sm">Cadastrar</button>

                </div>

            </div>

        </div>

    </form>

    <div class="col-xs-12 form-group">

        <?php if ($_SESSION['admin_nivel_acesso']==1) { ?>

            <a href="<?=URL_PAINEL.$sistema['url']?>" class="btn btn-sm btn-default pull-right"><i class="icon-double-angle-left"></i>Voltar</a>

        <?php }else{

            if ($sistema['mostar_voltar']) { ?>

                <a href="<?=URL_PAINEL.$sistema['url']?>" class="btn btn-sm btn-default pull-right"><i class="icon-double-angle-left"></i>Voltar</a>

            <?php }

        } ?>

    </div>

<?php }elseif ($url[1]=='atualizar') {

    $select = '';

    foreach ($sistema['campos'] as $nome) {

        if ($nome['input']=='multiselect') {

        }else{

            $select .= $nome['name'].', ';

        }

    }

    $select = substr($select, 0, -2);

    if (isset($url[3])) {

        if ($url[3]=='remover_imagem') {



            foreach ($sistema['campos'] as $campo) {

                if ($campo['input']=='image'&&$campo['name']==$url[4]) {



                    $rows = $Funcoes->select($campo['name'])->from(PREFIX.$sistema['bd'])->where(array('url' => $url[2]))->fetch_first();

                    if ($Funcoes->affected_rows > 0) {

                        if (!empty($rows[$campo['name']])) {

                            $Funcoes->delete_images_from_path(PATH_IMAGES.$sistema['bd'].SEP,$rows[$campo['name']]);

                        }

                    }



                }

            }



            $_SESSION['SYSTEM_MENSSAGE'] = 'Imagem removida com sucesso !';

            $_SESSION['SYSTEM_STATUS'] = 'success';



            $Funcoes->where(array('url' => $url[2]))->update(PREFIX.$sistema['bd'], array($url[4] => ''));



            $Funcoes->redirect(URL_PAINEL.$sistema['url'].'/atualizar/'.$url[2]);

            exit();

        }

    }



    if (isset($url[3])) {

        if ($url[3]=='remover_arquivo') {



            foreach ($sistema['campos'] as $campo) {

                if ($campo['input']=='archive'&&$campo['name']==$url[4]) {

                    $rows = $Funcoes->select($campo['name'])->from(PREFIX.$sistema['bd'])->where(array('url' => $url[2]))->fetch_first();

                    if ($Funcoes->affected_rows > 0) {

                        if (!empty($rows[$campo['name']])) {

                            $Funcoes->deletar_aquivo(PATH_ARCHIVES.$sistema['bd'].SEP.$rows[$campo['name']]);

                        }

                    }

                }

            }



            $_SESSION['SYSTEM_MENSSAGE'] = 'Imagem removida com sucesso !';

            $_SESSION['SYSTEM_STATUS'] = 'success';



            $Funcoes->where(array('url' => $url[2]))->update(PREFIX.$sistema['bd'], array($url[4] => ''));



            $Funcoes->redirect(URL_PAINEL.$sistema['url'].'/atualizar/'.$url[2]);

            exit();

        }

    }





    if (!empty($_POST)) {



        $resultado = $Funcoes->select('id')->from(PREFIX.$sistema['bd'])->where(array('url' => $url[2] ))->fetch_first();

        if ($Funcoes->affected_rows > 0) {



            $id = $resultado['id'];

            $Funcoes->setId($id);



        }else{

            $Funcoes->redirect(URL_PAINEL.$sistema['url']);

            exit();

        }





        foreach ($sistema['campos'] as $campo) {



            if ($campo['mostrar_campo']&&$campo['input']!='multiselect') {



                if ($campo['input'] == 'image'||$campo['input'] == 'archive') {



                    if (isset($_FILES[$campo['name']])) {

                        $files[$campo['name']] = $_FILES[$campo['name']];

                    }



                }else{

                    if (isset($_POST[$campo['name']])) {

                        $data[$campo['name']] = $_POST[$campo['name']];

                    }



                }



            }



            if ($campo['input']=='multiselect') {

                if (!empty($_POST[$sistema['bd'].'_'.$campo['category']])) {

                    $data_multi[$sistema['bd'].'_'.$campo['category']] = $_POST[$sistema['bd'].'_'.$campo['category']];

                }

            }

            if($campo['input']=='dropdown_plus_more_options'){

                $parametros = $campo['parametros'];

                $post = $_POST[$parametros['fields'][0]['name']];

                $multi_post = array();

                $resultado = $Funcoes->select($campo['name'])->from(PREFIX.$sistema['bd'])->where(array('url' => $url[2] ))->fetch_first();

                $json = json_decode($resultado[$campo['name']],true);

                foreach ($post as $index => $valores) {

                    foreach ($parametros['fields'] as $key => $field) {

                        if ($field['type']['input']=='image'||$field['type']['input']=='archive') {

                            $tmp_name = $_FILES[$field['name']]['tmp_name'][$index];

                            $name = $_FILES[$field['name']]['name'][$index];



                            if (empty($tmp_name)) {

                                $name_arquivo = $json[$index][$field['name']];

                            }else{





                                $temp = explode('.', $name);

                                $name = $temp[0];

                                $extension = end($temp);



                                $name_arquivo = $Funcoes->url_amigavel($name).'.'.$extension;

                                if ($field['type']['input']=='image') {

                                    $Funcoes->criar_pasta(PATH_IMAGES);

                                    $Funcoes->criar_pasta(PATH_IMAGES.$sistema['bd']);

                                    $name_arquivo = $Funcoes->verificar_existe_imagem_nome(PATH_IMAGES.$sistema['bd'].SEP, $name_arquivo);

                                    move_uploaded_file($tmp_name, PATH_IMAGES.$sistema['bd'].SEP.$name_arquivo);

                                }elseif ($field['type']['input']=='archive') {

                                    $Funcoes->criar_pasta(PATH_ARCHIVES);

                                    $Funcoes->criar_pasta(PATH_ARCHIVES.$sistema['bd']);

                                    $name_arquivo = $Funcoes->verificar_existe_imagem_nome(PATH_ARCHIVES.$sistema['bd'].SEP, $name_arquivo);

                                    move_uploaded_file($tmp_name, PATH_ARCHIVES.$sistema['bd'].SEP.$name_arquivo);

                                }

                            }

                            $multi_post[$index][$field['name']] = $name_arquivo;

                        }else{

                            if (!empty($_POST[$field['name']][$index])) {

                                $multi_post[$index][$field['name']] = $_POST[$field['name']][$index];

                            }

                        }

                    }

                }

                $data[$campo['name']] = json_encode($multi_post);

            }

        }



        $Funcoes->setData($data);



        if (!empty($data_multi)) {

            $Funcoes->setDataMulti($data_multi);

        }



        $resultado = $data;



        if (!empty($files)) {

            $Funcoes->setFiles($files);

        }



        if (isset($sistema['galeria'])) {



            foreach ($sistema['galeria'] as $galeria) {



                foreach ($galeria['campos'] as $campo) {



                    if ($campo['mostrar_campo']) {



                        if ($campo['input'] == 'image'||$campo['input'] == 'archive'||$campo['input'] == 'multi_image'||$campo['input'] == 'multi_archive') {



                            $files_galerias[$galeria['bd']][$campo['name']] = isset($_FILES[$galeria['bd'].'_'.$campo['name']])?$_FILES[$galeria['bd'].'_'.$campo['name']]:'';



                        }else{



                            $data_galerias[$galeria['bd']][$campo['name']] = isset($_POST[$galeria['bd'].'_'.$campo['name']])?$_POST[$galeria['bd'].'_'.$campo['name']]:'';



                        }



                    }



                }



            }



            $Funcoes->setDataGalerias($data_galerias);

            $Funcoes->setFilesGalerias($files_galerias);



        }



        $Funcoes->atualizar();



    }else{

        $resultado = $Funcoes->select($select)->from(PREFIX.$sistema['bd'])->where(array('url' => $url[2] ))->fetch_first();

        if ($Funcoes->affected_rows > 0) {





        }else{

            $Funcoes->redirect(URL_PAINEL.$sistema['url']);

            exit();

        }

    }



    ?>

    <div class="page-header">

        <h1> <?php echo $sistema['titulo_atualizar']; ?> </h1>

    </div>



    <div class="col-xs-12 form-group">

        <?php if ($_SESSION['admin_nivel_acesso']==1) { ?>

            <a href="<?=URL_PAINEL.$sistema['url']?>" class="btn btn-sm btn-default pull-right"><i class="icon-double-angle-left"></i>Voltar</a>

        <?php }else{

            if ($sistema['mostar_voltar']) { ?>

                <a href="<?=URL_PAINEL.$sistema['url']?>" class="btn btn-sm btn-default pull-right"><i class="icon-double-angle-left"></i>Voltar</a>

            <?php }

        } ?>

    </div>

    <div class="col-xs-12 form-group">

        <?php if ($_SESSION['SYSTEM_MENSSAGE']!='') {

            echo $Funcoes->message_system($_SESSION['SYSTEM_MENSSAGE'], $_SESSION['SYSTEM_STATUS']);

            $_SESSION['SYSTEM_MENSSAGE'] = '';

        }?>

    </div>

    <form method="post" enctype="multipart/form-data">

        <div class="col-xs-12">

            <?php foreach ($sistema['campos'] as $campo) {

                if ($campo['mostrar_campo']) {

                    $show = true;

                    if (isset($campo['parametros'][0]['only'])) {

                        if (in_array($url[2], $campo['parametros'][0]['only'])) {

                            if ($campo['input']=='dropdown_plus_more_options') {

                                $json = $resultado[$campo['name']];

                                $result_json = json_decode($json);

                                echo '<div class="row" id="area_multi_'.$campo['name'].'">'; ?>

                                    <?php if(count($result_json) > 0):

                                        foreach ($result_json as $index_2 => $json): ?>

                                            <div class="col-md-3" style="outline: 5px solid #e3e3e3; padding: 25px;">

                                                <div class="text-center"> <label><?php echo $campo['titulo']; ?></label> </div>

                                                <?php foreach ($campo['parametros']['fields'] as $index => $field): ?>

                                                    <div style="margin-bottom: 10px;">

                                                        <?php if ($field['type']['input'] == 'image') { ?>

                                                            <?php if (isset($json->{$field['name']})) {

                                                                $imagem = $json->{$field['name']};

                                                                $src_path = URL_UPLOAD_IMAGE.$sistema['bd'].'/';

                                                                $real_path = PATH_IMAGES.$sistema['bd'].SEP; ?>

                                                                <div class="input-group full-width text-center">

                                                                    Imagem atual<br/>

                                                                    <img src="<?php echo $Funcoes->image($imagem,320,220,$real_path,'redimencionar',100,$src_path); ?>" class="img-responsive" style="display: initial;">

                                                                </div>

                                                            <?php } ?>

                                                            <label>

                                                                <?php echo $field['label'] ?>

                                                                <input type="file" name="<?php echo $field['name'];?>[]">

                                                            </label>

                                                        <?php } ?>

                                                        <?php if ($field['type']['input'] == 'archive') { ?>

                                                            <?php if (isset($json[$field['name']])) {

                                                                $arquivo = $json[$field['name']]; ?>

                                                                <div class="input-group full-width text-center">

                                                                    <a href="<?php echo URL_UPLOAD_ARCHIVE.$sistema['bd'].'/'.$arquivo;?>" target="_blank">

                                                                        Arquivo atual

                                                                    </a>

                                                                </div>

                                                            <?php } ?>

                                                            <label>

                                                                <?php echo $field['label'] ?>

                                                                <input type="file" name="<?php echo $field['name'];?>[]">

                                                            </label>

                                                        <?php } ?>

                                                        <?php if ($field['type']['input'] == 'checkbox') { ?>

                                                            <label>

                                                                <?php echo $field['label'] ?>

                                                                <input name="<?php echo $field['name'] ?>[<?php echo($index_2); ?>]" id="<?php echo $field['name'] ?>[<?php echo($index_2); ?>]" class="ace ace-switch ace-switch-6" type="checkbox" value="1" <?php echo(isset($json[$field['name']]) && $json[$field['name']]==1?' checked':''); ?> />

                                                                <span class="lbl"></span>

                                                            </label>

                                                        <?php } ?>

                                                        <?php if ($field['type']['input'] == 'money') { ?>

                                                            <div class="input-group full-width">

                                                                <div class="input-group bootstrap-timepicker">

                                                                    <input name="<?php echo $field['name'] ?>[]" type="text" class="form-control input-mask-money" value="<?php echo $json[$field['name']] ?>" placeholder="<?php echo $field['label'] ?>" />

                                                                    <span class="input-group-addon"><i class="icon-money bigger-110"></i></span>

                                                                </div>

                                                            </div>

                                                        <?php } ?>

                                                        <?php if ($field['type']['input'] == 'textarea') { ?>

                                                            <textarea type="text" class="full-width" name="<?php echo $field['name'] ?>[]" style="height:200px;" placeholder="<?php echo $field['label'] ?>" ><?php echo $json->{$field['name']} ?></textarea>

                                                        <?php } ?>

                                                        <?php if ($field['type']['input'] == 'text') { ?>
                                                            <input name="<?php echo $field['name'] ?>[]" type="text" class="full-width" value="<?php echo $json->{$field['name']} ?>" placeholder="<?php echo $field['label'] ?>" />

                                                        <?php } ?>

                                                        <?php if ($field['type']['input'] == 'category') { ?>

                                                            <select name="<?php echo $field['name'] ?>[]" class="full-width">

                                                                <option value=""><?php echo $field['label'] ?></option>

                                                                <?php $Funcoes->select('id,'.$field['type']['parameters']['field']);

                                                                $query = $Funcoes->from($field['type']['parameters']['bd'])->fetch();

                                                                if ($Funcoes->affected_rows > 0) {

                                                                    foreach($query as $base){

                                                                        if ($base['id']==$json[$field['name']]) {

                                                                            $selected = ' selected';

                                                                        }else{

                                                                            $selected = '';

                                                                        }  ?>

                                                                        <option value="<?php echo $base['id']; ?>"<?php echo $selected; ?>>

                                                                            <?php echo $base[$field['type']['parameters']['field']]; ?>

                                                                        </option>

                                                                    <?php }

                                                                } ?>

                                                            </select>
                                                        <?php } ?>
                                                    </div>

                                                <?php endforeach; ?>

                                                <button type="remove-this-<?php echo $campo['name'];?>" class="btn btn-danger btn-sm pull-right">Remover</button>

                                            </div>

                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php echo '</div>'; ?>

                                <div class="col-md-12">

                                    <button type="add-more-<?php echo $campo['name'];?>" class="btn btn-success btn-sm pull-right">Adicionar mais <?php echo $campo['titulo']; ?></button>

                                </div>

                            <?php }else{





                                if ($campo['input'] == 'archive') {

                                    if (!empty($resultado[$campo['name']])) { ?>

                                        <div class="row">

                                            <div class="col-sm-12 text-center">

                                                <a href="<?php echo URL_UPLOAD_ARCHIVE.$sistema['bd'].'/'.$resultado[$campo['name']];?>" target="_blank">Arquivo atual</a><br/>

                                            </div>

                                        </div>

                                        <br>



                                        <div class="row">

                                            <div class="col-sm-12 text-center">

                                                <a href="<?php echo URL_PAINEL.$sistema['url'].'/atualizar/'.$url[2].'/';?>remover_arquivo/<?php echo $campo['name'];?>">Remover arquivo</a>

                                            </div>

                                        </div>

                                        <br>



                                    <?php }

                                }

                                if ($campo['div']['abertura']) { ?>

                                    <div class="row">

                                <?php } ?>

                                    <?php if (@$campo['swap_reference']) {

                                        $swap_reference_input = $campo['swap_reference']['input'];

                                        $swap_reference_value = $campo['swap_reference']['value'];

                                        $attr_data = 'data-troca-'.$swap_reference_input.'="true" data-swap-'.$swap_reference_input.'="'.$swap_reference_value.'"';

                                        if ($resultado[$swap_reference_input]==$swap_reference_value) {

                                            $attr_style =' style="margin-bottom: 10px;"';

                                        }else{

                                            $attr_style =' style="margin-bottom: 10px; display:none;"';

                                        }

                                    }else{

                                        $attr_data = '';

                                        $attr_style = ' style="margin-bottom: 10px;"';

                                    } ?>

                                    <?php if (isset($campo['pre_select_logado'])){

                                        if (isset($campo['pre_select_logado']['nivel_de_acesso'])&&$campo['pre_select_logado']['nivel_de_acesso']==$_SESSION['admin_nivel_acesso']) {

                                            $show = (isset($campo['pre_select_logado']['show'])?$campo['pre_select_logado']['show']:true);

                                        }



                                    }

                                    if ($show==false){

                                        $attr_style =' style="margin-bottom: 10px; display:none;"';

                                    } ?>

                                    <div class="<?php echo $campo['class_titulo'];?>"<?php echo $attr_data.$attr_style; ?>>

                                        <label><?php echo $campo['titulo'];?></label>

                                    </div>

                                    <div class="<?php echo $campo['class'];?>"<?php echo $attr_data.$attr_style; ?>>

                                        <?php if ($campo['input'] == 'text') { ?>

                                            <input type="text" name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>" class="full-width" maxlength="<?php echo $campo['amount'];?>" value="<?php echo htmlspecialchars($resultado[$campo['name']]); ?>">

                                        <?php }

                                        if ($campo['input'] == 'cep') { ?>

                                            <input type="cep" name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>" class="full-width" maxlength="<?php echo $campo['amount'];?>" value="<?php echo htmlspecialchars($resultado[$campo['name']]); ?>">

                                        <?php }

                                        if ($campo['input'] == 'incrementador') {

                                            $resultado[$campo['name']] = str_pad($resultado[$campo['name']], 10, 0, STR_PAD_LEFT); ?>

                                            <input type="text" name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>" class="full-width text-center" maxlength="<?php echo $campo['amount'];?>" value="<?=$resultado[$campo['name']];?>" readonly>

                                        <?php }

                                        if ($campo['input'] == 'int') { ?>

                                            <input type="text" name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>" class="full-width input-mask-int text-center" maxlength="<?php echo $campo['amount'];?>" value="<?= htmlentities($resultado[$campo['name']]) ;?>">

                                        <?php }

                                        if ($campo['input'] == 'select') { ?>

                                            <select name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>">

                                                <option value=""></option>

                                                <?php $dados_conteudo = end($campo['parametros']);

                                                foreach ($dados_conteudo['conteudo'] as $key => $value) {

                                                    if ($resultado[$campo['name']]==$key) {

                                                        $select = ' selected';

                                                    }else{

                                                        $select = '';

                                                    } ?>

                                                    <option value="<?php echo $key; ?>"<?php echo $select; ?>><?php echo $value; ?></option>

                                                <?php } ?>

                                            </select>

                                        <?php }

                                        if ($campo['input'] == 'color') { ?>

                                            <input type="color" name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>" class="full-width" maxlength="<?php echo $campo['amount'];?>" value="<?php echo htmlspecialchars($resultado[$campo['name']]); ?>">

                                        <?php }

                                        if ($campo['input'] == 'cpf') { ?>

                                            <input type="cpf" name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>" class="full-width text-center" maxlength="<?php echo $campo['amount'];?>" value="<?=$resultado[$campo['name']];?>">

                                        <?php }

                                        if ($campo['input'] == 'cnpj') { ?>

                                            <input type="cnpj" name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>" class="full-width text-center" maxlength="<?php echo $campo['amount'];?>" value="<?=$resultado[$campo['name']];?>">

                                        <?php }

                                        if ($campo['input'] == 'date') {

                                            $resultado[$campo['name']] = explode(' ', $resultado[$campo['name']]); ?>

                                            <div class="input-group">

                                                <div class="input-group">

                                                    <input class="form-control input-mask-date date-picker" type="text" id="<?php echo $campo['name'];?>" name="<?php echo $campo['name'];?>" value="<?php echo implode("/",array_reverse(explode("-", $resultado[$campo['name']][0]))); ?>" />

                                                    <span class="input-group-addon"><i class="icon-calendar bigger-110"></i></span>

                                                </div>

                                            </div>

                                        <?php }

                                        if ($campo['input'] == 'datetime') {

                                            $resultado[$campo['name']] = str_replace(' ', 'T', $resultado[$campo['name']]); ?>

                                            <div class="input-group">

                                                <div class="input-group">

                                                    <input class="form-control" type="datetime-local" id="<?php echo $campo['name'];?>" name="<?php echo $campo['name'];?>" value="<?php echo $resultado[$campo['name']]; ?>" />

                                                    <span class="input-group-addon"><i class="icon-calendar bigger-110"></i></span>

                                                </div>

                                            </div>

                                        <?php }

                                        if ($campo['input'] == 'time') { ?>

                                            <div class="input-group">

                                                <div class="input-group bootstrap-timepicker">

                                                    <input class="form-control time-picker" type="text" id="<?php echo $campo['name'];?>" name="<?php echo $campo['name'];?>" value="<?=$resultado[$campo['name']];?>" />

                                                    <span class="input-group-addon"><i class="icon-time bigger-110"></i></span>

                                                </div>

                                                <small class="text-success">hh:mm:ss</small>

                                            </div>

                                        <?php }

                                        if ($campo['input'] == 'money') { ?>

                                            <div class="input-group">

                                                <div class="input-group bootstrap-timepicker">

                                                    <input id="<?php echo $campo['name'];?>" name="<?php echo $campo['name'];?>" type="text" class="form-control input-mask-money" value="<?=str_replace('.',',',$resultado[$campo['name']]);?>" />

                                                    <span class="input-group-addon"><i class="icon-money bigger-110"></i></span>

                                                </div>

                                            </div>

                                        <?php }

                                        if ($campo['input'] == 'image') {

                                            if ($campo['input'] == 'image') {

                                                if (!empty($resultado[$campo['name']])) {

                                                    $imagem = $resultado[$campo['name']];

                                                    $src_path = URL_UPLOAD_IMAGE.$sistema['bd'].'/';

                                                    $real_path = PATH_IMAGES.$sistema['bd'].SEP; ?>

                                                    <div class="row">

                                                        <div class="col-sm-12 text-center">

                                                            Imagem atual<br/>

                                                            <img src="<?php echo $Funcoes->image($imagem,600,500,$real_path,'redimencionar',100,$src_path); ?>" class="img-responsive" style="display: initial;">

                                                        </div>

                                                    </div>

                                                    <br>



                                                    <div class="row">

                                                        <div class="col-sm-12 text-center">

                                                            <a href="<?php echo URL_PAINEL.$sistema['url'].'/atualizar/'.$url[2].'/';?>remover_imagem/<?php echo $campo['name'];?>">Remover imagem</a>

                                                        </div>

                                                    </div>

                                                    <br>

                                                <?php }

                                            }?>

                                            <input type="file" id="<?php echo $campo['name'];?>" name="<?php echo $campo['name'];?>">

                                        <?php }

                                        if ($campo['input'] == 'archive') { ?>

                                            <input type="file" id="<?php echo $campo['name'];?>" name="<?php echo $campo['name'];?>">

                                        <?php }

                                        if ($campo['input'] == 'estados') { ?>

                                            <select name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>" data-uf="true" data-target="<?=$campo['parametros']?>">

                                                <option value=""></option>

                                                <?php if (!empty($resultado[$campo['name']])) {

                                                    $url_webservice = 'https://ibge.herokuapp.com/estado/UF';

                                                    $ch = curl_init();

                                                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                                                    curl_setopt($ch, CURLOPT_URL, $url_webservice);

                                                    $result = curl_exec($ch);

                                                    curl_close($ch);

                                                    $array = array();

                                                    $array = json_decode($result, true);

                                                    foreach ($array as $key => $value) {

                                                        if ($resultado[$campo['name']] == $key) {

                                                            $selected = ' selected="selected"';

                                                        }else{

                                                            $selected = '';

                                                        }?>

                                                        <option value="<?=$key?>"<?=$selected;?>><?=$key?></option>

                                                    <?php }

                                                }else{ ?>

                                                    <script type="text/javascript">

                                                        $(function() {

                                                            $.getJSON("https://ibge.herokuapp.com/estado/UF", function(result){

                                                                $.each(result, function(sigla, code){

                                                                    $('select[data-uf="true"]').append($('<option>', {

                                                                        value: sigla,

                                                                        text: sigla

                                                                    }));

                                                                });

                                                            });

                                                        });

                                                    </script>

                                                <?php } ?>

                                            </select>

                                        <?php }

                                        if ($campo['input'] == 'cidades') { ?>

                                            <select name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>">

                                                <option value=""></option>

                                                <?php if (!empty($resultado[$campo['parametros']])) {

                                                    $url_webservice = 'https://ibge.herokuapp.com/municipio/?val='.$resultado[$campo['parametros']];

                                                    $ch = curl_init();

                                                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                                                    curl_setopt($ch, CURLOPT_URL, $url_webservice);

                                                    $result = curl_exec($ch);

                                                    curl_close($ch);

                                                    $array = array();

                                                    $array = json_decode($result, true);

                                                    foreach ($array as $key => $value) {

                                                        if ($resultado[$campo['name']] == $key) {

                                                            $selected = ' selected="selected"';

                                                        }else{

                                                            $selected = '';

                                                        }?>

                                                        <option value="<?=$key?>"<?=$selected;?>><?=$key?></option>

                                                    <?php }

                                                } ?>

                                            </select>

                                        <?php }

                                        if ($campo['input'] == 'category') {

                                            $where = 'status = 1';

                                            if (isset($campo['pre_select_logado'])){

                                                if (isset($campo['pre_select_logado']['nivel_de_acesso'])&&$campo['pre_select_logado']['nivel_de_acesso']==$_SESSION['admin_nivel_acesso']) {

                                                    $data[$campo['name']] = $campo['pre_select_logado']['id'];

                                                    if (isset($campo['pre_select_logado']['where'])) {

                                                        $where .= ' AND '.$campo['pre_select_logado']['where'];

                                                    }

                                                }

                                            } ?>

                                            <select name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>">

                                                <option value=""></option>

                                                <?php $rows = $Funcoes->select('id, '.$campo['parametros'])->from($campo['category'])->where($where)->fetch();

                                                if ($Funcoes->affected_rows > 0) {

                                                    foreach($rows as $row){

                                                        if ($resultado[$campo['name']]==$row['id']) {

                                                            $selected = ' selected="selected"';

                                                        }else{

                                                            $selected = '';

                                                        } ?>

                                                        <option value="<?php echo $row['id']; ?>"<?php echo $selected; ?>><?php echo $row[$campo['parametros']]; ?></option>

                                                    <?php }

                                                } ?>

                                            </select>

                                        <?php }

                                        if ($campo['input'] == 'category_plus_category') { ?>

                                            <select name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>">

                                                <option value=""></option>

                                                <?php $rows = $Funcoes->select('id,'.$campo['parametros']['name'].','.$campo['parametros']['where'])->from($campo['category'])->where(array('status' => 1 ))->fetch();

                                                if ($Funcoes->affected_rows > 0) {

                                                    foreach($rows as $row){

                                                        if ($resultado[$campo['name']] == $row['id']) {

                                                            $selected = ' selected="selected"';

                                                        }else{

                                                            $selected = '';

                                                        }  ?>

                                                        <option value="<?php echo $row['id']; ?>"<?php echo $selected; ?>><?php echo $Funcoes->get_custom_by_id($campo['parametros']['name_category'],$campo['parametros']['category'],$row[$campo['parametros']['where']]).' - '.$row[$campo['parametros']['name']]; ?></option>

                                                    <?php }

                                                } ?>

                                            </select>

                                        <?php }

                                        if ($campo['input'] == 'subcategory') { ?>



                                            <select name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>">

                                                <option value=""></option>

                                                <?php $rows = $Funcoes->select('id, nome')->from($campo['category'])->where(array('status' => 1, $campo['parametros']['input'] => $resultado[$campo['parametros']['input']] ))->fetch();

                                                if ($Funcoes->affected_rows > 0) {

                                                    foreach($rows as $row){

                                                        if ($resultado[$campo['name']]==$row['id']) {

                                                            $selected = ' selected="selected"';

                                                        }else{

                                                            $selected = '';

                                                        } ?>

                                                        <option value="<?php echo $row['id']; ?>"<?php echo $selected; ?>><?php echo $row['nome']; ?></option>

                                                    <?php }

                                                } ?>

                                            </select>

                                        <?php }

                                        if ($campo['input'] == 'multiselect_subcategory') {

                                            $sqlwhere = '';

                                            $rows = $Funcoes->select($campo['parametros']['where'])->from($campo['parametros']['reference'])->where(array($campo['parametros']['sistema'] => $resultado[$campo['parametros']['primary']] ))->fetch();

                                            if ($Funcoes->affected_rows > 0):

                                                foreach ($rows as $key => $row) {

                                                    if ($key>0) {

                                                        $sqlwhere .=' OR ';

                                                    }

                                                    $val = $row[$campo['parametros']['where']];

                                                    $sqlwhere .= $campo['parametros']['select'].'.'.$campo['parametros']['where'].' = '.$val;

                                                }

                                            else:

                                                $sqlwhere = '';

                                            endif; ?>

                                            <select name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>">

                                                <?php if (!empty($sqlwhere )) {

                                                    $rows = $Funcoes->query('SELECT '.$campo['category'].'.'.$campo['parametros']['name'].', '.$campo['category'].'.'.$campo['parametros']['primary'].' FROM '.$campo['category'].' LEFT JOIN '.$campo['parametros']['select'].' ON '.$campo['category'].'.id = '.$campo['parametros']['select'].'.'.$campo['name'].' WHERE '.$sqlwhere)->fetch();

                                                    if ($Funcoes->affected_rows > 0) {

                                                        echo '<option value=""></option>';

                                                        foreach ($rows as $row) {

                                                            if ($resultado[$campo['name']]==$row[$campo['parametros']['primary']]) {

                                                                $selected = ' selected="selected"';

                                                            }else{

                                                                $selected = '';

                                                            }

                                                            echo '<option value="'.$row[$campo['parametros']['primary']].'"'.$selected.'>'.$row[$campo['parametros']['name']].'</option>';

                                                        }

                                                    }else{

                                                        echo '<option value=""></option>';

                                                    }

                                                }else{

                                                    echo '<option value=""></option>';

                                                } ?>

                                            </select>

                                        <?php }

                                        if ($campo['input'] == 'textarea') { ?>

                                            <textarea type="text" style="height:200px;" class="full-width" rows="<?php echo $campo['parametros']['rows'];?>" maxlength="<?php echo $campo['amount'];?>" name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>"><?php echo html_entity_decode($resultado[$campo['name']]); ?></textarea>

                                        <?php }

                                        if ($campo['input'] == 'editor') { ?>

                                            <textarea type="text" class="full-width" name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>"><?php echo $resultado[$campo['name']]; ?></textarea>

                                        <?php }

                                        if ($campo['input'] == 'checkbox') {

                                            if ($resultado[$campo['name']]==1) {

                                                $resultado[$campo['name']] = ' checked="checked"';

                                             } ?>

                                            <label>

                                                <input name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>" class="ace ace-switch ace-switch-6" type="checkbox"<?=$resultado[$campo['name']];?> value="1" />

                                                <span class="lbl"></span>

                                            </label>

                                        <?php }

                                        if ($campo['input'] == 'multiselect') {

                                            $rows = $Funcoes->select('id, '.$campo['parametros']['bd_select'])->from(PREFIX.$campo['category'])->fetch();

                                            if ($Funcoes->affected_rows > 0) {

                                                foreach($rows as $row){



                                                    $id = $row['id'];

                                                    $nome = $row[$campo['parametros']['bd_select']];



                                                    $compar = $Funcoes->select($campo['name'].','.$campo['parametros']['campo'])->from(PREFIX.$sistema['bd'].'_'.PREFIX.$campo['category'])->where(array($campo['name'] => $resultado['id'], $campo['parametros']['campo'] => $id ))->fetch_first();

                                                    if ($Funcoes->affected_rows > 0) { $checked = ' checked="checked"'; }else{ $checked = ''; } ?>

                                                    <label>

                                                        <input type="checkbox" class="ace ace-checkbox-2" name="<?php echo $sistema['bd'].'_'.$campo['category']; ?>[]" value="<?php echo $id; ?>"<?php echo $checked; ?>>

                                                        <span class="lbl"><?php echo $nome; ?></span>

                                                    </label>

                                                    <?php

                                                }

                                            }



                                        } ?>

                                    </div>

                                <?php if ($campo['div']['fechamento']) { ?>

                                    </div>

                                <?php }

                            }

                        }

                    }else{



                        if ($campo['input']=='dropdown_plus_more_options') {

                            $result_json = $resultado[$campo['name']];

                            $result_json = json_decode($result_json, true);



                            echo '<div class="row" id="area_multi_'.$campo['name'].'">'; ?>

                                <?php if (!empty($result_json)):

                                    foreach ($result_json as $index_2 => $json):  ?>

                                        <div class="col-md-3" style="outline: 5px solid #e3e3e3; padding: 25px;">

                                            <div class="text-center"> <label><?php echo $campo['titulo']; ?></label> </div>

                                            <?php foreach ($campo['parametros']['fields'] as $index => $field): ?>

                                                <div style="margin-bottom: 10px;">

                                                    <?php if ($field['type']['input'] == 'money') { ?>

                                                        <div class="input-group full-width">

                                                            <div class="input-group bootstrap-timepicker">

                                                                <input name="<?php echo $field['name'] ?>[]" type="text" class="form-control input-mask-money" value="<?php echo $json[$field['name']] ?>" placeholder="<?php echo $field['label'] ?>" />

                                                                <span class="input-group-addon"><i class="icon-money bigger-110"></i></span>

                                                            </div>

                                                        </div>

                                                    <?php } ?>

                                                    <?php if ($field['type']['input'] == 'image') { ?>

                                                        <?php if (isset($json[$field['name']])) {

                                                            $imagem = $json[$field['name']];

                                                            $src_path = URL_UPLOAD_IMAGE.$sistema['bd'].'/';

                                                            $real_path = PATH_IMAGES.$sistema['bd'].SEP; ?>

                                                            <div class="input-group full-width text-center">

                                                                Imagem atual<br/>

                                                                <img src="<?php echo $Funcoes->image($imagem,320,220,$real_path,'redimencionar',100,$src_path); ?>" class="img-responsive" style="display: initial;">

                                                            </div>

                                                        <?php } ?>

                                                        <label>

                                                            <?php echo $field['label'] ?>

                                                            <input type="file" name="<?php echo $field['name'];?>[]">

                                                        </label>

                                                    <?php } ?>

                                                    <?php if ($field['type']['input'] == 'archive') { ?>

                                                        <?php if (isset($json[$field['name']])) {

                                                            $arquivo = $json[$field['name']]; ?>

                                                            <div class="input-group full-width text-center">

                                                                <a href="<?php echo URL_UPLOAD_ARCHIVE.$sistema['bd'].'/'.$arquivo;?>" target="_blank">

                                                                    Arquivo atual

                                                                </a>

                                                            </div>

                                                        <?php } ?>

                                                        <label>

                                                            <?php echo $field['label'] ?>

                                                            <input type="file" name="<?php echo $field['name'];?>[]">

                                                        </label>

                                                    <?php } ?>

                                                    <?php if ($field['type']['input'] == 'textarea') { ?>

                                                        <textarea type="text" class="full-width" name="<?php echo $field['name'] ?>[]" style="height:200px;" placeholder="<?php echo $field['label'] ?>" ><?php echo isset($json[$field['name']])?$json[$field['name']]:''; ?></textarea>

                                                    <?php } ?>

                                                    <?php if ($field['type']['input'] == 'text') { ?>

                                                        <input name="<?php echo $field['name'] ?>[]" type="text" class="full-width" value="<?php echo $json[$field['name']] ?>" placeholder="<?php echo $field['label'] ?>" value="<?php echo $json[$field['name']] ?>" />

                                                    <?php } ?>

                                                    <?php if ($field['type']['input'] == 'checkbox') {  ?>

                                                        <label>

                                                            <?php echo $field['label'] ?>

                                                            <input name="<?php echo $field['name'] ?>[<?php echo($index_2); ?>]" id="<?php echo $field['name'] ?>[<?php echo($index_2); ?>]" class="ace ace-switch ace-switch-6" type="checkbox" value="1" <?php echo(isset($json[$field['name']]) && $json[$field['name']]==1?' checked':''); ?> />

                                                            <span class="lbl"></span>

                                                        </label>

                                                    <?php } ?>

                                                    <?php if ($field['type']['input'] == 'category') { ?>

                                                        <select name="<?php echo $field['name'] ?>[]" class="full-width">

                                                            <option value=""><?php echo $field['label'] ?></option>

                                                            <?php $Funcoes->select('id,'.$field['type']['parameters']['field']);

                                                            $query = $Funcoes->from($field['type']['parameters']['bd'])->fetch();

                                                            if ($Funcoes->affected_rows > 0) {

                                                                foreach($query as $base){

                                                                    if ($base['id']==$json[$field['name']]) {

                                                                        $selected = ' selected';

                                                                    }else{

                                                                        $selected = '';

                                                                    }  ?>

                                                                    <option value="<?php echo $base['id']; ?>"<?php echo $selected; ?>>

                                                                        <?php echo $base[$field['type']['parameters']['field']]; ?>

                                                                    </option>

                                                                <?php }

                                                            } ?>

                                                        </select>

                                                    <?php } ?>

                                                </div>

                                            <?php endforeach; ?>

                                            <button type="remove-this-<?php echo $campo['name'];?>" class="btn btn-danger btn-sm pull-right">Remover</button>

                                        </div>

                                    <?php endforeach;

                                endif;?>

                            <?php echo '</div>'; ?>

                            <div class="col-md-12">

                                <button type="add-more-<?php echo $campo['name'];?>" class="btn btn-success btn-sm pull-right">Adicionar mais <?php echo $campo['titulo']; ?></button>

                            </div>

                        <?php }else{



                            if ($campo['input'] == 'image') {

                                if (!empty($resultado[$campo['name']])) {

                                    $imagem = $resultado[$campo['name']];

                                    $src_path = URL_UPLOAD_IMAGE.$sistema['bd'].'/';

                                    $real_path = PATH_IMAGES.$sistema['bd'].SEP; ?>

                                    <div class="row">

                                        <div class="col-sm-12 text-center">

                                            Imagem atual<br/>

                                            <img src="<?php echo $Funcoes->image($imagem,600,500,$real_path,'redimencionar',100,$src_path); ?>" class="img-responsive" style="display: initial;">

                                        </div>

                                    </div>

                                    <br>



                                    <div class="row">

                                        <div class="col-sm-12 text-center">

                                            <a href="<?php echo URL_PAINEL.$sistema['url'].'/atualizar/'.$url[2].'/';?>remover_imagem/<?php echo $campo['name'];?>">Remover imagem</a>

                                        </div>

                                    </div>

                                    <br>



                                <?php }

                            }

                            if ($campo['input'] == 'archive') {

                                if (!empty($resultado[$campo['name']])) { ?>

                                    <div class="row">

                                        <div class="col-sm-12 text-center">

                                            <a href="<?php echo URL_UPLOAD_ARCHIVE.$sistema['bd'].'/'.$resultado[$campo['name']];?>" target="_blank">Arquivo atual</a><br/>

                                        </div>

                                    </div>

                                    <br>



                                    <div class="row">

                                        <div class="col-sm-12 text-center">

                                            <a href="<?php echo URL_PAINEL.$sistema['url'].'/atualizar/'.$url[2].'/';?>remover_arquivo/<?php echo $campo['name'];?>">Remover arquivo</a>

                                        </div>

                                    </div>

                                    <br>



                                <?php }

                            }

                            if ($campo['div']['abertura']) { ?>

                                <div class="row">

                            <?php } ?>

                                <?php if (@$campo['swap_reference']) {

                                    $swap_reference_input = $campo['swap_reference']['input'];

                                    $swap_reference_value = $campo['swap_reference']['value'];

                                    $attr_data = 'data-troca-'.$swap_reference_input.'="true" data-swap-'.$swap_reference_input.'="'.$swap_reference_value.'"';

                                    if (isset($resultado[$swap_reference_input])  && $resultado[$swap_reference_input]==$swap_reference_value) {

                                        $attr_style =' style="margin-bottom: 10px;"';

                                    }else{

                                        $attr_style =' style="margin-bottom: 10px; display:none;"';

                                    }

                                }else{

                                    $attr_data = '';

                                    $attr_style = ' style="margin-bottom: 10px;"';

                                } ?>

                                <?php if (isset($campo['pre_select_logado'])){

                                    if (isset($campo['pre_select_logado']['nivel_de_acesso'])&&$campo['pre_select_logado']['nivel_de_acesso']==$_SESSION['admin_nivel_acesso']) {

                                        $show = (isset($campo['pre_select_logado']['show'])?$campo['pre_select_logado']['show']:true);

                                    }



                                }

                                if ($show==false){

                                    $attr_style =' style="margin-bottom: 10px; display:none;"';

                                } ?>

                                <div class="<?php echo $campo['class_titulo'];?>"<?php echo $attr_data.$attr_style; ?>>

                                    <label><?php echo $campo['titulo'];?></label>

                                </div>

                                <div class="<?php echo $campo['class'];?>"<?php echo $attr_data.$attr_style; ?>>

                                    <?php if ($campo['input'] == 'text') { ?>

                                        <input type="text" name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>" class="full-width" maxlength="<?php echo $campo['amount'];?>" value="<?php echo htmlspecialchars($resultado[$campo['name']]); ?>">

                                    <?php }

                                    if ($campo['input'] == 'cep') { ?>

                                        <input type="cep" name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>" class="full-width" maxlength="<?php echo $campo['amount'];?>" value="<?php echo htmlspecialchars($resultado[$campo['name']]); ?>">

                                    <?php }

                                    if ($campo['input'] == 'incrementador') {

                                        $resultado[$campo['name']] = str_pad($resultado[$campo['name']], 10, 0, STR_PAD_LEFT); ?>

                                        <input type="text" name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>" class="full-width text-center" maxlength="<?php echo $campo['amount'];?>" value="<?=$resultado[$campo['name']];?>" readonly>

                                        <?php }

                                    if ($campo['input'] == 'int') { ?>

                                        <input type="text" name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>" class="full-width input-mask-int text-center" maxlength="<?php echo $campo['amount'];?>" value="<?=htmlentities($resultado[$campo['name']]);?>">

                                    <?php }

                                    if ($campo['input'] == 'select') { ?>

                                        <select name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>">

                                            <option value=""></option>

                                            <?php $dados_conteudo = end($campo['parametros']);

                                            foreach ($dados_conteudo['conteudo'] as $key => $value) {

                                                if ($resultado[$campo['name']]==$key) {

                                                    $select = ' selected';

                                                }else{

                                                    $select = '';

                                                } ?>

                                                <option value="<?php echo $key; ?>"<?php echo $select; ?>><?php echo $value; ?></option>

                                            <?php } ?>

                                        </select>

                                    <?php }

                                    if ($campo['input'] == 'color') { ?>

                                        <input type="color" name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>" class="full-width" maxlength="<?php echo $campo['amount'];?>" value="<?php echo htmlspecialchars($resultado[$campo['name']]); ?>">

                                    <?php }

                                    if ($campo['input'] == 'cpf') { ?>

                                        <input type="cpf" name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>" class="full-width text-center" maxlength="<?php echo $campo['amount'];?>" value="<?=$resultado[$campo['name']];?>">

                                    <?php }

                                    if ($campo['input'] == 'cnpj') { ?>

                                        <input type="cnpj" name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>" class="full-width text-center" maxlength="<?php echo $campo['amount'];?>" value="<?=$resultado[$campo['name']];?>">

                                    <?php }

                                    if ($campo['input'] == 'date') {

                                        $resultado[$campo['name']] = explode(' ', $resultado[$campo['name']]); ?>

                                        <div class="input-group">

                                            <div class="input-group">

                                                <input class="form-control input-mask-date date-picker" type="text" id="<?php echo $campo['name'];?>" name="<?php echo $campo['name'];?>" value="<?php echo implode("/",array_reverse(explode("-", $resultado[$campo['name']][0]))); ?>" />

                                                <span class="input-group-addon"><i class="icon-calendar bigger-110"></i></span>

                                            </div>

                                        </div>

                                    <?php }

                                    if ($campo['input'] == 'datetime') {

                                        $resultado[$campo['name']] = str_replace(' ', 'T', $resultado[$campo['name']]); ?>

                                        <div class="input-group">

                                            <div class="input-group">

                                                <input class="form-control" type="datetime-local" id="<?php echo $campo['name'];?>" name="<?php echo $campo['name'];?>" value="<?php echo $resultado[$campo['name']]; ?>" />

                                                <span class="input-group-addon"><i class="icon-calendar bigger-110"></i></span>

                                            </div>

                                        </div>

                                    <?php }

                                    if ($campo['input'] == 'time') { ?>

                                        <div class="input-group">

                                            <div class="input-group bootstrap-timepicker">

                                                <input class="form-control time-picker" type="text" id="<?php echo $campo['name'];?>" name="<?php echo $campo['name'];?>" value="<?=$resultado[$campo['name']];?>" />

                                                <span class="input-group-addon"><i class="icon-time bigger-110"></i></span>

                                            </div>

                                            <small class="text-success">hh:mm:ss</small>

                                        </div>

                                    <?php }

                                    if ($campo['input'] == 'money') { ?>

                                        <div class="input-group">

                                            <div class="input-group bootstrap-timepicker">

                                                <input id="<?php echo $campo['name'];?>" name="<?php echo $campo['name'];?>" type="text" class="form-control input-mask-money" value="<?=str_replace('.',',',$resultado[$campo['name']]);?>" />

                                                <span class="input-group-addon"><i class="icon-money bigger-110"></i></span>

                                            </div>

                                        </div>

                                    <?php }

                                    if ($campo['input'] == 'image') { ?>

                                        <input type="file" id="<?php echo $campo['name'];?>" name="<?php echo $campo['name'];?>">

                                    <?php }

                                    if ($campo['input'] == 'archive') { ?>

                                        <input type="file" id="<?php echo $campo['name'];?>" name="<?php echo $campo['name'];?>">

                                    <?php }

                                    if ($campo['input'] == 'estados') { ?>

                                        <select name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>" data-uf="true" data-target="<?=$campo['parametros']?>">

                                            <option value=""></option>

                                            <?php if (!empty($resultado[$campo['name']])) {

                                                $url_webservice = 'https://ibge.herokuapp.com/estado/UF';

                                                $ch = curl_init();

                                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                                                curl_setopt($ch, CURLOPT_URL, $url_webservice);

                                                $result = curl_exec($ch);

                                                curl_close($ch);

                                                $array = array();

                                                $array = json_decode($result, true);

                                                foreach ($array as $key => $value) {

                                                    if ($resultado[$campo['name']] == $key) {

                                                        $selected = ' selected="selected"';

                                                    }else{

                                                        $selected = '';

                                                    }?>

                                                    <option value="<?=$key?>"<?=$selected;?>><?=$key?></option>

                                                <?php }

                                            }else{ ?>

                                                <script type="text/javascript">

                                                    $(function() {

                                                        $.getJSON("https://ibge.herokuapp.com/estado/UF", function(result){

                                                            $.each(result, function(sigla, code){

                                                                $('select[data-uf="true"]').append($('<option>', {

                                                                    value: sigla,

                                                                    text: sigla

                                                                }));

                                                            });

                                                        });

                                                    });

                                                </script>

                                            <?php } ?>

                                        </select>

                                    <?php }

                                    if ($campo['input'] == 'cidades') { ?>

                                        <select name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>">

                                            <option value=""></option>

                                            <?php if (!empty($resultado[$campo['parametros']])) {

                                                $url_webservice = 'https://ibge.herokuapp.com/municipio/?val='.$resultado[$campo['parametros']];

                                                $ch = curl_init();

                                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                                                curl_setopt($ch, CURLOPT_URL, $url_webservice);

                                                $result = curl_exec($ch);

                                                curl_close($ch);

                                                $array = array();

                                                $array = json_decode($result, true);

                                                foreach ($array as $key => $value) {

                                                    if ($resultado[$campo['name']] == $key) {

                                                        $selected = ' selected="selected"';

                                                    }else{

                                                        $selected = '';

                                                    }?>

                                                    <option value="<?=$key?>"<?=$selected;?>><?=$key?></option>

                                                <?php }

                                            } ?>

                                        </select>

                                    <?php }

                                    if ($campo['input'] == 'category') {

                                        $where = 'status = 1';

                                        if (isset($campo['pre_select_logado'])){

                                            if (isset($campo['pre_select_logado']['nivel_de_acesso'])&&$campo['pre_select_logado']['nivel_de_acesso']==$_SESSION['admin_nivel_acesso']) {

                                                $data[$campo['name']] = $campo['pre_select_logado']['id'];

                                                if (isset($campo['pre_select_logado']['where'])) {

                                                    $where .= ' AND '.$campo['pre_select_logado']['where'];

                                                }

                                            }

                                        } ?>

                                        <select name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>">

                                            <option value=""></option>

                                            <?php $rows = $Funcoes->select('id, '.$campo['parametros'])->from($campo['category'])->where($where)->fetch();

                                            if ($Funcoes->affected_rows > 0) {

                                                foreach($rows as $row){

                                                    if ($resultado[$campo['name']]==$row['id']) {

                                                        $selected = ' selected="selected"';

                                                    }else{

                                                        $selected = '';

                                                    } ?>

                                                    <option value="<?php echo $row['id']; ?>"<?php echo $selected; ?>><?php echo $row[$campo['parametros']]; ?></option>

                                                <?php }

                                            } ?>

                                        </select>

                                    <?php }

                                    if ($campo['input'] == 'category_plus_category') { ?>

                                        <select name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>">

                                            <option value=""></option>

                                            <?php $rows = $Funcoes->select('id,'.$campo['parametros']['name'].','.$campo['parametros']['where'])->from($campo['category'])->where(array('status' => 1 ))->fetch();

                                            if ($Funcoes->affected_rows > 0) {

                                                foreach($rows as $row){

                                                    if ($resultado[$campo['name']] == $row['id']) {

                                                        $selected = ' selected="selected"';

                                                    }else{

                                                        $selected = '';

                                                    }  ?>

                                                    <option value="<?php echo $row['id']; ?>"<?php echo $selected; ?>><?php echo $Funcoes->get_custom_by_id($campo['parametros']['name_category'],$campo['parametros']['category'],$row[$campo['parametros']['where']]).' - '.$row[$campo['parametros']['name']]; ?></option>

                                                <?php }

                                            } ?>

                                        </select>

                                    <?php }

                                    if ($campo['input'] == 'multiselect_subcategory') {

                                        $sqlwhere = '';

                                        $rows = $Funcoes->select($campo['parametros']['where'])->from($campo['parametros']['reference'])->where(array($campo['parametros']['sistema'] => $resultado[$campo['parametros']['primary']] ))->fetch();

                                        if ($Funcoes->affected_rows > 0):

                                            foreach ($rows as $key => $row) {

                                                if ($key>0) {

                                                    $sqlwhere .=' OR ';

                                                }

                                                $val = $row[$campo['parametros']['where']];

                                                $sqlwhere .= $campo['parametros']['select'].'.'.$campo['parametros']['where'].' = '.$val;

                                            }

                                        else:

                                            $sqlwhere = '';

                                        endif; ?>

                                        <select name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>">

                                            <?php if (!empty($sqlwhere )) {

                                                $rows = $Funcoes->query('SELECT '.$campo['category'].'.'.$campo['parametros']['name'].', '.$campo['category'].'.'.$campo['parametros']['primary'].' FROM '.$campo['category'].' LEFT JOIN '.$campo['parametros']['select'].' ON '.$campo['category'].'.id = '.$campo['parametros']['select'].'.'.$campo['name'].' WHERE '.$sqlwhere)->fetch();

                                                if ($Funcoes->affected_rows > 0) {

                                                    echo '<option value=""></option>';

                                                    foreach ($rows as $row) {

                                                        if ($resultado[$campo['name']]==$row[$campo['parametros']['primary']]) {

                                                            $selected = ' selected="selected"';

                                                        }else{

                                                            $selected = '';

                                                        }

                                                        echo '<option value="'.$row[$campo['parametros']['primary']].'"'.$selected.'>'.$row[$campo['parametros']['name']].'</option>';

                                                    }

                                                }else{

                                                    echo '<option value=""></option>';

                                                }

                                            }else{

                                                echo '<option value=""></option>';

                                            } ?>

                                        </select>

                                    <?php }

                                    if ($campo['input'] == 'subcategory') { ?>



                                        <select name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>">

                                            <option value=""></option>

                                            <?php $rows = $Funcoes->select('id, nome')->from($campo['category'])->where(array('status' => 1, $campo['parametros']['input'] => $resultado[$campo['parametros']['input']] ))->fetch();

                                            if ($Funcoes->affected_rows > 0) {

                                                foreach($rows as $row){

                                                    if ($resultado[$campo['name']]==$row['id']) {

                                                        $selected = ' selected="selected"';

                                                    }else{

                                                        $selected = '';

                                                    } ?>

                                                    <option value="<?php echo $row['id']; ?>"<?php echo $selected; ?>><?php echo $row['nome']; ?></option>

                                                <?php }

                                            } ?>

                                        </select>

                                    <?php }

                                    if ($campo['input'] == 'textarea') { ?>

                                        <textarea type="text" style="height:200px;" class="full-width" rows="<?php echo $campo['parametros']['rows'];?>" maxlength="<?php echo $campo['amount'];?>" name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>"><?php echo html_entity_decode($resultado[$campo['name']]); ?></textarea>

                                    <?php }

                                    if ($campo['input'] == 'editor') { ?>

                                        <textarea type="text" class="full-width" name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>"><?php echo $resultado[$campo['name']]; ?></textarea>

                                    <?php }

                                    if ($campo['input'] == 'checkbox') {

                                        if ($resultado[$campo['name']]==1) {

                                            $resultado[$campo['name']] = ' checked="checked"';

                                         } ?>

                                        <label>

                                            <input name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>" class="ace ace-switch ace-switch-6" type="checkbox"<?=$resultado[$campo['name']];?> value="1" />

                                            <span class="lbl"></span>

                                        </label>

                                    <?php }

                                    if ($campo['input'] == 'multiselect') {

                                        $rows = $Funcoes->select('id, '.$campo['parametros']['bd_select'])->from(PREFIX.$campo['category'])->fetch();

                                        if ($Funcoes->affected_rows > 0) {

                                            foreach($rows as $row){



                                                $id = $row['id'];

                                                $nome = $row[$campo['parametros']['bd_select']];



                                                $compar = $Funcoes->select($campo['name'].','.$campo['parametros']['campo'])->from(PREFIX.$sistema['bd'].'_'.PREFIX.$campo['category'])->where(array($campo['name'] => $resultado['id'], $campo['parametros']['campo'] => $id ))->fetch_first();

                                                if ($Funcoes->affected_rows > 0) { $checked = ' checked="checked"'; }else{ $checked = ''; } ?>

                                                <label>

                                                    <input type="checkbox" class="ace ace-checkbox-2" name="<?php echo $sistema['bd'].'_'.$campo['category']; ?>[]" value="<?php echo $id; ?>"<?php echo $checked; ?>>

                                                    <span class="lbl"><?php echo $nome; ?></span>

                                                </label>

                                                <?php

                                            }

                                        }



                                    } ?>

                                </div>

                            <?php if ($campo['div']['fechamento']) { ?>

                                </div>

                            <?php }

                        }

                    }

                }

            }

            if (isset($sistema['sistema_ligado'])) { ?>

                <table id="sample-table-2" class="table table-striped table-bordered table-hover">

                    <thead>

                        <tr>

                            <?php $select = '';

                            foreach ($sistema['sistema_ligado']['list'] as $nome) {

                                echo '<th class="center">'.$nome['nome'].'</th>';

                                $select .= $nome['bd'].', ';

                            }

                            $select = substr($select, 0, -2); ?>

                        </tr>

                    </thead>



                    <tbody id="conteudo_body">

                        <?php $Funcoes->where(array($sistema['sistema_ligado']['where'] => $resultado['id']));

                        $resultados = $Funcoes->select($select)->from(PREFIX.$sistema['sistema_ligado']['bd'])->fetch();

                        if ($Funcoes->affected_rows > 0) {

                            foreach($resultados as $resultado){ ?>

                                <tr>

                                    <?php foreach ($sistema['sistema_ligado']['list'] as $nome) {

                                        echo '<td class="center">'.$resultado[$nome['bd']].'</td>';

                                    } ?>

                                </tr>

                            <?php }

                        }else{ ?>

                            <tr>

                                <td colspan="99" class="center">

                                    Nenhum cadastro no momento

                                </td>

                            </tr>

                        <?php } ?>

                    </tbody>

                </table>

            <?php } ?>

            <div class="clearfix form-actions">

                <div class="col-sm-12 text-center">

                    <button type="submit" class="btn btn-success btn-sm">Atualizar</button>

                </div>

            </div>

            <?php if (isset($sistema['galeria'])) {

                foreach ($sistema['galeria'] as $galeria) {

                    if (isset($galeria['only'])) {

                        if (in_array($url[2], $galeria['only'])) {

                            echo '<div class="col-xs-12"><h4 class="header smaller">'.$galeria['titulo'].'</h4></div> ';

                            foreach ($galeria['campos'] as $campo) {

                                if ($campo['mostrar_campo']) {



                                    $class = '';

                                    if (!empty($campo['parametros'])) {

                                        $only = current($campo['parametros']);

                                        if (isset($only['only'])) {

                                            if ( in_array ($url[2], $only['only'])) {

                                                $class = '';

                                            }else{

                                                $class = ' hidden';

                                            }



                                        }else{

                                            $class = '';

                                        }

                                     }  ?>

                                    <div class="row<?=$class?>">

                                        <div class="col-xs-3 align-r">

                                            <label><?php echo $campo['titulo'];?></label>

                                        </div>

                                        <div class="<?php echo $campo['class'];?>">

                                            <?php if ($campo['input'] == 'text') { ?>

                                                <input type="text" name="<?php echo $galeria['bd'].'_'.$campo['name'];?>" id="<?php echo $galeria['bd'].'_'.$campo['name'];?>" class="full-width" maxlength="<?php echo $campo['amount'];?>" value="">

                                            <?php }

                                            if ($campo['input'] == 'category') { ?>

                                                <select name="<?php echo $galeria['bd'].'_'.$campo['name'];?>" id="<?php echo $galeria['bd'].'_'.$campo['name'];?>">

                                                    <option value=""></option>

                                                    <?php $rows = $Funcoes->select('id, '.$campo['parametros'])->from($campo['category'])->where(array('status' => 1 ))->fetch();

                                                    if ($Funcoes->affected_rows > 0) {

                                                        foreach($rows as $row){

                                                            if ($resultado[$campo['name']]==$row['id']) {

                                                                $selected = ' selected="selected"';

                                                            }else{

                                                                $selected = '';

                                                            } ?>

                                                            <option value="<?php echo $row['id']; ?>"<?php echo $selected; ?>><?php echo $row[$campo['parametros']]; ?></option>

                                                        <?php }

                                                    } ?>

                                                </select>

                                            <?php }

                                            if ($campo['input'] == 'select') {?>

                                                <select <?=$class?> name="<?php echo $galeria['bd'].'_'.$campo['name'];?>" id="<?php echo $galeria['bd'].'_'.$campo['name'];?>">

                                                    <option value=""></option>

                                                    <?php $dados_conteudo = end($campo['parametros']);

                                                    foreach ($dados_conteudo['conteudo'] as $key => $value) {

                                                        if ($data[$campo['name']]==$key) {

                                                            $select = ' selected';

                                                        }else{

                                                            $select = '';

                                                        } ?>

                                                        <option value="<?php echo $key; ?>"<?php echo $select; ?>><?php echo $value; ?></option>

                                                    <?php } ?>

                                                </select>

                                            <?php }

                                            if ($campo['input'] == 'image') { ?>

                                                <input type="file" id="<?php echo $galeria['bd'].'_'.$campo['name'];?>" name="<?php echo $galeria['bd'].'_'.$campo['name'];?>">

                                            <?php }

                                            if ($campo['input'] == 'multi_image') { ?>

                                                <input type="file" id="<?php echo $galeria['bd'].'_'.$campo['name'];?>" name="<?php echo $galeria['bd'].'_'.$campo['name'];?>[]" multiple>

                                            <?php }

                                            if ($campo['input'] == 'archive') { ?>

                                                <input type="file" id="<?php echo $galeria['bd'].'_'.$campo['name'];?>" name="<?php echo $galeria['bd'].'_'.$campo['name'];?>">

                                            <?php }

                                            if ($campo['input'] == 'textarea') { ?>

                                                <textarea type="text" style="height:200px;" class="full-width" rows="<?php echo $campo['parametros']['rows']; ?>" maxlength="<?php echo $campo['amount'];?>" name="<?php echo $galeria['bd'].'_'.$campo['name'];?>" id="<?php echo html_entity_decode($galeria['bd'].'_'.$campo['name']);?>"></textarea>

                                            <?php }

                                            if ($campo['input'] == 'editor') { ?>

                                                <textarea type="text" class="full-width" name="<?php echo $galeria['bd'].'_'.$campo['name'];?>" id="<?php echo $galeria['bd'].'_'.$campo['name'];?>"></textarea>

                                            <?php }

                                            if ($campo['input'] == 'checkbox') {

                                                if ($resultado_galeria[$campo['name']]==1) {

                                                    $resultado_galeria[$campo['name']] = ' checked="checked"';

                                                 } ?>

                                                <label>

                                                    <input name="<?php echo $galeria['bd'].'_'.$campo['name'];?>" id="<?php echo $galeria['bd'].'_'.$campo['name'];?>" class="ace ace-switch ace-switch-6" type="checkbox" value="1" />

                                                    <span class="lbl"></span>

                                                </label>

                                            <?php } ?>

                                        </div>

                                    </div>

                                    <br>

                                <?php }

                            } ?>

                            <div class="clearfix form-actions">

                                <div class="col-sm-12 text-center">

                                    <button type="submit" class="btn btn-success btn-sm">Enviar</button>

                                </div>

                            </div>

                            <?php break;

                        }



                    }else{

                        echo '<div class="col-xs-12"><h4 class="header smaller">'.$galeria['titulo'].'</h4></div> ';



                        foreach ($galeria['campos'] as $campo) {

                            if ($campo['mostrar_campo']) { ?>

                                <div class="row">

                                    <div class="col-xs-3 align-r">

                                        <label><?php echo $campo['titulo'];?></label>

                                    </div>

                                    <div class="<?php echo $campo['class'];?>">

                                        <?php if ($campo['input'] == 'text') { ?>

                                            <input type="text" name="<?php echo $galeria['bd'].'_'.$campo['name'];?>" id="<?php echo $galeria['bd'].'_'.$campo['name'];?>" class="full-width" maxlength="<?php echo $campo['amount'];?>" value="">

                                        <?php }

                                        if ($campo['input'] == 'category') { ?>

                                            <select name="<?php echo $galeria['bd'].'_'.$campo['name'];?>" id="<?php echo $galeria['bd'].'_'.$campo['name'];?>">

                                                <option value=""></option>

                                                <?php $rows = $Funcoes->select('id, '.$campo['parametros'])->from($campo['category'])->where(array('status' => 1 ))->fetch();

                                                if ($Funcoes->affected_rows > 0) {

                                                    foreach($rows as $row){

                                                        if ($resultado[$campo['name']]==$row['id']) {

                                                            $selected = ' selected="selected"';

                                                        }else{

                                                            $selected = '';

                                                        } ?>

                                                        <option value="<?php echo $row['id']; ?>"<?php echo $selected; ?>><?php echo $row[$campo['parametros']]; ?></option>

                                                    <?php }

                                                } ?>

                                            </select>

                                        <?php }

                                        if ($campo['input'] == 'image') { ?>

                                            <input type="file" id="<?php echo $galeria['bd'].'_'.$campo['name'];?>" name="<?php echo $galeria['bd'].'_'.$campo['name'];?>">

                                        <?php }

                                        if ($campo['input'] == 'multi_image') { ?>

                                            <input type="file" id="<?php echo $galeria['bd'].'_'.$campo['name'];?>" name="<?php echo $galeria['bd'].'_'.$campo['name'];?>[]" multiple>

                                        <?php }

                                        if ($campo['input'] == 'archive') { ?>

                                            <input type="file" id="<?php echo $galeria['bd'].'_'.$campo['name'];?>" name="<?php echo $galeria['bd'].'_'.$campo['name'];?>">

                                        <?php }

                                        if ($campo['input'] == 'textarea') { ?>

                                            <textarea type="text" style="height:200px;" class="full-width" rows="<?php echo $campo['parametros']['rows']; ?>" maxlength="<?php echo $campo['amount'];?>" name="<?php echo $galeria['bd'].'_'.$campo['name'];?>" id="<?php echo $galeria['bd'].'_'.$campo['name'];?>"></textarea>

                                        <?php }

                                        if ($campo['input'] == 'editor') { ?>

                                            <textarea type="text" class="full-width" name="<?php echo $galeria['bd'].'_'.$campo['name'];?>" id="<?php echo $galeria['bd'].'_'.$campo['name'];?>"></textarea>

                                        <?php }

                                        if ($campo['input'] == 'checkbox') {

                                            if ($resultado_galeria[$campo['name']]==1) {

                                                $resultado_galeria[$campo['name']] = ' checked="checked"';

                                             } ?>

                                            <label>

                                                <input name="<?php echo $galeria['bd'].'_'.$campo['name'];?>" id="<?php echo $galeria['bd'].'_'.$campo['name'];?>" class="ace ace-switch ace-switch-6" type="checkbox" value="1" />

                                                <span class="lbl"></span>

                                            </label>

                                        <?php } ?>

                                    </div>

                                </div>

                                <br>

                            <?php }

                        } ?>

                        <div class="clearfix form-actions">

                            <div class="col-sm-12 text-center">

                                <button type="submit" class="btn btn-success btn-sm">Enviar</button>

                            </div>

                        </div>

                    <?php }

                } ?>

            </form>



            <?php $registro = $Funcoes->select('id')->from(PREFIX.$sistema['bd'])->where(array('url' => $url[2] ))->fetch_first();

            if ($Funcoes->affected_rows > 0) {

                $id = $registro['id'];

            }else{

                $Funcoes->redirect(URL_PAINEL.$sistema['url']);

                exit();

            }



            $legenda = $galeria['legenda_desta'];

            $imagem = $galeria['image_desta'];



            $resultado_galeria = $Funcoes->select("$legenda, $imagem, id, ordem")->from(PREFIX.$galeria['bd'])->where(array($sistema['bd'] => $id ))->order_by('ABS(ordem)')->fetch();

            if ($Funcoes->affected_rows > 0) { ?>

                <form action="<?=URL_PAINEL.$sistema['url']?>/excluir-fotos/<?=$url[2];?>/" method="POST">

                    <input type="hidden" name="galeria" value="<?php echo $galeria['bd']; ?>">

                    <div class="col-xs-12">

                        <h4 class="header smaller lighter blue">

                            Clique nas imagens para alterar seus dados

                            <button type="submit" class="btn btn-danger btn-sm pull-right hidden" onclick=" return confirm('Deseja realmente excluir esse(s) Cadastro(s)?')">

                                <i class="icon-trash"></i>

                                Excluir cadastros selecionados

                            </button>

                        </h4>

                    </div>

                    <div class="col-xs-12 form-group">

                        <ul class="ace-thumbnails">

                            <?php if ($galeria['type'] == 'images' ) {

                                foreach($resultado_galeria as $result_gal){



                                    $src_path = URL_UPLOAD_IMAGE.$sistema['bd'].'/';

                                    $real_path = PATH_IMAGES.$sistema['bd'].SEP; ?>

                                    <li draggable="true">

                                        <input type="hidden" name="id" value="<?php echo $result_gal['id']; ?>">

                                        <a data-rel="colorbox">

                                            <i class="miniatura" style="background-image: url(<?php echo $Funcoes->image($result_gal[$imagem],220,220,$real_path,'cortar',100,$src_path); ?>); background-size:100% auto;"></i>

                                        </a>

                                        <div class="tools tools-bottom">

                                            <a href="<?=URL_PAINEL.$sistema['url']?>/<?=$url[2];?>/galeria/<?php echo $galeria['bd']; ?>/atualizar/<?=$result_gal['id'];?>"><i class="icon-pencil"></i></a>

                                            <a href="<?=URL_PAINEL.$sistema['url']?>/<?=$url[2];?>/galeria/<?php echo $galeria['bd']; ?>/excluir/<?=$result_gal['id'];?>"><i class="icon-remove red"></i></a>

                                        </div>

                                        <div class="tools tools-top hidden">

                                            <input type="checkbox" name="<?php echo $galeria['bd']; ?>[]" value="<?php echo $result_gal['id'];?>" >

                                        </div>

                                    </li>

                                <?php }

                            } ?>

                        </ul>

                    </div>

                </form>

            <?php }



        } ?>

    </div>

    <div class="col-xs-12 form-group">

        <?php if ($_SESSION['admin_nivel_acesso']==1) { ?>

            <a href="<?=URL_PAINEL.$sistema['url']?>" class="btn btn-sm btn-default pull-right"><i class="icon-double-angle-left"></i>Voltar</a>

        <?php }else{

            if ($sistema['mostar_voltar']) { ?>

                <a href="<?=URL_PAINEL.$sistema['url']?>" class="btn btn-sm btn-default pull-right"><i class="icon-double-angle-left"></i>Voltar</a>

            <?php }

        } ?>

    </div>

<?php }elseif (isset($url[2])&&$url[2]=='galeria') {



    if ($url[4]=='excluir') {



        if (isset($sistema['galeria'])) {





            foreach ($sistema['galeria'] AS $galeria) {



                if ($galeria['bd']==$url[3]) {



                    foreach ($galeria['campos'] as $campo) {



                        if ($campo['input']=='multi_image') {





                            $rows = $Funcoes->select($campo['name'])->from(PREFIX.$galeria['bd'])->where(array('id' => intval($url[5]) ))->fetch_first();

                            if ($Funcoes->affected_rows > 0) {

                                if (!empty($rows[$campo['name']])) {

                                    $Funcoes->delete_images_from_path(PATH_IMAGES.$sistema['bd'].SEP,$rows[$campo['name']]);

                                }

                            }





                        }

                    }

                }

            }



            $Funcoes->delete()->from(PREFIX.$galeria['bd'])->where('id', intval($url[5]))->limit(1)->execute();



            $_SESSION['SYSTEM_MENSSAGE'] = 'Cadastro excluído com sucesso !';

            $_SESSION['SYSTEM_STATUS'] = 'success';



            $Funcoes->redirect(URL_PAINEL.$sistema['url'].'/atualizar/'.$url[1]);

            exit();





        }



    }elseif ($url[4]=='atualizar') {



        if (isset($sistema['galeria'])) {



            foreach ($sistema['galeria'] AS $galeria) {



                if ($galeria['bd']==$url[3]) {



                    $Funcoes->setGaleriaName($galeria['bd']);



                    $select = '';

                    foreach ($galeria['campos'] as $nome) {

                        $select .= $nome['name'].', ';

                    }

                    $select = substr($select, 0, -2);



                    if (!empty($_POST)) {



                        $Funcoes->setId($url[5]);



                        $data = $_POST;

                        $files = $_FILES;



                        $Funcoes->setData($data);

                        $resultado = $data;



                        $Funcoes->setFiles($files);



                        $retorno = $Funcoes->atualizar_galeria();





                        if ($retorno) {

                            $_SESSION['SYSTEM_MENSSAGE'] = 'Cadastro atualizado com sucesso !';

                            $_SESSION['SYSTEM_STATUS'] = 'success';

                        }else{

                            $_SESSION['SYSTEM_MENSSAGE'] = 'Ops ouve algum problema com o cadastro !';

                            $_SESSION['SYSTEM_STATUS'] = 'danger';

                        }

                        $this->redirect(URL_PAINEL.$url[0].'/'.$url[1].'/'.$url[2].'/'.$url[3].'/'.$url[4].'/'.$url[5]);

                        exit();



                    }else{

                        $resultado = $Funcoes->select($select)->from(PREFIX.$galeria['bd'])->where(array('id' => intval($url[5]) ))->fetch_first();

                        if ($Funcoes->affected_rows > 0) {





                        }else{

                            $Funcoes->redirect(URL_PAINEL.$sistema['url']);

                            exit();

                        }

                    } ?>



                    <div class="page-header">

                        <h1> <?php echo $sistema['titulo_atualizar_galeria']; ?> </h1>

                    </div>



                    <div class="col-xs-12 form-group">

                        <?php if ($_SESSION['admin_nivel_acesso']==1) { ?>

                            <a href="<?=URL_PAINEL.$sistema['url']?>/atualizar/<?php echo $url[1]; ?>" class="btn btn-sm btn-default pull-right"><i class="icon-double-angle-left"></i>Voltar</a>

                        <?php }else{

                            if ($sistema['mostar_voltar']) { ?>

                                <a href="<?=URL_PAINEL.$sistema['url']?>/atualizar/<?php echo $url[1]; ?>" class="btn btn-sm btn-default pull-right"><i class="icon-double-angle-left"></i>Voltar</a>

                            <?php }

                        } ?>

                    </div>

                    <div class="col-xs-12 form-group">

                        <?php if ($_SESSION['SYSTEM_MENSSAGE']!='') {

                            echo $Funcoes->message_system($_SESSION['SYSTEM_MENSSAGE'], $_SESSION['SYSTEM_STATUS']);

                            $_SESSION['SYSTEM_MENSSAGE'] = '';

                        }?>

                    </div>

                    <form method="post" enctype="multipart/form-data">

                        <div class="col-xs-12">

                            <?php foreach ($galeria['campos'] as $campo) {

                                if ($campo['mostrar_campo']) {

                                    if (isset($campo['parametros']['only'])&&is_array($campo['parametros']['only'])) {

                                        if ($campo['parametros']['only']==$url[2]) {



                                            if ($campo['input'] == 'image') {

                                                if (!empty($resultado[$campo['name']])) {

                                                    $real_path = PATH_IMAGES.$sistema['bd'].SEP;

                                                    $src_path = URL_UPLOAD_IMAGE.$sistema['bd'].'/'; ?>

                                                    <div class="row">

                                                        <div class="col-sm-12 text-center">

                                                            Imagem atual<br/>

                                                            <img src="<?php echo $Funcoes->image($resultado[$campo['name']],450,450,$real_path,'redimencionar',100,$src_path); ?>">

                                                        </div>

                                                    </div>

                                                    <br>



                                                <?php }

                                            }

                                            if ($campo['input'] == 'multi_image') {

                                                if (!empty($resultado[$campo['name']])) {

                                                    $real_path = PATH_IMAGES.$sistema['bd'].SEP;

                                                    $src_path = URL_UPLOAD_IMAGE.$sistema['bd'].'/'; ?>

                                                    <div class="row">

                                                        <div class="col-sm-12 text-center">

                                                            Imagem atual<br/>

                                                            <img src="<?php echo $Funcoes->image($resultado[$campo['name']],450,450,$real_path,'redimencionar',100,$src_path); ?>">

                                                        </div>

                                                    </div>

                                                    <br>



                                                <?php }

                                            }

                                            if ($campo['input'] == 'archive') {

                                                if (!empty($resultado[$campo['name']])) { ?>

                                                    <div class="row">

                                                        <div class="col-sm-12 text-center">

                                                            <a href="<?php echo URL_UPLOAD_ARCHIVE.$sistema['bd'].'/'.$resultado[$campo['name']];?>" target="_blank">Arquivo atual</a><br/>

                                                        </div>

                                                    </div>

                                                    <br>



                                                <?php }

                                            }

                                            if (!empty($campo['parametros'])) {

                                                $only = current($campo['parametros']);

                                                if (isset($only['only'])) {

                                                    if ( in_array ($url[2], $only['only'])) {

                                                        $class = '';

                                                    }else{

                                                        $class = ' hidden';

                                                    }



                                                }else{

                                                    $class = '';

                                                }

                                             } ?>

                                            <div class="row<?=$class?>">

                                                <div class="col-xs-3 align-r">

                                                    <label><?php echo $campo['titulo'];?></label>

                                                </div>

                                                <div class="<?php echo $campo['class'];?>">

                                                    <?php if ($campo['input'] == 'text') { ?>

                                                        <input type="text" name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>" class="full-width" maxlength="<?php echo $campo['amount'];?>" value="<?php echo $resultado[$campo['name']]; ?>">

                                                    <?php }

                                                    if ($campo['input'] == 'select') {?>

                                                        <select <?=$class?> name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>">

                                                            <option value=""></option>

                                                            <?php $dados_conteudo = end($campo['parametros']);

                                                            foreach ($dados_conteudo['conteudo'] as $key => $value) {

                                                                if ($data[$campo['name']]==$key) {

                                                                    $select = ' selected';

                                                                }else{

                                                                    $select = '';

                                                                } ?>

                                                                <option value="<?php echo $key; ?>"<?php echo $select; ?>><?php echo $value; ?></option>

                                                            <?php } ?>

                                                        </select>

                                                    <?php }

                                                    if ($campo['input'] == 'date') { ?>

                                                        <div class="input-group">

                                                            <div class="input-group">

                                                                <input class="form-control input-mask-date date-picker" type="text" id="<?php echo $campo['name'];?>" name="<?php echo $campo['name'];?>" value="<?php echo implode("/",array_reverse(explode("-", $resultado[$campo['name']]))); ?>" />

                                                                <span class="input-group-addon"><i class="icon-calendar bigger-110"></i></span>

                                                            </div>

                                                        </div>

                                                    <?php }

                                                    if ($campo['input'] == 'datetime') {

                                                        $resultado[$campo['name']] = str_replace(' ', 'T', $resultado[$campo['name']]); ?>

                                                        <div class="input-group">

                                                            <div class="input-group">

                                                                <input class="form-control" type="datetime-local" id="<?php echo $campo['name'];?>" name="<?php echo $campo['name'];?>" value="<?php echo $resultado[$campo['name']]; ?>" />

                                                                <span class="input-group-addon"><i class="icon-calendar bigger-110"></i></span>

                                                            </div>

                                                        </div>

                                                    <?php }

                                                    if ($campo['input'] == 'time') { ?>

                                                        <div class="input-group">

                                                            <div class="input-group">

                                                                <input class="form-control time-picker" type="text" id="<?php echo $campo['name'];?>" name="<?php echo $campo['name'];?>" value="<?=$resultado[$campo['name']];?>" />

                                                                <span class="input-group-addon"><i class="icon-time bigger-110"></i></span>

                                                            </div>

                                                            <small class="text-success">hh:mm:ss</small>

                                                        </div>

                                                    <?php }

                                                    if ($campo['input'] == 'money') { ?>

                                                        <div class="input-group">

                                                            <div class="input-group">

                                                                <input id="<?php echo $campo['name'];?>" name="<?php echo $campo['name'];?>" type="text" class="form-control input-mask-money" value="<?=$resultado[$campo['name']];?>" />

                                                                <span class="input-group-addon"><i class="icon-money bigger-110"></i></span>

                                                            </div>

                                                        </div>

                                                    <?php }

                                                    if ($campo['input'] == 'image') { ?>

                                                        <input type="file" id="<?php echo $campo['name'];?>" name="<?php echo $campo['name'];?>">

                                                    <?php }

                                                    if ($campo['input'] == 'multi_image') { ?>

                                                        <input type="file" id="<?php echo $campo['name'];?>" name="<?php echo $campo['name'];?>">

                                                    <?php }

                                                    if ($campo['input'] == 'archive') { ?>

                                                        <input type="file" id="<?php echo $campo['name'];?>" name="<?php echo $campo['name'];?>">

                                                    <?php }

                                                    if ($campo['input'] == 'category') { ?>



                                                        <select name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>">

                                                            <option value=""></option>

                                                            <?php $rows = $Funcoes->select('id, '.$campo['parametros'])->from($campo['category'])->where(array('status' => 1 ))->fetch();

                                                            if ($Funcoes->affected_rows > 0) {

                                                                foreach($rows as $row){

                                                                    if ($resultado[$campo['name']]==$row['id']) {

                                                                        $selected = ' selected="selected"';

                                                                    }else{

                                                                        $selected = '';

                                                                    } ?>

                                                                    <option value="<?php echo $row['id']; ?>"<?php echo $selected; ?>><?php echo $row[$campo['parametros']]; ?></option>

                                                                <?php }

                                                            } ?>

                                                        </select>

                                                    <?php }

                                                    if ($campo['input'] == 'subcategory') { ?>



                                                        <select name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>">

                                                            <option value=""></option>

                                                            <?php $rows = $Funcoes->select('id, nome')->from($campo['category'])->where(array('status' => 1 ))->fetch();

                                                            if ($Funcoes->affected_rows > 0) {

                                                                foreach($rows as $row){

                                                                    if ($resultado[$campo['name']]==$row['id']) {

                                                                        $selected = ' selected="selected"';

                                                                    }else{

                                                                        $selected = '';

                                                                    } ?>

                                                                    <option value="<?php echo $row['id']; ?>"<?php echo $selected; ?>><?php echo $row['nome']; ?></option>

                                                                <?php }

                                                            } ?>

                                                        </select>

                                                    <?php }

                                                    if ($campo['input'] == 'textarea') { ?>

                                                        <textarea type="text" style="height:200px;" class="full-width" rows="<?php echo $campo['parametros']['rows'];?>" maxlength="<?php echo $campo['amount'];?>" name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>"><?php echo html_entity_decode($resultado[$campo['name']]); ?></textarea>

                                                    <?php }

                                                    if ($campo['input'] == 'editor') { ?>

                                                        <textarea type="text" class="full-width" name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>"><?php echo $resultado[$campo['name']]; ?></textarea>

                                                    <?php }

                                                    if ($campo['input'] == 'checkbox') {

                                                        if ($resultado[$campo['name']]==1) {

                                                            $resultado[$campo['name']] = ' checked="checked"';

                                                         } ?>

                                                        <label>

                                                            <input name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>" class="ace ace-switch ace-switch-6" type="checkbox"<?=$resultado[$campo['name']];?> value="1" />

                                                            <span class="lbl"></span>

                                                        </label>

                                                    <?php } ?>

                                                </div>

                                            </div>

                                            <br><?php

                                        }

                                    }else{

                                        if ($campo['input'] == 'multi_image') {

                                            if (!empty($resultado[$campo['name']])) {

                                                $real_path = PATH_IMAGES.$sistema['bd'].SEP;

                                                $src_path = URL_UPLOAD_IMAGE.$sistema['bd'].'/'; ?>

                                                <div class="row">

                                                    <div class="col-sm-12 text-center">

                                                        Imagem atual<br/>

                                                        <img src="<?php echo $Funcoes->image($resultado[$campo['name']],450,450,$real_path,'redimencionar',100,$src_path); ?>">

                                                    </div>

                                                </div>

                                                <br>



                                            <?php }

                                        }

                                        if ($campo['input'] == 'image') {

                                            if (!empty($resultado[$campo['name']])) {

                                                $real_path = PATH_IMAGES.$sistema['bd'].SEP;

                                                $src_path = URL_UPLOAD_IMAGE.$sistema['bd'].'/'; ?>

                                                <div class="row">

                                                    <div class="col-sm-12 text-center">

                                                        Imagem atual<br/>

                                                        <img src="<?php echo $Funcoes->image($resultado[$campo['name']],450,450,$real_path,'redimencionar',100,$src_path); ?>">

                                                    </div>

                                                </div>

                                                <br>

                                            <?php }

                                        }

                                        if ($campo['input'] == 'archive') {

                                            if (!empty($resultado[$campo['name']])) { ?>

                                                <div class="row">

                                                    <div class="col-sm-12 text-center">

                                                        <a href="<?php echo URL_UPLOAD_ARCHIVE.$sistema['bd'].'/'.$resultado[$campo['name']];?>" target="_blank">Arquivo atual</a><br/>

                                                    </div>

                                                </div>

                                                <br>



                                            <?php }

                                        }

                                        if (!empty($campo['parametros'])) {

                                            $only = current($campo['parametros']);

                                            if (isset($only['only'])) {

                                                if ( in_array ($url[1], $only['only'])) {

                                                    $class = '';

                                                }else{

                                                    $class = ' hidden';

                                                }



                                            }else{

                                                $class = '';

                                            }

                                         }else{

                                            $class = '';

                                         } ?>

                                        <div class="row<?=$class?>">

                                            <div class="col-xs-3 align-r">

                                                <label><?php echo $campo['titulo'];?></label>

                                            </div>

                                            <div class="<?php echo $campo['class'];?>">

                                                <?php if ($campo['input'] == 'text') { ?>

                                                    <input type="text" name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>" class="full-width" maxlength="<?php echo $campo['amount'];?>" value="<?php echo $resultado[$campo['name']]; ?>">

                                                <?php }

                                                if ($campo['input'] == 'select') {?>

                                                        <select <?=$class?> name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>">

                                                            <option value=""></option>

                                                            <?php $dados_conteudo = end($campo['parametros']);

                                                            foreach ($dados_conteudo['conteudo'] as $key => $value) {

                                                                if ($resultado[$campo['name']]==$key) {

                                                                    $select = ' selected';

                                                                }else{

                                                                    $select = '';

                                                                } ?>

                                                                <option value="<?php echo $key; ?>"<?php echo $select; ?>><?php echo $value; ?></option>

                                                            <?php } ?>

                                                        </select>

                                                    <?php }

                                                if ($campo['input'] == 'date') { ?>

                                                    <div class="input-group">

                                                        <div class="input-group">

                                                            <input class="form-control input-mask-date date-picker" type="text" id="<?php echo $campo['name'];?>" name="<?php echo $campo['name'];?>" value="<?php echo implode("/",array_reverse(explode("-", $resultado[$campo['name']]))); ?>" />

                                                            <span class="input-group-addon"><i class="icon-calendar bigger-110"></i></span>

                                                        </div>

                                                    </div>

                                                <?php }

                                                if ($campo['input'] == 'datetime') {

                                                    $resultado[$campo['name']] = str_replace(' ', 'T', $resultado[$campo['name']]); ?>

                                                    <div class="input-group">

                                                        <div class="input-group">

                                                            <input class="form-control" type="datetime-local" id="<?php echo $campo['name'];?>" name="<?php echo $campo['name'];?>" value="<?php echo $resultado[$campo['name']]; ?>" />

                                                            <span class="input-group-addon"><i class="icon-calendar bigger-110"></i></span>

                                                        </div>

                                                    </div>

                                                <?php }

                                                if ($campo['input'] == 'time') { ?>

                                                    <div class="input-group">

                                                        <div class="input-group bootstrap-timepicker">

                                                            <input class="form-control time-picker" type="text" id="<?php echo $campo['name'];?>" name="<?php echo $campo['name'];?>" value="<?=$resultado[$campo['name']];?>" />

                                                            <span class="input-group-addon"><i class="icon-time bigger-110"></i></span>

                                                        </div>

                                                        <small class="text-success">hh:mm:ss</small>

                                                    </div>

                                                <?php }

                                                if ($campo['input'] == 'money') { ?>

                                                    <div class="input-group">

                                                        <div class="input-group bootstrap-timepicker">

                                                            <input id="<?php echo $campo['name'];?>" name="<?php echo $campo['name'];?>" type="text" class="form-control input-mask-money" value="<?=$resultado[$campo['name']];?>" />

                                                            <span class="input-group-addon"><i class="icon-money bigger-110"></i></span>

                                                        </div>

                                                    </div>

                                                <?php }

                                                if ($campo['input'] == 'image') { ?>

                                                    <input type="file" id="<?php echo $campo['name'];?>" name="<?php echo $campo['name'];?>">

                                                <?php }

                                                if ($campo['input'] == 'multi_image') { ?>

                                                    <input type="file" id="<?php echo $campo['name'];?>" name="<?php echo $campo['name'];?>">

                                                <?php }

                                                if ($campo['input'] == 'archive') { ?>

                                                    <input type="file" id="<?php echo $campo['name'];?>" name="<?php echo $campo['name'];?>">

                                                <?php }

                                                if ($campo['input'] == 'category') { ?>



                                                    <select name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>">

                                                        <option value=""></option>

                                                        <?php $rows = $Funcoes->select('id, '.$campo['parametros'])->from($campo['category'])->where(array('status' => 1 ))->fetch();

                                                        if ($Funcoes->affected_rows > 0) {

                                                            foreach($rows as $row){

                                                                if ($resultado[$campo['name']]==$row['id']) {

                                                                    $selected = ' selected="selected"';

                                                                }else{

                                                                    $selected = '';

                                                                } ?>

                                                                <option value="<?php echo $row['id']; ?>"<?php echo $selected; ?>><?php echo $row[$campo['parametros']]; ?></option>

                                                            <?php }

                                                        } ?>

                                                    </select>

                                                <?php }

                                                if ($campo['input'] == 'subcategory') { ?>



                                                    <select name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>">

                                                        <option value=""></option>

                                                        <?php $rows = $Funcoes->select('id, nome')->from($campo['category'])->where(array('status' => 1 ))->fetch();

                                                        if ($Funcoes->affected_rows > 0) {

                                                            foreach($rows as $row){

                                                                if ($resultado[$campo['name']]==$row['id']) {

                                                                    $selected = ' selected="selected"';

                                                                }else{

                                                                    $selected = '';

                                                                } ?>

                                                                <option value="<?php echo $row['id']; ?>"<?php echo $selected; ?>><?php echo $row['nome']; ?></option>

                                                            <?php }

                                                        } ?>

                                                    </select>

                                                <?php }

                                                if ($campo['input'] == 'textarea') { ?>

                                                    <textarea type="text" style="height:200px;" class="full-width" rows="<?php echo $campo['parametros']['rows'];?>" maxlength="<?php echo $campo['amount'];?>" name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>"><?php echo html_entity_decode($resultado[$campo['name']]); ?></textarea>

                                                <?php }

                                                if ($campo['input'] == 'editor') { ?>

                                                    <textarea type="text" class="full-width" name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>"><?php echo $resultado[$campo['name']]; ?></textarea>

                                                <?php }

                                                if ($campo['input'] == 'checkbox') {

                                                    if ($resultado[$campo['name']]==1) {

                                                        $resultado[$campo['name']] = ' checked="checked"';

                                                     } ?>

                                                    <label>

                                                        <input name="<?php echo $campo['name'];?>" id="<?php echo $campo['name'];?>" class="ace ace-switch ace-switch-6" type="checkbox"<?=$resultado[$campo['name']];?> value="1" />

                                                        <span class="lbl"></span>

                                                    </label>

                                                <?php } ?>

                                            </div>

                                        </div>

                                        <br><?php

                                    }

                                }

                            } ?>

                            <div class="clearfix form-actions">

                                <div class="col-sm-12 text-center">

                                    <button type="submit" class="btn btn-success btn-sm">Atualizar</button>

                                </div>

                            </div>



                        </div>

                    </form>

                    <div class="col-xs-12 form-group">

                        <?php if ($_SESSION['admin_nivel_acesso']==1) { ?>

                            <a href="<?=URL_PAINEL.$sistema['url']?>/atualizar/<?php echo $url[1]; ?>" class="btn btn-sm btn-default pull-right"><i class="icon-double-angle-left"></i>Voltar</a>

                        <?php }else{

                            if ($sistema['mostar_voltar']) { ?>

                                <a href="<?=URL_PAINEL.$sistema['url']?>/atualizar/<?php echo $url[1]; ?>" class="btn btn-sm btn-default pull-right"><i class="icon-double-angle-left"></i>Voltar</a>

                            <?php }

                        } ?>

                    </div>

                <?php }

            }

        }else{

            $Funcoes->redirect(URL_PAINEL.$sistema['url']);

            exit();

        }

    }

}elseif ($url[1]=='excluir') {

    if (!empty($url[2])) {



        foreach ($sistema['campos'] as $campo) {

            if ($campo['input']=='image') {



                $rows = $Funcoes->select($campo['name'])->from(PREFIX.$sistema['bd'])->where(array('url' => $url[2]))->fetch_first();

                if ($Funcoes->affected_rows > 0) {

                    if (!empty($rows[$campo['name']])) {

                        $Funcoes->delete_images_from_path(PATH_IMAGES.$sistema['bd'].SEP,$rows[$campo['name']]);

                    }

                }



            }



            if ($campo['input']=='archive') {



                $rows = $Funcoes->select($campo['name'])->from(PREFIX.$sistema['bd'])->where(array('url' => $url[2]))->fetch_first();

                if ($Funcoes->affected_rows > 0) {

                    if (!empty($rows[$campo['name']])) {

                        $Funcoes->deletar_aquivo(PATH_ARCHIVES.$sistema['bd'].SEP.$rows[$campo['name']]);

                    }

                }



            }

        }



        if (isset($sistema['galeria'])) {



            $registro = $Funcoes->select('id')->from(PREFIX.$sistema['bd'])->where(array('url' => $url[2] ))->fetch_first();

            if ($Funcoes->affected_rows > 0) {

                $id = $registro['id'];

            }else{

                $Funcoes->redirect(URL_PAINEL.$sistema['url']);

                exit();

            }



            foreach ($sistema['galeria'] as $galeria) {



                foreach ($galeria['campos'] as $campo) {



                    if ($campo['input']=='multi_image') {





                        $rows = $Funcoes->select($campo['name'])->from(PREFIX.$galeria['bd'])->where(array($sistema['bd'] => $id))->fetch();

                        if ($Funcoes->affected_rows > 0) {

                            foreach ($rows as $key => $row) {

                                $Funcoes->delete_images_from_path(PATH_IMAGES.$sistema['bd'].SEP,$row[$campo['name']]);

                            }



                        }





                    }

                }



            }



            $Funcoes->delete()->from(PREFIX.$galeria['bd'])->where(array($sistema['bd'] => $id))->execute();

        }



        $Funcoes->delete()->from(PREFIX.$sistema['bd'])->where('url', $url[2])->limit(1)->execute();



        $_SESSION['SYSTEM_MENSSAGE'] = 'Cadastro excluído com sucesso !';

        $_SESSION['SYSTEM_STATUS'] = 'success';



    }else{



        $_SESSION['SYSTEM_MENSSAGE'] = 'Opssss ! Algo deu errado. ';

        $_SESSION['SYSTEM_STATUS'] = 'danger';

    }



    $Funcoes->redirect(URL_PAINEL.$sistema['url']);

    exit();

}elseif ($url[1]=='instalar') {



    $Funcoes->instalar();

    exit();

}elseif ($url[1]=='limpar') {



    $_SESSION['busca_'.$sistema['bd']] = '';

    $_SESSION['cidade_'.$sistema['bd']] = '';

    $_SESSION['estado_'.$sistema['bd']] = '';

    $Funcoes->redirect(URL_PAINEL.$sistema['url']);

    exit();

}elseif ($url[1]=='exportar') {



    $this->criar_pasta(PATH_PAINEL.'export');



    $data = date("F j, Y, g:i a");

    $data = strtolower($data);

    $data = str_replace(",", "-", $data);

    $data = str_replace(" ", "-", $data);

    $data = str_replace(":", "-", $data);

    $data = str_replace("--", "-", $data);



    $arquivo = $data.'.csv';



    $_SESSION['csv_name_'.$sistema['bd']] = $arquivo;



    $fp = fopen(PATH_PAINEL.'export'.SEP.$arquivo, "a");



    $select = '';

    $csv = '';



    foreach ($sistema['export'] as $key => $array) {



        if ($key==0) {

            $csv.=  key($array);

            $select.=  $array[key($array)];

        }else{

            $csv.=  '; '.key($array);

            $select.=  ', '.$array[key($array)];

        }

    }

    $csv.= ' '.chr(13);





    $normalizeChars = array(

            'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'Ae',

            'Ç'=>'C',

            'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E',

            'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I',

            'Ð'=>'Dj',

            'Ñ'=>'N',

            'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O',

            'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U',

            'Ý'=>'Y',

            'Þ'=>'B',

            'ß'=>'Ss',

            'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'ae',

            'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e',

            'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i',

            'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o',

            'ù'=>'u', 'ú'=>'u', 'û'=>'u',

            'ý'=>'y',

            'þ'=>'b',

            'ÿ'=>'y',

            'Š'=>'S', 'š'=>'s', 'ś' => 's',

            'Ž'=>'Z', 'ž'=>'z',

            'ƒ'=>'f',

            chr(13) => '', chr(10) => '',

        );



    $resultados = $Funcoes->select($select)->from(PREFIX.$sistema['bd'])->fetch();

    if ($Funcoes->affected_rows > 0) {

        foreach($resultados as $resultado){



            foreach ($sistema['export'] as $key => $nome) {

                $string = $resultado[$nome[key($nome)]];



                foreach ($normalizeChars as $errado => $certo) {

                    $string = str_replace($errado, $certo, $string);

                }

                $corrigir = get_html_translation_table(HTML_ENTITIES);

                $string = strtr($string, $corrigir);

                $string = htmlentities($string);

                $string = htmlspecialchars($string);

                $string = strip_tags($string);



                if ($key==0) {

                    $csv.=  $string;

                }else{

                    $csv.=  '; '.$string;

                }





            }



            $csv.= ' '.chr(13);

        }





        $escreve = fwrite($fp, $csv);

    }else{

        $escreve = fwrite($fp, "Vazio");

    }



    fclose($fp);



    $Funcoes->redirect(URL_PAINEL.$sistema['url']);

    exit();

}elseif ($url[1]=='clone') {



    $data = $Funcoes->select('*')->from(PREFIX.$sistema['bd'])->where(array('url' => $url[2] ))->fetch_first();

    if ($Funcoes->affected_rows > 0) {

        unset($data['id']);

        $url = $Funcoes->url_amigavel($data['nome']);

        $verificar = true;

        $cont = 1;

        while ($verificar) {

            $rows = $Funcoes->select('id')->from(PREFIX.$sistema['bd'])->where(array('url' => $url))->fetch_first();

            if ($Funcoes->affected_rows > 0) {

                $url = $Funcoes->url_amigavel($Funcoes->tratarString($data['nome'])).'_'.$cont;

            }else{

                $verificar = false;

            }

            $cont ++;

        }



        $data['url'] = $url;

        $Funcoes->insert(PREFIX.$sistema['bd'], $data);



    }



    $Funcoes->redirect(URL_PAINEL.$sistema['url']);

    exit();

}elseif ($url[1]=='excluir-fotos') {



    $item_atual = $url[2];

    $galeria = $_POST['galeria'];

    $fotos = $_POST[$galeria];

    foreach ($fotos as $key => $id_foto) {

        $row = $Funcoes->select('image')->from(PREFIX.$galeria)->where(array('id' => $id_foto))->fetch_first();

        if ($Funcoes->affected_rows > 0) {

            $Funcoes->delete_images_from_path(PATH_IMAGES.$sistema['bd'].SEP,$row['image']);

        }

        $Funcoes->delete()->from(PREFIX.$galeria)->where(array('id' => $id_foto))->execute();

    }



    $Funcoes->redirect(URL_PAINEL.$sistema['url'].'/atualizar/'.$item_atual);

    exit();

}elseif($url[1]=='order'){

    if ($_POST) {

        extract($_POST);

        foreach ($sistema['galeria'] AS $galeria) {

            if ($galeria['bd']==$url[2]) {

                $Funcoes->where(array('id' => $id))->update(PREFIX.$galeria['bd'], array('ordem' => $ordem));

            }

        }

    }

}else{

    $Funcoes->not_found();

} ?>

<script src="<?=URL_PAINEL_TEMPLATE?>assets/js/date-time/bootstrap-datepicker.min.js"></script>

<script src="<?=URL_PAINEL_TEMPLATE?>assets/js/date-time/locales/bootstrap-datepicker.pt-BR.js"></script>

<script src="<?=URL_PAINEL_TEMPLATE?>assets/js/date-time/bootstrap-timepicker.min.js"></script>

<script src="<?=URL_PAINEL_TEMPLATE?>assets/js/date-time/moment.min.js"></script>

<link rel="stylesheet" href="<?=URL_PAINEL_TEMPLATE?>assets/css/bootstrap-timepicker.css" />

<script src="<?=URL_PAINEL_TEMPLATE?>assets/js/jquery.maskedinput.min.js"></script>

<script src="<?=URL_PAINEL_TEMPLATE?>assets/js/jquery.maskMoney.min.js" type="text/javascript"></script>

<link rel="stylesheet" href="<?=URL_PAINEL_TEMPLATE?>assets/css/datepicker.min.css" />

<script>

    $('.date-picker').datepicker({autoclose:true, language: "pt-BR", format: "dd/mm/yyyy"}).next().on(ace.click_event, function(){$(this).prev().focus(); });

    $('.time-picker').timepicker({minuteStep: 1, showSeconds: false, showMeridian: false }).next().on(ace.click_event, function(){$(this).prev().focus(); });



    $('.time-picker').mask('99:99');

    var mascara_money = function(){

        $(".input-mask-money").maskMoney({prefix:'R$ ', allowNegative: false, thousands:'.', decimal:',', affixesStay: false});

    }



    mascara_money();



    var remove_this = function(swap_this){

        $('button[type="remove-this-'+swap_this+'"]').click(function(event) {

            event.preventDefault();

            $(this).parent().remove();

        });

    }

    var get_coodernadas = function(){

        $('#coordenadas').on('click', function(event) {

            event.preventDefault();



            var cep = $(this).parents().find('input[type="cep"]').val();

            only_numbers = /[^0-9]/g;

            cep = cep.replace(only_numbers,'');



            $.getJSON("https://maps.googleapis.com/maps/api/geocode/json?address="+cep+"&key=AIzaSyA80x5YFO4-QSjs0r7uwm69DBijFNWmFFc", function(data) {

                console.log(data);

                $('#latitude').val(data.results[0].geometry.location.lat);

                $('#longitude').val(data.results[0].geometry.location.lng);

            });



        });

    }



    get_coodernadas();



    $('input[type="date"]').mask('99/99/9999');

    $('input[type="cpf"]').mask('999.999.999-99');

    $('input[type="cnpj"]').mask('99.999.999/9999-99');



    $('input[type="cep"]').mask('99.999-999');



    <?php foreach ($sistema['campos'] as $campo) {

        extract($campo);



        if ($input=='dropdown_plus_more_options') { ?>

            var add_more_<?php echo $campo['name']; ?> = '<div class="col-md-3" style="outline: 5px solid #e3e3e3; padding: 25px;">';

                add_more_<?php echo $campo['name']; ?> = add_more_<?php echo $campo['name']; ?>+'<div class="text-center"> <label><?php echo $campo['titulo']; ?></label> </div>';

                    <?php foreach ($campo['parametros']['fields'] as $index => $field):?>

                        var add_more_<?php echo $campo['name']; ?> = add_more_<?php echo $campo['name']; ?>+'<div style="margin-bottom: 10px;">';

                            <?php if ($field['type']['input'] == 'money') { ?>

                                add_more_<?php echo $campo['name']; ?> = add_more_<?php echo $campo['name']; ?>+'<div class="input-group full-width">';

                                    add_more_<?php echo $campo['name']; ?> = add_more_<?php echo $campo['name']; ?>+'<div class="input-group bootstrap-timepicker">';

                                        add_more_<?php echo $campo['name']; ?> = add_more_<?php echo $campo['name']; ?>+'<input name="<?php echo $field['name'] ?>[]" type="money" class="form-control input-mask-money"  placeholder="<?php echo $field['label'] ?>" />';

                                        add_more_<?php echo $campo['name']; ?> = add_more_<?php echo $campo['name']; ?>+'<span class="input-group-addon"><i class="icon-money bigger-110"></i></span>';

                                    add_more_<?php echo $campo['name']; ?> = add_more_<?php echo $campo['name']; ?>+'</div>';

                                add_more_<?php echo $campo['name']; ?> = add_more_<?php echo $campo['name']; ?>+'</div>';

                            <?php } ?>

                            <?php if ($field['type']['input'] == 'image') { ?>

                                add_more_<?php echo $campo['name']; ?> = add_more_<?php echo $campo['name']; ?>+'<label><?php echo $field['label'] ?><input type="file" name="<?php echo $field['name'];?>[]"></label>';

                            <?php } ?>

                            <?php if ($field['type']['input'] == 'archive') { ?>

                                add_more_<?php echo $campo['name']; ?> = add_more_<?php echo $campo['name']; ?>+'<label><?php echo $field['label'] ?><input type="file" name="<?php echo $field['name'];?>[]"></label>';

                            <?php } ?>

                            <?php if ($field['type']['input'] == 'textarea') { ?>

                            add_more_<?php echo $campo['name']; ?> = add_more_<?php echo $campo['name']; ?>+'<textarea type="text" class="full-width" name="<?php echo $field['name'] ?>[]" style="height:200px;" placeholder="<?php echo $field['label'] ?>" ></textarea>';

                            <?php } ?>

                            <?php if ($field['type']['input'] == 'text') { ?>

                            add_more_<?php echo $campo['name']; ?> = add_more_<?php echo $campo['name']; ?>+'<input name="<?php echo $field['name'] ?>[]" type="text" class="full-width" value="" placeholder="<?php echo $field['label'] ?>" /> ';

                            <?php } ?>

                            <?php if ($field['type']['input'] == 'checkbox') { ?>

                            add_more_<?php echo $campo['name']; ?> = add_more_<?php echo $campo['name']; ?>+'<label><?php echo $field['label'] ?><input name="<?php echo $field['name'] ?>[{:index:}]" id="<?php echo $field['name'] ?>[{:index:}]" class="ace ace-switch ace-switch-6" type="checkbox" value="1" /><span class="lbl"></span></label>';

                            <?php } ?>

                            <?php if ($field['type']['input'] == 'category') { ?>

                                add_more_<?php echo $campo['name']; ?> = add_more_<?php echo $campo['name']; ?>+'<select name="<?php echo $field['name'] ?>[]" class="full-width">';

                                    add_more_<?php echo $campo['name']; ?> = add_more_<?php echo $campo['name']; ?>+'<option value=""><?php echo $field['label'] ?></option>';

                                    <?php $Funcoes->select('id,'.$field['type']['parameters']['field']);

                                    $query = $Funcoes->from($field['type']['parameters']['bd'])->fetch();

                                    if ($Funcoes->affected_rows > 0) {

                                        foreach($query as $base){  ?>

                                            add_more_<?php echo $campo['name']; ?> = add_more_<?php echo $campo['name']; ?>+'<option value="<?php echo $base['id']; ?>"><?php echo $base[$field['type']['parameters']['field']]; ?></option>';

                                        <?php }

                                    } ?>

                                add_more_<?php echo $campo['name']; ?> = add_more_<?php echo $campo['name']; ?>+'</select>';

                            <?php } ?>

                        add_more_<?php echo $campo['name']; ?> = add_more_<?php echo $campo['name']; ?>+'</div>';



                    <?php endforeach; ?>

                    add_more_<?php echo $campo['name']; ?> = add_more_<?php echo $campo['name']; ?>+'<button type="remove-this-<?php echo $campo['name'];?>" class="btn btn-danger btn-sm pull-right">Remover</button>';

                add_more_<?php echo $campo['name']; ?> = add_more_<?php echo $campo['name']; ?>+'</div>';

            add_more_<?php echo $campo['name']; ?> = add_more_<?php echo $campo['name']; ?>+'</div>';

            $('button[type="add-more-<?php echo $campo['name']; ?>"]').click(function(event) {

                event.preventDefault();

                index = $('#area_multi_<?php echo $campo['name']; ?> .col-md-3').length;

                template = add_more_<?php echo $campo['name']; ?>.replace(/{:index:}/g,index);

                $('#area_multi_<?php echo $campo['name']; ?>').append(template);

                mascara_money();

                remove_this('<?php echo $campo['name']; ?>');

            });

            remove_this('<?php echo $campo['name']; ?>');

        <?php } ?>





        <?php if ($swap_change) { ?>

            $('select[name="<?php echo $name ?>"]').change(function(event){

                var actual_value = $(this).val();

                $('[data-troca-<?php echo $name ?>="true"]').hide();

                $('[data-swap-<?php echo $name ?>="'+actual_value+'"]').show();

            });

        <?php }

        if ($input=='int') {

            $text = '';

            for ($i=1; $i <= intval($amount); $i++) {

                $text .= '9';

            } ?>

            $('input[type="int"][name="<?=$name?>"]').mask('<?=$text?>');

        <?php }

        if (!isset($url[1])||$url[1]=='page') {



        }else{

            if ($input=='editor') { ?>

                if ($('textarea[name="<?=$name?>"]').length) {

                    CKEDITOR.replace('<?=$name?>');

                }

            <?php }

        }



        if ($input=='estados') { ?>

            $(function() {

                $.getJSON("//ibge.herokuapp.com/estado/UF", function(result){

                    $.each(result, function(sigla, code){

                        $('select[data-uf="true"][name="<?=$name?>"]').append($('<option>', {

                            value: sigla,

                            text: sigla

                        }));

                    });

                });

            });

            $('select[data-uf="true"]').change(function() {

                var value = $(this).val();

                var target = $(this).data('target');

                $('select[name="'+target+'"]').html('<option value="">CIDADE:</option>');

                if (value === '') {

                    $('select[name="'+target+'"]').html('<option value="">CIDADE:</option>');

                }else{

                    $.getJSON("https://ibge.herokuapp.com/municipio/?val="+value, function(result){

                        $.each(result, function(nome, code){

                            $('select[name="'+target+'"]').append($('<option>', {

                                value: nome,

                                text: nome

                            }));

                        });

                    }).fail(function() {

                        console.log( "error" );

                    });

                }



            });

            $('select[data-togle="true"]').change(function() {

                var value = $(this).val();

                var target = $(this).data('target');

                $('select[name="'+target+'"]').html('<option value="">CIDADE:</option>');

                if (value === '') {

                    $('select[name="'+target+'"]').html('<option value="">CIDADE:</option>');

                }else{

                    $.getJSON("https://ibge.herokuapp.com/municipio/?val="+value, function(result){

                        $.each(result, function(nome, code){

                            $('select[name="'+target+'"]').append($('<option>', {

                                value: nome,

                                text: nome

                            }));

                        });

                    }).fail(function() {

                        console.log( "error" );

                    });

                }



            });

        <?php }

        if ($campo['input']=='subcategory') { ?>

            $('#<?php echo $campo['parametros']['input']; ?>').change(function(event) {

                event.preventDefault();

                $.ajax({

                    type: "POST",

                    url: '<?php echo URL_PAINEL_TEMPLATE; ?>ajax/subcategory.php',

                    data: {bd:"<?php echo $campo['parametros']['bd']; ?>", name:"<?php echo $campo['parametros']['name']; ?>", id:"<?php echo $campo['parametros']['id']; ?>", where:"<?php echo $campo['parametros']['where']; ?>", valor:$('#<?php echo $campo['parametros']['input']; ?>').val()},

                    success: function(retorno) {

                        $('#<?php echo $campo['name']; ?>').html(retorno);

                    }

                });



            });

        <?php }

        if ($input == 'multiselect_subcategory'): ?>

            $('input[name="<?=$parametros['reference'];?>[]"]').click(function(event) {

                var vals = $('input[name="<?=$parametros['reference'];?>[]"]:checkbox:checked').map(function(){return $(this).val(); }).get();

                $.ajax({

                    type: "POST",

                    url: '<?=URL_PAINEL_TEMPLATE?>ajax/multiselect_subcategory.php',

                    data: {

                        banco:"<?=$name?>",

                        vals:vals,

                        reference:"<?=$parametros['reference']?>",

                        select:"<?=$parametros['select']?>",

                        name:"<?=$parametros['name']?>",

                        primary:"<?=$parametros['primary']?>",

                        where:"<?=$category?>",

                        compare:"<?=$parametros['where']?>",

                    },

                    success: function(retorno) {

                        $('#<?=$name?>').html(retorno);

                    }

                });

            });

        <?php endif;

    } ?>



    $('.ace-thumbnails li').click(function(event){

        if ($(this).hasClass('active')) {

            $(this).removeClass('active');

        }else{

            $(this).addClass('active');

        }

        var checkbox = $(this).find('input[type="checkbox"]');

        checkbox.prop("checked", !checkbox.prop("checked"));



        function_check_inputs();



    });



    var function_check_inputs = function(event){

        var checkboxes = $('.ace-thumbnails li').find('input[type="checkbox"]');

        var marcado = false;

        checkboxes.each(function(index, checkbox) {

            if (checkbox.checked) {

                marcado = true;

            }

        });



        if (marcado) {

            $('.header.smaller.lighter.blue button').removeClass('hidden');

        }else{

            $('.header.smaller.lighter.blue button').addClass('hidden');

        }

    }



    var drag_and_drop = function(){

        function handleDrop(e) {

          // this/e.target is current target element.



          if (e.stopPropagation) {

            e.stopPropagation(); // Stops some browsers from redirecting.

          }



          // Don't do anything if dropping the same column we're dragging.

          if (dragSrcEl != this) {

            // Set the source column's HTML to the HTML of the columnwe dropped on.

            dragSrcEl.innerHTML = this.innerHTML;

            this.innerHTML = e.dataTransfer.getData('text/html');

          }



          return false;

        }



        function handleDragEnd(e) {

            // this/e.target is the source node.

            ordem = 0;

            [].forEach.call(cols, function (col) {



                col.removeAttribute("style");

                col.classList.remove('over');

                var id = col.querySelectorAll('input[name="id"]')[0].getAttribute('value');

                atualizar_ordem(id,ordem);

                ordem ++;

            });

        }



        var dragSrcEl = null;

        function handleDragStart(e) {

            // Target (this) element is the source node.



            this.style.opacity = '0.4';



            dragSrcEl = this;



            e.dataTransfer.effectAllowed = 'move';

            e.dataTransfer.setData('text/html', this.innerHTML);

        }



        function handleDragOver(e) {

            if (e.preventDefault) {

                e.preventDefault(); // Necessary. Allows us to drop.

            }

            e.dataTransfer.dropEffect = 'move';  // See the section on the DataTransfer object.

            return false;

        }



        function handleDragEnter(e) {

            // this / e.target is the current hover target.

            this.classList.add('over');

        }



        function handleDragLeave(e) {

            this.classList.remove('over');  // this / e.target is previous target element.

        }



        var cols = document.querySelectorAll('.ace-thumbnails li[draggable="true"]');

        [].forEach.call(cols, function(col) {

            col.addEventListener('dragstart', handleDragStart, false);

            col.addEventListener('dragenter', handleDragEnter, false)

            col.addEventListener('dragover', handleDragOver, false);

            col.addEventListener('dragleave', handleDragLeave, false);

            col.addEventListener('drop', handleDrop, false);

            col.addEventListener('dragend', handleDragEnd, false);

        });

    }

    <?php if (isset($sistema['galeria'])) {

        foreach ($sistema['galeria'] as $galeria) { ?>



            function_check_inputs();

            drag_and_drop();



            var atualizar_ordem = function(id,ordem){

                $.ajax({type: "POST", url: '<?=URL_PAINEL_TEMPLATE.$sistema['url'].'/order/'.$galeria['bd']?>', data: {id:id, ordem:ordem, }, });

            }

            <?php break;

        }

    } ?>

</script>
<?php
/**
 * CRUD LEADS MODAL  17/09/2018 18:51
 */

 // GLOBAL INFORMAÇÕES
 global $current_user;
 $current_user = wp_get_current_user();
 $user_info = get_userdata($current_user->ID);
 $first_name = $user_info->first_name;
 $last_name = $user_info->last_name;
 $user_email = $user_info->user_email;
 $user_id = $user_info->ID;
 $user_login = $user_info->user_login;

 $user_associado_id =

 date_default_timezone_set('America/Sao_Paulo');
 $hoje = date('y-m-d');
 $agora = date('H:i:s' , time());

// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";

    $nome = (isset($_POST["nome"]) && $_POST["nome"] != null) ? $_POST["nome"] : "";
    $email = (isset($_POST["email"]) && $_POST["email"] != null) ? $_POST["email"] : "";

    $token_campanha = (isset($_POST["token_campanha"]) && $_POST["token_campanha"] != null) ? $_POST["token_campanha"] : "";

    $consultor = (isset($_POST["consultor"]) && $_POST["consultor"] != null) ? $_POST["consultor"] : "";

    $usuario = (isset($_POST["usuario"]) && $_POST["usuario"] != null) ? $_POST["usuario"] : "";

    $data = (isset($_POST["data"]) && $_POST["data"] != null) ? $_POST["data"] : "";

    $hora = (isset($_POST["hora"]) && $_POST["hora"] != null) ? $_POST["hora"] : "";

    $whats = (isset($_POST["whats"]) && $_POST["whats"] != null) ? $_POST["whats"] : "";

    $id_face = (isset($_POST["id_face"]) && $_POST["id_face"] != null) ? $_POST["id_face"] : "";

    $link_face = (isset($_POST["link_face"]) && $_POST["link_face"] != null) ? $_POST["link_face"] : "";

    $interesse = (isset($_POST["interesse"]) && $_POST["interesse"] != null) ? $_POST["interesse"] : "";

    $status = (isset($_POST["status"]) && $_POST["status"] != null) ? $_POST["status"] : "";

    $feedback = (isset($_POST["feedback"]) && $_POST["feedback"] != null) ? $_POST["feedback"] : "";

    $data_nascimento = (isset($_POST["data_nascimento"]) && $_POST["data_nascimento"] != null) ? $_POST["data_nascimento"] : "";

    $cep = (isset($_POST["cep"]) && $_POST["cep"] != null) ? $_POST["cep"] : "";

    $cidade = (isset($_POST["cidade"]) && $_POST["cidade"] != null) ? $_POST["cidade"] : "";

    $estado = (isset($_POST["estado"]) && $_POST["estado"] != null) ? $_POST["estado"] : "";

    $logradouro = (isset($_POST["logradouro"]) && $_POST["logradouro"] != null) ? $_POST["logradouro"] : "";

    $celular = (isset($_POST["celular"]) && $_POST["celular"] != null) ? $_POST["celular"] : NULL;

    // dados da campanha


    $titulo_campanha = (isset($_POST["titulo_campanha"]) && $_POST["titulo_campanha"] != null) ? $_POST["titulo_campanha"] : "";

    $prodServ = (isset($_POST["prodServ"]) && $_POST["prodServ"] != null) ? $_POST["prodServ"] : "";

    $id_associado = (isset($_POST["id_associado"]) && $_POST["id_associado"] != null) ? $_POST["id_associado"] : "";

    $desconto = (isset($_POST["desconto"]) && $_POST["desconto"] != null) ? $_POST["desconto"] : "";

    $quantidade = (isset($_POST["quantidade"]) && $_POST["quantidade"] != null) ? $_POST["quantidade"] : "";

    $codigo_produto = (isset($_POST["codigo_produto"]) && $_POST["codigo_produto"] != null) ? $_POST["codigo_produto"] : "";

  //data da compra, agendamento, pastas, etc.. colcoar depois

} else if (!isset($id)) {
    // Se não se não foi setado nenhum valor para variável $id
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $nome = NULL;
    $email = NULL;
    $celular = NULL;
    $token_campanha = NULL;
    $consultor = NULL;
    $usuario = NULL;
    $data = NULL;
    $hora = NULL;
    $whats = NULL;
    $id_face = NULL;
    $link_face = NULL;
    $interesse = NULL;
    $status = NULL;
    $feedback = NULL;
    $data_nascimento = NULL;
    $cep = NULL;
    $logradouro = NULL;
    $cidade = NULL;
    $estado = NULL;
    $titulo_campanha = NULL;
    $prodServ = NULL;
    $id_associado = NULL;
    $desconto = NULL;
    $quantidade = NULL;
    $codigo_produto = NULL;

}

// Cria a conexão com o banco de dados
try {
    $conexao = new PDO("mysql:host=localhost;dbname=leadsbac_app", "leadsbac_rogerio", "#aniaslv12714");
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexao->exec("set names utf8");
} catch (PDOException $erro) {
    echo "Erro na conexão:".$erro->getMessage();
}

// Bloco If que Salva os dados no Banco - atua como Create e Update
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $nome != "") {
    try {
        if ($id != "") {
            $stmt = $conexao->prepare("UPDATE leads SET nome=?, email=?, celular=?, token_campanha=?, consultor=?, usuario=?, data=?, hora=?, whats=?, id_face=?, link_face=?, interesse=?, status=?, feedback=?, data_nascimento=?, cep=?, logradouro=?, cidade=?, estado=?, titulo_campanha=?, prodServ=?, id_associado=?, desconto=?, quantidade=?, codigo_produto=? WHERE id = ?");
            $stmt->bindParam(26, $id);
        } else {
            $stmt = $conexao->prepare("INSERT INTO leads (nome, email, celular, token_campanha, consultor, usuario, data, hora, whats, id_face, link_face, interesse, status, feedback, data_nascimento, cep, logradouro,  cidade, estado, titulo_campanha, prodServ, id_associado, desconto, quantidade, codigo_produto) VALUES (?, ?, ?, ?, ?, ? , ?, ?, ?, ?, ?, ?, ?, ?, ? ,? ,? ,? ,? ,? ,? ,? , ?, ?, ?)");
        }
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $celular);
        $stmt->bindParam(4, $token_campanha);
        $stmt->bindParam(5, $consultor);
        $stmt->bindParam(6, $usuario);
        $stmt->bindParam(7, $data);
        $stmt->bindParam(8, $hora);
        $stmt->bindParam(9, $whats);
        $stmt->bindParam(10, $id_face);
        $stmt->bindParam(11, $link_face);
        $stmt->bindParam(12, $interesse);
        $stmt->bindParam(13, $status);
        $stmt->bindParam(14, $feedback);
        $stmt->bindParam(15, $data_nascimento);
        $stmt->bindParam(16, $cep);
        $stmt->bindParam(17, $logradouro);
        $stmt->bindParam(18, $cidade);
        $stmt->bindParam(19, $estado);
        $stmt->bindParam(20, $titulo_campanha);
        $stmt->bindParam(21, $prodServ);
        $stmt->bindParam(22, $id_associado);
        $stmt->bindParam(23, $desconto);
        $stmt->bindParam(24, $quantidade);
        $stmt->bindParam(25, $codigo_produto);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                echo "Dados cadastrados com sucesso!";
                $id = null;
                $nome = null;
                $email = null;
                $celular = null;
                $token_campanha = null;
                $consultor = null;
                $usuario = null;
                $data = null;
                $hora = null;
                $whats = null;
                $id_face = null;
                $link_face = null;
                $interesse = null;
                $status = null;
                $feedback = null;

                $data_nascimento = NULL;
                $cep = NULL;
                $logradouro = NULL;
                $cidade = NULL;
                $estado = NULL;
                $titulo_campanha = NULL;
                $prodServ = NULL;
                $id_associado = NULL;
                $desconto = NULL;
                $quantidade = NULL;
                $codigo_produto = NULL;
            } else {
                echo "Erro ao tentar efetivar cadastro";
            }
        } else {
            throw new PDOException("Erro: Não foi possível executar a declaração sql");
        }
    } catch (PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }
}

// Bloco if que recupera as informações no formulário, etapa utilizada pelo Update
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {
    try {
        $stmt = $conexao->prepare("SELECT * FROM leads WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $rs = $stmt->fetch(PDO::FETCH_OBJ);
            $id = $rs->id;
            $nome = $rs->nome;
            $email = $rs->email;
            $celular = $rs->celular;
            $token_campanha = $rs->token_campanha;
            $consultor = $rs->consultor;
            $usuario = $rs->usuario;
            $data = $rs->data;
            $hora = $rs->hora;
            $whats = $rs->whats;
            $id_face = $rs->id_face;
            $link_face = $rs->link_face;
            $interesse = $rs->interesse;
            $status = $rs->status;
            $feedback = $rs->feedback;

            $cep = $rs->cep;
            $cidade = $rs->cidade;
            $estado = $rs->estado;
            $logradouro = $rs->logradouro;
            $data_nascimento = $rs->data_nascimento;
            $titulo_campanha = $rs->titulo_campanha;
            $prodServ = $rs->prodServ;
            $id_associado = $rs->id_associado;
            $quantidade = $rs->quantidade;
            $desconto = $rs->desconto;
            $codigo_produto = $rs->codigo_produto;

        } else {
            throw new PDOException("Erro: Não foi possível executar a declaração sql");
        }
    } catch (PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }
}

// Bloco if utilizado pela etapa Delete
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
    try {
        $stmt = $conexao->prepare("DELETE FROM leads WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            echo "Registo foi excluído com êxito";
            $id = null;
        } else {
            throw new PDOException("Erro: Não foi possível executar a declaração sql");
        }
    } catch (PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }
}
?>

<div class="container" id="x">
    <?php if($nome != null): ?>
    </div>
    <style>.hwp-popup ul li::before{display:none!important}</style>
    <div class="row">
    <?php endif; ?>

      <form action="?act=save" method="POST" name="form1">

        <input type="hidden" name="data" value="<?php echo $hoje; ?>" />
        <input type="hidden" name="hora" value="<?php echo $agora; ?>" />

      <div class="">
        <button type="submit" value="salvar"  class="overlay-close ">Salvar</button>

      <div class="body page-index clearfix">

        <div class="element element-2">
                <h5 style="text-align: left!important; padding-left: 2%; width:60%">

                            <div class="media media-auto">
                                <div class="media-left">
                                  <div class="avatar avatar-lgz <?php if(empty($link_face)){echo "avatar-image";} ?>  visible-lg-inline-block visible-md-inline-block visible-sm-inline-block visible-xs-inline-block m-r-1">
                                        <span class="badge">1</span>
                                          <img  onerror="imageError(this)" alt="Avatar" src="https://graph.facebook.com/<?php echo $link_face; ?>/picture">
                      <script>
                        function imageError(element) {
                            element.onerror='';
                            element.src='http://leadsback.com.br/app/wp-content/uploads/2018/07/default-avatar.png';
                        }
                      </script>

                                <i style="top: 70%!important"class="avatar-status bg-danger avatar-status-bottom"></i>
                                  </div>
                                </div>
                                <div class="media-body">
                                    <strong class="media-heading text-white caixa-alta"><?php echo $nome; ?></strong>
                                    <br>
                                    <small class="media-heading"><span>atualizado |  <?php echo $data; echo "  "; echo "as:" ; echo "  "; echo " "; echo $hora; ?> </span></small>
                                      </br>
                                    <small class="media-heading"><span>conduzido por usuário:  <?php echo ucfirst($usuario); ?> </span></small>

                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-5 col-xs-12">


                                        <div class="btn-toolbar pull-right hidden-lg hidden-md hidden-sm m-b-2 m-t-2">
                                            <div class="btn-group btn-group-justified" role="group" aria-label="...">


                                                <a class="btn btn-block btn-default "  role="button"><i class="fa fa-th-large"></i></a>
                                                <a class="btn btn-block btn-default" role="button"><i class="fa fa-plus"></i></a>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>


                        </h5>
              </div>

              <div class="element element-3">

            <div class="">
            <div style="color:#'f8f8f8'!important" class="panel-heading">
              <div class="list-group">
                <div style="margin-top: 0px; width: 100%; margin-left: 3%/* z-index: 9999; */;" class="col-lg-5 col-md-5 col-sm-5 col-xs-6 col-sm-offset-2 col-lg-offset-3 col-md-offset-1 col-sm-4 col-sm-offset-2 hidden-xs">
            <!-- START Toolbar -->
              <div class="btn-toolbar pull-right">


                <div class="btn-group" role="group" aria-label="...">
                    <a href="/app/74be16979710d4c4e7c6647856088456?act=upd&id=<?php echo $rs->id; ?>/" class="btn btn-default hwp-close" role="button"><i class="fa fa-list"></i></a>
                    <a class="btn btn-default hwp-close"  role="button"><i class="fa fa-th-large"></i></a>
                </div>
                <div class="btn-group" role="group" aria-label="...">

              </div>
          </div>
            <!-- END Toolbar -->
        </div>

              </div>


              <div id="progress" class="hr-text hr-text-left">
                                  <h6 class="text-white">
                                    <strong>Etapa</strong>
                                  </h6>
              </div>

              <div class="progress">
                        <div class="progress-bar pregress-bar-vendido" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php switch ($status) {
                          case 'online':
                            echo "50%";
                            break;

                            case 'Vendido':
                              echo "100%";
                              break;

                          default:
                            echo "30%";
                            break;
                        }?>;">
                            <?php echo $status; ?>
                        </div>
                    </div>

              <li class="list-group-item no-bg b-t-0">
                            <!-- START Media Task Name -->
                            <div class="media m-t-0">
                                <div class="media-body">
                                    <!-- START ID & Title Task -->
                                    <h6 class="m-b-1"><a href="/app/email"><?php echo $email; ?></a></h6>
                                    <!-- END ID & Title Task -->
                                </div>
                                <div class="media-right media-middle">
                                    <span class="label label-success label-outline">Online há 1 hora</span>
                                </div>
                            </div>
                            <!-- END Media Task Name -->
                            <div class="progress b-r-a-0 m-t-0 m-b-1" style="height: 3px;">
                                <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: <?php switch ($status) {
                                  case 'online':
                                    echo "50%";
                                    break;

                                  default:
                                    echo "15%";
                                    break;
                                }?>">
                                    <span class="sr-only">50% Complete</span>
                                </div>
                            </div>
                            <div class="row m-b-2">
                                <div class="col-sm-4 col-xs-4 text-center">
                                    <h4 class="m-t-0 f-w-300 m-b-0">1</h4>
                                    <p class="text-center m-b-0">Interesse(s)</p>
                                </div>
                                <div class="col-sm-4 col-xs-4 text-center">
                                    <h4 class="m-t-0 f-w-300 m-b-0"><?php echo info_vendas_cliente(); ?></h4>
                                    <p class="text-center m-b-0">Compras</p>
                                </div>
                                <div class="col-sm-4 col-xs-4 text-center">
                                    <h4 class="m-t-0 f-w-300 m-b-0">1</h4>
                                    <p class="text-center m-b-0">Negociação</p>
                                </div>
                            </div>
                        </li>

              <div id="dados-pessoais" class="hr-text hr-text-left">
                                  <h6 class="text-white">
                                    <strong>Dados Pessoais</strong>
                                  </h6>
              </div>

                                <div class="list-group no-bg b-a-2">
                                                        <a class="list-group-item  no-bg">
                                                            <h5 class="list-group-item-heading">Nome</h5><input class="form-control" type="text" name="nome" value="<?php echo $nome; ?>">
                                                        </a>

                                                        <a class="list-group-item  no-bg">
                                                            <h5 class="list-group-item-heading">Whatsapp</h5><input class="form-control" type="text" name="whats" value="<?php echo $whats; ?>">
                                                        </a>

                                                        <a class="list-group-item">
                                                            <h5 class="list-group-item-heading">Interesse</h5>
                                                            <input class="form-control" type="text" name="interesse" value="<?php echo $interesse; ?>">
                                                        </a>


                                                    </div>
                                                    <!-- SISTEMA DE LIGAÇÃO E LINKS REDES SOCIAIS -->
                                                    <p class="text-center m-t-1">
                                                                    <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Call">
                                                                      <span class="fa-stack fa-lg">
                                                                        <i class="fa fa-circle fa-stack-2x text-success"></i>
                                                                        <i class="fa fa-phone fa-stack-1x fa-inverse"></i>
                                                                      </span>
                                                                    </a>
                                                                    <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Dismiss">
                                                                      <span class="fa-stack fa-lg">
                                                                        <i class="fa fa-circle fa-stack-2x text-danger"></i>
                                                                        <i class="fa fa-close fa-stack-1x fa-inverse "></i>
                                                                      </span>
                                                                    </a>
                                                                    <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Chat">
                                                                      <span class="fa-stack fa-lg">
                                                                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                                                                        <i class="fa fa-comment fa-stack-1x fa-inverse"></i>
                                                                      </span>
                                                                    </a>
                                                                    <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Only Voice">
                                                                      <span class="fa-stack fa-lg">
                                                                        <i class="fa fa-circle fa-stack-2x text-warning"></i>
                                                                        <i class="fa fa-microphone fa-stack-1x fa-inverse"></i>
                                                                      </span>
                                                                    </a>
                                                                  </p>

                                              <!-- FIM SISTEMA DE LIGAÇÃO -->

                                </div>

          </div>

          <div id="editar" class="hr-text hr-text-left">
                                  <h6 class="text-white">
                                    <strong>Editar Dados</strong>
                                  </h6>
                          </div>

          <div class="list-group">


                        <a  class="list-group-item">
                            <h5 class="list-group-item-heading">Link Facebook</h5>
                            <input class="form-control" type="text" name="link_face" value="<?php echo $link_face; ?>">
                        </a>

                        <a  class="list-group-item">
                            <h5 class="list-group-item-heading">Celular</h5>
                            <input class="form-control" type="text" name="celular" value="<?php echo $celular; ?>">
                        </a>

                        <a class="list-group-item">
                            <h5 class="list-group-item-heading">Email</h5>
                            <input class="form-control" type="text" name="email" value="<?php echo $email; ?>">
                        </a>

                        <a  class="list-group-item">
                            <h5 class="list-group-item-heading">Cidade</h5>

                            <select name="cidade" style="height: 35px!important" class="form-control">
                                        <option value="<?php echo $cidade; ?>"><?php echo $cidade; ?></option>
                                        <option value="Londrina - PR">Londrina - PR</option>
                                        <option value="Cambé - PR">Cambé -PR</option>
                                        <option value="ibiporâ - PR">ibiporâ - PR</option>
                                        <option value="Maringá - PR">Maringá - PR</option>
                                        <option value="Curitiba - PR">Curitiba - PR</option>
                            </select>

                        </a>
                    </div></div>
              <div class="element element-4">
                <?php
                $urlatual = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                $urlcontemUpd   = '?act=upd';
                $pos = strpos($urlatual, $urlcontemUpd);
                // precisa ser identico false pra rodar
                if ($pos === false): ?>
                <div style="width: 100%; margin-left: 0%" class="dropdown">
                  <button class="btn btn-default  dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-bars m-r-1"></i>
                    <span class="caret"></span>
                  </button>
                  <ul style="min-width: 100%"class="dropdown-menu dropdown-menu-right">
                    <li>
                      <div class="col-lg-12 col-md-6 col-sm-6 col-xs-6 m-b-3">
                        <p class="small text-uppercase">
                          <strong>Ações</strong>
                        </p>
                        <ul class="nav nav-pills nav-stacked">
                          <li role="presentation">
                            <a>
                            <button class="text-muted button-salvar" type="submit" onclick="setTimeout(myFunction, 1500)" value="salvar" >
                              <i class="fa fa-fw fa-circle-o text-success m-r-1"></i> Salvar
                            </button>
                            </a>

                          </li>
                          <li role="presentation">
                            <a href="/app/74be16979710d4c4e7c6647856088456?act=upd&amp;id=265 /# baa528d51793e5b565daa9f6e923bd68856c11dd-8cdd-419a-a9b6-e2f71815703a " class="text-muted">
                              <i class="fa fa-fw fa-circle-o text-info m-r-1"></i> Vender
                            </a>
                          </li>
                          <li role="presentation">
                            <a href="http://leadsback.com.br/app/74be16979710d4c4e7c6647856088456?act=del&amp;id=265/PASCOAL MENEZEZ/43 996772531 " class="text-muted">
                              <i class="fa fa-fw fa-circle-o text-primary m-r-1"></i> Deletar
                            </a>
                          </li>
                          <li role="presentation">
                            <a href="#" class="text-muted">
                              <i class="fa fa-fw fa-plus text-muted m-r-1"></i> Devolver
                            </a>
                          </li>
                        </ul>
                      </div>
                    </li>
                  </ul>
                </div>
               <?php endif;?>

                                <!-- histórico -->
                                <div class="list-group">
                                              <div id="informacoes" class="hr-text hr-text-left">
                                                    <h6 class="text-white">
                                                      <strong>Informações de interesse </strong>
                                                    </h6>
                                                  </div>
                                                  <?php if(!empty($interesse)): ?>
                                                  <div class="panel-default">
                                                      <div class="panel-body bg-success text-white b-r-a-3">
                                                          <strong>Interessado em <?php echo $interesse; ?>   </strong>
                                                      </div>
                                                  </div>
                                                    <?php endif; ?>
                                                  <label class="left">Status</label>
                                                  <a  class="list-group-item  no-bg">
                                                      <select required
                                                      name="status" style="height: 35px!important" class="form-control" >
                                                        <option <?php

                                               // Preenche o status no campo status com um valor "value"
                                               if (isset($status) && $status != null || $status != "") {
                                                   echo "value=\"{$status}\"";
                                               }
                                               ?>><?php echo $status; ?></option>
                                                        <option value="sem-contato">Sem contato</option>
                                                        <option value="Vendido">Vendido</option>
                                                        <option value="Divergente">Proposta Divergente | Condições Comerciais incompatíveis com a necessidade do cliente</option>

                                                        <option value="pediu-retorno">Pediu retorno ( Agenda )</option>

                                                        <option value="nao-vendas">Não Venda | Motivo: Achou caro, sem condições etc...</option>

                                                        <option value="Devolvidos">Devolver ao Condutor | Cliente não interessado | Não há interesse algum no produto ou serviço</option>

                                                      </select>
                                                  </a>


                                                  <div class="table">
                                                  <table class="table  m-t-2">
                                                      <thead>
                                                          <tr>
                                                              <th class="small text-muted text-uppercase"><strong>Interesse</strong>
                                                              </th>
                                                              <th class="small text-muted text-uppercase"><strong>Vigência</strong>
                                                              </th>
                                                              <th class="small text-muted text-uppercase"><strong>Atendimento</strong>
                                                              </th>
                                                              <th class="small text-muted text-uppercase"><strong>Campanhas</strong>
                                                              </th>

                                                          </tr>
                                                      </thead>

                                                      <tbody>
                                                          <tr>
                                                              <td class="v-a-m">
                                                                  <div class="media media-auto">
                                                                      <div class="media-left">
                                                                          <i class="fa fa-fw fa-shopping-cart fa-3x"></i>
                                                                      </div>
                                                                      <div class="media-body">
                                                                          <span class="media-heading text-white"><?php if(empty($interesse)){echo "Produto / Serviço";} else{echo $interesse;}?></span>
                                                                          <br>
                                                                          <span class="media-heading"><span></span></span>
                                                                      </div>
                                                                  </div>
                                                              </td>
                                                              <td class="v-a-m"><span><?php echo $data; echo "    -    ";  ?></span>
                                                                  <br>
                                                                  <span><?php echo $hora; ?></span>
                                                              </td>
                                                              <td class="v-a-m">
                                                                  <div class="avatar visible-lg-inline-block visible-md-inline-block visible-sm-inline-block visible-xs-inline-block">
                                                                      <img class="img-circle" onerror="imageError(this)" alt="Avatar" src="https://graph.facebook.com/<?php echo $link_face; ?>/picture">
                                                                  </div>
                                                                  <div class="avatar visible-lg-inline-block visible-mdinline-block visible-sm-inline-block visible-xs-inline-block">
                                                                      <img class="img-circle  m-r-1" src="https://s3.amazonaws.com/uifaces/faces/twitter/jcubic/128.jpg" alt="Avatar">
                                                                  </div>

                                                              </td>
                                                              <td class="v-a-m">
                                                                  <span class="label label-gray-light  label-outline"><span>Orgânico</span></span>
                                                                  <span class="label label-gray-light  label-outline"><span>Google Ads</span></span>
                                                                  <span class="label label-gray-light  label-outline"><span>facebook Ads</span></span>
                                                              </td>

                                                          </tr>


                                                      </tbody>
                                                  </table>
                                              </div>

                                              <div id="Negociacao" class="hr-text hr-text-left">
                                                    <h6 class="text-white">
                                                      <strong>Negociação </strong>
                                                    </h6>
                                                  </div>

                <?php echo do_shortcode('[xyz-ips snippet="chartModalLeads"]'); ?>

                <div class="media">


                            <div class="media-left">
                                <div class="avatar">
                                  <?php
                                     $user_id = $user_info->id;
                                        echo get_avatar( $id_associado, 34 ); ?>
                                    <i class="avatar-status avatar-status-bottom  bg-danger b-brand-gray-darker"></i>
                                </div>
                            </div>

                            <div class="media-body">
                                <?php if(!empty($feedback)): ?>
                                <div class="panel-default">
                                    <div class="panel-body bg-cinza text-white b-r-a-3">
                                        <strong>Interessado em <?php echo $interesse; ?>   |   <?php echo strtoupper($feedback); ?>  | às <?php echo $hora, " Status | ", $status;?>  </strong>
                                    </div>
                                </div>
                                <h5 style="text-align: left"class="m-t-1"><span>usuário <?php echo $usuario; ?></span><small><span>  |  <?php echo $data; echo " | "; echo $hora; ?></span></small></h5>


                            <?php endif; ?>

                              <?php if(!empty($feedback)): ?>
                                  <div class="hr-text hr-text-center m-t-2 m-b-1">
                                    <h6 class="text-white"><strong><?php echo $agora; echo " | "; echo $hora; ?></strong></h6>
                                  </div>
                                <div class="media">
                            <div class="media-body">
                                <div class="panel-default">
                                    <div class="panel-body bg-gray text-white b-r-a-3">
                                        <span><?php echo $feedback; ?></span>
                                    </div>
                                </div>
                                <h5 class="m-t-1 text-right"><span><?php echo $user_login; ?></span><small><span><?php echo $data; ?></span></small></h5>

                            </div>
                            <div class="media-right">
                                <div class="avatar">
                                  <?php
                                     $user_id = $user_info->id;
                                        echo get_avatar( $user_id, 34 ); ?>
                                    <i class="avatar-status avatar-status-bottom  bg-success b-brand-gray-darker"></i>
                                </div>
                            </div>
                        </div>
                      <?php endif; ?>
                      </div>
                        </div>


                </div>



<div style="margin-left: 90%">
  <button type="submit" value="salvar" onclick="setTimeout(myFunction, 1500)"class="mdl-button mdl-js-button mdl-button--fab mdl-button--colored">
    <i class="material-icons">add</i>
  </button>
</div>

<div id="feedback" class="hr-text hr-text-left">
  <h6 class="text-white">
    <strong>Feedback</strong>
  </h6>
</div>


<div style="float:left">Feedback:</div>
<textarea required style="font-size: 16px!important" name="feedback" rows="4" cols="50">
<?php echo $feedback; ?>
</textarea>
<div class="">
<button type="submit" value="salvar" onclick="setTimeout(myFunction, 1500)" class="btn btn-default btn-lg btn-block">Salvar</button>
</div>


<div class="hr-text hr-text-left">
  <h6 class="text-white">
    <strong>Localização</strong>
  </h6>
</div>


<iframe width="100%" height="520" frameborder="0" src="https://webforsite.carto.com/builder/55a9f9d2-1c4c-484f-b46f-6ea9720409d6/embed" allowfullscreen webkitallowfullscreen mozallowfullscreen oallowfullscreen msallowfullscreen></iframe>




<input class="form-control " type="hidden" name="id"
  <?php

// Preenche o id no campo id com um valor "value"
if (isset($id) && $id != null || $id != "") {
    echo "value=\"{$id}\"";
}
?> />

<input type="hidden" name="consultor" value="<?php echo $consultor; ?>"  />

<input type="hidden" name="usuario" value="<?php echo $usuario; ?>" />
<input type="hidden" name="prodServ" value="<?php echo $user_login; ?>" />



          </form>
</div>

</div>

                        <!-- FIM DO ELEMENT 4 -->


<script>

<?php if(!isset($id)){return;} ?>
<?php $fallback = '/app/';
$anterior = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $fallback; ?>

$(document).ready(function () {
   $('input').keypress(function (e) {
        var code = null;
        code = (e.keyCode ? e.keyCode : e.which);
        return (code == 13) ? false : true;
   });
});</script>
                <script>function x(){window.location="<?php echo $_SERVER['PHP_SELF'];?>"}</script>
                <script>var urlAtual=window.location.href;var urlnMostrar="http://leadsback.com.br/app/74be16979710d4c4e7c6647856088456/";if(urlAtual==urlnMostrar){document.getElementById("feedback-alert").style.display="block"}else{document.getElementById("feedback-alert").style.display="none"}</script>
                <script>function myFunction(){window.location="<?php echo $anterior; ?>"</script>

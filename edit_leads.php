<?php
/**
 * EDITAR LEADS
 */

// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
    $nome = (isset($_POST["nome"]) && $_POST["nome"] != null) ? $_POST["nome"] : "";
    $whats = (isset($_POST["whats"]) && $_POST["whats"] != null) ? $_POST["whats"] : "";
    $link_face = (isset($_POST["link_face"]) && $_POST["link_face"] != null) ? $_POST["link_face"] : NULL;
    $link_campanha = (isset($_POST["link_campanha"]) && $_POST["link_campanha"] != null) ? $_POST["link_campanha"] : NULL;
} else if (!isset($id)) {
    // Se não se não foi setado nenhum valor para variável $id
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $nome = NULL;
    $whats = NULL;
    $link_face = NULL;
    $link_campanha = NULL;
}

// Cria a conexão com o banco de dados
try {
    $conexao = new PDO("mysql:host=localhost; dbname=leadsbac_app", "leadsbac_rogerio", "#aniaslv12714");
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexao->exec("set names utf8_unicode_ci");
} catch (PDOException $erro) {
    echo "Erro na conexão:".$erro->getMessage();
}

// Bloco If que Salva os dados no Banco - atua como Create e Update
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $nome != "") {
    try {
        if ($id != "") {
            $stmt = $conexao->prepare("UPDATE cadastro_leads SET nome=?, whats=?, link_face=?, link_campanha=?  WHERE id = ?");
            $stmt->bindParam(5, $id);
        } else {
            $stmt = $conexao->prepare("INSERT INTO cadastro_leads (nome, whats, link_face, link_campanha) VALUES (?, ?, ?, ?)");
        }
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $whats);
        $stmt->bindParam(3, $link_face);
        $stmt->bindParam(4, $link_campanha);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                echo "Dados cadastrados com sucesso!";
                $id = null;
                $nome = null;
                $whats = null;
                $link_face = null;
                $link_campanha = null;
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
        $stmt = $conexao->prepare("SELECT * FROM cadastro_leads WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $rs = $stmt->fetch(PDO::FETCH_OBJ);
            $id = $rs->id;
            $nome = $rs->nome;
            $whats = $rs->whats;
            $link_face = $rs->link_face;
            $link_campanha = $rs->link_campanha;
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
        $stmt = $conexao->prepare("DELETE FROM cadastro_leads WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            echo " <div class='alert no-bg b-l-danger b-l-3 b-t-gray b-r-gray b-b-gray' role='alert'>
            <strong class='text-white'>Já era!</strong> <span class='text-gray-lighter'>Registo foi excluído com êxito</span>
        </div>";
            $id = null;
        } else {
            throw new PDOException("Erro: Não foi possível executar a declaração sql");
        }
    } catch (PDOException $erro) {
        echo "Erro: ".$erro->getMessage();
    }
}
?>
<!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
        </head>

        <body>


            <li class="dropdown">

          <a class="dropdown-toggle" data-toggle="dropdown" href="javascript: void(0)" role="button" aria-expanded="false">
          <button style="width: 100px; float: right; background: #00a3e3!important; color: #fff; " type="button" class="mdl-button show-modal  mdl-button--raised">Atualizar</button>
            <i class="fa fa-lg fa-fw fa-user-plus hidden-xs"></i>
            <span class="hidden-sm hidden-md hidden-lg">Messages


              <span class="label label-primary label-pill label-with-icon hidden-xs"></span>
            </span>
            <span class="label label-primary label-pill label-with-icon hidden-xs">
              17            </span>
            <span class="fa fa-fw fa-angle-down hidden-lg hidden-md hidden-sm"></span>
          </a>
          <!-- CONEXÃO -->
                    <ul class="dropdown-menu dropdown-menu-right p-t-0 b-t-0 p-b-0 b-b-0 b-a-0">
            <li>
              <div style="width: 850px" class="yamm-content p-t-0 p-r-0 p-l-0 p-b-0">
                <ul class="list-group m-b-0">
                  <li class="list-group-item b-r-0 b-l-0 b-r-0 b-t-r-0 b-t-l-0 b-b-2 w-350">
                    <small class="text-uppercase">
                      <strong>LEADS ONLINE
                        00:00:001                      </strong>
                    </small>
                    <a role="button" href="/app/leads/" class="btn m-t-0 btn-xs btn-default pull-right">
                      <i class="fa fa-pencil"></i>
                    </a>
                  </li>
                  <!-- START Scroll de informação -->
                  <li class="list-group-item b-a-0 p-x-0 p-y-0 b-t-0">
                    <div class="scroll-200 custom-scrollbar ps-container ps-theme-default" data-ps-id="a44c8258-53ef-b88c-8118-a6c5ef8d42a8">
                      <a class="list-group-item b-r-0 b-l-0">
                        <div class="media">
                          <div class="media-left media-middle">
                            <div class="avatar">
                              <img class="media-object img-circle" src="https://s3.amazonaws.com/uifaces/faces/twitter/Silveredge9/128.jpg" alt="Avatar">
                                <i class="avatar-status avatar-status-bottom
                                  bg-success b-gray-darker">
                                </i>
                              </div>
                            </div>
                            <div style="width: 600px"class="media-body media-auto">
                            <form action="?act=save" method="POST" name="form1" >

                            <input class="form-control" type="hidden" name="id" <?php

                            // Preenche o id no campo id com um valor "value"
                            if (isset($id) && $id != null || $id != "") {
                                echo "value=\"{$id}\"";
                            }
                            ?> />
                            Nome:
                           <input class="form-control" type="text" name="nome" <?php

                           // Preenche o nome no campo nome com um valor "value"
                           if (isset($nome) && $nome != null || $nome != "") {
                               echo "value=\"{$nome}\"";
                           }
                           ?> />
                           E-mail:
                           <input class="form-control" type="text" name="whats" <?php

                           // Preenche o whats no campo whats com um valor "value"
                           if (isset($whats) && $whats != null || $whats != "") {
                               echo "value=\"{$whats}\"";
                           }
                           ?> />
                           link_face:
                           <input class="form-control" type="text" name="link_face" <?php

                           // Preenche o link_face no campo link_face com um valor "value"
                           if (isset($link_face) && $link_face != null || $link_face != "") {
                               echo "value=\"{$link_face}\"";
                           }
                           ?> />

                           link_campanha:
                           <input class="form-control" type="text" name="link_campanha" <?php

                           // Preenche o link_campanha no campo link_campanha com um valor "value"
                           if (isset($link_campanha) && $link_campanha != null || $link_campanha != "") {
                               echo "value=\"{$link_campanha}\"";
                           }
                           ?> />
                           <input class="btn btn-default" type="submit" value="salvar" />
                           <input type="reset" value="Novo" />
                           <hr>
                        </form>
                            </div>
                          </div>
                        </a>
                        <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;">
                          <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                        </div>
                        <div class="ps-scrollbar-y-rail" style="top: 0px; right: 0px;">
                          <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                        </div>
                      </div>
                    </li>
                    <!-- FINAL DO SCROOLING -->
                    <li class="list-group-item b-a-0 p-x-0 b-b-0 p-y-0 r-a-0">
                      <a class="list-group-item text-center b-b-0 b-r-0 b-l-0 b-r-b-r-0 b-r-b-l-0" href="http://leadsback.com.br/app/associado/14/05/2018/cont/164/">
                        Todos os Leads

                        <i class="fa fa-angle-right"></i>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
            </ul>
            <!-- FIM  -->
          </li>
          <?php
          $user = wp_get_current_user();
		// SE ESTE CARA FOR ADMIN OU ASSOCIADO
		if ( in_array( 'administrator', (array) $user->roles ) || in_array( 'associado', (array) $user->roles ) ): ?>
            <table class="table " width="100%">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Whats</th>
                    <th>link_face</th>
                    <th>link_campanha</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <?php
                global $current_user;
                $current_user = wp_get_current_user();
                $user_info = get_userdata($current_user->ID);
                $first_name = $user_info->first_name;
                $last_name = $user_info->last_name;
                $user_email = $user_info->user_email;
                $user_id = $user_info->ID;
                $user_login = $user_info->user_login;

                // Bloco que realiza o papel do Read - recupera os dados e apresenta na tela
                try {
                    $stmt = $conexao->prepare("SELECT * FROM cadastro_leads where usuario='$user_login' order by id desc");
                    if ($stmt->execute()) {
                        while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                            echo "<tr>";
                            echo "<td>".$rs->nome."</td><td>".$rs->whats."</td><td>".$rs->link_face
                                       ."</td>
                                       <td>".$rs->link_campanha
                                                  ."</td><td><center><a class='btn btn-success' href=\"?act=upd&id=".$rs->id."\"><i class='fa fa-fw fa-pencil'></i></a>"
                                       ."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                                       ."<a class='btn btn-danger' href=\"?act=del&id=".$rs->id."\"><i class='fa fa-fw fa-trash'></i></a></center></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "Erro: Não foi possível recuperar os dados do banco de dados";
                    }
                } catch (PDOException $erro) {
                    echo "Erro: ".$erro->getMessage();
                }
                ?>
            </table>
            <?php endif ?>

            <?php if ( !in_array( 'administrator', (array) $user->roles ) and !in_array( 'associado', (array) $user->roles ) )
            {header("location: /app/leads");
            exit;}?>
        </body>
    </html>

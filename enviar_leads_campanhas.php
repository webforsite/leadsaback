<?php
/**
 * CRUD  ENVIAR LEADS 18/08/2018 15:31
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
 $user_nicename = $user_info->user_nicename;

 $hoje = date('y-m-d');
 $agora = date('H:i:s' , time());


// DADOS
if ($_POST['form_name'] == "form_leads" && $_SERVER['REQUEST_METHOD'] == 'POST') {

    print_r($_POST);
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

    $preco = (isset($_POST["preço"]) && $_POST["preco"] != null) ? $_POST["preco"] : "";

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
    $preco = NULL;
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
            $stmt = $conexao->prepare("UPDATE leads SET nome=?, email=?, celular=?, token_campanha=?, consultor=?, usuario=?, data=?, hora=?, whats=?, id_face=?, link_face=?, interesse=?, status=?, feedback=?, cep=?, data_nascimento=?, cidade=?, estado=?, logradouro=?, titulo_campanha=?, prodServ=?, quantidade=?, preco=?, desconto=?, codigo_produto=? WHERE id = ?");
            $stmt->bindParam(26, $id);
        } else {
            $stmt = $conexao->prepare("INSERT INTO leads (nome, email, celular, token_campanha, consultor, usuario, data, hora, whats, id_face, link_face, interesse, status, feedback, cep, data_nascimento, cidade, estado, logradouro, titulo_campanha, prodServ, quantidade, preco, desconto, codigo_produto) VALUES (?, ?, ?, ?, ?, ? , ?, ?, ?, ?, ?, ?, ?, ?, ? ,? ,? ,? ,? ,? ,? ,? , ?, ?, ?)");
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
        $stmt->bindParam(15, $cep);
        $stmt->bindParam(16, $cidade);
        $stmt->bindParam(17, $estado);
        $stmt->bindParam(18, $data_nascimento);
        $stmt->bindParam(19, $logradouro);
        $stmt->bindParam(20, $titulo_campanha);
        $stmt->bindParam(21, $quantidade);
        $stmt->bindParam(22, $prodServ);
        $stmt->bindParam(23, $preco);
        $stmt->bindParam(24, $desconto);
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
                $preco = NULL;
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
            $preco = $rs->preco;
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
// conexao 2
$pdo = new PDO("mysql:host=localhost; dbname=leadsbac_app", "leadsbac_rogerio", "#aniaslv12714");
$pdo->exec("set names utf8");
$sql = "SELECT * FROM campanhas where id='$idx' ";
$result = $pdo->query( $sql );
$rows = $result->fetchAll( PDO::FETCH_ASSOC );
$stmty = $pdo->prepare($sql);
$stmty->execute();
$result = $stmty->fetchAll(PDO::FETCH_OBJ); // Retorna um array de objetos
for($ix = 0; $ix < count($result); $ix++){
$titulo_anuncio = $result[$ix]->titulo_anuncio;
}

?>
<?php echo $idx;?>
<!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <?php
            echo $current_user->user_login; ?>
        </head>
        <body>
            <form action="/app/74be16979710d4c4e7c6647856088456/?act=save" method="POST" name="form2" >
                <h1>Cadastro de Leads</h1>
                <hr>
                <input type="hidden" name="id" <?php

                // Preenche o id no campo id com um valor "value"
                if (isset($id) && $id != null || $id != "") {
                    echo "value=\"{$id}\"";
                }
                ?> />

                <input type="hidden" name="form_leads"/>

                <input type="hidden" name="token_campanha" <?php

                // Preenche o id no campo token_campanha com um valor "value"
                if (isset($token_campanha) && $token_campanha != null || $token_campanha != "") {
                    echo "value=\"{$token_campanha}\"";
                }
                ?>  />


                <input type="text" name="consultor" value="<?php
                echo $user_id; ?>"  />

                <input type="hidden" name="usuario" value="<?php echo $user_nicename; ?>" />

                <input type="hidden" name="data" value="<?php echo $hoje; ?>" />

                <input type="hidden" name="hora" value="<?php echo $agora; ?>" />

                <input type="hidden" name="status" <?php
                $status = "online";
                // Preenche o hora no campo hora com um valor "value"
                if (isset($status) && $status != null || $status != "") {
                    echo "value=\"{$status}\"";
                }
                ?>  />

                <input type="hidden" name="feedback" <?php

                // Preenche o hora no campo hora com um valor "value"
                if (isset($feedback) && $feedback != null || $feedback != "") {
                    echo "value=\"{$feedback}\"";
                }
                ?>  />


                <input type="hidden" name="cep" <?php

                // Preenche o id no campo token_campanha com um valor "value"
                if (isset($cep) && $cep != null || $cep != "") {
                    echo "value=\"{$cep}\"";
                }
                ?>  />

                <input type="hidden" name="cidade" <?php

                // Preenche o id no campo token_campanha com um valor "value"
                if (isset($cidade) && $cidade != null || $cidade != "") {
                    echo "value=\"{$cidade}\"";
                }
                ?>  />

                <input type="hidden" name="estado" <?php

                // Preenche o id no campo token_campanha com um valor "value"
                if (isset($estado) && $estado != null || $estado != "") {
                    echo "value=\"{$estado}\"";
                }
                ?>  />

                <input type="hidden" name="logradouro" <?php

                // Preenche o id no campo token_campanha com um valor "value"
                if (isset($logradouro) && $logradouro != null || $logradouro != "") {
                    echo "value=\"{$logradouro}\"";
                }
                ?>  />

                <input type="hidden" name="data_nascimento" <?php

                // Preenche o id no campo token_campanha com um valor "value"
                if (isset($data_nascimento) && $data_nascimento != null || $data_nascimento != "") {
                    echo "value=\"{$data_nascimento}\"";
                }
                ?>  />

                <input type="hidden" name="titulo_campanha" value="<?php echo $titulo_anuncio; ?>" />

                <input type="hidden" name="prodServ" <?php

                // Preenche o id no campo token_campanha com um valor "value"
                if (isset($prodServ) && $prodServ != null || $prodServ != "") {
                    echo "value=\"{$prodServ}\"";
                }
                ?>  />

                <input type="hidden" name="preco" <?php

                // Preenche o id no campo token_campanha com um valor "value"
                if (isset($preco) && $preco != null || $preco != "") {
                    echo "value=\"{$preco}\"";
                }
                ?>  />

                <input type="hidden" name="quantidade" <?php

                // Preenche o id no campo token_campanha com um valor "value"
                if (isset($quantidade) && $quantidade != null || $quantidade != "") {
                    echo "value=\"{$quantidade}\"";
                }
                ?>  />

                <input type="hidden" name="desconto" <?php

                // Preenche o id no campo token_campanha com um valor "value"
                if (isset($desconto) && $desconto != null || $desconto != "") {
                    echo "value=\"{$desconto}\"";
                }
                ?>  />

                <input type="hidden" name="codigo_produto" <?php

                // Preenche o id no campo token_campanha com um valor "value"
                if (isset($codigo_produto) && $codigo_produto != null || $codigo_produto != "") {
                    echo "value=\"{$codigo_produto}\"";
                }
                ?>  />




                Nome:
               <input type="text" name="nome" class="form-control"<?php

               // Preenche o nome no campo nome com um valor "value"
               if (isset($nome) && $nome != null || $nome != "") {
                   echo "value=\"{$nome}\"";
               }
               ?> />
               E-mail:
               <input type="text" name="email"  class="form-control"<?php

               // Preenche o email no campo email com um valor "value"
               if (isset($email) && $email != null || $email != "") {
                   echo "value=\"{$email}\"";
               }
               ?> />

               Whatsapp:
               <input type="text" name="whats"  class="form-control"<?php

               // Preenche o whats no campo whats com um valor "value"
               if (isset($whats) && $whats != null || $whats != "") {
                   echo "value=\"{$whats}\"";
               }
               ?> />

               ID Facebook:
               <input type="text" name="id_face"  class="form-control" <?php

               // Preenche o id do face no campo id do face com um valor "value"
               if (isset($id_face) && $id_face != null || $id_face != "") {
                   echo "value=\"{$id_face}\"";
               }
               ?> />

               Link Facebook:
               <input type="text" name="link_face"  class="form-control" <?php

               // Preenche o celular no campo celular com um valor "value"
               if (isset($link_face) && $link_face != null || $link_face != "") {
                   echo "value=\"{$link_face}\"";
               }
               ?> />

               Celular:
               <input type="text" name="celular"  class="form-control"<?php

               // Preenche o celular no campo celular com um valor "value"
               if (isset($celular) && $celular != null || $celular != "") {
                   echo "value=\"{$celular}\"";
               }
               ?> />
               <input type="submit" value="salvar" />
               <input type="reset" value="Novo" />
               <hr>
            </form>
            <table class="table table-striped table table-striped mdl-data-table mdl-js-data-table mdl-data-table--selectable" border="1" width="100%">
                <tr>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Celular</th>
                    <th>Ações</th>
                </tr>
                <?php

                // Bloco que realiza o papel do Read - recupera os dados e apresenta na tela
                try {
                    $stmt = $conexao->prepare("SELECT * FROM leads where consultor ='$user_id'ORDER by id desc limit 10 ");
                    if ($stmt->execute()) {
                        while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                            echo "<tr>";
                            echo "<td>".$rs->nome."</td><td>".$rs->email."</td><td>".$rs->celular
                                       ."</td><td><center><a href=\"?act=upd&id=".$rs->id."\">[Editar]</a>"
                                       ."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                                       ."<a href=\"?act=del&id=".$rs->id."\">[Excluir]</a></center></td>";
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
        </body>
    </html>

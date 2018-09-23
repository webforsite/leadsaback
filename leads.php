<?php
/**
* CRUD PDO - Meus Leads - 23/09/2018 - 02:51
* Rogério Mário
*/

//PERMISSÕES PARA VISUALIZAR PÁGINA
 if(in_array( 'gerente', (array) $user->roles))
 {header('location: /app/'); exit;}
 
# fim permissão

// GLOBAL INFORMAÇÕES
$user = wp_get_current_user();
global $current_user;
$current_user = wp_get_current_user();
$user_info = get_userdata($current_user->ID);
$first_name = $user_info->first_name;
$last_name = $user_info->last_name;
$user_email = $user_info->user_email;
$user_id = $user_info->ID;
$user_login = $user_info->user_login;
$edit = "teste";
$hoje = date('d-m-y');

#fim GLOBAL

// VERIFICAR SE FOI ENVIADO DADOS VIA POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
$nome = (isset($_POST["nome"]) && $_POST["nome"] != null) ? $_POST["nome"] : "";
$whats = (isset($_POST["whats"]) && $_POST["whats"] != null) ? $_POST["whats"] : "";

$status = (isset($_POST["status"]) && $_POST["status"] != null) ? $_POST["status"] : "";

$feedback = (isset($_POST["feedback"]) && $_POST["feedback"] != null) ? $_POST["feedback"] : NULL;

} else if (!isset($id)) {
// Se não se não foi setado valor para variável $id
$id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
$nome = NULL;
$whats = NULL;
$feedback = NULL;
$status = NULL;

}

// CONEXÃO BANCO DE DADOS
try {
$conexao = new PDO("mysql:host=localhost; dbname=leadsbac_app", "leadsbac_rogerio", "#aniaslv12714");
$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$conexao->exec("set names utf8");
} catch (PDOException $erro) {
//echo "Erro na Conexão:".$erro->getMessage();
}


// IF SALVA DADOS NO BANCO | CREATE | UPDATE
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $nome != "") {
try {
if ($id != "") {
$stmt = $conexao->prepare("UPDATE leads SET nome=?, whats=?, status=?, feedback=?,  WHERE id = ?");
$stmt->bindParam(5, $id);
} else {
$stmt = $conexao->prepare("INSERT INTO leads (nome, whats, status, feedback) VALUES (?, ?, ?, ?)");
}
$stmt->bindParam(1, $nome);
$stmt->bindParam(2, $whats);
$stmt->bindParam(3, $status);
$stmt->bindParam(4, $feedback);

if ($stmt->execute()) {
if ($stmt->rowCount() > 0) {
echo "Dados cadastrados com sucesso!";
$id = null;
$nome = null;
$whats = null;
$status = null;
$feedback = null;

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
// BUSCAR INFORMÇÕES PARA O FORMULÁRIO - UPDATE
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {
try {
$stmt = $conexao->prepare("SELECT * FROM leads WHERE id = ?");
$stmt->bindParam(1, $id, PDO::PARAM_INT);
if ($stmt->execute()) {
$rs = $stmt->fetch(PDO::FETCH_OBJ);
$id = $rs->id;
$nome = $rs->nome;
$cidade = $rs->cidade;
$data = $rs->data;
$hora = $rs->hora;
$whats = $rs->whats;
$status = $rs->status;
$feedback = $rs->feedback;
$link_face = $rs->link_face;
$token = $rs->token_campanha;
$interesse = $rs->interesse;


if(!isset($id)){header('location: /app/74be16979710d4c4e7c6647856088456'); exit;}
// TABELA DE DADOS
echo  '
<ol class="breadcrumb">
                        <li><a href="/app/">Home</a></li>
                        <li class="active"><a href="https://leadsback.com.br/app/74be16979710d4c4e7c6647856088456/">Leads</a></li>
                    </ol>
<table class="table table-striped table table-striped mdl-data-table mdl-js-data-table mdl-data-table--selectable" width="100%">
  <thead style="background: #f8f8f8!important;">
    <tr>
      <th>ID</th>
      <th>Cidade</th>
      <th>Data</th>
      <th>Hora</th>
			<th>Cliente</th>
      <th>Whats</th>
      <th>Origem</th>
      <th>Status</th>
      <th>feedback</th>
      <th>Ações</th>
    </tr>
  </thead>
  <tr class="">
    <td>'. $id .'</td>
    <td>'. $cidade .'</td>
    <td>'. $data .'</td>
    <td>'. $hora .'</td>
		<td class="td_feedback">
    <div class="media-left media-middle media-middle">
                                    <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="">
                                        <div class="avatar"> <img  onerror="imageError(this)" class="media-object img-circle" src="https://graph.facebook.com/'. $link_face . '/picture" alt="Avatar"><i class="avatar-status avatar-status-bottom  bg-warning b-brand-gray-darker"></i> </div>
                                    </a>
                                </div><div style="margin-left: 50px; margin-top: -35px">
      <a href="http://leadsback.com.br/app/74be16979710d4c4e7c6647856088456?act=upd&id='. $id .'/#"> '. $nome .'</a></div>
    </td>
    <td>'. $whats .'</td>
    <td>
      <a href="https://www.messenger.com/t/'. $link_face .'" target="_blank">
        <svg width="25px" fill="#0084ff"
          xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
          <path d="M224 32C15.9 32-77.5 278 84.6 400.6V480l75.7-42c142.2 39.8 285.4-59.9 285.4-198.7C445.8 124.8 346.5 32 224 32zm23.4 278.1L190 250.5 79.6 311.6l121.1-128.5 57.4 59.6 110.4-61.1-121.1 128.5z"></path>
        </svg>
      </a>
      <a href="https://api.whatsapp.com/send?phone=55'.$whats.'&text=Olá,%20'. $nome .',!%20Podemos%20Conversar%20Sobre%20seu%20interesse%20em%20'.$interesse .'?" target="_blank">
        <svg
          xmlns="http://www.w3.org/2000/svg" width="25px" fill="#2dbda8" viewBox="0 0 448 512">
          <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"></path>
        </svg>
      </a>
    </td>
    <td>
      <div class="dropdown">
        <button style="background: #f8f8f8" class="btn btn-default  dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <div style="margin-top: -3px">
            <svg
              xmlns="http://www.w3.org/2000/svg" width="30px" fill="#0084ff" viewBox="0 0 576 512">
              <path d="M569.354 231.631C512.969 135.949 407.81 72 288 72 168.14 72 63.004 135.994 6.646 231.631a47.999 47.999 0 0 0 0 48.739C63.031 376.051 168.19 440 288 440c119.86 0 224.996-63.994 281.354-159.631a47.997 47.997 0 0 0 0-48.738zM288 392c-75.162 0-136-60.827-136-136 0-75.162 60.826-136 136-136 75.162 0 136 60.826 136 136 0 75.162-60.826 136-136 136zm104-136c0 57.438-46.562 104-104 104s-104-46.562-104-104c0-17.708 4.431-34.379 12.236-48.973l-.001.032c0 23.651 19.173 42.823 42.824 42.823s42.824-19.173 42.824-42.823c0-23.651-19.173-42.824-42.824-42.824l-.032.001C253.621 156.431 270.292 152 288 152c57.438 0 104 46.562 104 104z"></path>
            </svg>
          </div>
        </button>
        <ul class="modal-leads col-md-12 dropdown-menu dropdown-menu-right">
          <li>'. $edit .'</li>
        </ul>
      </div>
    </td>
    <td>

        <div class="">
          <select style="height: 35px!important" class="form-control">
            <option value="'. $rs->status.'">'. $rs->status.'</option>
          </select>
        </div>
        <input class="form-control" type="hidden" name="id" value="'.$id.'"/>
        <input class="btn btn-default " type="hidden" value="salvar" onclick="setTimeout(myFunction, 1500);" />

    </td>
    <td>
      <div class="dropdown">
        <button class="btn btn-default  dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-bars m-r-1"></i>
          <span class="caret"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-right">
          <li>
            <div class="col-lg-12 col-md-6 col-sm-6 col-xs-6 m-b-3">
              <p class="small text-uppercase">
                <strong>Ações</strong>
              </p>
              <ul class="nav nav-pills nav-stacked">
                <li role="presentation">
                  <a type="submit" onclick="setTimeout(myFunction,1500)" value="salvar" class="text-muted">
                    <i class="fa fa-fw fa-circle-o text-success m-r-1"></i> Salvar
                  </a>

                </li>
                <li role="presentation">
                  <a href="/app/74be16979710d4c4e7c6647856088456?act=upd&amp;id='. $id .'/'. $token .'" class="text-muted">
                    <i class="fa fa-fw fa-circle-o text-info m-r-1"></i> Trabalhar Contato
                  </a>
                </li>
                <li role="presentation">
                  <a href="http://leadsback.com.br/app/74be16979710d4c4e7c6647856088456?act=del&amp;id='. $id .'" class="text-muted">
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
    </td>
  </tr>
</table>
';
echo do_shortcode('[xyz-ips snippet="74beMODAL"]');
} else {
throw new PDOException("Erro: Não foi possível executar a declaração sql");
}
} catch (PDOException $erro) {
echo "Erro: ".$erro->getMessage();
}
}
// IF DELETE
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
try {
$stmt = $conexao->prepare("DELETE FROM leads WHERE id = ?");
$stmt->bindParam(1, $id, PDO::PARAM_INT);
if ($stmt->execute()) {
echo "
<div class='alert no-bg b-l-danger b-l-3 b-t-gray b-r-gray b-b-gray ' data-dismiss='alert' aria-label='Close' role='alert'>
<strong class='text-white'>". $token ."</strong>
  <span class='text-gray-lighter'>Registo foi excluído com sucesso!
    <a href='#'>X</a>
  </span>
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

<table id="example" class="table table-striped table table-striped mdl-data-table mdl-js-data-table mdl-data-table--selectable" width=100%>
  <thead style=background:#f8f8f8>
    <tr>
      <th>ID
                </th>
      <th>Cidade
                </th>
      <th>Data
                </th>
      <th>Hora
                </th>
      <th>Nome
                </th>
      <th>Whats
                </th>
      <th>Origem
                </th>
      <th>Status
                </th>
      <th>feedback
                </th>
      <th>Ações
                </th>
    </tr>
  </thead>

<?php
// READ TABLE
try {
$stmt = $conexao->prepare("SELECT * FROM leads where consultor='$user_id' and status='offline' or status='online' and consultor='$user_id' or usuario='$user_login' and consultor='$user_id' or consultor='$user_login' order by id asc limit 30");
 if($status == "offline"){echo '<style>.bg-danger {
     background-color: #FF2C26!important;
     color: #fff!important;
 }</style>';}

$svg = "status-svg";

if ($stmt->execute()) {
while ($rs = $stmt->fetch(PDO::FETCH_OBJ) ) {
echo "
  <tr>";
echo "
    <td>".$rs->id."</td>
    <td>".$rs->cidade."</td>
    <td>".date_format(new DateTime($rs->data), "d-m-y")."</td>
    <td>".$rs->hora."</td>
		<td class='td_feedback'>
    <div class='media-left media-middle media-middle'>
                                    <a href='http://leadsback.com.br/app/74be16979710d4c4e7c6647856088456?act=upd&id=".$rs->id."/' data-toggle='tooltip' data-placement='top' title='' data-original-title=''>
                                        <div class='avatar'> <img  onerror='imageError(this)' class='media-object img-circle' src='https://graph.facebook.com/". $rs->link_face . "/picture' alt='Avatar'><i class='avatar-status avatar-status-bottom  bg-warning b-brand-gray-darker'></i> </div>
                                    </a>
                                </div><div style='margin-left: 50px; margin-top: -35px'>
      <a href='http://leadsback.com.br/app/74be16979710d4c4e7c6647856088456?act=upd&id=".$rs->id."/".$rs->token_campanha."'>".$rs->nome."</a></div>
    </td>
    <td>".$rs->whats."</td>
    <td>
      <a href='https://www.messenger.com/t/".$rs->link_face."' target='_blank'>
        <svg width='25px' fill='#0084ff'
          xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512'>
          <path d='M224 32C15.9 32-77.5 278 84.6 400.6V480l75.7-42c142.2 39.8 285.4-59.9 285.4-198.7C445.8 124.8 346.5 32 224 32zm23.4 278.1L190 250.5 79.6 311.6l121.1-128.5 57.4 59.6 110.4-61.1-121.1 128.5z'></path>
        </svg>
      </a>
      <a href='https://api.whatsapp.com/send?phone=55".$rs->whats."&text=Ol%C3%A1 ".$rs->nome."!%20Podemos%20Conversar%20Sobre%20o%20teu%20Interesse%20em%20".$rs->interesse."?' target='_blank'>
        <svg
          xmlns='http://www.w3.org/2000/svg' width='25px' fill='#2dbda8' viewBox='0 0 448 512'>
          <path d='M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z'></path>
        </svg>
      </a>
    </td>
    <td>
      <div style='margin-top: 7px'>
        <svg class='". $rs->status."' id='".$svg."'
          xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24'>
          <circle cx='12' cy='12' r='12'></circle>
        </svg>
      </div>
    </td>
    <td>
      <form method='POST' action='/auth/enviar/enviar_feedback.php'>
        <div class=''>
          <select name='' style='height: 35px!important' class='form-control'>
            <option value='".$rs->status."'>".$rs->status."</option>

          </select>
        </div>
      </form>
    </td>
    <td>
      <div class='dropdown'>
        <button class='btn btn-default  dropdown-toggle' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
          <i class='fa fa-bars m-r-1'></i>
          <span class='caret'></span>
        </button>
        <ul class='dropdown-menu dropdown-menu-right'>
          <li>
            <div class='col-lg-12 col-md-6 col-sm-6 col-xs-6 m-b-3'>
              <p class='small text-uppercase'>
                <strong>Ações</strong>
              </p>
              <ul class='nav nav-pills nav-stacked'>
                <li role='presentation'>
                  <a href='#' class='text-muted'>
                    <i class='fa fa-fw fa-circle-o text-success m-r-1'></i> Salvar
                  </a>

                </li>
                <li role='presentation'>
                  <a href='/app/74be16979710d4c4e7c6647856088456?act=upd&id=".$rs->id." /# ".$rs->token_campanha." ' class='text-muted'>
                    <i class='fa fa-fw fa-circle-o text-info m-r-1'></i> Trabalhar Contato
                  </a>
                </li>
                <li role='presentation'>
                  <a href='http://leadsback.com.br/app/74be16979710d4c4e7c6647856088456?act=del&amp;id=". $rs->id."' class='text-muted'>
                    <i class='fa fa-fw fa-circle-o text-primary m-r-1'></i> Deletar
                  </a>
                </li>

                <li role='presentation'>
                  <a href='#' class='text-muted'>
                    <i class='fa fa-fw fa-plus text-muted m-r-1'></i> Devolver
                  </a>
                </li>
              </ul>
            </div>
          </li>
        </ul>
      </div>
    </td>
";
echo "
  </tr>";
}
} else {
echo "Erro: Não foi possível recuperar os dados do banco de dados";
}
} catch (PDOException $erro) {
echo "Erro: ".$erro->getMessage();
}
?>
</table>

<script>
        $(document).ready(function() {
            $("#example").DataTable({
                columnDefs: [{
                    targets: [0, 1, 2],
                    className: "mdl-data-table__cell--non-numeric"
                }]
            })
        });
    </script>
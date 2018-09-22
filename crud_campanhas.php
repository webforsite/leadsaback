<?php
/**
* CRUD PDO - CAMPANHAS - 24/08/2018 - 10:31
* Rogério Mário
*/
// GLOBAL INFORMAÇÕES
global $current_user;
$current_user = wp_get_current_user();
$user_info = get_userdata($current_user->ID);
$first_name = $user_info->first_name;
$last_name = $user_info->last_name;
$user_adm = $user_info->user_adm;
$user_id = $user_info->ID;
$user_login = $user_info->user_login;
$hoje = date('d-m-y');
$agora = date('H:i:s' , time());

// Verificar se foi enviando dados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
  $titulo_anuncio = (isset($_POST["titulo_anuncio"]) && $_POST["titulo_anuncio"] != null) ? $_POST["titulo_anuncio"] : "";
  $adm = (isset($_POST["adm"]) && $_POST["adm"] != null) ? $_POST["adm"] : "";
  $token_campanha = (isset($_POST["token_campanha"]) && $_POST["token_campanha"] != null) ? $_POST["token_campanha"] : NULL;
$empresa = (isset($_POST["empresa"]) && $_POST["empresa"] != null) ? $_POST["empresa"] : "";
$id_associado = (isset($_POST["id_associado"]) && $_POST["id_associado"] != null) ? $_POST["id_associado"] : "";
$tipo_campanha = (isset($_POST["tipo_campanha"]) && $_POST["tipo_campanha"] != null) ? $_POST["tipo_campanha"] : "";
$preco = (isset($_POST["preco"]) && $_POST["preco"] != null) ? $_POST["preco"] : "";
$cidade = (isset($_POST["cidade"]) && $_POST["cidade"] != null) ? $_POST["cidade"] : "";
$estado = (isset($_POST["estado"]) && $_POST["estado"] != null) ? $_POST["estado"] : "";

$inicio = (isset($_POST["inicio"]) && $_POST["inicio"] != null) ? $_POST["inicio"] : "";
$fim = (isset($_POST["fim"]) && $_POST["fim"] != null) ? $_POST["fim"] : "";

$status_campanha = (isset($_POST["status_campanha"]) && $_POST["status_campanha"] != null) ? $_POST["status_campanha"] : "";

$texto_anuncio = (isset($_POST["texto_anuncio"]) && $_POST["texto_anuncio"] != null) ? $_POST["texto_anuncio"] : "";

} else if (!isset($id)) {
  // Se não se não foi setado nenhum valor para variável $id
  $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
  $titulo_anuncio = NULL;
  $adm = NULL;
  $token_campanha = NULL;
  $empresa = NULL;
  $id_associado = NULL;
  $tipo_campanha = NULL;
  $preco = NULL;
  $cidade = NULL;
  $estado = NULL;
  $inicio = NULL;
  $fim = NULL;
  $status_campanha = NULL;
  $texto_anuncio = NULL;
}

// Cria a conexão com o banco de dados
try {
  $conexao = new PDO("mysql:host=localhost; dbname=leadsbac_app", "leadsbac_rogerio", "#aniaslv12714");
  $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $conexao->exec("set names utf8");
} catch (PDOException $erro) {
  echo "Erro na conexão:".$erro->getMessage();
}

// Bloco If que Salva os dados no Banco - atua como Create e Update
if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $titulo_anuncio != "") {
  try {
      if ($id != "") {
          $stmt = $conexao->prepare("UPDATE campanhas SET titulo_anuncio=?, adm=?, token_campanha=?, empresa=?, id_associado=?, tipo_campanha=?, preco=?, cidade=?, estado=?, inicio=?, fim=?, status_campanha=?, texto_anuncio=? WHERE id = ?");
          $stmt->bindParam(14, $id);
      } else {
          $stmt = $conexao->prepare("INSERT INTO campanhas (titulo_anuncio, adm, token_campanha, empresa, id_associado, tipo_campanha, preco, cidade, estado, inicio, fim, status_campanha, texto_anuncio) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
      }
      $stmt->bindParam(1, $titulo_anuncio);
      $stmt->bindParam(2, $adm);
      $stmt->bindParam(3, $token_campanha);
  $stmt->bindParam(4, $empresa);
  $stmt->bindParam(5, $id_associado);
  $stmt->bindParam(6, $tipo_campanha);
  $stmt->bindParam(7, $preco);
  $stmt->bindParam(8, $cidade);
  $stmt->bindParam(9, $estado);
  $stmt->bindParam(10, $inicio);
  $stmt->bindParam(11, $fim);
  $stmt->bindParam(12, $status_campanha);
  $stmt->bindParam(13, $texto_anuncio);

      if ($stmt->execute()) {
          if ($stmt->rowCount() > 0) {
              echo "Dados cadastrados com sucesso!";
              $id = null;
              $titulo_anuncio = null;
              $adm = null;
              $token_campanha = null;
              $empresa = null;
              $id_associado = null;
              $tipo_campanha = null;
              $preco = null;
              $cidade = null;
              $estado = null;
              $inicio = null;
              $fim = null;
              $status_campanha = null;
              $texto_anuncio = null;
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
      $stmt = $conexao->prepare("SELECT * FROM campanhas WHERE id = ?");
      $stmt->bindParam(1, $id, PDO::PARAM_INT);
      if ($stmt->execute()) {
          $rs = $stmt->fetch(PDO::FETCH_OBJ);
          $id = $rs->id;
          $titulo_anuncio = $rs->titulo_anuncio;
          $adm = $rs->adm;
          $token_campanha = $rs->token_campanha;
          $empresa = $rs->empresa;
          $id_associado = $rs->id_associado;
          $tipo_campanha = $rs->tipo_campanha;
          $preco = $rs->preco;
          $cidade = $rs->cidade;
          $estado = $rs->estado;
          $inicio = $rs->inicio;
          $fim = $rs->fim;
          $status_campanha = $rs->status_campanha;
          $texto_anuncio = $rs->texto_anuncio;
          if(!isset($id)){header('location: /app/campanhas'); exit;}
          // TABELA DE DADOS
          echo  '
          <table class="table table-striped table table-striped mdl-data-table mdl-js-data-table mdl-data-table--selectable" width="100%">
            <thead style="background: #f8f8f8!important">
              <tr>
                <th>ID</th>
                <th>Cidade</th>
                <th>Início</th>
                <th>Fim</th>
          			<th>Título</th>
                <th>Empresa</th>
                <th>Destino</th>
                <th>status_campanha</th>
                <th>Desafio</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tr class="">
              <td>'. $id .'</td>
              <td>'. $cidade .'</td>
              <td>'. $inicio .'</td>
              <td>'. $fim .'</td>
          		<td class="td_feedback">
              <div class="media-left media-middle media-middle">
                                              <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="">
                                                  <div class="avatar"> <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0Ij48cGF0aCBkPSJNMTUgMjFjMCAxLjU5OC0xLjM5MiAzLTIuOTcxIDNzLTMuMDI5LTEuNDAyLTMuMDI5LTNoNnptLjEzNy0xNy4wNTVjLS42NDQtLjM3NC0xLjA0Mi0xLjA3LTEuMDQxLTEuODJ2LS4wMDNjLjAwMS0xLjE3Mi0uOTM4LTIuMTIyLTIuMDk2LTIuMTIycy0yLjA5Ny45NS0yLjA5NyAyLjEyMnYuMDAzYy4wMDEuNzUxLS4zOTYgMS40NDYtMS4wNDEgMS44Mi00LjY2OCAyLjcwOS0xLjk4NSAxMS43MTUtNi44NjIgMTMuMzA2djEuNzQ5aDIwdi0xLjc0OWMtNC44NzctMS41OTEtMi4xOTMtMTAuNTk4LTYuODYzLTEzLjMwNnptLTMuMTM3LTIuOTQ1Yy41NTIgMCAxIC40NDkgMSAxIDAgLjU1Mi0uNDQ4IDEtMSAxcy0xLS40NDgtMS0xYzAtLjU1MS40NDgtMSAxLTF6bS02LjQ1MSAxNmMxLjE4OS0xLjY2NyAxLjYwNS0zLjg5MSAxLjk2NC01LjgxNS40NDctMi4zOS44NjktNC42NDggMi4zNTQtNS41MDkgMS4zOC0uODAxIDIuOTU2LS43NiA0LjI2NyAwIDEuNDg1Ljg2MSAxLjkwNyAzLjExOSAyLjM1NCA1LjUwOS4zNTkgMS45MjQuNzc1IDQuMTQ4IDEuOTY0IDUuODE1aC0xMi45MDN6Ii8+PC9zdmc+"><i class="avatar-status_campanha avatar-status_campanha-bottom  bg-warning b-brand-gray-darker"></i> </div>
                                              </a>
                                          </div><div style="margin-left: 50px; margin-top: -35px">
                <a href="http://leadsback.com.br/app/campanhas?act=upd&id='. $id .'/#"> '. $titulo_anuncio .'</a></div>
              </td>
              <td>'. $empresa .'</td>
              <td>
                <a href="https://www.messenger.com/t/'. $link_face .'" target="_blank">
                <svg width="33px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
 viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><path style="fill:#FBBB00;" d="M113.47,309.408L95.648,375.94l-65.139,1.378C11.042,341.211,0,299.9,0,256
c0-42.451,10.324-82.483,28.624-117.732h0.014l57.992,10.632l25.404,57.644c-5.317,15.501-8.215,32.141-8.215,49.456
C103.821,274.792,107.225,292.797,113.47,309.408z"/><path style="fill:#518EF8;" d="M507.527,208.176C510.467,223.662,512,239.655,512,256c0,18.328-1.927,36.206-5.598,53.451
c-12.462,58.683-45.025,109.925-90.134,146.187l-0.014-0.014l-73.044-3.727l-10.338-64.535
c29.932-17.554,53.324-45.025,65.646-77.911h-136.89V208.176h138.887L507.527,208.176L507.527,208.176z"/><path style="fill:#28B446;" d="M416.253,455.624l0.014,0.014C372.396,490.901,316.666,512,256,512
c-97.491,0-182.252-54.491-225.491-134.681l82.961-67.91c21.619,57.698,77.278,98.771,142.53,98.771
c28.047,0,54.323-7.582,76.87-20.818L416.253,455.624z"/><path style="fill:#F14336;" d="M419.404,58.936l-82.933,67.896c-23.335-14.586-50.919-23.012-80.471-23.012
c-66.729,0-123.429,42.957-143.965,102.724l-83.397-68.276h-0.014C71.23,56.123,157.06,0,256,0
C318.115,0,375.068,22.126,419.404,58.936z"/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                </a>
                <a href="https://api.empresaapp.com/send?phone=55'.$empresa.'&text=Olá,%20'. $titulo_anuncio .',!%20Podemos%20Conversar%20Sobre%20seu%20interesse%20em%20'.$interesse .'?" target="_blank">
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
                    <select  style="height: 35px!important" class="form-control">
                      <option value="R$ '. $rs->orcamento.'">R$ '. $rs->orcamento.'</option>
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
                <a href="#" class="text-muted">
                  <i class="fa fa-fw fa-circle-o text-success m-r-1"></i> Salvar
                </a>
              </li>
              <li role="presentation">
                <a href="https://leadsback.com.br/app/campanhas?act=upd&amp;id='.$id.'" class="text-muted">
                  <i class="fa fa-fw fa-circle-o text-info m-r-1"></i> Trabalhar
                </a>
              </li>
              <li role="presentation">
                <a href="/app/campanhas?act=del&amp;id='.$id.'" class="text-muted">
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
          echo do_shortcode('[xyz-ips snippet="88aaMODAL"]');
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
      $stmt = $conexao->prepare("DELETE FROM campanhas WHERE id = ?");
      $stmt->bindParam(1, $id, PDO::PARAM_INT);
      if ($stmt->execute()) {
          echo " <div class='alert no-bg b-l-danger b-l-3 b-t-gray b-r-gray b-b-gray' role='alert'>
          <strong class='text-white'>Ual!</strong> <span class='text-gray-lighter'>Anúncio Excluído com Sucesso!</span>
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

<table id="campanhas" class="table table-striped table table-striped mdl-inicio-table mdl-js-inicio-table mdl-inicio-table--selectable" width=100%>
  <thead>
    <tr>
      <th>ID
                </th>
      <th>Cidade
                </th>
      <th>inicio
                </th>
      <th>fim
                </th>
      <th>status
      </th>
      <th>titulo_anuncio
                </th>
      <th>empresa
                </th>
      <th>Destino
                </th>

      <th>Orçamento
                </th>
      <th>Ações
                </th>
    </tr>
  </thead>

<?php
// READ TABLE
try {
$stmt = $conexao->prepare("SELECT * FROM campanhas  order by id desc");
 if($status_campanha == "offline"){echo '<style>.bg-danger {
     background-color: #FF2C26!important;
     color: #fff!important;
 }</style>';}


$svg = "status_campanha-svg";

if ($stmt->execute()) {
while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
echo "
  <tr>";
echo "
    <td>".$rs->id."</td>
    <td>".$rs->cidade."</td>
    <td>".$rs->inicio."</td>
    <td>".$rs->fim."</td>
    <td>
      <div style='margin-top: 7px'>
        <svg class='". $rs->status_campanha." offline' id='".$svg."'
          xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24'>
          <circle cx='12' cy='12' r='12'></circle>
        </svg>
      </div>
    </td>
		<td class='td_campanha'>
    <div class='media-left media-middle media-middle'>
                                    <a href='#' inicio-toggle='tooltip' inicio-placement='top' title='' inicio-original-title=''>
                                        <div class='avatar'> <img  onerror='imageError(this)' class='media-object img-circle' src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0Ij48cGF0aCBkPSJNMTUgMjFjMCAxLjU5OC0xLjM5MiAzLTIuOTcxIDNzLTMuMDI5LTEuNDAyLTMuMDI5LTNoNnptLjEzNy0xNy4wNTVjLS42NDQtLjM3NC0xLjA0Mi0xLjA3LTEuMDQxLTEuODJ2LS4wMDNjLjAwMS0xLjE3Mi0uOTM4LTIuMTIyLTIuMDk2LTIuMTIycy0yLjA5Ny45NS0yLjA5NyAyLjEyMnYuMDAzYy4wMDEuNzUxLS4zOTYgMS40NDYtMS4wNDEgMS44Mi00LjY2OCAyLjcwOS0xLjk4NSAxMS43MTUtNi44NjIgMTMuMzA2djEuNzQ5aDIwdi0xLjc0OWMtNC44NzctMS41OTEtMi4xOTMtMTAuNTk4LTYuODYzLTEzLjMwNnptLTMuMTM3LTIuOTQ1Yy41NTIgMCAxIC40NDkgMSAxIDAgLjU1Mi0uNDQ4IDEtMSAxcy0xLS40NDgtMS0xYzAtLjU1MS40NDgtMSAxLTF6bS02LjQ1MSAxNmMxLjE4OS0xLjY2NyAxLjYwNS0zLjg5MSAxLjk2NC01LjgxNS40NDctMi4zOS44NjktNC42NDggMi4zNTQtNS41MDkgMS4zOC0uODAxIDIuOTU2LS43NiA0LjI2NyAwIDEuNDg1Ljg2MSAxLjkwNyAzLjExOSAyLjM1NCA1LjUwOS4zNTkgMS45MjQuNzc1IDQuMTQ4IDEuOTY0IDUuODE1aC0xMi45MDN6Ii8+PC9zdmc+' alt='Avatar'><i class='avatar-status_campanha avatar-status_campanha-bottom  bg-warning b-brand-gray-darker'></i> </div>
                                    </a>
                                </div><div style='margin-left: 50px; margin-top: -35px'>
      <a href='http://leadsback.com.br/app/campanhas?act=upd&id=".$rs->id."/'>".$rs->titulo_anuncio."</a></div>
    </td>
    <td>".$rs->empresa."</td>
    <td>
      <a href='https://www.messenger.com/t/".$rs->tipo_campanha."' target='_blank'>
        <svg width='25px' fill='#0084ff'
          xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512'>
          <path d='M224 32C15.9 32-77.5 278 84.6 400.6V480l75.7-42c142.2 39.8 285.4-59.9 285.4-198.7C445.8 124.8 346.5 32 224 32zm23.4 278.1L190 250.5 79.6 311.6l121.1-128.5 57.4 59.6 110.4-61.1-121.1 128.5z'></path>
        </svg>
      </a>
      <a href='https://api.empresaapp.com/send?phone=55".$rs->empresa."&text=Ol%C3%A1,!' target='_blank'>
        <svg
          xmlns='http://www.w3.org/2000/svg' width='25px' fill='#2dbda8' viewBox='0 0 448 512'>
          <path d='M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z'></path>
        </svg>
      </a>
    </td>

    <td>
      <form method='POST' action='/auth/enviar/enviar_texto_anuncio.php'>
        <div class=''>
          <select name='orcamento' style='height: 35px!important' class='form-control'>
            <option value='R$ ".$rs->orcamento."'>R$ ".$rs->orcamento."</option>

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
              <a href='https://leadsback.com.br/app/campanhas?act=upd&amp;id=".$rs->id."' class='text-muted'>
                <i class='fa fa-fw fa-circle-o text-info m-r-1'></i> Trabalhar
              </a>
            </li>
            <li role='presentation'>
              <a href='https://leadsback.com.br/app/campanhas?act=del&amp;id=".$rs->id."' class='text-muted'>
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
var $doc = $('html, body');
$('a').click(function() {
    $doc.animate({
        scrollTop: $( $.attr(this, 'href') ).offset().top
    }, 500);
    return false;
});
</script>

<script>
        $(document).ready(function() {
            $("#example").inicioTable({
                columnDefs: [{
                    targets: [0, 1, 2],
                    className: "mdl-inicio-table__cell--non-numeric"
                }]
            })
        });
    </script>

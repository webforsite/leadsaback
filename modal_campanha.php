<?php
	/**
	* CRUD PDO - MODAL CAMPANHAS - 20/09/2018 - 10:31
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
	?>

	<?php
	$user = wp_get_current_user();
	// SE ESTE CARA FOR ADMIN

	// Verificar se foi enviando dados via POST
	if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
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
?>

<?php
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


<!-- LAYOUT -->
<div class="container" id="x">
	<?php if($titulo_anuncio != null): ?>
</div>
<style>.hwp-popup ul li::before{display:none!important}</style>
<div class="row">
<?php endif; ?>
<?php
// SE ESTE CARA FOR ADMIN
if ( in_array( 'administrator', (array) $user->roles ) ): ?>
<form action="?act=save" method="POST" name="form1" >
	<div class="">
	<button type="submit" value="salvar"  class="overlay-close ">Salvar</button>
	<div class="body page-index clearfix">
		<div class="element element-2">
			<h5 style="text-align: left!important; padding-left: 2%; width:60%">
				<div class="media media-auto">
					<div class="media-left">
						<div class="avatar avatar-lgz  visible-lg-inline-block visible-md-inline-block visible-sm-inline-block visible-xs-inline-block m-r-1">
							<img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0Ij48cGF0aCBkPSJNMTAuMjUyIDIzaC0zLjIxYy0uNjEyIDAtMS4xNTctLjQyNy0xLjM1NC0xLjAwN2wtMS41OTEtNC45OTNoNC42MTVsLjkxOCAzLjE3MWMuMTc4LjU1Mi41MTIgMS4wNDEuOTYyIDEuNDA4Ljc1OC42MTguMjcxIDEuNDIxLS4zNCAxLjQyMXptOS4yODYtMjEuOTAyYy0xLjUyMi42MTctNC41MjUgMy43MzktOC4yNTIgNC42MzktLjgwMiAxLjA5OS0xLjI4NSAyLjg4Mi0xLjI4NSA0Ljg0NiAwIDEuODYxLjQzOCAzLjU1MyAxLjE2NSA0LjY2MiAzLjk0MS45NDIgNi4zMDMgMy45OTYgOC4zMDkgNC42NzEgMi4yMDEuNzQyIDQuNTI5LTMuNDY4IDQuNTI1LTkuNDIyLS4wMDMtNS45NTktMi40NzEtMTAuMjAyLTQuNDYyLTkuMzk2em0xLjcwNCAxNS40NzJjLS43MTkgMS42NTYtMS45ODcgMS42ODUtMi43Mi4wMDEtLjQzNi0xLjAwMi0uNzMxLTIuNzcyLS44OTItMy45NjFoLjM4YzEuMTc0IDAgMi4xMjUtLjk1NCAyLjEyNS0yLjEzMXMtLjk1MS0yLjEzMi0yLjEyNS0yLjEzMmgtLjM5Yy4xNi0xLjIxLjUzOC0yLjk0Ny45NzQtMy44OS43NjQtMS42NTIgMS45NDEtMS42OCAyLjcyLS4wMDEgMS4zMTUgMi44MzggMS4zNjggOC43OTQtLjA3MiAxMi4xMTR6bS0xMi40MzUtMS41N2gtNC4zNzFjLTIuNDUyIDAtNC40MzYtMi4wNDctNC40MzYtNC41czEuOTg0LTQuNSA0LjQzNi00LjVoNC40NDRjLS41NjEgMS4zLS44NzYgMi44ODctLjg3NiA0LjU5NCAwIDEuNjI3LjI5IDMuMTQxLjgwMyA0LjQwNnoiLz48L3N2Zz4=">
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
						<strong class="media-heading text-white caixa-alta"><?php echo $titulo_anuncio; ?></strong>
						<br>
						<small class="media-heading"><span>Início |  <?php echo $inicio; echo "  "; echo "até:" ; echo "  "; echo " "; echo $fim; ?> </span></small>
					</div>
					<div class="row">
						<div class="col-lg-4 col-md-6 col-sm-5 col-xs-12">
							<div class="btn-toolbar pull-right hidden-lg hidden-md hidden-sm m-b-2 m-t-2">
								<div class="btn-group btn-group-justified" role="group" aria-label="...">
									<a class="btn btn-block btn-default" href="#" role="button"><i class="fa fa-folder"></i></a>
									<a class="btn btn-block btn-default" href="#" role="button"><i class="fa fa-link"></i></a>
									<a class="btn btn-block btn-default" href="#" role="button"><i class="fa fa-trash"></i></a>
									<a class="btn btn-block btn-default hwp-close" role="button"><i class="fa fa-list"></i></a>
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
									<a class="btn btn-default hwp-close" role="button"><i class="fa fa-folder"></i></a>
									<a class="btn btn-default hwp-close " href="#" role="button"><i class="fa fa-trash"></i></a>
								</div>
								<div class="btn-group" role="group" aria-label="...">
									<a  class="btn btn-default hwp-close" role="button"><i class="fa fa-list"></i></a>
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
							<strong>Visão Geral - Anúncio</strong>
						</h6>
					</div>
					<div class="progress">
						<div class="progress-bar pregress-bar-vendido" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php switch ($status_campanha) {
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
							<?php echo $status_campanha; ?>
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
							<div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: <?php switch ($status_campanha) {
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
								<h4 class="m-t-0 f-w-300 m-b-0"><?php
								echo total_leads_campanhas_interesse();?></h4>
								<p class="text-center m-b-0">interessado(s)</p>
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
							<h5 class="list-group-item-heading">Status</h5>
              <select required
    						name="status_campanha" style="height: 35px!important" class="form-control" >
    						<option <?php
    							// Preenche o status no campo status com um valor "value"
    							if (isset($status_campanha) && $status_campanha != null || $status_campanha != "") {
    							    echo "value=\"{$status_campanha}\"";
    							}
    							?>><?php echo $status_campanha; ?></option>
    						<option value="Online">Online</option>
    						<option value="Offline">Offline</option>
    					</select>
						</a>
						<a class="list-group-item  no-bg">
							<h5 class="list-group-item-heading">Administrador</h5>
							<input class="form-control" type="text" name="adm" value="<?php echo $adm; ?>">
						</a>
						<a class="list-group-item">
							<h5 class="list-group-item-heading">Destino</h5>
              <select required
    						name="tipo_campanha" style="height: 35px!important" class="form-control" >
    						<option <?php
    							// Preenche o status no campo status com um valor "value"
    							if (isset($tipo_campanha) && $tipo_campanha != null || $tipo_campanha != "") {
    							    echo "value=\"{$tipo_campanha}\"";
    							}
    							?>><?php echo $tipo_campanha; ?></option>
    						<option value="Facebook">Facebook</option>
    						<option value="Google">Google</option>
                <option value="Orgânico">Orgâncico</option>
                <option value="Google | Facebook">Google | Facebook</option>
                <option value="Google | Facebook | Orgânico">Google | Facebook | Orgânico</option>
                <option value="Facebook | Orgânico">Facebook | Orgânico</option>
                <option value="Google | Orgânico">Google | Orgânico</option>
    					</select>
						</a>
					</div>
				</div>
			</div>
			<div id="editar" class="hr-text hr-text-left">
				<h6 class="text-white">
					<strong>Editar Dados</strong>
				</h6>
			</div>
			<div class="list-group">
				<a  class="list-group-item">
					<h5 class="list-group-item-heading">Preço</h5>
					<input class="form-control" type="text" name="preco" value="<?php echo $preco; ?>">
				</a>
				<a  class="list-group-item">
					<h5 class="list-group-item-heading">Cidade</h5>
					<select name="cidade" style="height: 35px!important" class="form-control">
						<option value="<?php echo $cidade; ?>"><?php echo $cidade; ?></option>
						<option value="Londrina">Londrina - PR</option>
						<option value="Cambé">Cambé -PR</option>
						<option value="ibiporâ">ibiporâ - PR</option>
						<option value="Maringá">Maringá - PR</option>
						<option value="Curitiba">Curitiba - PR</option>
					</select>
				</a>
			</div>
		</div>
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
									<a class="text-muted button-salvar" type="submit" value="salvar">
									<i class="fa fa-fw fa-circle-o text-success m-r-1"></i> Participar
									</a>
								</li>
								<li role="presentation">
									<a href="#" class="text-muted">
									<i class="fa fa-fw fa-circle-o text-info m-r-1"></i> Publicar
									</a>
								</li>
								<li role="presentation">
									<a href="# " class="text-muted">
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

			<!-- Planejamento -->
			<div class="list-group">
				<div id="informacoes" class="hr-text hr-text-left">
					<h6 class="text-white">
						<strong>Informações do Anúncio </strong>
					</h6>
				</div>
				<label class="left">Token Campanha</label>
				<a  class="list-group-item  no-bg">
					<select required
						name="token_campanha" style="height: 35px!important" class="form-control" >
						<option <?php
							// Preenche o status no campo status com um valor "value"
							if (isset($token_campanha) && $token_campanha != null || $token_campanha != "") {
							    echo "value=\"{$token_campanha}\"";
							}
							?>><?php echo $token_campanha; ?></option>
						<option value="Sem Contato">Sem contato</option>
						<option value="Vendido">Vendido</option>
						<option value="Proposta Divergente">Proposta Divergente</option>
						<option value="Pediu Retorno">Pediu retorno ( Agenda )</option>
						<option value="Pediu Mais Informações">Pediu Mais Informações ( texto_anuncio )</option>
					</select>
				</a>
				<div class="table">
					<table class="table  m-t-2">
						<thead>
							<tr>
								<th class="small text-muted text-uppercase"><strong>Destino</strong>
								</th>
								<th class="small text-muted text-uppercase"><strong>Vigência</strong>
								</th>
								<th class="small text-muted text-uppercase"><strong>Atendimento</strong>
								</th>
								<th class="small text-muted text-uppercase"><strong>Campanhas</strong>
								</th>
								<th class="small text-muted text-uppercase text-right"><strong>Ações</strong>
								</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="v-a-m">
									<div class="media media-auto">
										<div class="media-left">
											<?php
												switch ($tipo_campanha) {
												  case 'facebook':
												    // code...
												    echo '<i class="fa fa-fw fa-facebook fa-3x"></i>';
												    break;
												  case 'google':
												    echo '<i class="fa fa-fw fa-google fa-3x"></i>';
												    break;
												  case 'organico':
												    echo '<i class="fa fa-fw fa-facebook fa-3x"></i>';
												    break;
												  default:
												    // code...
												    break;
												}
												?>
										</div>
										<div class="media-body">
											<span class="media-heading text-white"><?php if(empty($tipo_campanha)){echo "Produto / Serviço";} else{echo $tipo_campanha;}?></span>
											<br>
											<span class="media-heading"><span></span></span>
										</div>
									</div>
								</td>
								<td class="v-a-m"><span><?php echo $inicio; echo "    -    ";  ?></span>
									<br>
									<span><?php echo $fim; ?></span>
								</td>
								<td class="v-a-m">
									<div class="avatar visible-lg-inline-block visible-md-inline-block visible-sm-inline-block visible-xs-inline-block">
										<img class="img-circle" onerror="imageError(this)" alt="Avatar" src="https://graph.facebook.com/<?php echo $status_campanha; ?>/picture">
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
								<td class="text-right v-a-m">
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
															<a href="#" type="submit" onclick="setTimeout(myFunction,1500)" value="salvar" class="text-muted">
															<i class="fa fa-fw fa-circle-o text-success m-r-1"></i> Salvar
															</a>
														</li>
														<li role="presentation">
															<a href="/app/campanhas?act=upd&amp;id='.$id.'/" class="text-muted">
															<i class="fa fa-fw fa-circle-o text-info m-r-1"></i> Editar Campanha
															</a>
														</li>
														<li role="presentation">
															<a href="http://leadsback.com.br/app/campanhas?act=del&amp;id='.$id'." class="text-muted">
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
						</tbody>
					</table>
				</div>
				<div id="Negociacao" class="hr-text hr-text-left">
					<h6 class="text-white">
						<strong>Anúncio</strong>
					</h6>
				</div>
				Título
				<input class="form-control" name="titulo_anuncio" value="<?php echo $titulo_anuncio; ?>">
				<label class="left">Texto Anúncio</label>
				<a  class="list-group-item  no-bg"><textarea name="texto_anuncio"
					style="height: 250px!important" class="form-control" ><?php echo $texto_anuncio;?></textarea>
				</a>
				<div class="media">
					<div class="media-left">
						<div class="avatar">
							<img class="media-object img-circle" src="https://s3.amazonaws.com/uifaces/faces/twitter/joemdesign/128.jpg" alt="Avatar">
							<i class="avatar-status avatar-status-bottom  bg-danger b-brand-gray-darker"></i>
						</div>
					</div>
					<div class="media-body">
						<div class="panel-default">
							<div class="panel-body bg-info-l text-white b-r-a-3">
								<strong>Iniciado campanha no  <?php echo $tipo_campanha; ?>   |   <?php echo $inicio; ?> até:  <?php echo $fim; ?>  </strong>
							</div>
						</div>
						<h5 style="text-align: left"class="m-t-1"><span>usuário <?php echo $usuario; ?></span><small><span>  |  <?php echo $inicio; echo " | "; echo $fim; ?></span></small></h5>
						<?php if(!empty($texto_anuncio)): ?>
						<div class="hr-text hr-text-center m-t-2 m-b-1">
							<h6 class="text-white"><strong><?php echo $agora; echo " | "; echo $fim; ?></strong></h6>
						</div>
						<div class="media">
							<div class="media-body">
								<div class="panel-default">
									<div class="panel-body bg-gray text-white b-r-a-3">
										<span><?php echo $texto_anuncio; ?></span>
									</div>
								</div>
								<h5 class="m-t-1 text-right"><span><?php echo $user_login; ?></span><small><span><?php echo $inicio; ?></span></small></h5>
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
			<!--
				<div style="margin-left: 90%">
				  <button type="submit" value="salvar" class="mdl-button mdl-js-button mdl-button--fab mdl-button--colored">
				    <i class="material-icons">add</i>
				  </button>
				</div>
				-->
			<div id="texto_anuncio" class="hr-text hr-text-left">
				<h6 class="text-white">
					<strong>Texto do Anúncio</strong>
				</h6>
			</div>
			<div style="float:left">Escreva :</div>
			<textarea required style="font-size: 16px!important" name="texto_anuncio" rows="4" cols="50"><?php $texto = trim($texto_anuncio); echo $texto; ?></textarea>
			<div class="">
				<button type="submit" value="salvar"  class="btn btn-default btn-lg btn-block">Salvar</button>
			</div>
			<div class="hr-text hr-text-left">
				<h6 class="text-white">
					<strong>Planejamento</strong>
				</h6>
			</div>


			<input class="form-control " type="hidden" name="id"
				<?php
					// Preenche o id no campo id com um valor "value"
					if (isset($id) && $id != null || $id != "") {
					    echo "value=\"{$id}\"";
					}
					?> />
			<input type="hidden" name="empresa"  class="form-control"<?php
				// preenche empresa
				if (isset($empresa) && $empresa != null || $empresa != "") {
				    echo "value=\"{$empresa}\"";
				}
				?> />
			<input type="hidden" name="id_associado"  class="form-control"<?php
				// Preenche id_associado
				if (isset($id_associado) && $id_associado != null || $id_associado != "") {
				    echo "value=\"{$id_associado}\"";
				}
				?> />
			<input type="hidden" name="orcamento"  class="form-control"<?php
				// Preenche id_associado
				if (isset($orcamento) && $orcamento != null || $orcamento != "") {
				    echo "value=\"{$orcamento}\"";
				                                }
				                                ?> />

			<input type="hidden" name="adm"  class="form-control"<?php
				// Preenche o adm no campo adm com um valor "value"
				if (isset($adm) && $adm != null || $adm != "") {
				    echo "value=\"{$adm}\"";
				}
				?> />
			<input type="hidden" name="estado"  class="form-control"<?php
				// Preenche estado
				if (isset($estado) && $estado != null || $estado != "") {
				    echo "value=\"{$estado}\"";
				}
				?> />

			<input type="hidden" name="inicio"  class="form-control"<?php
				// Preenche inicio
				if (isset($inicio) && $inicio != null || $inicio != "") {
				    echo "value=\"{$inicio}\"";
				}
				?> />
			<input type="hidden" name="fim"  class="form-control"<?php
				// Preenche fim
				if (isset($fim) && $fim != null || $fim != "") {
				    echo "value=\"{$fim}\"";
				}
				?> />

</form>
<?php endif; ?>
</div>


<?php
if ( in_array( 'associado', (array) $user->roles ) ): ?>

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
$sql = "SELECT * FROM campanhas where id='$id' ";
$result = $pdo->query( $sql );
$rows = $result->fetchAll( PDO::FETCH_ASSOC );
$stmty = $pdo->prepare($sql);
$stmty->execute();
$result = $stmty->fetchAll(PDO::FETCH_OBJ); // Retorna um array de objetos
for($ix = 0; $ix < count($result); $ix++){
$titulo_anuncio = $result[$ix]->titulo_anuncio;
$cidade = $result[$ix]->cidade;
$empresa = $result[$ix]->empresa;
}

// conexao 3 rand
$pdoX = new PDO("mysql:host=localhost; dbname=leadsbac_app", "leadsbac_rogerio", "#aniaslv12714");
$pdoX->exec("set names utf8");
$sqlX = "SELECT * FROM usuarios where ip='$empresa' order by rand()";
$resultX = $pdoX->query( $sqlX );
$rowsX = $resultX->fetchAll( PDO::FETCH_ASSOC );
$stmtyX = $pdoX->prepare($sqlX);
$stmtyX->execute();
$resultX = $stmtyX->fetchAll(PDO::FETCH_OBJ); // Retorna um array de objetos
for($ix = 0; $ix < count($resultX); $ix++){
$consultorX = $resultX[$ix]->login;
}

?>

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
                echo $consultorX; ?>"  />

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

                <input type="hidden" name="cidade" value="<?php echo $cidade; ?>" />

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

								<input type="hidden" name="interesse" value="<?php echo $titulo_anuncio; ?>"/>


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

<?php endif; ?>
</div>
<!-- FIM DO ELEMENT 4 -->

	<?php if(!isset($id)){return;} ?>
<script>
	$(document).ready(function () {
	   $('input').keypress(function (e) {
	        var code = null;
	        code = (e.keyCode ? e.keyCode : e.which);
	        return (code == 13) ? false : true;
	   });
	});
</script>
<script>function x(){window.location="<?php echo $_SERVER['PHP_SELF'];?>"}</script>
<script>var urlAtual=window.location.href;var urlnMostrar="http://leadsback.com.br/app/campanhas/";if(urlAtual==urlnMostrar){document.getElementById("texto_anuncio-alert").style.display="block"}else{document.getElementById("texto_anuncio-alert").style.display="none"}</script>
<script>function myFunction(){window.location="http://leadsback.com.br/app/campanhas/?act=upd&id=<?php echo $id; ?>"};</script>

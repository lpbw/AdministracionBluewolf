<?
	session_start();
	$url =  "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

	if ($url == "www.bluewolf.com.mx/admon/AdministracionBlueWolf/")
	{
		if ($_SESSION['usuario']!= "" && $_SESSION['pass']!="")
		{
			$usuario = $_SESSION['usuario'];
			$pass = $_SESSION['pass'];
		}
		else
		{
			$usuario = "";
			$pass = "";
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<!--Import Google Icon Font-->
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<!--Import materialize.css-->
		<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
		<link type="text/css" rel="stylesheet" href="css/materialize.css"  media="screen,projection"/>
		<!--Let browser know website is optimized for mobile-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="css/font-awesome.min.css">
		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
		<title>Administración-BlueWolf</title>
		<style>
			.cursor{
				cursor:pointer;
			}
		</style>
		<script>
			//Cuando no ha iniciaso nunca.
			function NuevoLogin()
			{
				var fd = new FormData(document.getElementById("login"));
				fd.append('usuario',$("#usuario").val());
				fd.append('password',$("#password").val());

				$.ajax({
					url:   'nuevo_login.php',
					type:  'post',
					dataType: "html",
					data: fd,
					cache: false,
            		contentType: false,
            		processData: false,
					beforeSend: function ()
					{
							//$("#informacion2").html("Procesando, espere por favor...");
					},
					success:  function (response)
					{
						console.log(response);
					}
				});
			}

			//Cuando ahi session.
			function ActualLogin()
			{
				var fd = new FormData(document.getElementById("actual"));
				fd.append('usuario',$("#iconousuario").val());
				fd.append('password',$("#iconopass").val());

				$.ajax({
					url:   'actual_login.php',
					type:  'post',
					dataType: "html",
					data: fd,
					cache: false,
            		contentType: false,
            		processData: false,
					beforeSend: function ()
					{
							//$("#informacion2").html("Procesando, espere por favor...");
					},
					success:  function (response)
					{
						console.log(response);
					}
				});
			}
		</script>
	</head>
	<body>
		<!-- contenedor -->
		<div>
			<!-- columnas -->
			<div class="col s12 m12 l12 xl12">
				<br><br><br>
				<!-- login -->
					<div class="row">
						<div class="col s12 m12 l4 xl4 offset-l4 offset-xl4">
							<div class="card white-grey darken1">
								<div class="card-content black-text">
									<span class="card-title center flow-text">
										INICIAR SESIÓN
									</span>
									
										<?
										if ($usuario != "" && $pass != "")
										{
										?>
										<form method="post" name="actual" id="actual">
											<div class="row">
												<div class="col s12 m4 l4 xl4 offset-s4 offset-m4 offset-l4 offset-xl4 cursor">
													<div class="chip cursor" id="IconoLogin">
														<label class="cursor" onclick="ActualLogin();">
															<i class="small material-icons cursor">account_circle</i>
															<b><? echo $usuario; ?></b>
															<input type="hidden" value="<? echo $usuario;?>" name="iconousuario" id="iconousuario">
															<input type="hidden" value="<? echo $pass;?>" name="iconopass" id="iconopass">
														</label>	
													</div>
												</div>
											</div>
										</form>
										<?
										}
										else
										{
										?>
										<form method="post"  name="login" id="login" action="nuevo_login.php">
											<div class="row">
												<div class="input-field col s12 m12 l12 xl12">
													<input id="usuario" type="text" class="validate" name="usuario">
													<label class="active" for="usuario">Usuario</label>
												</div>
											</div>
											<div class="row">
												<div class="input-field col s12">
													<input id="pass" type="password" class="validate" name="password">
													<label for="pass">Contraseña</label>
												</div>
											</div>
											<div class="row">
												<div class="col s4 m4 l4 xl4 offset-s4 offset-m4 offset-l4 offset-xl4">
													<a class="btn indigo darken-3 btn" name="entrar" id="entrar" onclick="NuevoLogin();">Entrar</a>
												</div>	
											</div>
										</form>
										<?
										}
										?>
								</div>
							</div>
						</div>
					</div>
				<!-- fin login -->
			
			</div>
			<!-- fin columnas -->
		</div>
		<!-- fin contenedor -->

		<!--JavaScript at end of body for optimized loading-->
		<script type="text/javascript" src="js/materialize.min.js"></script>
		<script type="text/javascript" src="js/materialize.js"></script>
		<script type="text/javascript" src="js/initialize.js"></script>
	</body>
</html>
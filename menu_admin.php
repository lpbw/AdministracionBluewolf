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
			.loader 
			{
				position: fixed;
				left: 0px;
				top: 0px;
				width: 100%;
				height: 100%;
				z-index: 9999;
				background: url('images/pageLoader.gif') 50% 50% no-repeat rgb(249,249,249);
				opacity: .8;
			}
			.centrar
			{
				margin-left:15%;
			}
		</style>
		<script>
			$(window).ready(function()
			{
    			$(".loader").fadeOut("slow");
			});
		</script>
	</head>
	<body>

		<div class="loader"></div>
		

		<ul id="slide-out" class="sidenav">
			<li><img src="images/bw.png" class="centrar"></li>
			<li><div class="divider"></div></li>
			<li><a href="#!">Clientes</a></li>
			<li><div class="divider"></div></li>
			<li><a class="subheader">Subheader</a></li>
			<li><a class="waves-effect" href="#!">Third Link With Waves</a></li>
  		</ul>

		<!-- contenedor -->
		<div>
			<div class="row">
				<div class="col s12 m12 l12 xl12">
					<!-- boton nav bar -->
					<a href="#" data-target="slide-out" class="sidenav-trigger">
						<i class="material-icons medium indigo-text">
							menu
						</i>
					</a>
					<!-- fin boton nav bar -->
				</div>
			</div>
			
			<div class="row">
				<div class="col s12 m12 l12 xl12">
					
				</div>
			</div>

		</div>
		<!-- fin contenedor -->

		<!--JavaScript at end of body for optimized loading-->
		<script type="text/javascript" src="js/materialize.min.js"></script>
		<script type="text/javascript" src="js/materialize.js"></script>
		<script type="text/javascript" src="js/initialize.js"></script>
	</body>
</html>
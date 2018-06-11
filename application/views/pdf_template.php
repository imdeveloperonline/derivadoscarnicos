<?php header('Content-Type: text/html; charset=UTF-8');
setlocale(LC_ALL,"es_ES.UTF-8"); ?>
<!DOCTYPE html>
<html lang="es">
	<meta charset="utf-8">
	<head>
		<meta charset="utf-8">
		<!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

		<title> Derivados Cárnicos </title>

		
		

		<style type="text/css">
			body {
				max-width: 100% !important;
				overflow-x: hidden;
				font-size: 11px;
			}

			.content {
				padding-top: 20px;
			}
			table {
				width: 100%;
				border-collapse: collapse;
			}
			th, td {
				border: 1px solid #ACACAC;
				padding: 5px;
			}
			thead tr {
				background: #C6C6C6;
				text-align: center;
			}

			ul {
				list-style: none;
			}

			.title {
				text-align: center;
			}
			.text-center {
				width: 23%; float: left;text-align: center; padding: 10px 0 10px 0;
			}
		
		</style>
	</head>
	
	<body>

		<header>
			<div style="display: block; margin-right: auto; margin-left: auto;">
				<img src="<?= base_url() ?>assets/img/logo.png" style="width: 15%; height: auto; margin-left: 42.5%">
			</div>
			<div style="text-align: center;">
				<h2>Derivados Cárnicos</h2>
				<p><?= ucfirst(strftime("%A %d-%m-%Y",time())) ?></p>
			</div>
		</header>

		<div class="content">

		
		<?php echo $content ?>
		</div>
	

	</body>
</html>
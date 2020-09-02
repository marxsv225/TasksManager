<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{
header('location:index.php');
}
else{

if(isset($_POST['submit']))
  {
	$nomtache=$_POST['nomtache'];
    $nomclient=$_POST['nomclient'];
    $details=$_POST['details'];
    $dateajout=$_POST['dateajout'];
	$datefin=$_POST['datefin'];
	$statut="en cours";
    $sql="INSERT INTO taches(nom_tache,nom_client,description,date_ajout,date_rendu, statut) VALUES(:nomtache,:nomclient,:details,:dateajout,:datefin, :statut)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':nomtache',$nomtache,PDO::PARAM_STR);
    $query->bindParam(':nomclient',$nomclient,PDO::PARAM_STR);
    $query->bindParam(':details',$details,PDO::PARAM_STR);
    $query->bindParam(':dateajout',$dateajout,PDO::PARAM_STR);
    $query->bindParam(':datefin',$datefin,PDO::PARAM_STR);
    $query->bindParam(':statut',$statut,PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();
    if($lastInsertId)
    {
		header('location: loading-tasks.php');
    $msg="Tâche enregistrée avec succès !";
    }
    else
    {
    $error="Echec d'enregistrement, veuillez reprendre s'il vous plaît !";
    }

}


	?>
<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	
	<title>RentMarket | Admin </title>

	<!-- Font awesome -->
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<!-- Sandstone Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- Bootstrap Datatables -->
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<!-- Bootstrap social button library -->
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<!-- Bootstrap select -->
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<!-- Bootstrap file input -->
	<link rel="stylesheet" href="css/fileinput.min.css">
	<!-- Awesome Bootstrap checkbox -->
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<!-- Admin Stye -->
	<link rel="stylesheet" href="css/style.css">
<style>
		.errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
		</style>

</head>

<body>
	<?php include('includes/header.php');?>
	<div class="ts-main-content">
	<?php include('includes/leftbar.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<h2 class="page-title">Ajouter d'une tâche</h2>
						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">Infos produit</div>
<?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php }
				else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>

									<div class="panel-body">
									<form method="post" class="form-horizontal" enctype="multipart/form-data">
										<div class="form-group">
											<label class="col-sm-2 control-label">Nom tâche<span style="color:red">*</span></label>
											<div class="col-sm-4">
												<input type="text" name="nomtache" class="form-control white_bg" required>
											</div>
											<label class="col-sm-2 control-label">Nom client<span style="color:red">*</span></label>
											<div class="col-sm-4">
												<input type="text" name="nomclient" class="form-control white_bg" required>
											</div>
										</div>

										<div class="hr-dashed"></div>
										<div class="form-group">
											<label class="col-sm-2 control-label">Description<span style="color:red">*</span></label>
											<div class="col-sm-10">
												<textarea class="form-control white_bg" name="details" rows="3" required></textarea>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-2 control-label">Date d'ajout<span style="color:red">*</span></label>
											<div class="col-sm-4">
												<input type="date" name="dateajout" class="form-control white_bg" required>
											</div>
											<label class="col-sm-2 control-label">Date de rendu <span style="color:red">*</span></label>
											<div class="col-sm-4">
												<input type="date" name="datefin" class="form-control white_bg" required>
											</div>
										</div>

										<div class="hr-dashed"></div>

										<div class="form-group">
											<div class="col-sm-8 col-sm-offset-2">
												<button class="btn btn-default" type="reset">Annuler</button>
												<button class="btn btn-primary" name="submit" type="submit">Enregistrer</button>
											</div>
										</div>
									</div>
								</div>

										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Loading Scripts -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>
</body>
</html>
<?php } ?>
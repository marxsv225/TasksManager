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
    $statut=$_POST['statut'];
	$id=intval($_GET['id']);

	if ($statut == '') {

		$sql="update taches set nom_tache=:nomtache,nom_client=:nomclient,description=:details,date_ajout=:dateajout,date_rendu=:datefin where id_tach=:id ";

		$query = $dbh->prepare($sql);
		$query->bindParam(':nomtache',$nomtache,PDO::PARAM_STR);
		$query->bindParam(':nomclient',$nomclient,PDO::PARAM_STR);
		$query->bindParam(':details',$details,PDO::PARAM_STR);
		$query->bindParam(':dateajout',$dateajout,PDO::PARAM_STR);
		$query->bindParam(':datefin',$datefin,PDO::PARAM_STR);
		$query->bindParam(':id',$id,PDO::PARAM_STR);
		$query->execute();

		header('location: manage-tasks.php');
		$msg="Données mises à jour avec succès !";
	}
	else {

		$sql="update taches set nom_tache=:nomtache,nom_client=:nomclient,description=:details,date_ajout=:dateajout,date_rendu=:datefin,statut=:statut where id_tach=:id ";

		$query = $dbh->prepare($sql);
		$query->bindParam(':nomtache',$nomtache,PDO::PARAM_STR);
		$query->bindParam(':nomclient',$nomclient,PDO::PARAM_STR);
		$query->bindParam(':details',$details,PDO::PARAM_STR);
		$query->bindParam(':dateajout',$dateajout,PDO::PARAM_STR);
		$query->bindParam(':datefin',$datefin,PDO::PARAM_STR);
		$query->bindParam(':statut',$statut,PDO::PARAM_STR);
		$query->bindParam(':id',$id,PDO::PARAM_STR);
		$query->execute();

		header('location: tasks-finished.php');
		$msg="Données mises à jour avec succès !";
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
	
	<title>Mon gestionnaire | Mise à jour </title>

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
					
						<h2 class="page-title">Modification d'une tâche</h2>

						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">Tâche</div>
									<div class="panel-body">
<?php if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php } ?>
<?php
	$id=intval($_GET['id']);
	$sql ="SELECT * from taches where id_tach =:id";
	$query = $dbh -> prepare($sql);
	$query-> bindParam(':id', $id, PDO::PARAM_STR);
	$query->execute();
	$results=$query->fetchAll(PDO::FETCH_OBJ);
	$cnt=1;
	if($query->rowCount() > 0)
	{
	foreach($results as $result)
{	?>

									<form method="post" class="form-horizontal" enctype="multipart/form-data">
										<div class="form-group">
											<label class="col-sm-2 control-label">Tâche<span style="color:red">*</span></label>
											<div class="col-sm-4">
												<input type="text" name="nomtache" class="form-control" value="<?php echo htmlentities($result->nom_tache)?>" required>
											</div>
											<label class="col-sm-2 control-label">Client<span style="color:red">*</span></label>
											<div class="col-sm-4">
												<input type="text" name="nomclient" class="form-control" value="<?php echo htmlentities($result->nom_client)?>" required>
											</div>
										</div>

									<div class="hr-dashed"></div>
										<div class="form-group">
											<label class="col-sm-2 control-label">Détails<span style="color:red">*</span></label>
											<div class="col-sm-10">
												<textarea class="form-control" name="details" rows="3" required><?php echo htmlentities($result->description);?></textarea>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-2 control-label">Date d'ajout<span style="color:red">*</span></label>
											<div class="col-sm-4">
												<input type="text" name="dateajout" class="form-control" value="<?php echo htmlentities($result->date_ajout);?>" required>
											</div>
											<label class="col-sm-2 control-label">Date de rendu<span style="color:red">*</span></label>
											<div class="col-sm-4">
												<input type="text" name="datefin" class="form-control" value="<?php echo htmlentities($result->date_rendu);?>" required>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label">Terminée</label>
											<div class="col-sm-10">
												<?php if ($result->statut == 'en cours') { ?>
											<div class="checkbox checkbox-inline">
												<input type="checkbox" id="powerdoorlocks" name="statut" value="terminée">
												<label for="powerdoorlocks"></label>
											</div>
											<?php } else {?>
											<div class="checkbox checkbox-inline">
												<input type="checkbox" id="powerdoorlocks" name="statut" checked value="terminée">
												<label for="powerdoorlocks"></label>
											</div>
											<?php }?>
										</div>
									<div class="hr-dashed"></div>
										<div class="form-group">
											<div class="col-sm-8 col-sm-offset-2" >
												<button class="btn btn-primary" name="submit" type="submit" style="margin-top:4%">Sauvegarder modification</button>
											</div>
										</div>
				<?php }} ?>
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
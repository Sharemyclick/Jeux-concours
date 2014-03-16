<?php error_reporting(0); ?>
<?php
// On inclut la page de paramètre de connection.
include('conf.php');
setlocale (LC_TIME, 'fr_FR.utf8','fra'); 

//TODO
$_SESSION['jeux_concours_id'] = '1';

// management of uncorrect format data
if(isset($_SESSION['errorType'])){
	switch($_SESSION['errorType']){
		case "mail":
			$message = "Le mail a un format incorrect.";
		break;
		case "firstname":
			$message = "Le prénom a un format incorrect.";
		break;
		case "lastname":
			$message = "Le nom a un format incorrect.";
		break;
		case "city":
			$message = "La ville a un format incorrect.";
		break;
		case "postal_code":
			$message = "Le code postal a un format incorrect.";
		break;
		case "blacklist":
			$message = "Le nom de domaine est incorrect.";
		break;
		case "already_played":
			$message = "Vous êtes déjà inscrit au jeu concours.";
		break;
	}
	unset($_SESSION['errorType']);
}else{//TODO see if we want to reset the form when refresh the page (f5 key for instance). If we want it, uncomment line below
//session_unset();
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sharemydeal des deal à GoGo</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Bootstrap -->
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="css/formpage1.css">
		<link rel="stylesheet" type="text/css" href="css/stickyfooter.css">

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		  <script src="../../assets/js/html5shiv.js"></script>
		  <script src="../../assets/js/respond.min.js"></script>
		<![endif]-->
		<!-- TradeDoubler site verification 2346518 -->		
	</head>
	
<body>
<!-- Wrap all page content here -->
<div id="wrap">

<!--  We GET all elements from the form in order to allow the prefilling in the url -->
<?php
$firstname = $GET_['firstname'];
$lastname = $GET_['lastname'];
$gender = $GET_['gender'];
$email = $GET_['email'];
$postal_code = $GET_['postal_code'];
$city = $GET_['city'];
$dob =  $GET_['yyyy'].'-'.$GET_['mm'].'-'.$GET_['dd'];
$pid_id = $GET_['pid'];
?>
	
	<div class="container">
		<form class="form-horizontal" action="register.php" method="POST">
			<!--  Starts form first row -->
			<div class="row">
				<div class="col-lg-4">
					<label class="control-label">Prenom:*</label>
						<input type="text" name="firstname" id="firstname" value='<?php echo $_SESSION['firstname']; ?>' class="form-control" placeholder="Prenom" pattern="^[a-zA-Z]{3,20}$" />
				</div>
				<div class="col-lg-4">
					<label class="control-label">Nom:*</label>
						<input type="text" name="lastname" id="lastname" value='<?php echo $_SESSION['lastname']; ?>' class="form-control" placeholder="Nom" pattern="^[a-zA-Z]{3,20}$" required />
				</div>
				<div class="col-lg-4">
					<label class="control-label">Civilité:*</label>
						<select name="gender" class="form-control" required>
							<option value=<?php echo $_SESSION['gender']; ?>><?php echo $_SESSION['gender']; ?></option>
							<option value="Mr">Mr</option>
							<option value="Mlle">Mlle</option>
							<option value="Mme">Mme</option>
						</select>
				</div>
			</div>
			<!--  Ends form first row -->
			<!--  Start form second row -->
			<div class="row">
				<div class="col-lg-3">
					<label class="control-label">Jour:*</label>
						<select name="dd" class="form-control" placeholder="JJ" required>
							<?php for($i = 1;$i <= 31; $i++){?>
							<option <?php echo ($_SESSION['dd'] == $i)?"selected":""; ?> value="<?php echo($i < 10)?"0".$i:$i; ?>"><?php echo $i;?></option>
							<?php }?>
							
						</select>
				</div>
				<div class="col-lg-4">
					<label class="control-label">Mois:*</label>
						<select name="mm" class="form-control" placeholder="MM" required>
							<?php for($i = 1;$i <= 12; $i++){?>
							<option <?php echo ($_SESSION['mm'] == $i)?"selected":""; ?> value="<?php echo date("m", mktime(0, 0, 0, $i, 1));?>"><?php echo ucfirst(strftime("%B",mktime(0, 0, 0, $i, 1))); ?></option>
							<?php }?>
						</select>
				</div>
				<div class="col-lg-5">
					<label class="control-label">Année:*</label>
						<select name="yyyy" class="form-control" placeholder="AAAA" required>
							<?php for($i = date("Y")-18;$i >= date("Y")-50; $i--){?>
							<option <?php echo ($_SESSION['yyyy'] == $i)?"selected":""; ?> value="<?php echo $i;?>"><?php echo $i;?></option>
							<?php }?>
						</select>
				</div>
			</div>
			<!--  Ends form second row -->
			<!--  Start form third row -->
			<div class="row">
				<div class="col-lg-12">
					<label class="control-label">Email:*</label>
						<input type="email" name="email" id="email" value='<?php echo $_SESSION['email']; ?>' class="form-control" placeholder="Email" required />
				</div>
			</div>
			<!--  Ends form third row -->
			<!--  Starts form fourth row -->
			<div class="row">
				<div class="col-lg-6">
					<label class="control-label">Code Postal:*</label>
						<input type="text" name="postal_code" id="postal_code" value='<?php echo $_SESSION['postal_code']; ?>' class="form-control" placeholder="code postal" pattern="^[0-9]{5}$" required />
				</div>
				<div class="col-lg-6">
					<label class="control-label">Ville:*</label>
						<input type="text" name="city" id="city" value='<?php echo $_SESSION['city']; ?>' class="form-control" placeholder="Ville" pattern="^[a-zA-Z]{3,20}$" required />
				</div>
			</div>
			<!--  Ends form fourth row -->
			<!--  Starts form fifth row HIDDEN elements -->
			<div class="row">
				<div class="col-lg-4">
					<input type="hidden" name="active" id="active" value="1"/>
				</div>
				<div class="col-lg-4">
					<input type="hidden" name="regdate2" id="regdate2" value="
					<?php
					// On met détermine le fuseau horaire. Disponible depuis PHP 5.1
					date_default_timezone_set('UTC');
					// On fait le print de quelque chose similaire: 04 07 2013
					echo date('Y-m-d');
					?>"/>
				</div>
				<div class="col-lg-4">
					<input type="hidden" name="pid_id" id="pid_id" value="<?php echo $_SESSION['pid_id'];/*TODO get from url ?*/?>"/>
					<input type="hidden" name="jeux_concours_id" id="jeux_concours_id" value="<?php echo $_SESSION['jeux_concours_id'];?>"/>
				</div>
			</div>
			<!--  Ends form fifth row -->
			<div class="checkbox">
				<label>
					<input type="checkbox" name="terms" id="terms" value="1" required>
					<p class="conditions">Je souhaite reçevoir les offres promotionnelles de Sharemydeal ainsi que celles de ces partenaires
					</p>
				</label>
			</div>
				<input type="hidden" name="step" id="step" value="1"/>
				<button type="submit" class="btn btn-success" name="submit">Je participe</button>
				<?php if($message != ""){?>
				<span style="color:red;"><?php echo $message;?></span>
				<?php }?>
		</form>
		
		
	</div>
	
<div id="push"></div>
</div>
<!-- End Wrap
================================================== -->

<!-- Start Sticky Footer
================================================== -->
<footer>
<div id="footer">
	<div class="container">
		<p class="muted credit">&copy;  2013 &bull; <a href="reglement.html">r&egrave;glement</a> &bull; <a href="termes-et-conditions.html">Termes et conditions</a> &bull; <a href="politique-confidentialite.html">Politique de confidentialit&eacute;</a> &bull; <a href="nous-contacter.html">Nous contacter</a> &bull; <a href="desabonner.php">Se d&eacute;sabonner</a></p>
    </div>
</div>
</footer>	

<!-- Les javascripts
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="http://code.jquery.com/jquery.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="js/bootstrap.js"></script>

<script src="js/jquery.backstretch.min.js"></script>
    <script>
		/*
		* Here is an example of how to use Backstretch as a slideshow.
		* Just pass in an array of images, and optionally a duration and fade value.
		*/
		$.backstretch("images/jeux1bis.jpg");
	</script>

</body>
</html>

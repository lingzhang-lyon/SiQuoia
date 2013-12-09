<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_player_logged_in(); ?>
<?php
	$player=find_player_by_id($_SESSION["player_id"]);
	$errors=null;
	if (isset($_POST['submit'])) {
		$required_fields = array("amount");
		validate_presences($required_fields);	

		$credits=$player["credits"];
		$amount=$_POST["amount"];
		//update credits
		$query  = "UPDATE players SET ";
		$query .= "credits = {$amount} + {$credits} ";
		$query .= "WHERE id ={$_SESSION['player_id']}; ";
		$result = mysqli_query($connection, $query);
		confirm_query($result);
		
		if ($result) {
		$_SESSION["message"]="Thank you for your payment!";
		redirect_to("player.php");
		} else {
			// Failure
			$_SESSION["message"] = "Payment failed.";
		}

	}
?>

<?php $layout_context = "player"; ?>
<?php include("../includes/layouts/header.php"); ?>

<div id="main">

<div id="navigation">
<div class="wrapper">
<br />
<a href="player.php">&laquo; Back</a><br />

<br />

</div>
</div>


<div id="page">


<?php echo message(); ?>
<?php echo form_errors($errors); ?>

<h2>Please select your payment: <?php echo htmlentities($player["username"]); ?></h2>
<form action="player_make_payment.php" method="post">

<p>Payment amount:
<input type="radio" name="amount" value=100 /> $9.99 For 100 Credits
&nbsp;
<input type="radio" name="amount" value=200 /> $18.99 For 200 Credits
</p>


<input type="submit" name="submit" value="Submit your payment" />
</form>
<a href="player.php">Cancel</a>
</br> </br>


</div>

</div>

<?php include("../includes/layouts/footer.php"); ?>
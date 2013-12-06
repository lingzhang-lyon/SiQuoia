<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_player_logged_in(); 
	$player=find_player_by_id ($_SESSION["player_id"]);
?>


<?php
if (isset($_POST['submit'])) {
	// Process the form
	
	// validations
	$required_fields = array("level3categoryId","mode");
	validate_presences($required_fields);
	
	if (empty($errors) && $player['credits']>=10) {
		
		// Perform Update

		$player_id = $_SESSION["player_id"];
		$category_id = mysql_prep($_POST["level3categoryId"]);
		$mode = mysql_prep($_POST["mode"]);
		
	
		$query  = "INSERT INTO quiz (";
		$query .= "  player_id, category_id, mode";
		$query .= ") VALUES (";
		$query .= "  {$player_id}, {$category_id},'{$mode}'";
		$query .= ")";
		$result = mysqli_query($connection, $query);

		if ($result && mysqli_affected_rows($connection) >= 0) {
			// Success  choose quiz, player's credit will reduce by 10, then go to create_quiz.php
			$query  = "UPDATE players SET ";
			$query .= "credits ={$player['credits']} - 10 ";
			$query .= "WHERE id={$player_id}";
			$result2 = mysqli_query($connection, $query);
			confirm_query($result2);
			
			$query  = "select id from quiz ";
			$query .= "WHERE player_id={$player_id} ";
			$query .= "order by id desc ";
			$query .= "limit 1; ";
			$result3 = mysqli_query($connection, $query);
			confirm_query($result3);
			$selected_quiz = mysqli_fetch_assoc ($result3);
			$_SESSION["quiz_id"]=$selected_quiz['id'];
			redirect_to("player_create_quiz.php");
		} else {
			// Failure
			$_SESSION["message"] = "Choose quiz failed.";
		}
			
	}
			
} else {
	// This is probably a GET request
	
} // end: if (isset($_POST['submit']))

?>

<?php $layout_context = "player"; ?>
<?php include("../includes/layouts/header.php"); ?>

<div id="main">
  <div id="navigation">
    &nbsp;
  </div>
  <div id="page">
			
		<?php echo message(); ?>
		<?php echo form_errors($errors); ?>
		<?php if($player["credits"]<10) {
			  echo "You don't have enough credits, do you want to make a payment? "; 
			  echo "<a href=\"player_make_payment.php\">Make Payment</a>";
		}
		?>
	   
		
		<h2>You can choose a quiz here <?php echo htmlentities($player["username"]); ?></h2>
		<form action="player_choose_quiz.php" method="post">
<p> Each quiz cost 10 credits, please choose the category and mode for your quiz.</p>
		<p>Category:
		<?php 
			echo "<select name=\"level3categoryId\" >";
			$level3category_set = find_all_level3_category();
			while($level3category = mysqli_fetch_assoc($level3category_set)) { 
				echo "<option value ={$level3category['id']}> {$level3category['category_name']} </option> ";
			}
			echo "</select>";
		?>
		</p>
		<p>Mode:
		<input type="radio" name="mode" value="learning" />Learning Mode
		&nbsp;
		<input type="radio" name="mode" value="challenge" />Challenge Mode
		</p>
        <input type="submit" name="submit" value="Create a quiz" /> 


		<a href="player.php">Cancel</a>
		
		
		
	</div>
</div>

<?php include("../includes/layouts/footer.php"); ?>

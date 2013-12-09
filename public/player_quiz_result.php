<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_player_logged_in(); 
	$player = find_player_by_id ($_SESSION["player_id"]);
	$quiz =find_quiz_by_id ($_GET["quizId"]);
	?>


<?php	

	$correct_rate=$quiz["correct_rate"];
	
?>

<?php $layout_context = "player"; ?>
<?php include("../includes/layouts/header.php"); ?>

<div id="main">
  <div id="navigation" class="wrapper">
	<br />
	<a href="player.php">&laquo; Back to Dashboard</a><br />

	<br />
  </div>
  <div id="page" class="wrapper">
			
		<?php echo message(); ?>
		<?php echo form_errors($errors); ?>

		
		<h2><?php echo htmlentities($player["username"]); ?>, The results of the quiz you have taken are: </h2>
		<h3> Correct Rate:<?php echo htmlentities(100*$correct_rate); ?> % </h3>

       <?php		    
		   $player_answered_question_set=find_player_answered_questions($quiz['id']);
		   $count=1;
			while ($quiz_question=mysqli_fetch_assoc($player_answered_question_set)){
				echo quiz_question_for_result($quiz_question, $count);
				$count++;
				
			}
		?>

		
       

		<a href="player.php">Back to Player Dashboard</a>
		

		
	</div>
</div>

<?php include("../includes/layouts/footer.php"); ?>

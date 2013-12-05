<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_player_logged_in(); 
	$player = find_player_by_id ($_SESSION["player_id"]);
	?>


<?php
	$player_id = $_SESSION["player_id"];
	$quiz_id = $_SESSION["quiz_id"];

	$player_answered_question_set=find_player_answered_questions($quiz_id);
	$count=0; 
	$correct_count=0;
	while ($quiz_question=mysqli_fetch_assoc($player_answered_question_set)){
	    if($quiz_question['correct_option']===$quiz_question['player_answer']){
			$correct_count++;
		}
		$count++;
	}
	$correct_rate=(double)100*$correct_count/$count;
?>

<?php $layout_context = "player"; ?>
<?php include("../includes/layouts/header.php"); ?>

<div id="main">
  <div id="navigation" class="wrapper">
    &nbsp;
  </div>
  <div id="page" class="wrapper">
			
		<?php echo message(); ?>
		<?php echo form_errors($errors); ?>

		
		<h2><?php echo htmlentities($player["username"]); ?>, The results of the quiz you have taken are: </h2>
		<h3> Correct Rate:<?php echo htmlentities($correct_rate); ?> % </h3>

       <?php		    
		   $player_answered_question_set=find_player_answered_questions($quiz_id);
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

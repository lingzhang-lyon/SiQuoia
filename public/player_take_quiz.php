<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_player_logged_in(); 
	$player = find_player_by_id ($_SESSION["player_id"]);
	?>


<?php
if (isset($_POST['submit'])) {
	// Process the form
	// Perform insert
	$quiz_question_set = find_questions_by_quiz_id($_SESSION["quiz_id"]);
	//find all the questions contained in this quiz
	$player_id = $_SESSION["player_id"];
	$quiz_id = $_SESSION["quiz_id"];
	
	while($quiz_question=mysqli_fetch_assoc($quiz_question_set)){
		$question_id=$quiz_question['id'];
		$required_fields = array('answer_for_question_'.$question_id);// validations
		validate_presences($required_fields);		
		if (empty($errors) ) {
			$player_answer=$_POST['answer_for_question_'.$question_id];
			$query  = "INSERT INTO question_playeranswer (";
			$query .= "  player_id, quiz_id, question_id,player_answer";
			$query .= ") VALUES (";
			$query .= "  {$player_id}, {$quiz_id},{$question_id}, {$player_answer}";
			$query .= ")";
			$result = mysqli_query($connection, $query);
			confirm_query($result);	
			}
		else {//if not complete will not go to result.
			$_SESSION["message"]="you must select answers for all the question befor submit";
			redirect_to ("player_take_quiz.php");
		}
	}
	
	redirect_to ("player_quiz_result.php");
		
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

		
		<h2>Taking your quiz now <?php echo htmlentities($player["username"]); ?></h2>
		<form action="player_take_quiz.php" method="post">
       <?php
		   $quiz_question_set = find_questions_by_quiz_id($_SESSION["quiz_id"]);
		    $count=1;
			while ($quiz_question=mysqli_fetch_assoc($quiz_question_set)){
				echo "Question".$count." :&nbsp";
				echo quiz_question_for_selection($quiz_question);
				$count++;
			}
		?>

		
        <input type="submit" name="submit" value="Submit" /> 


		<a href="player.php" onclick="return confirm('Are you sure? Your answer will not be recorded.');">Cancel</a>
		
		</form>
		
	</div>
</div>

<?php include("../includes/layouts/footer.php"); ?>

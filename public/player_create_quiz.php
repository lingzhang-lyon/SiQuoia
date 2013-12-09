<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_player_logged_in(); 
	$player=find_player_by_id ($_SESSION["player_id"]);
	$quiz=find_quiz_by_id($_SESSION["quiz_id"]);
	
?>
<?php	
	$questions_per_quiz=5;  //now we just show 5 questions, later could change to 10 or 100

	
	$query  = "select id, category_id from questions ";
	$query .= "where category_id = {$quiz['category_id']} ";
	$query .= "order by rand() limit {$questions_per_quiz}; ";
	$random_selected_question_set = mysqli_query($connection, $query);
	confirm_query($random_selected_question_set); //get random selected questions from the category
	
	while ($selected_question=mysqli_fetch_assoc($random_selected_question_set)){		
		
		$query  = "INSERT INTO quiz_question (";
		$query .= "quiz_id, question_id ";
		$query .= ") VALUES (";
		$query .= "  {$quiz['id']}, {$selected_question['id']} ";
		$query .= ")";
		$insert_result = mysqli_query($connection, $query);
		confirm_query($insert_result);
		
	}
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

        <h2> The quiz you selected is created, want to start now?</h2> 

		<a href="player_take_quiz.php">Start now </a>
		
		
		
	</div>
</div>

<?php include("../includes/layouts/footer.php"); ?>

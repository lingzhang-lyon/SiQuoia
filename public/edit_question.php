<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php
	$current_question=find_question_by_id ($_GET["questionId"]);
	
	
	if (isset($_POST['submit'])) {
		// Process the form
		
		$question_id = urlencode($_GET["questionId"]);
		$content = mysql_prep($_POST["content"]);
		$option1 = mysql_prep($_POST["option1"]);
		$option2 = mysql_prep($_POST["option2"]);
		$option3 = mysql_prep($_POST["option3"]);
		$option4 = mysql_prep($_POST["option4"]);
		$correct_option = $_POST["correct_option"];
		$status= mysql_prep($_POST["status"]);
		$level3categoryId=mysql_prep($_POST["level3categoryId"]);
		
		
		// validations
		$required_fields = array("content", "option1", "option2","option3","option4","correct_option","status","level3categoryId");
		validate_presences($required_fields);
		
		
		if (empty($errors)) {
			
			// Perform Update
			
			$query  = "UPDATE questions SET ";
			$query .= "question_content = '{$content}', ";
			$query .= "option1 = '{$option1}', ";
			$query .= "option2 = '{$option2}', ";
			$query .= "option3 = '{$option3}', ";
			$query .= "option4 = '{$option4}', ";
			$query .= "correct_option = {$correct_option}, ";
			$query .= "status = '{$status}', ";
			$query .= "category_id = {$level3categoryId} ";
			$query .= "WHERE id = {$question_id} ";
			$query .= "LIMIT 1";
			$result = mysqli_query($connection, $query);
			
			if ($result && mysqli_affected_rows($connection) == 1) {
				// Success
				$_SESSION["message"] = "Question updated.";
				redirect_to("manage_questions.php?question={$question_id}");
			} else {
				// Failure
				$_SESSION["message"] = "Question update failed.";
			}
			
		}
	} else {
		// This is probably a GET request
		
	} // end: if (isset($_POST['submit']))
	
	?>

<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

<div id="main">

<div id="navigation">
<div class="wrapper">
<br />
<a href="manage_questions.php">&laquo; Back</a><br />

<br />

</div>
</div>


<div id="page">


<?php echo message(); ?>
<?php echo form_errors($errors); ?>

<h2>Edit Question: <?php echo htmlentities($current_question["id"]); ?></h2>
<form action="edit_question.php?questionId=<?php echo urlencode($current_question["id"]); ?>" method="post">

<p>Submitted by player:
<?php $player=find_player_by_id($current_question["player_id"]);
	echo htmlentities($player["username"]); //show question submittee
	?><br />
</p>

<p>Category:

<?php
	//  could show leve1 and level2 category later
	//$question_category=find_category_by_id ($current_question["category_id"]);
	//echo $question_category["category_name"];
	
?>	


<?php	
	echo "<select name=\"level3categoryId\" >";
	$level3category_set = find_all_level3_category();
	while($level3category = mysqli_fetch_assoc($level3category_set)) { 
		echo "<option value ={$level3category['id']}";
		if ($level3category['id'] == $current_question["category_id"]) {
			echo " selected";
		}
		echo "> {$level3category['category_name']} </option> ";
	}
    echo "</select>";
?>



</p>


<p>Content:<br />
<textarea name="content" rows="4" cols="60"><?php echo htmlentities($current_question["question_content"]); ?></textarea>
</p>

<p>Option1:<br />
<textarea name="option1" rows="2" cols="60"><?php echo htmlentities($current_question["option1"]); ?></textarea>
</p>

<p>Option2:<br />
<textarea name="option2" rows="2" cols="60"><?php echo htmlentities($current_question["option2"]); ?></textarea>
</p>

<p>Option3:<br />
<textarea name="option3" rows="2" cols="60"><?php echo htmlentities($current_question["option3"]); ?></textarea>
</p>

<p>Option4:<br />
<textarea name="option4" rows="2" cols="60"><?php echo htmlentities($current_question["option4"]); ?></textarea>
</p>


<p>Correct Option:
<select name="correct_option">
<?php
	
	
	for($number=1; $number <= 4; $number++) {
		echo "<option value={$number}";
		if ($number == $current_question["correct_option"]) {
			echo " selected";
		}
		echo ">{$number}</option>";
	}
	?>
</select>
</p>

<p>Status:
<input type="radio" name="status" value="approved" <?php if ($current_question["status"] == 'approved') { echo "checked"; } ?> /> approved
&nbsp;
<input type="radio" name="status" value="nonapproved" <?php if ($current_question["status"] == 'nonapproved') { echo "checked"; } ?>/>nonapproved
</p>

<input type="submit" name="submit" value="Edit Question" />
</form>

<a href="manage_questions.php?question=<?php echo urlencode($current_question["id"]); ?>">Cancel</a>
&nbsp;
&nbsp;
<a href="delete_question.php?questionId=<?php echo urlencode($current_question["id"]); ?>" onclick="return confirm('Are you sure?');">Delete Question</a>

</br> </br>

</div>
</div>

</div>

<?php include("../includes/layouts/footer.php"); ?>

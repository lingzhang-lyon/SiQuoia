<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php
	
	$current_category=find_category_by_id ($_GET["categoryId"]);
	
	if (isset($_POST['submit'])) {
		// Process the form
		
		
		$content = mysql_prep($_POST["content"]);
		$option1 = mysql_prep($_POST["option1"]);
		$option2 = mysql_prep($_POST["option2"]);
		$option3 = mysql_prep($_POST["option3"]);
		$option4 = mysql_prep($_POST["option4"]);
		$correct_option = $_POST["correct_option"];
		$level3categoryId=mysql_prep($_POST["level3categoryId"]);
		
		
		// validations
		$required_fields = array("content", "option1", "option2","option3","option4","correct_option","level3categoryId");
		validate_presences($required_fields);
		
		
		if (empty($errors)) {
			
			// Perform Update
			
			$query  = "INSERT into questions ( ";
			$query .= "question_content, option1,option2,option3,option4, correct_option,category_id,status ";
			$query .= " )VALUES (";
			$query .= " '{$content}','{$option1}', '{$option2}', '{$option3}','{$option4}', {$correct_option},{$level3categoryId},'approved'";
			$query .= ")";
			$insert_result = mysqli_query($connection, $query);
			
			if ($insert_result) {
				// Success
				$_SESSION["message"] = "Question submitted.Do you want to submit another question?";
				
			} else {
				// Failure
				$_SESSION["message"] = "Question submition failed.";
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

<h2>Submit A New Question: <?php echo htmlentities($_SESSION["username"]); ?></h2>
<form action="new_question.php?categoryId=<?php echo urlencode($current_category["id"]); ?>" method="post">

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
		if ($level3category['id'] == $current_category["id"]) {
			echo " selected";
		}
		echo "> {$level3category['category_name']} </option> ";
	}
    echo "</select>";
?>
</p>


<p>Content:<br />
<textarea name="content" rows="4" cols="60"></textarea>
</p>

<p>Option1:<br />
<textarea name="option1" rows="2" cols="60"></textarea>
</p>

<p>Option2:<br />
<textarea name="option2" rows="2" cols="60"></textarea>
</p>

<p>Option3:<br />
<textarea name="option3" rows="2" cols="60"></textarea>
</p>

<p>Option4:<br />
<textarea name="option4" rows="2" cols="60"></textarea>
</p>


<p>Correct Option:
<select name="correct_option">
<option value=1>1</option>
<option value=2>2</option>
<option value=3>3</option>
<option value=4>4</option>
</select>
</p>


<input type="submit" name="submit" value="Submit the new question" />
</form>

<a href="player.php">Cancel</a>
</br> </br>

</div>
</div>

</div>

<?php include("../includes/layouts/footer.php"); ?>

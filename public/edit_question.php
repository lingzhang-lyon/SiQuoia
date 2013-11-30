<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_logged_in(); ?>


<?php
	$current_question=find_question_by_id ($_GET["questionId"]);
	
	
	if (isset($_POST['submit'])) {
		// Process the form
		
		$question_id = urlencod($_GET["questionId"]);
		$content = mysql_prep($_POST["content"]);
		$option1 = mysql_prep($_POST["option1"]);
		$option2 = mysql_prep($_POST["option2"]);
		$option3 = mysql_prep($_POST["option3"]);
		$option4 = mysql_prep($_POST["option4"]);
		$correct_answer = (int) $_POST["correct_answer"];
		$status= mysql_prep($_POST["status"]);
		
		
		// validations
		$required_fields = array("content", "option1", "option2","option3","option4","correct_answer","status");
		validate_presences($required_fields);
		
		
		if (empty($errors)) {
			
			// Perform Update
			
			$query  = "UPDATE questions SET ";
			$query .= "content = '{$content}', ";
			$query .= "option1 = '{$option1}', ";
			$query .= "option2 = '{$option2}', ";
			$query .= "option3 = '{$option3}', ";
			$query .= "option4 = '{$option4}', ";
			$query .= "correct_answer = {$correct_answer}, ";
			$query .= "status = '{$status}' ";
			$query .= "WHERE id = {$question_id} ";
			$query .= "LIMIT 1";
			$result = mysqli_query($connection, $query);
			
			if ($result && mysqli_affected_rows($connection) == 1) {
				// Success
				$_SESSION["message"] = "Question updated.";
				redirect_to("manage_question.php?question={$question_id}");
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
<br />
<a href="manage_questions.php">&laquo; Back</a><br />

<br />

</div>


<div id="page">
<?php echo message(); ?>
<?php echo form_errors($errors); ?>

<h2>Edit Question: <?php echo htmlentities($current_question["id"]); ?></h2>
<form action="edit_question.php?question=<?php echo urlencode($current_question["id"]); ?>" method="post">

<p>Submitted by player:
<?php $player=find_player_by_id($current_question["player_id"]);
echo htmlentities($player["username"]); //show question submittee
	?><br />
</p>

<p>Category:

<?php
//
$category=find_category_by_id ($current_question["category_id"]);
echo $category["category_name"];
    /*
	$output ="<select name=\"category\">";
	
	$question= find_question_by_id ($_GET["questionId"]);
	$level1category_set = find_all_level1_category();
	while($level1category = mysqli_fetch_assoc($level1category_set)) {
	$output .="<optgroup label = ";
	$output .="\"{$level1category['category_name']}\">";
	$level2category_set = find_sub_category($level1category["id"]);
	    while($level2category = mysqli_fetch_assoc($level2category_set)) {
		$output .="<optgroup label =";
		$output .="\"{$level2category['category_name']}\">";
		$level3category_set = find_sub_category($level2category["id"]);
		      while($level3category = mysqli_fetch_assoc($level3category_set)) {
			  $output .="<option value=";
			  $output .="\"{$level3category['id']}\">";
			  $output .="{$level3category['category_name']}";
			  if ($level3category['id'] == $category['id']) {
			      $output .= " selected";
		          }
			  $output .="</option>";
			  }
		$output .="</optgroup>";
		}
	$output .="</optgroup></select>";
	}
	return $output;
*/
$output ="<select name=\"category\">";
/*	
	$question= find_question_by_id ($_GET["questionId"]);
	$level1category_set = find_all_level1_category();
	while($level1category = mysqli_fetch_assoc($level1category_set)) {
	$output .="<optgroup label = ";
	$output .="\"{$level1category['category_name']}\">";
	$level2category_set = find_sub_category($level1category["id"]);
	    while($level2category = mysqli_fetch_assoc($level2category_set)) {
		$output .="<optgroup label =";
		$output .="\"{$level2category['category_name']}\">";
		$level3category_set = find_sub_category($level2category["id"]);
		      while($level3category = mysqli_fetch_assoc($level3category_set)) {
			  $output .="<option value=";
			  $output .="\"{$level3category['id']}\">";
			  $output .="{$level3category['category_name']}";
			  if ($level3category['id'] == $category['id']) {
			      $output .= " selected";
		          }
			  $output .="</option>";
			  }
		$output .="</optgroup>";
		}
	$output .="</optgroup></select>";
	}
	*/
	return $output;


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

<p>Option3:<br />
<textarea name="option4" rows="2" cols="60"><?php echo htmlentities($current_question["option4"]); ?></textarea>
</p>


<p>Correct Option:
<select name="correct_option">
<?php
	$question= find_question_by_id ($_GET["questionId"]);
	
	for($number=1; $number <= 4; $number++) {
		echo "<option value={$number}";
		if ($current_question["correct_option"] == $number) {
			echo " selected";
		}
		echo ">{$number}</option>";
	}
	?>
</select>
</p>

<p>Status:
<input type="checkbox" name="radio" value="approved" <?php if ($current_question["status"] == 'approved') { echo "checked"; } ?> /> approved
&nbsp;
<input type="checkbox" name="radio" value="nonapproved" <?php if ($current_question["status"] == 'nonapproved') { echo "checked"; } ?>/>nonapproved
</p>

<input type="submit" name="submit" value="Edit Question" />
</form>



<br />
<a href="manage_question.php?question=<?php echo urlencode($current_question["id"]); ?>">Cancel</a>
&nbsp;
&nbsp;
<a href="delete_page.php?page=<?php echo urlencode($current_question["id"]); ?>" onclick="return confirm('Are you sure?');">Delete Question</a>



</div>
</div>

<?php include("../includes/layouts/footer.php"); ?>

<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>

<?php
  $question = find_question_by_id($_GET["questionId"]);
  if (!$question) {
    // player ID was missing or invalid or 
    // player couldn't be found in database
    redirect_to("manage_questions.php");
  }
  
  $id = $question["id"];
  $query = "DELETE FROM questions WHERE id = {$id} LIMIT 1";
  $result = mysqli_query($connection, $query);

  if ($result && mysqli_affected_rows($connection) == 1) {
    // Success
    $_SESSION["message"] = "Question deleted.";
    redirect_to("manage_questions.php");
  } else {
    // Failure
    $_SESSION["message"] = "Question deletion failed.";
    redirect_to("manage_questions.php");
  }
  
?>

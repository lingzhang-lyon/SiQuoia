<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>


<?php
if (isset($_POST['submit'])) {
  // Process the form
  
  // validations
  $required_fields = array("username", "password");
  validate_presences($required_fields);
  
  $fields_with_max_lengths = array("username" => 30);
  validate_max_lengths($fields_with_max_lengths);
  
  if (empty($errors)) {
    // Perform Create

    $player_username = mysql_prep($_POST["username"]);
    $player_hashed_password = password_encrypt($_POST["password"]);
    
    $query  = "INSERT INTO players (";
    $query .= "  username, hashed_password, membership, credits, points ";
    $query .= ") VALUES (";
    $query .= "  '{$player_username}', '{$player_hashed_password}','trial', 0, 0 ";
    $query .= ")";
    $result = mysqli_query($connection, $query);

    if ($result) {
      // Success
	  $player=find_player_by_username($player_username);
      $_SESSION["player_id"] = $player['id'];
	  $_SESSION["player_username"] = $player_username;
	  $_SESSION["player_hashed_password"] = $player_hashed_password;
      redirect_to("player.php");
    } else {
      // Failure
      $_SESSION["message"] = "Player account creation failed.";
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
	<br />
	<a href="index.php">&laquo; Main Page</a><br />
  </div>
  <div id="page">
    <?php echo message(); ?>
    <?php echo form_errors($errors); ?>
    
    <h2>Registration</h2>
    <form action="registration.php" method="post">
      <p>Username:
        <input type="text" name="username" value="" />
      </p>
      <p>Password:
        <input type="password" name="password" value="" />
      </p>
      <input type="submit" name="submit" value="Create your player account" />
    </form>
    <br />
    <a href="index.php">Cancel</a>
  </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>

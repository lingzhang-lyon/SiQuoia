<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_logged_in(); ?>

<?php
if (isset($_POST['submit'])) {
  // Process the form
  
  // validations
  $required_fields = array("username", "password", "membership");
  validate_presences($required_fields);
  
  $fields_with_max_lengths = array("username" => 30);
  validate_max_lengths($fields_with_max_lengths);
  
  if (empty($errors)) {
    // Perform Create

    $player_username = mysql_prep($_POST["username"]);
    $player_hashed_password = password_encrypt($_POST["password"]);
	$player_membership = $_POST["membership"];
    
    $query  = "INSERT INTO players (";
    $query .= "  username, hashed_password,membership";
    $query .= ") VALUES (";
    $query .= "  '{$player_username}', '{$player_hashed_password}','{$player_membership}'";
    $query .= ")";
    $result = mysqli_query($connection, $query);

    if ($result) {
      // Success
      $_SESSION["message"] = "player created.";
      redirect_to("manage_players.php");
    } else {
      // Failure
      $_SESSION["message"] = "Player creation failed.";
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
    &nbsp;
  </div>
  <div id="page">
    <?php echo message(); ?>
    <?php echo form_errors($errors); ?>
    
    <h2>Create Player</h2>
    <form action="new_player.php" method="post">
      <p>Username:
        <input type="text" name="username" value="" />
      </p>
      <p>Password:
        <input type="password" name="password" value="" />
	  </p>
	  <p>Membership:
		<input type="radio" name="membership" value="trial" /> Trial
		&nbsp;
		<input type="radio" name="membership" value="standard" /> Standard
	  </p>
      <input type="submit" name="submit" value="Create Player" />
    </form>
    <br />
    <a href="manage_players.php">Cancel</a>
  </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>

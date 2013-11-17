<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_logged_in(); ?>

<?php
  $player = find_player_by_id($_GET["id"]);
  
  if (!$player) {
    // player ID was missing or invalid or 
    // player couldn't be found in database
    redirect_to("manage_players.php");
  }
?>

<?php
if (isset($_POST['submit'])) {
  // Process the form
  
  // validations
  $required_fields = array("username", "password", "membership");
  validate_presences($required_fields);
  
  $fields_with_max_lengths = array("username" => 30);
  validate_max_lengths($fields_with_max_lengths);
  
  if (empty($errors)) {
    
    // Perform Update

	$id = $player["id"];
	$player_username = mysql_prep($_POST["username"]);
	$player_hashed_password = password_encrypt($_POST["password"]);
	$player_membership = mysql_prep($_POST["membership"]);
  
    $query  = "UPDATE players SET ";
    $query .= "username = '{$player_username}', ";
    $query .= "hashed_password = '{$player_hashed_password}', ";
	$query .= "membership = '{$player_membership}' ";
    $query .= "WHERE id = {$id} ";
    $query .= "LIMIT 1";
    $result = mysqli_query($connection, $query);

    if ($result 
		//&& mysqli_affected_rows($connection) == 1
		) {
      // Success
      $_SESSION["message"] = "Player updated.";
      redirect_to("manage_players.php");
    } else {
      // Failure
      $_SESSION["message"] = "Player update failed.";
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
    
    <h2>Edit Player: <?php echo htmlentities($player["username"]); ?></h2>
    <form action="edit_player.php?id=<?php echo urlencode($player["id"]); ?>" method="post">
      <p>Username:
        <input type="text" name="username" value="<?php echo htmlentities($player["username"]); ?>" />
      </p>
      <p>Password:
        <input type="password" name="password" value="" />
      </p>
	  <p>Membership:
		<input type="radio" name="membership" value="trial" /> Trial
		&nbsp;
		<input type="radio" name="membership" value="standard" /> Standard
	  </p>
      <input type="submit" name="submit" value="Edit Player" />
    </form>
    <br />
    <a href="manage_players.php">Cancel</a>
  </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>

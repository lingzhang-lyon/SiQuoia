<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_player_logged_in(); 
	$player=find_player_by_id ($_SESSION["player_id"]);
?>
<?php

if (isset($_POST['submit'])) {
  // Process the form
  
  // validations
  //$required_fields = array("user_name","user_email","password");
  $required_fields = array("player_name","password");

  validate_presences($required_fields);
  
  $fields_with_max_lengths = array("player_name" =>20);
  validate_max_lengths($fields_with_max_lengths);
  
  if (empty($errors)) {
    
    // Perform Update

    $id = $player["id"];
    $player_name = mysql_prep($_POST["player_name"]);
    $player_hashed_password = password_encrypt($_POST["password"]);

    $query  = "UPDATE players SET ";
    $query .= "username = '{$player_name}', ";
    $query .= "hashed_password = '{$player_hashed_password}' ";
    $query .= "WHERE id = {$id} ";
    $query .= "LIMIT 1";
    $result = mysqli_query($connection, $query);

    if ($result 
		//&& mysqli_affected_rows($connection) == 1
		) {
      // Success
      $_SESSION["message"] = "Player update successful.";
      redirect_to("player.php");
    } else {
      // Failure
      $_SESSION["message"] = "Player update failed.";
    }
  
  }
} else {
  // This is probably a GET request
  
} // end: if (isset($_POST['submit']))
?>


<?php include("../includes/layouts/header.php"); ?>


<div id="main">
  <div id="navigation">
<br />
<a href="player.php">&laquo; Back</a><br />

<br />
  </div>

  <div id="page">
    <?php echo message(); ?>
    <?php echo form_errors($errors); ?>
    
    <h2>Edit Your Profile: <?php echo htmlentities($player["username"]); ?></h2>
    <form action="player_edit_profile.php?id=<?php echo urlencode($_SESSION['player_id']); ?>" method="post">

		<p><h3>Player Name</h3>&nbsp;
		<input type="text" name="player_name" value="<?php echo htmlentities($player['username']); ?>" />
		</p>		

		<p><h3>Password</h3>&nbsp;
		<input type="password" name="password" value="" />
		</p>
        <p><h3>Membership</h3> &nbsp;
		<?php echo htmlentities($player["membership"]); ?>
		</p>
		<p><h3>Credits Banlance</h3> &nbsp;
		<?php echo htmlentities($player["credits"]); ?>
		</p>
		<p><h3>Points</h3> &nbsp;
		<?php echo htmlentities($player["points"]); ?>
		</p>
		
		<input type="submit" name="submit" value="Edit Player" class="blue" />
    </form>
    <br />
  </div>
</div>
<?php include("../includes/layouts/footer.php"); ?>
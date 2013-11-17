<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>

<?php
  $player = find_player_by_id($_GET["id"]);
  if (!$player) {
    // player ID was missing or invalid or 
    // player couldn't be found in database
    redirect_to("manage_players.php");
  }
  
  $id = $player["id"];
  $query = "DELETE FROM players WHERE id = {$id} LIMIT 1";
  $result = mysqli_query($connection, $query);

  if ($result && mysqli_affected_rows($connection) == 1) {
    // Success
    $_SESSION["message"] = "Player deleted.";
    redirect_to("manage_players.php");
  } else {
    // Failure
    $_SESSION["message"] = "Player deletion failed.";
    redirect_to("manage_players.php");
  }
  
?>

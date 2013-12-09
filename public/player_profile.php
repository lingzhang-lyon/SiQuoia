<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_player_logged_in(); 
	$player=find_player_by_id ($_SESSION["player_id"]);
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
		<?php echo htmlentities($player["username"]); ?>
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
		
		<a href="player_edit_profile.php">Edit your profile</a><br />
    </form>
    <br />
  </div>
</div>
<?php include("../includes/layouts/footer.php"); ?>
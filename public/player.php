<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_player_logged_in(); ?>

<?php $layout_context = "player"; ?>
<?php include("../includes/layouts/header.php"); ?>

<div id="main">
  <div id="navigation">
    &nbsp;
  </div>
  <div id="page">
    <h2>Player Dashbord</h2>
    <p>Welcome to SiQuoia, <?php echo htmlentities($_SESSION["player_username"]); ?>.</p>
    <ul>
		<li><a href="choose_quiz.php">Choose Quiz</a></li>
		<li><a href="new_questions.php">Submit New Questions</a></li>
		<li><a href="edit_players.php">Edit Your Profile</a></li>
		<li><a href="make_payment.php">Make A Payment</a></li>
		<li><a href="redeem_credits.php">Redeem Your Credits</a></li>
		<li><a href="player_logout.php">Logout</a></li>
    </ul>
  </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>

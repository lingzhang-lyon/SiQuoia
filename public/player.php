<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_player_logged_in(); ?>
<?php
$player=find_player_by_id ($_SESSION["player_id"]);

	$query  = "select * from quiz ";
	$query .= "WHERE player_id ={$_SESSION['player_id']}; ";
	$player_taken_quiz_set = mysqli_query($connection, $query);
	//confirm_query($player_taken_quiz_set);	
?>





<?php $layout_context = "player"; ?>
<?php include("../includes/layouts/header.php"); ?>

<div id="main" class="wrapper">
  <div id="navigation">
	<br></br>
	<h2><a href="player_profile.php">
	<?php echo $player["username"]; ?> </a></h2>

		<ul>
		<li><a href="player_choose_quiz.php">Choose Quiz</a></li>
		<li><a href="player_new_question.php">Submit New Questions</a></li>
		<li><a href="player_edit_profile.php">Edit Your Profile</a></li>
		<li><a href="player_make_payment.php">Make A Payment</a></li>
		<li><a href="redeem_credits.php">Redeem Your Credits</a></li>
		<li><a href="player_logout.php">Logout</a></li>
		</ul>
  </div>
  <div id="page" >
<?php echo message(); ?>

    <h2>Player Dashbord</h2>
    <p>Welcome to SiQuoia, <?php echo htmlentities($player["username"]); ?>.</p>
	<p>
	Your Credits Balance are: <?php echo htmlentities($player["credits"]); ?>.
	&nbsp;
	&nbsp;
	Your Current Points are: <?php echo htmlentities($player["points"]); ?>.
	</p>
    
    <h3> Your quiz history </h3>

	<table>
	<tr>
	<th>Quiz Date</th>
	<th>Quiz Category</th>
	<th>Quiz Mode</th>
    </tr>
	<?php 
	   while($player_taken_quiz = mysqli_fetch_assoc($player_taken_quiz_set)) { 
		   $category=find_category_by_id($player_taken_quiz['category_id']);
			$output = "<tr align='center'><td style ='width: 250px;'> <a href='player_quiz_result.php?quizId=";
		    $output .=$player_taken_quiz['id'];
		    $output .="'>".$player_taken_quiz['quiz_date']."</a></td>";
			$output .="<td style ='width: 250px;'>".$category['category_name']."</td>";
			$output .="<td style ='width: 250px;'>".$player_taken_quiz['mode']."</td></tr>";
		   echo $output;
		}
	?>
    </table>

    <br>
    
	<h3> Leader Board </h3>
	<br></br>


  </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>

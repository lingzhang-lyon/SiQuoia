<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_player_logged_in(); 
	$player = find_player_by_id ($_SESSION["player_id"]);
	$quiz=find_quiz_by_id($_SESSION["quiz_id"]);
	?>

<?php	
		
if (isset($_POST['submit'])) {
	
	if($quiz['mode']=='challenge' && date('Y-m-d H:i:s') > $_SESSION['endtime'] ){
		//  
		$_SESSION["message"]="Time is aready up, your quiz result was not recorded";
		$_SESSION['endtime']="";
		redirect_to ("player.php");
	}
	else {
	// Process the form
	// Perform insert
	$quiz_question_set = find_questions_by_quiz_id($_SESSION["quiz_id"]);
	//find all the questions contained in this quiz
	$player_id = $_SESSION["player_id"];
	$quiz_id = $_SESSION["quiz_id"];
	
		//insert player's answer to question_playeranswer table
	while($quiz_question=mysqli_fetch_assoc($quiz_question_set)){
		$question_id=$quiz_question['id'];
		$required_fields = array('answer_for_question_'.$question_id);// validations
		validate_presences($required_fields);		
		if (empty($errors) ) {
			$player_answer=$_POST['answer_for_question_'.$question_id];
			$query  = "INSERT INTO question_playeranswer (";
			$query .= "  player_id, quiz_id, question_id,player_answer";
			$query .= ") VALUES (";
			$query .= "  {$player_id}, {$quiz_id},{$question_id}, {$player_answer}";
			$query .= ")";
			$result = mysqli_query($connection, $query);
			confirm_query($result);	
			}
		else {//if not complete will not go to result.
			$_SESSION["message"]="you must select answers for all the question befor submit";
			redirect_to ("player_take_quiz.php");
		}
	}
	
		//count correct rate, update quiz talbe
	$correct_rate = correct_rate_for_quiz($player_id,$quiz_id);
		$query ="update quiz set ";
		$query .="correct_rate= {$correct_rate} ";
		$query .="where id={$quiz_id}; ";
		$result = mysqli_query($connection, $query);
		confirm_query($result);
		
      //update player's points accordingly
	$new_points =$player["points"] + accumulated_points_for_quiz($player_id,$quiz_id);
		
		$query ="update players set ";
		$query .="points = {$new_points} ";
		$query .="where id={$player_id}; ";
		$result = mysqli_query($connection, $query);
		confirm_query($result);
		
		
	redirect_to ("player_quiz_result.php?quizId={$quiz_id}");
	}
		
} else {
	//not click submit, when the page was load for the first time
	$when_end = mktime(date("H"),date("i")+5,date("s"),date("m"),date("d"),date("Y"));
	$endtime=date('Y-m-d H:i:s', $when_end);
	//$_SESSION["message"]="end time set up";
	$_SESSION["endtime"]=$endtime;
	
	//}
} // end: if (isset($_POST['submit']))
?>




<?php $layout_context = "player"; ?>
<?php include("../includes/layouts/header.php"); ?>

<script>
function Timer(maxtime,id,callback){
	//maxtime：时间，单位s
	//id：显示计时器信息的容器id
	//callback：计时器结束回调
    var tmp
    function CountDown() {
        if (maxtime >= 0) {
            hours = Math.floor(maxtime / (60 * 60));
            tmp = maxtime - hours * 60 * 60 ;
            minutes = Math.floor(tmp / (60 ));
            tmp = tmp - minutes * 60;
            seconds = tmp
            msg = "You still have" + hours + " hour " + minutes + " minutes" + seconds + " seconds to submit "
            document.getElementById(id).innerHTML = msg;
            maxtime -= 1;
        }
        else {
            clearInterval(timer);
            if(typeof callback=="function")callback();//执行倒计时完成后的回调
        }
    }
    var timer = setInterval(function(){CountDown()}, 1000);
}
window.onload=function(){
	new Timer(300,'timer1',function(){document.getElementById("timer1").innerHTML = "Time is up!";});
	
}
</script>


<div id="main">
  <div id="navigation">
    &nbsp;
  </div>
  <div id="page" class ="wrapper" >
   
		<?php echo message(); ?>
		<?php echo form_errors($errors); ?>
		
		<h2>Taking your quiz now <?php echo htmlentities($player["username"]); ?></h2>
	<?php 
		if ($quiz['mode']=='challenge') { ?>
		 <h3> You are in challenge mode</h3>
		<div id="timer1" style="color:red; font-size:18px"></div>
	<?php }
		else{ ?>
		<h3> You are in challenge mode</h3>
	<?php } ?>

		<form action="player_take_quiz.php" method="post">
        
       <?php
		   $quiz_question_set = find_questions_by_quiz_id($_SESSION["quiz_id"]);
		    $count=1;
			while ($quiz_question=mysqli_fetch_assoc($quiz_question_set)){
				echo "</br> Question".$count." :&nbsp";
				echo quiz_question_for_selection($quiz_question);
				$count++;
			}
		?>
         
		
        <input type="submit" name="submit" value="Submit" /> 


		<a href="player.php" onclick="return confirm('Are you sure? Your answer will not be recorded.');">Cancel</a>
		
		</form>
		
	</div>
</div>

<?php include("../includes/layouts/footer.php"); ?>

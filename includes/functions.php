<?php  //functions for siquoia

	function redirect_to($new_location) {
	  header("Location: " . $new_location);
	  exit;
	}

	function mysql_prep($string) {
		global $connection;
		
		$escaped_string = mysqli_real_escape_string($connection, $string);
		return $escaped_string;
	}
	
	function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed.");
		}
	}

	function form_errors($errors=array()) {
		$output = "";
		if (!empty($errors)) {
		  $output .= "<div class=\"error\">";
		  $output .= "Please fix the following errors:";
		  $output .= "<ul>";
		  foreach ($errors as $key => $error) {
		    $output .= "<li>";
				$output .= htmlentities($error);
				$output .= "</li>";
		  }
		  $output .= "</ul>";
		  $output .= "</div>";
		}
		return $output;
	}
	
	function find_all_subjects($public=true) {
		global $connection;
		
		$query  = "SELECT * ";
		$query .= "FROM subjects ";
		if ($public) {
			$query .= "WHERE visible = 1 ";
		}
		$query .= "ORDER BY position ASC";
		$subject_set = mysqli_query($connection, $query);
		confirm_query($subject_set);
		return $subject_set;
	}
	
	function find_pages_for_subject($subject_id, $public=true) {
		global $connection;
		
		$safe_subject_id = mysqli_real_escape_string($connection, $subject_id);
		
		$query  = "SELECT * ";
		$query .= "FROM pages ";
		$query .= "WHERE subject_id = {$safe_subject_id} ";
		if ($public) {
			$query .= "AND visible = 1 ";
		}
		$query .= "ORDER BY position ASC";
		$page_set = mysqli_query($connection, $query);
		confirm_query($page_set);
		return $page_set;
	}
	
	function find_all_admins() {
		global $connection;
		
		$query  = "SELECT * ";
		$query .= "FROM admins ";
		$query .= "ORDER BY username ASC";
		$admin_set = mysqli_query($connection, $query);
		confirm_query($admin_set);
		return $admin_set;
	}
	
	function find_all_players() {
		global $connection;
		
		$query  = "SELECT * ";
		$query .= "FROM players ";
		$query .= "ORDER BY username ASC";
		$player_set = mysqli_query($connection, $query);
		confirm_query($player_set);
		return $player_set;
	}
	
	function find_all_level1_category() {
		global $connection;
		
		$query  = "SELECT * ";
		$query .= "FROM categories ";
		$query .= "WHERE category_level = 1 ";
		$query .= "ORDER BY category_name ASC";
		$category1_set = mysqli_query($connection, $query);
		confirm_query($category1_set);
		return $category1_set;
	}
	
	function find_all_level3_category() {
		global $connection;
		
		$query  = "SELECT * ";
		$query .= "FROM categories ";
		$query .= "WHERE category_level = 3 ";
		$query .= "ORDER BY category_name ASC";
		$category3_set = mysqli_query($connection, $query);
		confirm_query($category3_set);
		return $category3_set;
	}
	
	function find_questions_by_category($category_id) {
		global $connection;
		
		$safe_category_id = mysqli_real_escape_string($connection, $category_id);
		
		$query  = "SELECT * ";
		$query .= "FROM questions ";
		$query .= "WHERE category_id = {$safe_category_id} ";
		$query .= "ORDER BY id ASC";
		$question_set = mysqli_query($connection, $query);
		confirm_query($question_set);
		return $question_set;
	}
	
	
	function find_sub_category($category_id) {
		global $connection;
		
		$safe_category_id = mysqli_real_escape_string($connection, $category_id);
		
		$query  = "SELECT * ";
		$query .= "FROM categories ";
		$query .= "WHERE parent_category_id = {$safe_category_id} ";
		$query .= "ORDER BY category_name ASC";
		$category_set = mysqli_query($connection, $query);
		confirm_query($category_set);
		return $category_set;
	}
	
	function find_parent_category($category_id) {
		global $connection;
		
		$safe_category_id = mysqli_real_escape_string($connection, $category_id);
		
		$query  = "SELECT * ";
		$query .= "FROM categories ";
		$query .= "WHERE id = (SELECT parent_category_id ";
		$query .= "FROM categories ";
		$query .= "WHERE id = {$safe_category_id}) ";
		$category_set = mysqli_query($connection, $query);
		confirm_query($category_set);
		return $category_set;	
	}

	function find_subject_by_id($subject_id, $public=true) {
		global $connection;
		
		$safe_subject_id = mysqli_real_escape_string($connection, $subject_id);
		
		$query  = "SELECT * ";
		$query .= "FROM subjects ";
		$query .= "WHERE id = {$safe_subject_id} ";
		if ($public) {
			$query .= "AND visible = 1 ";
		}
		$query .= "LIMIT 1";
		$subject_set = mysqli_query($connection, $query);
		confirm_query($subject_set);
		if($subject = mysqli_fetch_assoc($subject_set)) {
			return $subject;
		} else {
			return null;
		}
	}

	function find_page_by_id($page_id, $public=true) {
		global $connection;
		
		$safe_page_id = mysqli_real_escape_string($connection, $page_id);
		
		$query  = "SELECT * ";
		$query .= "FROM pages ";
		$query .= "WHERE id = {$safe_page_id} ";
		if ($public) {
			$query .= "AND visible = 1 ";
		}
		$query .= "LIMIT 1";
		$page_set = mysqli_query($connection, $query);
		confirm_query($page_set);
		if($page = mysqli_fetch_assoc($page_set)) {
			return $page;
		} else {
			return null;
		}
	}
	
	function find_question_by_id($question_id) {
		global $connection;
		
		$safe_question_id = mysqli_real_escape_string($connection, $question_id);
		
		$query  = "SELECT * ";
		$query .= "FROM questions ";
		$query .= "WHERE id = {$safe_question_id} ";
		$query .= "LIMIT 1";
		$question_set = mysqli_query($connection, $query);
		confirm_query($question_set);
		if($question = mysqli_fetch_assoc($question_set)) {
			return $question;
		} else {
			return null;
		}
	}
	
	function find_category_by_id($category_id) {
		global $connection;
		
		$safe_category_id = mysqli_real_escape_string($connection, $category_id);
		
		$query  = "SELECT * ";
		$query .= "FROM categories ";
		$query .= "WHERE id = {$safe_category_id} ";
		$query .= "LIMIT 1";
		$category_set = mysqli_query($connection, $query);
		confirm_query($category_set);
		if($category = mysqli_fetch_assoc($category_set)) {
			return $category;
		} else {
			return null;
		}
	}
	
	function find_quiz_by_id($quiz_id) {
		global $connection;
		
		$safe_quiz_id = mysqli_real_escape_string($connection, $quiz_id);
		
		$query  = "SELECT * ";
		$query .= "FROM quiz ";
		$query .= "WHERE id = {$safe_quiz_id} ";
		$query .= "LIMIT 1";
		$quiz_set = mysqli_query($connection, $query);
		confirm_query($quiz_set);
		if($quiz = mysqli_fetch_assoc($quiz_set)) {
			return $quiz;
		} else {
			return null;
		}
	}
	
	function find_admin_by_id($admin_id) {
		global $connection;
		
		$safe_admin_id = mysqli_real_escape_string($connection, $admin_id);
		
		$query  = "SELECT * ";
		$query .= "FROM admins ";
		$query .= "WHERE id = {$safe_admin_id} ";
		$query .= "LIMIT 1";
		$admin_set = mysqli_query($connection, $query);
		confirm_query($admin_set);
		if($admin = mysqli_fetch_assoc($admin_set)) {
			return $admin;
		} else {
			return null;
		}
	}
	
	function find_player_by_id($player_id) {
		global $connection;
		
		$safe_player_id = mysqli_real_escape_string($connection, $player_id);
		
		$query  = "SELECT * ";
		$query .= "FROM players ";
		$query .= "WHERE id = {$safe_player_id} ";
		$query .= "LIMIT 1";
		$player_set = mysqli_query($connection, $query);
		confirm_query($player_set);
		if($player = mysqli_fetch_assoc($player_set)) {
			return $player;
		} else {
			return null;
		}
	}

	function find_admin_by_username($username) {
		global $connection;
		
		$safe_username = mysqli_real_escape_string($connection, $username);
		
		$query  = "SELECT * ";
		$query .= "FROM admins ";
		$query .= "WHERE username = '{$safe_username}' ";
		$query .= "LIMIT 1";
		$admin_set = mysqli_query($connection, $query);
		confirm_query($admin_set);
		if($admin = mysqli_fetch_assoc($admin_set)) {
			return $admin;
		} else {
			return null;
		}
	}
	
	function find_player_by_username($username) {
		global $connection;
		
		$safe_username = mysqli_real_escape_string($connection, $username);
		
		$query  = "SELECT * ";
		$query .= "FROM players ";
		$query .= "WHERE username = '{$safe_username}' ";
		$query .= "LIMIT 1";
		$player_set = mysqli_query($connection, $query);
		confirm_query($player_set);
		if($player = mysqli_fetch_assoc($player_set)) {
			return $player;
		} else {
			return null;
		}
	}

	function find_default_page_for_subject($subject_id) {
		$page_set = find_pages_for_subject($subject_id);
		if($first_page = mysqli_fetch_assoc($page_set)) {
			return $first_page;
		} else {
			return null;
		}
	}
	
	function find_selected_page($public=false) {
		global $current_subject;
		global $current_page;
		
		if (isset($_GET["subject"])) {
			$current_subject = find_subject_by_id($_GET["subject"], $public);
			if ($current_subject && $public) {
				$current_page = find_default_page_for_subject($current_subject["id"]);
			} else {
				$current_page = null;
			}
		} elseif (isset($_GET["page"])) {
			$current_subject = null;
			$current_page = find_page_by_id($_GET["page"], $public);
		} else {
			$current_subject = null;
			$current_page = null;
		}
	}
		
	function find_selected_question() {  //find selected category or question
		global $current_category;
		global $current_question;
		
		if (isset($_GET["category"])) {
			$current_category = find_category_by_id($_GET["category"]);
            $current_question = null;
		
		} elseif (isset($_GET["question"])) {
			$current_category = null;
			$current_question = find_question_by_id($_GET["question"]);
		} else {
			$current_category = null;
			$current_question = null;
		}
	}

	function find_questions_by_quiz_id($quiz_id){
		global $connection;
		
		$safe_quiz_id = mysqli_real_escape_string($connection, $quiz_id);
		
		$query  = "SELECT * ";
		$query .= "FROM questions ";
		$query .= "WHERE id in ( ";
		$query .= "select question_id from quiz_question ";
		$query .= "WHERE quiz_id = {$safe_quiz_id} ";
		$query .= ")";
		$quiz_question_set = mysqli_query($connection, $query);
		confirm_query($quiz_question_set);
		
		return $quiz_question_set;
		
	}
	
	function find_player_answered_questions($quiz_id){
		global $connection;
		
		$safe_quiz_id = mysqli_real_escape_string($connection, $quiz_id);
		
		$query  = "SELECT  Q.id, Q.question_content, Q.option1, Q.option2,Q.option3,Q.option4,
		Q.correct_option, QP.quiz_id, QP.player_answer ";
		$query .= "FROM questions Q, question_playeranswer QP ";
		$query .= "WHERE QP.quiz_id= {$safe_quiz_id} ";
		$query .= "AND Q.id=QP.question_id; ";
		$quiz_question_set = mysqli_query($connection, $query);
		confirm_query($quiz_question_set);
		
		return $quiz_question_set;
	}

	
	function correct_rate_for_quiz($player_id,$quiz_id){
		$player_answered_question_set=find_player_answered_questions($quiz_id);
		$count=0; 
		$correct_count=0;
		while ($quiz_question=mysqli_fetch_assoc($player_answered_question_set)){
			if($quiz_question['correct_option']===$quiz_question['player_answer']){
				$correct_count++;
			}
			$count++;
		}
		if ($count!=0){
			$correct_rate=(double)$correct_count/$count;
		}
		else $correct_rate=0;
		return $correct_rate;
	}
	
	function accumulated_points_for_quiz($player_id,$quiz_id,$points_for_each_corrent=10){
		$player_answered_question_set=find_player_answered_questions($quiz_id);
		$count=0; 
		$correct_count=0;
		while ($quiz_question=mysqli_fetch_assoc($player_answered_question_set)){
			if($quiz_question['correct_option']===$quiz_question['player_answer']){
				$correct_count++;
			}
		}
		return $points_for_each_corrent * $correct_count;
	}
	
//functions for views ---------------------------------------------------------------------------------:	
	
	// navigation takes 2 arguments
	// - the current subject array or null
	// - the current page array or null
	function navigation($subject_array, $page_array) {
		$output = "<ul class=\"subjects\">";
		$subject_set = find_all_subjects(false);
		while($subject = mysqli_fetch_assoc($subject_set)) {
			$output .= "<li";
			if ($subject_array && $subject["id"] == $subject_array["id"]) {
				$output .= " class=\"selected\"";
			}
			$output .= ">";
			$output .= "<a href=\"manage_content.php?subject=";
			$output .= urlencode($subject["id"]);
			$output .= "\">";
			$output .= htmlentities($subject["menu_name"]);
			$output .= "</a>";
			
			$page_set = find_pages_for_subject($subject["id"], false);
			$output .= "<ul class=\"pages\">";
			while($page = mysqli_fetch_assoc($page_set)) {
				$output .= "<li";
				if ($page_array && $page["id"] == $page_array["id"]) {
					$output .= " class=\"selected\"";
				}
				$output .= ">";
				$output .= "<a href=\"manage_content.php?page=";
				$output .= urlencode($page["id"]);
				$output .= "\">";
				$output .= htmlentities($page["menu_name"]);
				$output .= "</a></li>";
			}
			mysqli_free_result($page_set);
			$output .= "</ul></li>";
		}
		mysqli_free_result($subject_set);
		$output .= "</ul>";
		return $output;
	}

	function public_navigation($subject_array, $page_array) {
		$output = "<ul class=\"subjects\">";
		$subject_set = find_all_subjects();
		while($subject = mysqli_fetch_assoc($subject_set)) {
			$output .= "<li";
			if ($subject_array && $subject["id"] == $subject_array["id"]) {
				$output .= " class=\"selected\"";
			}
			$output .= ">";
			$output .= "<a href=\"index.php?subject=";
			$output .= urlencode($subject["id"]);
			$output .= "\">";
			$output .= htmlentities($subject["menu_name"]);
			$output .= "</a>";
			
			if ($subject_array["id"] == $subject["id"] || 
					$page_array["subject_id"] == $subject["id"]) {
				$page_set = find_pages_for_subject($subject["id"]);
				$output .= "<ul class=\"pages\">";
				while($page = mysqli_fetch_assoc($page_set)) {
					$output .= "<li";
					if ($page_array && $page["id"] == $page_array["id"]) {
						$output .= " class=\"selected\"";
					}
					$output .= ">";
					$output .= "<a href=\"index.php?page=";
					$output .= urlencode($page["id"]);
					$output .= "\">";
					$output .= htmlentities($page["menu_name"]);
					$output .= "</a></li>";
				}
				$output .= "</ul>";
				mysqli_free_result($page_set);
			}

			$output .= "</li>"; // end of the subject li
		}
		mysqli_free_result($subject_set);
		$output .= "</ul>";
		return $output;
	}
	
	function question_navigation($category_array, $question_array) {
		//level1
		$output = "<ul class=\"level1categories\">";
		$level1category_set = find_all_level1_category();
		while($level1category = mysqli_fetch_assoc($level1category_set)) {
			$output .= "<li";
			if ($category_array && $level1category["id"] == $category_array["id"]) {
				$output .= " class=\"categoryselected\"";
			}
			$output .= ">";
			$output .= "<a href=\"manage_questions.php?category=";
			$output .= urlencode($level1category["id"]);
			$output .= "\">";
			$output .= htmlentities($level1category["category_name"]);
			$output .= "</a>";
			
		    //level2
			$level2category_set = find_sub_category($level1category["id"]);
			$output .= "<ul class=\"level2categories\">";
			while($level2category = mysqli_fetch_assoc($level2category_set)) {
				$output .= "<li";
				if ($category_array && $level2category["id"] == $category_array["id"]) {
					$output .= " class=\"categoryselected\"";
				}
				$output .= ">";
				$output .= "<a href=\"manage_questions.php?category=";
				$output .= urlencode($level2category["id"]);
				$output .= "\">";
				$output .= htmlentities($level2category["category_name"]);
				$output .= "</a></li>";
		
			
				//level3
				$level3category_set = find_sub_category($level2category["id"]);
				$output .= "<ul class=\"level3categories\">";
				while($level3category = mysqli_fetch_assoc($level3category_set)) {
					$output .= "<li";
					if ($category_array && $level3category["id"] == $category_array["id"]) {
						$output .= " class=\"categoryselected\"";
					}
					elseif ($question_array && $level3category["id"] == $question_array["category_id"]) {
						$output .= " class=\"categoryselected\"";
					}
					$output .= ">";
					$output .= "<a href=\"manage_questions.php?category=";
					$output .= urlencode($level3category["id"]);
					$output .= "\">";
					$output .= htmlentities($level3category["category_name"]);
					$output .= "</a></li>";
				}
			
				mysqli_free_result($level3category_set);
				$output .= "</ul></li>";
			}
			mysqli_free_result($level2category_set);
			$output .= "</ul></li>";
		}

	 mysqli_free_result($level1category_set);
		$output .= "</ul>";
		return $output;
	}

	function show_level3category_for_selection(){ 
		echo "<select name=\"level3categoryId\" >";
		$level3category_set = find_all_level3_category();
		while($level3category = mysqli_fetch_assoc($level3category_set)) { 
			echo "<option value ={$level3category['id']}> {$level3category['category_name']} </option> ";
		}
		echo "</select>";
	}
	
	function quiz_question_for_selection($quiz_question,$count=0){ //$quiz_question is a tuple array of question, include all the info about this question
		
		$output ="<table><col width=\"700\"><tr><td>";
		$output .="<h3>Question".$count."&nbsp </h3>".htmlentities($quiz_question['question_content']);
		$output .="</td></tr><tr><td>";
		$output .="<input type='radio' name='answer_for_question_";
		$output .=htmlentities($quiz_question['id']);
		$output .="' value=1 />";
		$output .=htmlentities($quiz_question['option1']);
		$output .="</td></tr><tr><td>";
		$output .="<input type='radio' name='answer_for_question_";
		$output .=htmlentities($quiz_question['id']);
		$output .="' value=2 />";
		$output .=htmlentities($quiz_question['option2']);
		$output .="</td></tr><tr><td>";
		$output .="<input type='radio' name='answer_for_question_";
		$output .=htmlentities($quiz_question['id']);
		$output .="' value=3 />";
		$output .=htmlentities($quiz_question['option3']);
		$output .="</td></tr><tr><td>";
		$output .="<input type='radio' name='answer_for_question_";
		$output .=htmlentities($quiz_question['id']);
		$output .="' value=4 />";
		$output .=htmlentities($quiz_question['option4']);
		$output .="</td></tr></table></br>";
		return $output;
	}
	
	
	function quiz_question_for_result($quiz_question,$count=0){ 
		//$quiz_question is a tuple array of question, 
		//include all the info about this question and player's answer about this question in the quiz
		//$count is the sequence of question in the result list
	    $output ="<table><col width=\"700\"><tr><td>";
	 	$output .= "<h3>Question".$count."&nbsp";
		$output .="</h3>";
		$output .=htmlentities($quiz_question['question_content']);
		$output .="</td></tr><tr><td>";
		$output .="<ol>";
		$output .="<li> ";
		$output .=htmlentities($quiz_question['option1']);
		$output .="</li> ";
		$output .="<li> ";
		$output .=htmlentities($quiz_question['option2']);
		$output .="</li> ";
		$output .="<li> ";
		$output .=htmlentities($quiz_question['option3']);
		$output .="</li> ";
		$output .="<li> ";
		$output .=htmlentities($quiz_question['option4']);
		$output .="</li> ";
		$output .="</ol>";
		$output .="</td></tr><tr><td>";
		$output .="The correct answer is ";
		$output .=htmlentities($quiz_question['correct_option']);
		$output .="; &nbsp; ";
		$output .="Your answer is ";
		$output .=htmlentities($quiz_question['player_answer']);
		$output .="</td></tr></table></br>";

		return $output;
	}
		
		
		
		
		
	
//end of functions of views-------------------------------------------------------------------------------
	

	
	
	
	
	
	
	
	function password_encrypt($password) {
  	$hash_format = "$2y$10$";   // Tells PHP to use Blowfish with a "cost" of 10
	  $salt_length = 22; 					// Blowfish salts should be 22-characters or more
	  $salt = generate_salt($salt_length);
	  $format_and_salt = $hash_format . $salt;
	  $hash = crypt($password, $format_and_salt);
		return $hash;
	}
	
	function generate_salt($length) {
	  // Not 100% unique, not 100% random, but good enough for a salt
	  // MD5 returns 32 characters
	  $unique_random_string = md5(uniqid(mt_rand(), true));
	  
		// Valid characters for a salt are [a-zA-Z0-9./]
	  $base64_string = base64_encode($unique_random_string);
	  
		// But not '+' which is valid in base64 encoding
	  $modified_base64_string = str_replace('+', '.', $base64_string);
	  
		// Truncate string to the correct length
	  $salt = substr($modified_base64_string, 0, $length);
	  
		return $salt;
	}
	
	function password_check($password, $existing_hash) {
		// existing hash contains format and salt at start
	  $hash = crypt($password, $existing_hash);
	  if ($hash === $existing_hash) {
	    return true;
	  } else {
	    return false;
	  }
	}

	function attempt_login($username, $password) {
		$admin = find_admin_by_username($username);
		if ($admin) {
			// found admin, now check password
			if (password_check($password, $admin["hashed_password"])) {
				// password matches
				return $admin;
			} else {
				// password does not match
				return false;
			}
		} else {
			// admin not found
			return false;
		}
	}
	
	function player_attempt_login($username, $password) {
		$player = find_player_by_username($username);
		if ($player) {
			// found player, now check password
			if (password_check($password, $player["hashed_password"])) {
				// password matches
				return $player;
			} else {
				// password does not match
				return false;
			}
		} else {
			// player not found
			return false;
		}
	}

	function logged_in() {
		return isset($_SESSION['admin_id']);
	}
	
	function confirm_logged_in() {
		if (!logged_in()) {
			redirect_to("login.php");
		}
	}
	
	function player_logged_in() {
		return isset($_SESSION['player_username']);
	}
	
	function confirm_player_logged_in() {
		if (!player_logged_in()) {
			redirect_to("player_login.php");
		}
	}

?>


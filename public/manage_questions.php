<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>

<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>
<?php find_selected_question(); ?>

<div id="main">
  <div id="navigation">
		<br />
		<a href="admin.php">&laquo; Admin Dashboard</a><br />
		
		<?php echo question_navigation($current_category,$current_question); 
			?>
		<br />
		<a href="new_category.php">+ Add a root category</a>
  </div>
  <div id="page">
		<?php echo message(); ?>

		<?php //root category
		if ($current_category && $current_category["category_level"]==1) { ?>
		<h2>Manage Category</h2>
		Category name: <?php echo htmlentities($current_category["category_name"]); ?><br />
		Category level: <?php echo $current_category["category_level"]; ?><br />
		
		<br />
		<a href="edit_category.php?category=<?php echo urlencode($current_category["id"]); ?>">Edit Category</a>

		<div style="margin-top: 2em; border-top: 1px solid #000000;">
		<h3>Sub categories in this category:</h3>
		<ul>
		<?php 
			$sub_categories = find_sub_category($current_category["id"]);
			while($category = mysqli_fetch_assoc($sub_categories)) {
				echo "<li>";
				$safe_category_id = urlencode($category["id"]);
				echo "<a href=\"manage_questions.php?category={$safe_category_id}\">";
				echo htmlentities($category["category_name"]);
				echo "</a>";
				echo "</li>";
			}
			?>
		</ul>
		<br />
		+ <a href="new_category.php?parent_category=<?php echo urlencode($current_category["id"]); ?>">Add a new sub category to category</a>
		</div>

		<?php } //second level category
		elseif ($current_category && $current_category["category_level"]==2) { ?>
		<h2>Manage Category</h2>
		Category name: <?php echo htmlentities($current_category["category_name"]); ?><br />
		Category level: <?php echo $current_category["category_level"]; ?><br />
		Parent category: <?php $parent_category_set=find_parent_category($current_category["id"]);
								$parent_category=mysqli_fetch_assoc($parent_category_set);
								echo $parent_category["category_name"] ?><br />
		<br />
		<a href="edit_category.php?subject=<?php echo urlencode($current_category["id"]); ?>">Edit Category</a>
		
		<div style="margin-top: 2em; border-top: 1px solid #000000;">
			<h3>Sub categories in this category:</h3>
			<ul>
			<?php 
				$sub_categories = find_sub_category($current_category["id"]);
				while($category = mysqli_fetch_assoc($sub_categories)) {
					echo "<li>";
					$safe_category_id = urlencode($category["id"]);
					echo "<a href=\"manage_questions.php?category={$safe_category_id}\">";
					echo htmlentities($category["category_name"]);
					echo "</a>";
					echo "</li>";
				}
			?>
			</ul>
			<br />
			+ <a href="new_category.php?parent_category=<?php echo urlencode($current_category["id"]); ?>">Add a new sub category to category</a>
		</div>

		<?php } // third level category
		elseif ($current_category && $current_category["category_level"]==3) { ?>
		<h2>Manage Category</h2>
		Category name: <?php echo htmlentities($current_category["category_name"]); ?><br />
		Category level: <?php echo $current_category["category_level"]; ?><br />
		Parent category:  <?php $parent_category_set=find_parent_category($current_category["id"]);
								$parent_category=mysqli_fetch_assoc($parent_category_set);
								echo $parent_category["category_name"] ?><br />
		<br />
		<a href="edit_category.php?category=<?php echo urlencode($current_category["id"]); ?>">Edit Category</a>

		<div style="margin-top: 2em; border-top: 1px solid #000000;">
		<h3>Sub categories in this category:</h3>
			<table>
			<tr>
			<th style="text-align: left; width: 200px;">Question ID</th>
			<th style="text-align: left; width: 200px;">Question Status</th>
			<th colspan="2" style="text-align: left;">Actions</th>
			</tr>
		<?php $category_questions=find_questions_by_category($current_category["id"]);
				while($question = mysqli_fetch_assoc($category_questions)) { ?>
			<tr>
			<td><?php echo htmlentities($question["id"]); ?></td>
			<td><?php echo htmlentities($question["status"]); ?></td>
			<td><a href="manage_questions.php?question=<?php echo urlencode($question["id"]); ?>"> Review </a></td>
			</tr>
			<?php } ?>
			</table>
			<br />

		+ <a href="new_question.php?category=<?php echo urlencode($current_category["id"]); ?>">Add a new question to category</a>
		</div>


		<?php } // question level
		elseif ($current_question) { ?>
		<h2>Manage Questions</h2>
		Question ID: <?php echo htmlentities($current_question["id"]); ?><br />
		Content: <?php echo $current_question["question_content"]; ?><br />
		Options 1: <?php echo $current_question["option1"] ?><br />
		Options 2: <?php echo $current_question["option2"] ?><br />
		Options 3: <?php echo $current_question["option3"] ?><br />
		Options 4: <?php echo $current_question["option4"] ?><br />
		Correct Option: <?php echo $current_question["correct_option"] ?><br />
		Status: <?php echo $current_question["status"] ?><br />
		Category: <?php 
			$category=find_category_by_id($current_question["category_id"]);
			$parent_category_set=find_parent_category($category["id"]);
			$parent_category = mysqli_fetch_assoc ($parent_category_set);
			$root_category_set=find_parent_category($parent_category["id"]);
			$root_category = mysqli_fetch_assoc ($root_category_set);
			echo $root_category["category_name"];
			echo "-->";
			echo $parent_category["category_name"];
			echo "-->";
			echo $category["category_name"] 
			?><br />
		Level: <?php echo $current_question["level"] ?><br />
	  <br />
	  <a href="edit_question.php?questionId=<?php echo urlencode($current_question['id']); ?>">Edit question</a>
			
		<?php } // nothing selected
		else { ?>
		Please select a category or a question.
		<?php }?>

  </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>

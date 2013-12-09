<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php $layout_context = "public"; ?>
<?php include("../includes/layouts/header.php"); ?>

<?php find_selected_page(true); ?>

<div id="main" >
  <div id="navigation">
		<br> </br>
		<form action="login.php" method= "LINK">
		<button type ="submit"  class="blue" >
		Admin Login
		</button>	
		</form>

		<form action="registration.php" method= "LINK">
		<button type ="submit"  class="blue" >
		Registration
		</button>	
		</form>

		<form action="player_login.php" method= "LINK">
		<button type ="submit"  class="blue" >
		Player Login
		</button>	
		</form>
		
		<?php echo public_navigation($current_subject, $current_page); ?>
  </div>


 <div id="page" class="wrapper">
		<?php if ($current_page) { ?>
			
			<h2><?php echo htmlentities($current_page["menu_name"]); ?></h2>
			<?php echo nl2br(htmlentities($current_page["content"])); ?>
			
		<?php } else { ?>
			
		    <img src="images/Intelligence.jpg" width="900" height="600" >
			
		<?php }?>
  </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>

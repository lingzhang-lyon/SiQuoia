<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>

<?php
  $player_set = find_all_players();
?>

<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>
<div id="main">
  <div id="navigation">
		<br />
		<a href="admin.php">&laquo; Admin Dashboard</a><br />
  </div>
  <div id="page">
    <?php echo message(); ?>
    <h2>Manage Players</h2>
    <table>
      <tr>
        <th style="text-align: left; width: 200px;">Username</th>
		<th style="text-align: left; width: 200px;">Membership</th>
        <th colspan="2" style="text-align: left;">Actions</th>
      </tr>
    <?php while($player = mysqli_fetch_assoc($player_set)) { ?>
      <tr>
        <td><?php echo htmlentities($player["username"]); ?></td>
		<td><?php echo htmlentities($player["membership"]); ?></td>
        <td><a href="edit_player.php?id=<?php echo urlencode($player["id"]); ?>">Edit</a></td>
        <td><a href="delete_player.php?id=<?php echo urlencode($player["id"]); ?>" onclick="return confirm('Are you sure?');">Delete</a></td>
      </tr>
    <?php } ?>
    </table>
    <br />
    <a href="new_player.php">Add new player</a>
  </div>
</div>
<?php include("../includes/layouts/footer.php"); ?>

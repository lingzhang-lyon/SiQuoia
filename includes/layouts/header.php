<?php 
	if (!isset($layout_context)) {
		$layout_context = "public";
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
	<head>
		<title>SiQuoia Online Quiz <?php if ($layout_context == "admin") { echo "Admin";}
										 else if ($layout_context == "player") { echo "Player";}?></title>
		<link href="stylesheets/public.css" media="all" rel="stylesheet" type="text/css" />
	</head>
	<body>
    <div id="header">
      <table><tr>
       <td><img src="images/header.jpg" height="65" width="120"></td>
<td><h1> &nbsp;&nbsp;SiQuoia Online Quiz <?php if ($layout_context == "admin") { echo "Admin"; } 
		                            else if ($layout_context == "player") { echo "Player";}?> 
     </h1></td>
	 <tr></table>
      
    </div>

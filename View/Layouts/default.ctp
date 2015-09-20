<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $title_for_layout?></title>
<!-- <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"> -->
<!-- Include external files and scripts here (See HTML helper for more info.) -->
<?php echo $this->Html->css(array('reset', 'chosen.min', 'style')) ?>
<?php echo $this->Html->script(array('scripts', 'jquery-2.0.3.min', 'chosen.jquery.min')) ?>

<?php echo $scripts_for_layout ?>
<meta http-equiv="CACHE-CONTROL" content="NO-CACHE">
</head>
<body>

<!-- If you'd like some sort of menu to
show up on all of your views, include it here -->
<div id="header">
	<h1>iTunes U Feedmanager</h1>
    <div id="menu">
	<?php
	echo $this->Html->link('Feeds', '/feeds').' ';
	echo $this->Html->link('Assign items', '/items/assign').' ';
	echo $this->Html->link('Manage items', '/items/').' ';
	echo $this->Html->link('Import items', '/items/import').' ';
	// echo $this->Html->link('XGrid jobs', '/xgridstatus/').' ';
	echo $this->Html->link('Log out', '/users/logout').' ';
	?>
	</div>
</div>

<!-- Here's where I want my views to be displayed -->
<div id="content">
<?php echo $content_for_layout ?>
</div>

<!-- Add a footer to each displayed page -->
<div id="footer">
	<?php echo $this->Html->image('cake.power.gif') ?>
</div>
<!-- get all scripts included in views -->
</body>
</html>
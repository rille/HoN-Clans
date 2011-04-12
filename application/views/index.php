<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>HoN Clans</title>
	<link rel="stylesheet" type="text/css" href="i/css/base.css"/>
</head>
<body>
	<h1>HEY clan!</h1>
	<div class="clan-members">
		<?php foreach($stats as $clanmember) : ?>
		<div class="member-card">
			<img class="avatar" src="i/images/avatar-na.png" width="50" height="50"/>
			<h2><?php echo $clanmember['nickname']; ?>
				<span><?php echo $clanmember['rnk_amm_team_rating']; ?></span>
			</h2>
			<p>Ranked games: <?php echo $clanmember['rnk_games_played']; ?></p>
			<p>Ranked wins: <?php echo $clanmember['rnk_wins']; ?></p>
			<p>Ranked losses: <?php echo $clanmember['rnk_losses']; ?></p>
			<p>Win percentage: <?php echo $clanmember['rnk_win_percent']; ?>%</p>
		</div>
		<?php endforeach ?>
		<div class="clear"></div>
	</div>
	<!--
	<?php foreach($records as $row) : ?>
			
	<h1><?php echo $row->title; ?></h1>
		
	<?php endforeach ?>
	-->
</body>

<!-- LOLOL -->
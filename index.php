<!DOCTYPE html>
<html>
	<head>
		<title>SYSTEM</title>
		<link rel="stylesheet" type="text/css" href="css/empresa.css">
	</head>
	<body>
		<?php
		require_once 'core/init.php';

		if(Session::exists('home')) {
			echo '<p>' . Session::flash('home');
		}

		$user = new User();
		if($user->isLoggedIn()) {
		?>

		<div class="em-card">
			<h1 class="em-card-header">
				<p>Hello <a href="profile.php?user=<?php echo escape($user->data()->username); ?>"><?php echo escape($user->data()->username); ?></a>!</p>
			</h1>
			<ul>
				<li><a href="update.php">Update details</a></li>
				<li><a href="changepassword.php">Change password</a>
				<li><a href="logout.php">Log out</a></li></li>
			</ul>

			<?php

				if($user->hasPermission('admin')) {
					echo 'Your are an administrator!';
				}

			} else {
				echo '<p>You need to <a href="login.php">Log in</a> or <a href="register.php">Register</a></p>';
			}
			?>
		</div>
	</body>
</html>

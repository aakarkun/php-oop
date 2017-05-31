<!DOCTYPE html>
<html>
	<head>
		<title>SYSTEM</title>
		<link rel="stylesheet" type="text/css" href="css/empresa.css">
	</head>
	<body>
		<div class="em-card">
			<?php
				require_once 'core/init.php';

				if(!$username = Input::get('user')) {
					Redirect::to('index.php');
				} else {
					$user = new User($username);
					if(!$user->exists()) {
						Redirect::to(404);
					} else {
						$data = $user->data();

					}
					?>

					<h1 class="em-card-header"><?php echo escape($data->username) . "'s profile"; ?></h1>
					<p>Full name: <?php echo escape($data->name); ?></p>

				<?php
				}
				?>
		</div>


	</body>
</html>

<!DOCTYPE html>
<html>
	<head>
		<title>SYSTEM</title>
		<link rel="stylesheet" type="text/css" href="css/empresa.css">
	</head>
	<body>
		<div class="em-card">
			<h1 class="em-card-header">Change password</h1>
			<?php
			require_once 'core/init.php';

			$user = new User();

			if(!$user->isLoggedIn()) {
				Redirect::to('index.php');
			}

			if(Input::exists()) {
				if(Token::check(Input::get('token'))) {

					$validate = new Validate();
					$validation = $validate->check($_POST, array(
						'password_current' => array(
							'required' => true,
							'min' => 6
						),
						'password_new' => array(
							'required' => true,
							'min' => 6
						),
						'password_new_again' => array(
							'required' => true,
							'min' => 6,
							'matches' => 'password_new'
						)
					));

					if($validation->passed()) {

						if(Hash::make(Input::get('password_current'), $user->data()->salt) !== $user->data()->password) {
							echo 'Your current password is wrong.';
						} else {
							$salt = Hash::salt(32);
							$user->update(array(
								'password' => Hash::make(Input::get('password_new'), $salt),
								'salt' => $salt
							));

							Session::flash('home', 'Your password has been changed!');
							Redirect::to('index.php');
						}

					} else {
						foreach ($validation->errors() as $error) {
							echo $error, '<br />';
						}
					}

				}
			}

			?>

			<form action="" method="post" class="margin-top">
				<div class="field">
					<input type="password" class="em-input" name="password_current" id="password_current" placeholder="Current password">
				</div>

				<div class="field">
					<input type="password" class="em-input" name="password_new" id="password_new" placeholder="New password">
				</div>

				<div class="field">
					<input type="password" class="em-input" name="password_new_again" id="password_new_again" placeholder="New password again">
				</div>

				<input type="submit" class="em-button-submit" value="Change">
				<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
			</form>
		</div>
	</body>
</html>

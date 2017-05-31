<!DOCTYPE html>
<html>
	<head>
		<title>SYSTEM</title>
		<link rel="stylesheet" type="text/css" href="css/empresa.css">
	</head>
	<body>
		<div class="em-card">
			<h1 class="em-card-header">Create an Account</h1>
			<?php
			require_once 'core/init.php';

			if(Input::exists()) {
				if(Input::get('token')) {
					$validate = new Validate();
					$validation = $validate->check($_POST, array(
						'username' => array(
							'required' => true,
							'min' => 2,
							'max' => 20,
							'unique' => 'users'
						),
						'password' => array(
							'required' => true,
							'min' => 6
						),
						'password_again' => array(
							'required' => true,
							'matches' => 'password'
						),
						'name' => array(
							'required' => true,
							'min' => 2,
							'max' => 50
						)
					));

					if($validation->passed()) {
						$user = new User();

						$salt = Hash::salt(32);

						try {
							$user->create(array(
								'username' => Input::get('username'),
								'password' => Hash::make(Input::get('password'), $salt),
								'salt' => $salt,
								'name' => Input::get('name'),
								'joined' => date('Y-m-d H:i:s'),
								'group' => 1
							));

							Session::flash('home', 'You have been registered and can now log in!');
							Redirect::to('index.php');

						} catch(Exception $e) {
							die($e->getMessage());
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
					<input type="text" name="username" class="em-input" id="username" value="<?php echo escape(Input::get('username')); ?>" autocomplete="off" placeholder="Username">
				</div>
				<div class="field">
					<input type="password" name="password" class="em-input" id="password" placeholder="Choose a password">
				</div>
				<div class="field">
					<input type="password" name="password_again" class="em-input" id="password_again" placeholder="Confirm password">
				</div>
				<div class="field">
					<input type="text" name="name" class="em-input" id="name" value="<?php echo escape(Input::get('name')); ?>" placeholder="Full name">
				</div>
				<br />
				<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
				<input type="submit" value="Register" class="em-button-submit">
			</form>
		</div>
	</body>
</html>

<!DOCTYPE html>
<html>
	<head>
		<title>SYSTEM</title>
		<link rel="stylesheet" type="text/css" href="css/empresa.css">
	</head>
	<body>
		<div class="em-card">
				<h1 class="em-card-header">Login</h1>
				<?php
					require_once'core/init.php';

					if(Input::exists()) {
						if(Token::check(Input::get('token'))) {

							$validate = new Validate();
							$validation = $validate->check($_POST, array(
								'username' => array('required' => true),
								'password' => array('required' => true)
							));

							if($validation->passed()) {
								$user = new User();

								$remember = (Input::get('remember') ==='on') ? true : false;
								$login = $user->login(Input::get('username'), Input::get('password'), $remember);

								if($login) {
									Redirect::to('index.php');
								} else {
									echo '<p>Invalid username or password!</p>';
								}
							} else {
								foreach($validation->errors() as $error) {
									echo $error, '<br />';
								}
							}
						}
					}
				?>
			<form action="" method="post" class="em-form-center">
				<div class="field">
					<input type="text" class="em-input" name="username" id="username" autocomplete="off" placeholder="username">
				</div>

				<div class="field">
					<input type="password" class="em-input" name="password" id="password" autocomplete="off" placeholder="password">
				</div>

				<div class="field margin-top">
				<label for="remember">
					<input type="checkbox" class="input" name="remember" id="remember">Remember me
				</label>
				</div>

				<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
				<input type="submit" class="em-button-submit" value="Log in">
			</form>
		</div>
	</body>
</html>

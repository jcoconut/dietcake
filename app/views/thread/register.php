<?php if ($user->hasError() or (!$user->password_match) or $user->already_registered): ?>
	
<div data-alert class="alert-box warning radius" style="padd	ing:1px;background:#EEE;color:#333;">
	<h5 class="alert-heading"><i class="fi-alert" style="font-size:2rem;"></i> Oops..</h5>

	<?php if ($user->hasError()): ?>
		<span class="sub-header clearfix">Please enter valid entries!</span>
	<?php endif ?>
	
	<?php if (!$user->password_match): ?>
		<span class="sub-header clearfix">Passwords do not match! </span>
	<?php endif ?>

	<?php if ($user->already_registered): ?>
		<span class="sub-header clearfix">Username or Email already taken!</span>
	<?php endif ?>
	
<a href="#" class="close">&times;</a>
</div>
<?php endif ?>

<form class="row panel callout" action="<?php echo_htmlschars(url('')); ?>" method="post">
	<div class="small-12 columns">
		<div class="row">
			<h4>Register</h4> <small>Please fill up all fields</small>
		</div>
		<div class="row">
		

			<div class="medium-6 columns">
				<?php if (!empty($user->validation_errors['user_fname']['format']) || !empty($user->validation_errors['user_fname']['length'])): ?>
					<label class="cus-error"><i class="fi-alert"></i>First Name
				<?php else: ?>
					<label>First Name
				<?php endif; ?>
					<input type="text" placeholder="Juan" name="user_fname" maxlength='30' value="<?php echo_htmlschars(Param::get('user_fname')) ?>">
					</label>
			</div>

			<div class="medium-6 columns">
				<?php if (!empty($user->validation_errors['user_lname']['format']) || !empty($user->validation_errors['user_lname']['length'])): ?>
					<label class="cus-error"><i class="fi-alert"></i>Last Name
				<?php else: ?>
					<label>Last Name
				<?php endif; ?>
					<input type="text" placeholder="Dela Cruz" name="user_lname" maxlength='30' value="<?php echo_htmlschars(Param::get('user_lname')) ?>">
					</label>
			</div>

			<div class="medium-6 columns">
				<?php if (!empty($user->validation_errors['user_email']['format']) || !empty($user->validation_errors['user_email']['length'])): ?>
					<label class="cus-error"><i class="fi-alert"></i>Email
				<?php else: ?>
					<label>Email
				<?php endif; ?>
					<input type="email" placeholder="example@sample.com" name="user_email" maxlength='30' value="<?php echo_htmlschars(Param::get('user_email')) ?>">
					</label>

			</div>

			<div class="medium-6 columns">
				<?php if (!empty($user->validation_errors['user_username']['format']) || !empty($user->validation_errors['user_username']['length'])): ?>
					<label class="cus-error"><i class="fi-alert"></i>Username
				<?php else: ?>
					<label>Username
				<?php endif; ?>
					<input type="text" placeholder="jdelacruz" name="user_username" maxlength='30' value="<?php echo_htmlschars(Param::get('user_username')) ?>">
					</label>
			</div>

			<div class="medium-6 columns">
				<?php if (!empty($user->validation_errors['user_password']['length']) || $user->password_match==false): ?>
					<label class="cus-error"><i class="fi-alert"></i>Password
				<?php else: ?>
					<label>Password
				<?php endif; ?>
					<input type="password" name="user_password" maxlength='30'>
					</label>
			</div>

			<div class="medium-6 columns">
				<?php if (!empty($user->validation_errors['user_password']['length']) || $user->password_match==false): ?>
					<label class="cus-error"><i class="fi-alert"></i>Confirm Password
				<?php else: ?>
					<label>Confirm Password
				<?php endif; ?>
					<input type="password" name="user_confirm_password" maxlength='30'>
					</label>
			</div>
			
			<div class="small-12 columns">
				<div class="row">
					<div class="small-6 small-centered columns text-center">
						<input type="hidden" value="register_ok" name="page_next">
						<input type="submit" value="Register!" class="button ">
					</div>
				</div>
			</div>
		</div>
  	</div>
</form>

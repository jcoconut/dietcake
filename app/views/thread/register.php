<?php if ($user->hasError() || $user->hasError()): ?>
	
<div data-alert class="alert-box warning radius" style="padding:1px;background:#EEE;color:#333;">
	<h6 class="alert-heading"><i class="fi-alert" style="font-size:2rem;"></i> Oops..</h6>
	<?php $required_fields = array(); ?>
	<?php if (!empty($user->validation_errors['user_fname']['format'])): ?>
		Please Enter a valid name
	<?php endif ?>
	<?php if (!empty($user->validation_errors['user_fname']['length'])): ?>
		<?php $required_fields[] = "First Name"; ?>
	<?php endif ?>

	<?php if (!empty($user->validation_errors['user_lname']['format'])): ?>
		Please Enter a valid name
	<?php endif ?>
	<?php if (!empty($user->validation_errors['user_lname']['length'])): ?>
		<?php $required_fields[] = "Last Name"; ?>
	<?php endif ?>

	<?php if (!empty($user->validation_errors['user_username']['format'])): ?>
		Please Enter a valid name
	<?php endif ?>
	<?php if (!empty($user->validation_errors['user_username']['length'])): ?>
		<?php $required_fields[] = "Username"; ?>
	<?php endif ?>

	<?php if (!empty($user->validation_errors['user_password']['format'])): ?>
		Please Enter a valid name
	<?php endif ?>
	<?php if (!empty($user->validation_errors['user_password']['length'])): ?>
		<?php $required_fields[] = "Password"; ?>
	<?php endif ?>

	<?php if(count($required_fields) > 0): ?>
		<ul>Please fill up the required fields :
		<?php foreach ($required_fields as $fields ): ?>
			<li><?php echo $fields; ?></li>
		<?php endforeach; ?>
		</ul>
	<?php endif; ?>
<a href="#" class="close">&times;</a>
</div>
<?php endif ?>

<form class="row panel callout" action="<?php eh(url('')); ?>" method="post">
	<h4>Register</h4><small><em>Please fill up all fields</em></small>
	<div class="medium-6 columns">
		<label>First Name
		<input type="text" placeholder="Juan" name="user_fname">
		</label>
	</div>

	<div class="medium-6 columns">
		<label>Last Name
		<input type="text" placeholder="Dela Cruz" name="user_lname">
		</label>
	</div>

	<div class="medium-6 columns">
		<label>Email
		<input type="email" placeholder="example@sample.com" name="user_email">
		</label>
	</div>

	<div class="medium-6 columns">
		<label>Username
		<input type="text" placeholder="jdelacruz" name="user_username">
		</label>
	</div>

	<div class="medium-6 columns">
		<label>Password
		<input type="password" name="user_password">
		</label>
	</div>

	<div class="medium-6 columns">
		<label>Confirm Password
		<input type="password" name="user_confirm_password">
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
	
  
</form>

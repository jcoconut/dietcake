<?php if (!$user->password_match): ?>
	
<div data-alert class="alert-box warning radius" style="padd	ing:1px;background:#EEE;color:#333;">
	<h5 class="alert-heading"><i class="fi-alert" style="font-size:2rem;"></i> Oops..</h5>

	
	
	<?php if (!$user->password_match): ?>
		<span class="sub-header clearfix">Passwords do not match! </span>
	<?php endif ?>

	
	
<a href="#" class="close">&times;</a>
</div>
<?php endif ?>

<form class="row panel callout" action="<?php eh(url('')); ?>" method="post">
	<div class="small-12 columns">
		<div class="row">
			<h5>Change Password</h5>
		</div>
		<div class="row">
		

			

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
			<div class="medium-6 small-centered columns">
				<?php if (!empty($user->validation_errors['user_password']['length']) || $user->password_match==false): ?>
					<label class="cus-error"><i class="fi-alert"></i>Confirm Password
				<?php else: ?>
					<label>Current Password
				<?php endif; ?>
					<input type="password" name="user_confirm_password" maxlength='30'>
					</label>
			</div>
			<div class="small-12 columns">
				<div class="row">
					<div class="small-6 small-centered columns text-center">
						<input type="hidden" value="info_ok" name="page_next">
						<input type="submit" value="Save Changes" class="button ">
					</div>
				</div>
			</div>
		</div>
  	</div>
</form>

<div class="row">
	<div class="span5">
		<form method="post" action="<?php echo $this->Html->url('/users/register'); ?>" class="form-horizontal">
			<legend>Register</legend>

			<div class="control-group">		
				<label class="control-label" for="user_name">Name</label>
				<div class="controls">
					<input id="user_name" type="text" name="User[name]" />
				</div>
			</div>

			<div class="control-group">		
				<label class="control-label" for="user_email">Email</label>
				<div class="controls">
					<input id="user_email" type="text" name="User[email]" />
				</div>
			</div>

			<div class="control-group">		
				<label class="control-label" for="user_password">Password</label>
				<div class="controls">
					<input id="user_password" type="password" name="User[password]" />
				</div>
			</div>

			<div class="control-group">		
				<label class="control-label" for="user_password2">Confirm password</label>
				<div class="controls">
					<input id="user_password2" type="password" name="User[password2]" />
				</div>
			</div>

			<div class="form-actions">
				<button type="submit" class="btn btn-primary">Submit</button>
				<button type="reset" class="btn">Reset</button>
			</div>
		</form>
	</div>
	<div class="span7">
		&nbsp;
	</div>
</div>

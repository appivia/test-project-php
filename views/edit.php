<form method="post" action="update.php?id=<?= $user->getId() ?>" class="js-ajax-form js-update-user-form needs-validation" novalidate>
	<legend class="mb-4">
		Update user #<?= $user->getId() ?>
	</legend>

	<p>
		<a href="/">
			<span class="bi bi-arrow-left"></span>
			Go back to all users
		</a>
	</p>

	<div class="row mb-3">
		<label for="name" class="col-sm-2 col-form-label">Name:</label>
		<div class="col-sm-10">
			<input name="name" type="text" id="name" class="form-control" value="<?= $user->getName() ?>" required>
		</div>
	</div>

	<div class="row mb-3">
		<label for="email" class="col-sm-2 col-form-label">E-mail:</label>
		<div class="col-sm-10">
			<input name="email" type="email" id="email" class="form-control" value="<?= $user->getEmail() ?>" required>
		</div>
	</div>

	<div class="row mb-3">
		<label for="city" class="col-sm-2 col-form-label">City:</label>
		<div class="col-sm-10">
			<input name="city" type="text" id="city" class="form-control" value="<?= $user->getCity() ?>" required>
		</div>
	</div>


	<button type="submit" class="btn btn-primary">
		Update User
	</button>
</form>

<script>
	$(function () {
		$('.js-update-user-form').on('form:success', (event, data) => {
			// Show the success message
			createAlert($('.js-update-user-form'), 'User was successfully updated', 'success');
		});
	});
</script>

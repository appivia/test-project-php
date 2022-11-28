<header>
	<h1>PHP Test Application</h1>
</header>

<div class="table-responsive mb-4">
	<table class="table table-striped js-users-table">
		<thead>
			<tr>
				<th>Name</th>
				<th>E-mail</th>
				<th>City</th>
			</tr>
		</thead>
		<tbody class="table-group-divider">
			<?foreach($users as $user){?>
			<tr>
				<td><?=$user->getName()?></td>
				<td><?=$user->getEmail()?></td>
				<td><?=$user->getCity()?></td>
			</tr>
			<?}?>
		</tbody>
	</table>
</div>

<hr>

<form method="post" action="create.php" class="js-ajax-form js-add-user-form needs-validation" novalidate>
	<legend class="mb-0">
		Create a new user
	</legend>

	<p class="small mb-4">
		Create a new user by adding their information on the form below
	</p>

	<div class="row mb-3">
		<label for="name" class="col-sm-2 col-form-label">Name:</label>
		<div class="col-sm-10">
			<input name="name" type="text" id="name" class="form-control" required>
		</div>
	</div>

	<div class="row mb-3">
		<label for="email" class="col-sm-2 col-form-label">E-mail:</label>
		<div class="col-sm-10">
			<input name="email" type="email" id="email" class="form-control" required>
		</div>
	</div>

	<div class="row mb-3">
		<label for="city" class="col-sm-2 col-form-label">City:</label>
		<div class="col-sm-10">
			<input name="city" type="text" id="city" class="form-control" required>
		</div>
	</div>

	<button type="submit" class="btn btn-primary">
		Create new row
	</button>
</form>

<script>
	$(function () {
		$('.js-add-user-form').on('form:success', (event, data) => {
			// Show the success message
			createAlert($('.js-add-user-form'), 'User was successfully added', 'success');

			// Add the user to the table
			$('.js-users-table tbody').append(`
				<tr>
					<td>${data.name || ''}</td>
					<td>${data.email || ''}</td>
					<td>${data.city || ''}</td>
				</tr>
			`);
		});
	});
</script>

<header>
	<h1>PHP Test Application</h1>
</header>

<div class="table-responsive mb-4 js-users-container">
	<table class="table table-striped js-users-table">
		<thead>
			<tr>
				<th>#</th>
				<th>Name</th>
				<th>E-mail</th>
				<th>City</th>
			</tr>
		</thead>
		<tbody class="table-group-divider">
			<?foreach($users as $user){?>
			<tr data-id="<?=$user->getId()?>">
				<td><?=$user->getId()?></td>
				<td><?=$user->getName()?></td>
				<td><?=$user->getEmail()?></td>
				<td><?=$user->getCity()?></td>
				<td>
					<a href="/edit.php?id=<?=$user->getId()?>" class="btn btn-secondary">
						Edit
					</a>
				</td>
				<td>
					<a href="/delete.php?id=<?=$user->getId()?>" class="js-delete-user btn btn-danger" data-id="<?=$user->getId()?>">
						Delete
					</a>
				</td>
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
		Create User
	</button>
</form>

<script>
	$(function () {
		$('.js-add-user-form').on('form:success', (event, data) => {
			// Show the success message
			$form = $('.js-add-user-form');
			createAlert($form, 'User was successfully added', 'success');
			$form.trigger('reset');

			// Add the user to the table
			$('.js-users-table tbody').append(`
				<tr data-id="${data.id}">
					<td>${data.id}</td>
					<td>${data.name || ''}</td>
					<td>${data.email || ''}</td>
					<td>${data.city || ''}</td>
					<td>
						<a href="/edit.php?id=${data.id}" class="btn btn-secondary">
							Edit
						</a>
					</td>
					<td>
						<a href="/delete.php?id=${data.id}" class="js-delete-user btn btn-danger" data-id="${data.id}">
							Delete
						</a>
					</td>
				</tr>
			`);
		});

		$(document).on('click', '.js-delete-user', (evt) => {
			evt.preventDefault();
			evt.stopPropagation();

			if (!confirm('You are about to permanently delete this user, are you sure?')) {
				return;
			}

			const $target = $(event.target);

			$.ajax({
				url: $target.attr('href'),
				method: 'delete',
				success: () => {
					createAlert($('.js-users-container'), 'User was successfully deleted', 'success');
					const $row = $(`tr[data-id="${$target.data('id')}"]`);
					$row.hide(() => $row.remove());
				},
				error: () => {
					createAlert($('.js-users-container'), 'User could not be deleted', 'danger');
				},
			});
		});
	});
</script>

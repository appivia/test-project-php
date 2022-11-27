<header>
	<h1>PHP Test Application</h1>
</header>

<div class="table-responsive mb-4">
	<table class="table table-striped">
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

<form method="post" action="create.php" class="needs-validation" novalidate>
	<div class="row mb-3">
		<label for="name" class="col-sm-2 col-form-label">Name:</label>
		<div class="col-sm-10">
			<input name="name" input="text" id="name" class="form-control" required />
		</div>
	</div>

	<div class="row mb-3">
		<label for="email" class="col-sm-2 col-form-label">E-mail:</label>
		<div class="col-sm-10">
			<input name="email" input="email" id="email" class="form-control" required />
		</div>
	</div>

	<div class="row mb-3">
		<label for="city" class="col-sm-2 col-form-label">City:</label>
		<div class="col-sm-10">
			<input name="city" input="text" id="city" class="form-control" required />
		</div>
	</div>

	<button type="submit" class="btn btn-primary">
        Create new row
    </button>
</form>

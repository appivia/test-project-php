<h1 class="text-center">PHP Test Application</h1>

<div class="container-fluid">
<form class="form-horizontal" method="post" action="create.php">
	<div class="form-group">
		<label class="control-label col-sm-5" for="name">Name:</label>
		<div class="col-sm-3"><input name="name" input="text" id="name" class="form-control"/></div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-5" for="email">E-mail:</label>
		<div class="col-sm-3"><input name="email" type="email" input="text" id="email" class="form-control"/></div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-5" for="city">City:</label>
		<div class="col-sm-3"><input name="city" input="text" id="city" class="form-control"/></div>
	</div>
    <div class="form-group">
		<div class="col-sm-4 col-sm-offset-5">
			<button class="btn btn-default">Create new row</button>
		</div>
	</div>
</form>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th>E-mail</th>
			<th>City</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($users as $user){?>
		<tr>
			<td><?=$user->getName()?></td>
			<td><?=$user->getEmail()?></td>
			<td><?=$user->getCity()?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
</div>
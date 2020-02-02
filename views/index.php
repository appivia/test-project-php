<h1 class="text-center">PHP Test Application</h1>

<div class="container-fluid">
<?php
  include './views/form.php'
?>
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
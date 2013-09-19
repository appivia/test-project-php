<h1>PHP Test Application</h1>

<table>
	<thead>
		<tr>
			<th>Name</th>
			<th>E-mail</th>
			<th>City</th>
		</tr>
	</thead>
	<tbody>
		<?foreach($users as $user){?>
		<tr>
			<td><?=$user->getName()?></td>
			<td><?=$user->getEmail()?></td>
			<td><?=$user->getCity()?></td>
		</tr>
		<?}?>
	</tbody>
</table>				

<form method="post" action="create.php">
	
	<label for="name">Name:</label>
	<input name="name" input="text" id="name"/>
	
	<label for="email">E-mail:</label>
	<input name="email" input="text" id="email"/>
	
	<label for="city">City:</label>
	<input name="city" input="text" id="city"/>
	
	<button>Create new row</button>
</form>
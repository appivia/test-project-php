<script>
users = [
<?php
  // this is messy. better would be to create a separate endpoint to serve filters
  // or even better - to use a framework like React that would nicely handle this

  foreach($users as $user) {
    $resolvedUser = array("name" => $user->getName(), "email" => $user->getEmail(), "city" => $user->getCity());
    echo json_encode($resolvedUser);
    echo ",";
  }
?>
]
</script>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th>E-mail</th>
			<th>City <input type="text" id="cityFilter" placeholder="Filter by city name"/></th>
		</tr>
	</thead>
	<tbody id="tableList">
        <!-- Keeping it in case user has JS disabled -->
		<?php foreach($users as $user) {?>
		<tr>
			<td><?=$user->getName()?></td>
			<td><?=$user->getEmail()?></td>
			<td><?=$user->getCity()?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>

<script>
  $("#cityFilter").keyup(() => {
    const cityFilterValue = $("#cityFilter").val()
    const usersToRender = cityFilterValue == ""
        ? users
        : users.filter(({city}) => city.toLowerCase().startsWith(cityFilterValue.toLowerCase()))
    renderUserList(usersToRender)
  })
</script>
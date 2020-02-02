<h1 class="text-center">PHP Test Application</h1>
<script>
  let users = []; // used in the children templates

  function createUser(name, email, city) {
	  return {name, email, city}
  }
  function renderRow(user) {
      return `<tr>
        <td>${user.name}</td>
		<td>${user.email}</td>
		<td>${user.city}</td>
      </tr>`
  }

  function renderUserList(usersToRender) {
	$("#tableList").html(usersToRender.map(renderRow).join());
  }

</script>
<div class="container-fluid">
<?php
  include './views/form.php'
?>

<?php
  include './views/usersList.php'
?>

</div>
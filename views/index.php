<h1 class="text-center">PHP Test Application</h1>
<script>
  let users = []; // used in the children templates

  function createUser(name, email, city, phoneNumber) {
	  return {name, email, city, phoneNumber}
  }

  // in the ideal world, this would only be in usersList.php
  function renderRow(user) {
      return `<tr>
        <td>${user.name}</td>
		<td>${user.email}</td>
		<td>${user.city}</td>
		<td>${user.phoneNumber || ''}</td>
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
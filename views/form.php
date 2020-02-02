

<form class="form-horizontal" method="post" id="new-user-form">
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
			<input type="submit" class="btn btn-default" value="Create new row" />
		</div>
	</div>
</form>


<script>
  $("form").on( "submit", async function( event ) {
    event.preventDefault();

    const qs = $( this ).serialize()
    // ideally send POST, but this is faster to debug in PHP
    try {
        const fetchResponse = await fetch(`/api/user.php?${qs}`)
        const json = await fetchResponse.json()
        if (!json) { return }
        if (json.error) {
            alert(json.error)
        }
        if (json.success) {
            alert(json.success)
            users.push(json.user)
            renderUserList(users)
            $("form")[0].reset()
        }
    } catch(e) {
        console.log(e)
    }
  });
</script>

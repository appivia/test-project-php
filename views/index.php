<div class="row">

    <div id="header" class="col-md-12">
        <div class="page-header">
            <h1>PHP Test Application <small>Users List</small></h1>
        </div>
    </div>

    <div id="main" class="col-md-8">

    <div class="row filter">
        <div class="col-md-4 col-md-push-8">
              <input type="text" class="form-control" placeholder="Enter a City for filtering..">
        </div>
    </div>
    <div class="table-responsive">
    <table class="table table-striped table-hover table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>E-mail</th>
                <th>City</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($users as $user): ?>
            <tr>
                <td><?= $user->getName() ?></td>
                <td><?= $user->getEmail() ?></td>
                <td><?= $user->getCity() ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    </div>
    </div>

<div id="sidebar" class="col-md-4">

   <div class="well">

       <h3 class="well-header"><span class="glyphicon glyphicon-user"></span> Add New User</h3>

        <form method="post" action="create.php" class="form form-horizontal">

            <div class="form-group">
                <label for="name" class="col-sm-3 control-label">Name:</label>
                <div class="col-sm-9">
                    <input name="name" input="text" class="form-control" id="name" />
                </div>
            </div>

            <div class="form-group">
                <label for="email" class="col-sm-3 control-label">Email:</label>
                <div class="col-sm-9">
                    <input name="email" input="email" class="form-control" id="email" />
                </div>
            </div>

            <div class="form-group">
                <label for="city" class="col-sm-3 control-label">City:</label>
                <div class="col-sm-9">
                    <input name="city" input="text" class="form-control" id="city" />
                </div>
            </div>

            <input type="submit" class="btn btn-primary btn-lg btn-block" value="Create" />
        </form>
    </div>

</div>
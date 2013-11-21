<div ng-controller="UsersCtrl">

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
                <th>Phone N.</th>
                <th class="city">City</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($users as $user): ?>
            <tr>
                <td><?= $user->getName() ?></td>
                <td><?= $user->getEmail() ?></td>
                <td><?= $user->getPhoneNumber() ?></td>
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

        <form name="newUserForm" novalidate ng-submit="addUser()" class="form form-horizontal">

            <div class="form-group" ng-class="{'has-error': submitted && newUserForm.name.$invalid}">
                <label for="name" class="col-sm-3 control-label">Name:</label>
                <div class="col-sm-9">
                    <input name="name" input="text" class="form-control" id="name" ng-model="user.name" ng-pattern="name" required="required" />

                </div>
            </div>

            <div class="form-group" ng-class="{'has-error': submitted && newUserForm.email.$error.email}">
                <label for="email" class="col-sm-3 control-label">Email:</label>
                <div class="col-sm-9">
                    <input name="email" type="email" class="form-control" id="email" ng-model="user.email" />
                    <span ng-show="submitted && newUserForm.email.$error.email" class="help-block">Please enter a valid email address.</span>
                </div>
            </div>

            <div class="form-group" ng-class="{'has-error': submitted && newUserForm.phone.$invalid}">
                <label for="phone" class="col-sm-3 control-label">Phone:</label>
                <div class="col-sm-9">
                    <input name="phone" input="text" class="form-control" id="phone" ng-model="user.phone" ng-pattern="phone" />
                    <span ng-show="submitted && newUserForm.phone.$invalid" class="help-block">Please enter a valid phone number, allowed characters are "[0-9]- ()".</span>
                </div>
            </div>

            <div class="form-group" ng-class="{'has-error': submitted && newUserForm.city.$invalid}">
                <label for="city" class="col-sm-3 control-label">City:</label>
                <div class="col-sm-9">
                    <input name="city" input="text" class="form-control" id="city" ng-model="user.city" ng-pattern="city" />
                    <span ng-show="submitted && newUserForm.city.$invalid" class="help-block">Please enter a valid city.</span>
                </div>
            </div>

            <button class="btn btn-primary btn-lg btn-block" ng-click="submitted=true">Create</button>
        </form>
    </div>

</div>
</div>
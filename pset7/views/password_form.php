<!-- Users can change their passwords by confirming their old password and submitting (and confirming) a new one -->
<form action="change_password.php" method="post">
    <fieldset>
        <div class="form-group">
            <input autocomplete="off" autofocus class="form-control" name="old" placeholder="Current Password" type="password"/>
        </div>
        <div class="form-group">
            <input class="form-control" name="new" placeholder="New Password" type="password"/>
        </div>
        <div class="form-group">
            <input class="form-control" name="new_confirm" placeholder="Confirm New Password" type="password"/>
        </div>
        <div class="form-group">
            <button class="btn btn-default" type="submit">
                <span aria-hidden="true" class="glyphicon glyphicon-log-in"></span>
                Change Password
            </button>
        </div>
    </fieldset>
</form>
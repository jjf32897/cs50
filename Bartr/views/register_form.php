<!-- New users can register with a a school, username, email, and password -->
<form action="register.php" method="post">
    <fieldset>
        Which school do you attend?
        <div class="form-group">
            <select autofocus class="form-control" name="inst">
                <option disabled selected value="">Your Institution</option>
                <?php foreach($schools as $school): ?>
                <option value=<?=$school["id"]?>><?=$school["name"]?></option>
                <?php endforeach ?>
            </select>
        </div>
        Username (<i><16 characters</i>):
        <div class="form-group">
            <input autocomplete="off" class="form-control" name="username" placeholder="Username" type="text"/>
        </div>
        University E-mail:
        <div class="form-group">
            <input class="form-control" name="email" placeholder="E-mail Address" type="text"/>
            <input class="form-control" name="emailconf" placeholder="Confirm E-mail Address" type="text"/>
        </div>
        Password (<i>6-20 characters</i>):
        <div class="form-group">
            <input class="form-control" name="password" placeholder="Password" type="password"/>
            <input class="form-control" name="passconf" placeholder="Confirm Password" type="password"/>
        </div>
        <div class="form-group">
            <button class="btn btn-default" type="submit">
                <span aria-hidden="true" class="glyphicon glyphicon-log-in"></span>
                Register
            </button>
        </div>
    </fieldset>
</form>
<div>
    or <a href="login.php">Log In</a>
</div>

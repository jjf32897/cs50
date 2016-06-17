<!--form to submit a new offer-->
<form action="offer.php" method="post" enctype="multipart/form-data">
    <fieldset>
        <div class="form-group">
            <select class="form-control" name="type">
                <option disabled selected value="">You are...</option>
                <option value="Give">Giving</option>
                <option value="Want">Wanting</option>
            </select>
            <input class="form-control" name="item" placeholder="What is it?" type="text"/>
        </div>
        <div class="form-group" align="middle">
            <input type="file" name="fileToUpload" id="fileToUpload">
        </div>
        <div class="form-group">
            <button class="btn btn-default" type="submit" name="submit">
                <span aria-hidden="true" class="glyphicon glyphicon-log-in"></span>
                Post Offer
            </button>
        </div>
    </fieldset>
</form>
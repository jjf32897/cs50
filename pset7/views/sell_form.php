<!-- Users can select one of their owned stocks and sell all shares of it -->
<form action="sell.php" method="post">
    <fieldset>
        <div class="form-group">
            <select class="form-control" name="stock">
                <option disabled selected value="">Symbol</option>
                <?php foreach ($stocks as $stock): ?>
                <option value=<?= $stock["symbol"] ?>><?= $stock["symbol"] ?> (<?= $stock["shares"] ?>)</option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="form-group">
            <button class="btn btn-default" type="submit">
                <span aria-hidden="true" class="glyphicon glyphicon-log-in"></span>
                Sell
            </button>
        </div>
    </fieldset>
</form>
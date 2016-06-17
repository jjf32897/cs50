<!-- Displays a title for the page followed by a table of past transactions-->
<h3>Your Transaction History</h3>
<table class="table table-hover">
        <thead>
            <tr>
                <th>Date/Time</th>
                <th>Transaction</th>
                <th>Symbol</th>
                <th>Price</th>
                <th>Shares</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody style="text-align:left">
            <?php foreach ($transactions as $transaction): ?>
                <tr>
                    <td><?= $transaction["time"] ?></td>
                    <td><?= $transaction["trans"] ?></td>
                    <td><?= $transaction["symbol"] ?></td>
                    <td>$<?= number_format($transaction["price"], 2) ?></td>
                    <td><?= $transaction["shares"] ?></td>
                    <td>$<?= number_format($transaction["price"] * $transaction["shares"], 2) ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
<!-- Displays the page title and current balance followed by a table of owned stocks iff any stocks are owned -->
<h3>Your Portfolio</h3>
<p>Current Balance: $<?= number_format($fat_stacks, 2) ?></p>
<?php if (count($positions) != 0): ?>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Stock Name</th>
                <th>Symbol</th>
                <th>Shares Owned</th>
                <th>Current Price</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody style="text-align:left">
            <?php foreach ($positions as $position): ?>
                <tr>
                    <td><?= $position["name"] ?></td>
                    <td><?= $position["symbol"] ?></td>
                    <td><?= $position["shares"] ?></td>
                    <td>$<?= number_format($position["price"], 2) ?></td>
                    <td>$<?= number_format($position["price"] * $position["shares"], 2) ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
<?php endif; ?>
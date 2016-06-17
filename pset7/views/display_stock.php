<!-- Displays the name, symbol, and price of the requested stock. -->
<h3><?= htmlspecialchars($name) ?> (<?= $symbol ?>)</h3>
<p>Current Price: $<?= number_format($price,2) ?></p>
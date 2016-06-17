<!--table that displays a table of all confirmed transactions involving the current user-->
<?php if(!empty($transactions)): ?>
    <div style="width:1145px; height:295px; border:6px ridge #686868; overflow:auto;">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Offerer</th>
                    <th>Confirmed</th>
                    <th>Offer</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody style="text-align:left">
                <?php foreach ($transactions as $transaction): ?>
                    <tr>
                        <!--Will display "You" in place of the current user's own username-->
                        <?php if ($transaction["offerer_id"] == $_SESSION["id"]): ?>
                            <td>You</td>
                        <?php endif; ?>
                        <?php if ($transaction["offerer_id"] != $_SESSION["id"]): ?>
                            <td><?= htmlspecialchars(getusername($transaction["offerer_id"])) ?></td>
                        <?php endif; ?>
                        <?php if ($transaction["confirmed_id"] == $_SESSION["id"]): ?>
                            <td>You</td>
                        <?php endif; ?>
                        <?php if ($transaction["confirmed_id"] != $_SESSION["id"]): ?>
                            <td><?= htmlspecialchars(getusername($transaction["confirmed_id"])) ?></td>
                        <?php endif; ?>
                        <td><?= htmlspecialchars($transaction["offer"]) ?></td>
                        <td><?= date("n/j/y, g:ia", strtotime($transaction["time"])) ?></td> 
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<!--If no transactions were found, display something else-->
<?php if(empty($transactions)): ?>

    <h3> You haven't completed any transactions. </h3>

<?php endif; ?>
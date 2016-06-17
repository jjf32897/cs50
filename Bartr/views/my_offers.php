<!--A scrollable table that displays all offers made by the current user-->
<?php if(!empty($my_offers)): ?>
    <div style="width:1145px; height:295px; border:6px ridge #686868; overflow:auto;">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Give/Want</th>
                    <th>Item</th>
                    <th>Time</th>
                    <th>Responses</th>
                    <th>Photo</th>
                    <th></th>
                </tr>
            </thead>
            <tbody style="text-align:left">
                <?php foreach ($my_offers as $offer): ?>
                    <tr>
                        <td><?= $offer["type"] ?></td>
                        <td><?= htmlspecialchars($offer["offer"]) ?></td>
                        <td><?= date("n/j/y, g:ia", strtotime($offer["time"])) ?></td>
                        
                        <!--if there are no responders, display a solid 0-->
                        <?php if ($offer["responses"] == 0): ?>
                            <td>0</td>
                        <?php endif; ?>
                        
                        <!--if there are responders, make the number a link to open a modal window and submit a GET request via the URL-->
                        <?php if ($offer["responses"] != 0): ?>
                            
                            <!--send the offer ID to the URL and open modal window 2-->
                            <td><a href="my_offers.php?id=<?= $offer["id"] ?>#openModal2"><?= $offer["responses"] ?></a></td>
                        <?php endif; ?>
                        
                        <!--click "View Photo" to send the photo's location in /uploads to the URL and open modal window 1-->
                        <td><a href="?photo=<?= $offer["photo"] ?>#openModal">View Photo</a></td>
                        <td><a href='' onclick="deleteoffer(<?= $offer["id"]?>)">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!--modal window to display the offer's image-->
    <div id="openModal" class="modalDialog">
    	<div>
    	    <a href="#close" title="Close" class="close">X</a>
    	    
    	    <!--retrieves the image location from the URL and displays it-->
    	    <?php if ($_GET["photo"] != ""): ?>
        		  <img src=<?php echo "/uploads" . "/" . $_GET["photo"] ?> alt="offer_img" height="400">
    		<?php endif; ?>
    		
    		<!--displays something else if there is no photo-->
    		<?php if ($_GET["photo"] == ""): ?>
    		    <h2>No photo available.</h2>
    		<?php endif; ?>
    	</div>
    </div>

    <!--modal dialog box that displays a list of responders to the offer-->
    <div id="openModal2" class="modalDialog">
	    <div>
		    <a href="#close" title="Close" class="close">X</a>
		    <div style="width:350px; height:315px; overflow:auto;">
    		    <table class="table table-hover">
    		        <thead>
    		            <tr>
        		            <th>Responders</th>
        		            <th></th>
                        </tr>
    		        </thead>
    		        <tbody style="text-align:left">
    		            <?php $responders = getresponders($_GET["id"]);
    		                  $offer_id = $_GET["id"];
    		                  foreach ($responders as $responder): ?>
    		                    <tr>
        		                    <td><?= htmlspecialchars(getusername($responder["sender_id"])) ?></td>
        		                    
        		                    <!--a link to call confirmoffer() in scripts.js-->
        		                    <td><a href='' onclick="confirmoffer(<?= $responder["sender_id"] ?>, <?= $offer_id ?>)">Confirm</a></td>
    		                    </tr>
    		            <?php endforeach; ?>
    		        </tbody>
    		    </table>
		    </div>
	    </div>
    </div>
<?php endif; ?>

<!--If there are no offers, display something else-->
<?php if(empty($my_offers)): ?>

    <h3> You don't have any active offers. <a href="/offer.php">Make one now</a>. </h3>

<?php endif; ?>
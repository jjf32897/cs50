<!--displays a table showing current offers at the user's school-->
<!--search form-->
<form action="search.php" method="post">
    <div class="form-group">
        <input class="form-control" name="search" placeholder="Search" type="text"/>
        <button class="btn btn-default" type="submit">Search</button>
    </div>
</form>
<?php if(!empty($offers)): ?>
    <div style="width:1145px; height:245px; border:6px ridge #686868; overflow:auto;">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Give/Want</th>
                    <th>Item</th>
                    <th>Time</th>
                    <th>Responses</th>
                    <th>Photo</th>
                    <th></th>
                </tr>
            </thead>
            <tbody style="text-align:left">
                <?php foreach ($offers as $offer): ?>
                    <tr>
                        <!--will display "You" instead of the current user's username-->
                        <?php if ($offer["username"] == getusername($_SESSION["id"])): ?>
                            <td>You</td>
                        <?php endif; ?>
                        <?php if ($offer["username"] != getusername($_SESSION["id"])): ?>
                            <td><?= htmlspecialchars($offer["username"]) ?></td>
                        <?php endif; ?>
                        <td><?= $offer["type"] ?></td>
                        <td><?= htmlspecialchars($offer["offer"]) ?></td>
                        <td><?= date("n/j/y, g:ia", strtotime($offer["time"])) ?></td>
                        <td><?= $offer["responses"] ?></td>
                        
                        <!--will open a modal window to display the offer's photo-->
                        <td><a href="/?photo=<?= $offer["photo"] ?>#openModal">View Photo</a></td>
                        
                        <!--if the offerer is not the current user, allow the ability to "Respond"-->
                        <?php if (getuserID($offer["username"]) == $_SESSION["id"]): ?>
                            <td></td>
                        <?php endif; ?>
                        <?php if (getuserID($offer["username"]) != $_SESSION["id"]): ?>
                        
                            <!--opens a modal window that provides a messaging form-->
                            <td><a href="?user=<?= $offer["username"] ?>&id=<?= $offer["id"] ?>#openModal2">Respond</a></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    
    <!--modal window to display the offer's image-->
    <div id="openModal" class="modalDialog">
    	<div>
    	    <a href="#close" title="Close" class="close">X</a>
    	    <?php if ($_GET["photo"] != ""): ?>
        		  <img src=<?php echo "/uploads" . "/" . $_GET["photo"] ?> alt="offer_img" height="400">
    		<?php endif; ?>
    		<?php if ($_GET["photo"] == ""): ?>
    		    <h2>No photo available.</h2>
    		<?php endif; ?>
    	</div>
    </div>
    
    <!--modal window to open up a response (message) form-->
    <div id="openModal2" class="modalDialog">
    	<div>
    		<a href="#close" title="Close" class="close">X</a>
    		<h2>Message</h2>
    		
    		<!--retrieves the user from the URL-->
    		<p>To: <?= htmlspecialchars($_GET["user"]) ?></p>
    		<form action="message.php" method="post">
    		    <textarea autofocus rows="4" cols="50" required maxlength="150" name="msg" required></textarea>
    		    <input type="hidden" name="recipient" value=<?= getuserID($_GET["user"])?>>
		        <input type="hidden" name="offer_id" value=<?= $_GET["id"]?>>
    		    <div class="form-group">
                    <button class="btn btn-default" type="submit">Send</button>
                </div>
    		</form>
    	</div>
    </div>
    
<?php endif; ?>

<!--if there aren't any active offers, display something else-->
<?php if(empty($offers)): ?>

    <h3> No offers to show! </h3>

<?php endif; ?>
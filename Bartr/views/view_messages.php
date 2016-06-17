<!--displays all of the user's active conversations-->

<!--displays something else if there are no conversations-->
<?php if(empty($messages)): ?>
    
    <h3> No messages </h3>

<?php endif; ?>

<?php if(!empty($messages)): ?>
    <div style="width:1145px; height:295px; border:6px ridge #686868; overflow:auto;">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Offer</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody style="text-align:left">
                <?php foreach ($messages as $message): ?>
                    <tr>
                        <?php
                            if ($message["sender_id"] == $_SESSION["id"])
                            {
                                printf("<td>You</td>");
                            }
                            else
                            {
                                printf("<td>%s</td>", htmlspecialchars(getusername($message["sender_id"])));
                            }
                        ?>
                        <td><?= getoffer($message["offer_id"]) ?></td>
                        
                        <!--will open a modal window to display all messages of the selected conversation-->
                        <td><a href="messages.php?user=<?= $message["sender_id"] ?>&id=<?= $message["offer_id"] ?>#openModal">View Conversation</a></td> 
                        
                        <!--allows the user to respond to the message if it is not a conversation with only their messages-->
                        <?php if ($message["sender_id"] != $_SESSION["id"]): ?>
                            <td><a href="/messages.php?user=<?= getusername($message["sender_id"]) ?>&id=<?= $message["offer_id"] ?>#openModal2">Respond</a></td>
                        <?php endif; ?>
                        <?php if ($message["sender_id"] == $_SESSION["id"]): ?>
                            <td></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    
    <!--modal window which displays all messages of a conversation from most recent to oldest-->
    <div id="openModal" class="modalDialogMsg">
    	<div>
    		<a href="#close" title="Close" class="close">X</a>
    		<div style="width:950px; height:440px; overflow:auto;">
    		    <table class="table table-hover">
    		        <thead>
    		            <tr>
    		                <th>From</th>
    		                <th>To</th>
    		                <th>Message</th>
    		                <th>Time</th>
    		            </tr>
    		        </thead>
    		        <tbody style="text-align:left">
    		            <?php
    		                $messages = getmessages($_GET["user"], $_GET["id"]);
    		                $messages = array_reverse($messages);
    		                foreach ($messages as $message): ?>
        		                <tr>
        		                    <?php if ($message["sender_id"] == $_SESSION["id"]): ?>
        		                        <td>You</td>
        		                    <?php endif; ?>
        		                    <?php if ($message["sender_id"] != $_SESSION["id"]): ?>
        		                        <td><?= htmlspecialchars(getusername($message["sender_id"])) ?></td>
        		                    <?php endif; ?>
        		                    <?php if ($message["recipient_id"] == $_SESSION["id"]): ?>
        		                        <td>You</td>
        		                    <?php endif; ?>
        		                    <?php if ($message["recipient_id"] != $_SESSION["id"]): ?>
        		                        <td><?= htmlspecialchars(getusername($message["recipient_id"])) ?></td>
        		                    <?php endif; ?>
        		                    <td><?= htmlspecialchars($message["content"]) ?></td>
        		                    <td><?= date("n/j/y, g:ia", strtotime($message["time"])) ?></td>
        		                </tr>
                        <?php endforeach; ?>
    		        </tbody>
                </table>
    		</div>
    	</div>
    </div>
    
    <!--a modal window that displays a form to submit a message-->
    <div id="openModal2" class="modalDialog">
    	<div>
    		<a href="#close" title="Close" class="close">X</a>
    		<h2>Message</h2>
    		<p>To: <?= htmlspecialchars($_GET["user"]) ?></p>
    		<form action="message.php" method="post">
    		    <textarea autofocus rows="4" cols="50" maxlength="150" name="msg" required></textarea>
    		    <input type="hidden" name="recipient" value=<?= getuserID($_GET["user"])?>>
		        <input type="hidden" name="offer_id" value=<?= $_GET["id"]?>>
    		    <div class="form-group">
                    <button class="btn btn-default" type="submit">Send</button>
                </div>
    		</form>
    	</div>
    </div>
    
<?php endif; ?>
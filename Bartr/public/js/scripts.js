/**
 * scripts.js
 *
 * Computer Science 50
 * Problem Set 7
 *
 * Global JavaScript, if any.
 */

// confirms an offer by passing data to confirm_offer.php
function confirmoffer(user_id, offer_id)
{
    $.getJSON("confirm_offer.php", {offer_id: offer_id, confirmed_id: user_id});
}

// deletes an offer by passing data to delete_offer.php
function deleteoffer(id)
{
    $.getJSON("delete_offer.php", {offer_id: id});
}


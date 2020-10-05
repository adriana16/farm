'use strict';

function saveBid(elem) {
    var $this= $(elem),
        auctionId = $this.data('auction'),
        userId = $this.data('user'),
        amount = $('#bid_amount').val(),
        url = Routing.generate('api_post_auction', {'id': auctionId})
    ;

    $.ajax({
        type: "POST",
        url: url,
        data: {
            'user': userId,
            'amount': amount
        }
    }).done(function(data) {
        updateAuctionDetails(data);
    }).fail(function(data) {
        if (409 === data.status) {
            alert(data.responseJSON[0]);
        }
    });
}

function updateAuctionDetails(data) {
    $('#bidders-list').html("<b>" + data.bidder.name + "</b> paid: $" + data.bidder.price);
}

function getBiddersList(auctionId) {
    var url = Routing.generate('api_get_auction', {'id': auctionId});

    $.ajax({
        type: "GET",
        url: url
    }).done(function(data) {

        updateAuctionDetails(data);
        console.log(data);
        console.log(data.auction.status);

        if ("open" !== data.auction.status) {
            console.log('stop');
            clearInterval(bidderList);

            //TO-DO
            //Create order with last bidder
        }
    });
}

window.saveBid = saveBid;
window.getBiddersList = getBiddersList;

export {
    getBiddersList
}

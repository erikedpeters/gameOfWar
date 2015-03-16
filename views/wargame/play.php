<script>
    var playerOneDeck = [<?='\''.implode('\',\'',$playerOneDeck).'\''?>];
    var playerTwoDeck = [<?='\''.implode('\',\'',$playerTwoDeck).'\''?>];
    var playerOneDiscard = [];
    var playerTwoDiscard = [];
    $(document).ready(function(){
        $('.toggle').click(function(){
            if($('.cardView').is(":Visible")){
                $('.cardView').hide();
                $('.toggle').html('Show Cards');
            } else {
                $('.cardView').show();
                $('.toggle').html('Hide Cards');
            }
        })
        $('.button').click(function(){
            alert('Player One: '+playerOneDeck[0]+'\nPlayer Two: '+playerTwoDeck[0]);
            var outcome = compareCards(playerOneDeck[0], playerTwoDeck[0]);
            if(outcome == 1){
                alert('Player One Wins this battle!');
                playerOneDiscard.push(playerOneDeck[0], playerTwoDeck[0]);
                removeTopOfDecks();
            } else if(outcome == 2){
                alert('Player Two Wins this battle!');
                playerTwoDiscard.push(playerOneDeck[0], playerTwoDeck[0]);
                removeTopOfDecks();
            } else {
                alert('WAR!!!');
                war();
            }
            
            if(playerOneDeck.length == 0){
                if(playerOneDiscard.length > 0){
                    playerOneDiscard = shuffle(playerOneDiscard);
                    playerOneDeck= $.merge(playerOneDeck, playerOneDiscard);
                    playerOneDiscard = [];
                } else {
                    alert('Player Two Wins!');
                }
            }
            if(playerTwoDeck.length == 0){
                if(playerTwoDiscard.length > 0){
                    playerTwoDiscard = shuffle(playerTwoDiscard);
                    playerTwoDeck= $.merge(playerTwoDeck, playerTwoDiscard);
                    playerTwoDiscard = [];
                } else {
                    alert('Player One Wins!');
                }
            }

            populateCardList();
        });
    });

    function removeTopOfDecks(){
        playerOneDeck.splice(0,1);
        playerTwoDeck.splice(0,1);
    }

    function populateCardList(){
        $('.p1Cards').html('<b>Player One Cards:</b><br />');
        $('.p2Cards').html('<b>Player Two Cards:</b><br />');
        $.each(playerOneDeck, function(key, card){$('.p1Cards').append(card+"<br />")});
        $('.p1Discards').html('<b>Player One Discard Pile:</b><br />');
        $.each(playerOneDiscard, function(key, card){$('.p1Discards').append(card+"<br />")});
        $.each(playerTwoDeck, function(key, card){$('.p2Cards').append(card+"<br />")});
        $('.p2Discards').html('<b>Player Two Discard Pile:</b><br />');
        $.each(playerTwoDiscard, function(key, card){$('.p2Discards').append(card+"<br />")});
    }
    
    function compareCards(card1, card2){
        if(card1.indexOf("Ace") > -1){card1 = 14;}
        else if(card1.indexOf('King') > -1){card1 = 13;}
        else if(card1.indexOf('Queen') > -1){card1 = 12;}
        else if(card1.indexOf('Jack') > -1){card1 = 11;}
        else if(card1.indexOf('10') > -1){card1 = 10;}
        else{card1 = card1.substring(0,1);}
        if(card2.indexOf("Ace") > -1){card2 = 14;}
        else if(card2.indexOf('King') > -1){card2 = 13;}
        else if(card2.indexOf('Queen') > -1){card2 = 12;}
        else if(card2.indexOf('Jack') > -1){card2 = 11;}
        else if(card2.indexOf('10') > -1){card2 = 10;}
        else{card2 = card2.substring(0,1);}

        if(card1 > card2){
            return 1;
        } else if(card1 < card2){
            return 2;
        } else if(card1 == card2){
            return 0;
        }
    }

    function war(){
        var resolved = false;

        if(playerOneDeck.length<5){
            if(playerOneDiscard.length != 0){
                playerOneDiscard = shuffle(playerOneDiscard);
                playerOneDeck= $.merge(playerOneDeck, playerOneDiscard);
                playerOneDiscard = [];
            }
        }
        if(playerTwoDeck.length<5){
            if(playerTwoDiscard.length != 0){
                playerTwoDiscard = shuffle(playerTwoDiscard);
                playerTwoDeck= $.merge(playerTwoDeck, playerTwoDiscard);
                playerTwoDiscard = [];
            }
        }
        while(!resolved){
            var contestedPlayerOneCards = [];
            var contestedPlayerTwoCards = [];
            if(playerOneDeck.length < 5){
                for(var i=0;i<playerTwoDeck.length-1;i++) {
                    contestedPlayerTwoCards.push(playerTwoDeck[0]);
                    playerTwoDeck.splice(0,1);
                }
            } else {
                for(var i=0;i<5;i++) {
                    contestedPlayerOneCards.push(playerOneDeck[0]);
                    playerOneDeck.splice(0,1);
                }
            }
            if(playerTwoDeck.length < 5){
                for(var i=0;i<playerTwoDeck.length-1;i++) {
                    contestedPlayerTwoCards.push(playerTwoDeck[0]);
                    playerTwoDeck.splice(0,1);
                }
            } else {
                for(var i=0;i<5;i++) {
                    contestedPlayerTwoCards.push(playerTwoDeck[0]);
                    playerTwoDeck.splice(0,1);
                }
            }
            resolved = compareCards(playerOneDeck[0], playerTwoDeck[0]);
            if(resolved == 1){
                resolved = true;
                alert('Player One Wins this War!');
                playerOneDiscard.push(playerOneDeck[0], playerTwoDeck[0]);
                $.each(contestedPlayerOneCards, function(key, card){playerOneDiscard.push(card);});
                $.each(contestedPlayerTwoCards, function(key, card){playerOneDiscard.push(card);});
                removeTopOfDecks();
            } else if (resolved == 2){
                resolved = true;
                alert('Player Two Wins this War!');
                playerTwoDiscard.push(playerOneDeck[0], playerTwoDeck[0]);
                $.each(contestedPlayerOneCards, function(key, card){playerTwoDiscard.push(card);});
                $.each(contestedPlayerTwoCards, function(key, card){playerTwoDiscard.push(card);});
                removeTopOfDecks();
            } else {
                resolved = false;
            }
        }
    }

    function shuffle(deck){ //v1.0
        for(var j, x, i = deck.length; i; j = Math.floor(Math.random() * i), x = deck[--i], deck[i] = deck[j], deck[j] = x);
        return deck;
    };
</script>
<table><td>
<div class="cardView">
<table style="vertical-align:top; padding: 15px">
    <tr><td class="p1Cards">Player One:<br /><?php
            foreach($playerOneDeck as $card){
                echo $card.'<br />';
            }?></td><td class="p2Cards">Player Two:<br />
            <?php
            foreach($playerTwoDeck as $card){
                echo $card.'<br />';
            }?></td></tr>
    <tr><td class="p1Discards"></td><td class="p2Discards"></td></tr>
</table>
</div>
<button class="toggle">Hide Cards</button></td>
<td><button class="button">Play!</button></td>
</table>
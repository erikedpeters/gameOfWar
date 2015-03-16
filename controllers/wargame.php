<?php

class WargameController extends AppController {
    public function actionPlay() {
        $decks = $this->beginGame();
        $playerOneDeck = $decks[0];
        $playerTwoDeck = $decks[1];
        $this->setVar('playerOneDeck', $playerOneDeck);
        $this->setVar('playerTwoDeck', $playerTwoDeck);
    }

    public function beginGame(){
        $deck = array();
        foreach(array('Hearts','Clubs','Diamonds','Spades') as $suit){
            for($card=1; $card <= 13; $card++){
                if($card==1){
                    array_push($deck, 'Ace of '.$suit);
                } elseif($card==11) {
                    array_push($deck, 'Jack of '.$suit);
                } elseif($card==12) {
                    array_push($deck, 'Queen of '.$suit);
                } elseif($card==13) {
                    array_push($deck, 'King of '.$suit);
                } else {
                    array_push($deck, $card.' of '.$suit);
                }
            }
        }
        shuffle($deck);
        $playerDeck[0] = array_slice($deck,0,23);
        $playerDeck[1] = array_slice($deck,22,23);
        return $playerDeck;
    }
}
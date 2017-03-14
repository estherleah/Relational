<?php
session_start();

class Relationship {

    private $user;
    private $secondUser;
    private $privacyID;

    public function __construct($user, $secondUser, $privacyID) {
        $this->$user = $user;
        $this->$secondUser = $secondUser;
    }

    function areFriends() {

    }

    function areFriendsOfFriends() {

    }

    function areInSameCircle() {

    }

}

?>

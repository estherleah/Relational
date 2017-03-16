<?php

class Relationship {

    private $user;
    private $secondUser;
    private $privacyID;

    public function __construct($user, $secondUser) {
        $this->user = $user;
        $this->secondUser = $secondUser;
        $this->retrievePrivacyID();
    }

    function retrievePrivacyID() {
        $q0 = " SELECT privacyID
                FROM user
                WHERE userID = $this->secondUser ";

        $this->privacyID = mysqli_fetch_array(mysqli_query($GLOBALS['conn'], $q0, 0))['privacyID'];
    }

    function areSame() {
        if ($this->secondUser == $this->user) { return True; }
        else { return False; }
    }

    function shareContent() {
        if($this->user == $this->secondUser) {
            return True;
        } else {
            switch($this->privacyID) {
                case 1 : return True; break;
                case 2 : return $this->areFriendsOfFriends(); break;
                case 3 : return $this->shareACircle(); break;
                case 4 : return $this->areFriends(); break;
                case 5 : return False; break;
            }
        }
    }

    function areFriends() {
        // Are they friends?
        $q1 = " SELECT COUNT(*) AS areFriends
                FROM friendship
                WHERE userID1 = $this->user
                AND userID2 = $this->secondUser
                AND status = 1 ";

        $theyAreFriends = mysqli_fetch_array(mysqli_query($GLOBALS['conn'], $q1, 0))['areFriends'];

        if($theyAreFriends = 1){ return True; }
        else { return False; }
    }

    function areFriendsOfFriends() {
        // Are they friends or have common friends?
        $q2 = " SELECT COUNT(*) AS commonFriends
                FROM (
                    SELECT *
                    FROM friendship
                    WHERE userID1 = $this->user
                    AND userID2 = $this->secondUser
                    AND status = 1

                    UNION ALL

                    SELECT *
                    FROM
                    ( SELECT userID2, status
                      FROM friendship
                      WHERE userID1 = $this->user
                      AND status = 1 ) t1

                    INNER JOIN

                    ( SELECT userID2, status
                      FROM friendship
                      WHERE userID1 = $this->secondUser
                      AND status = 1 ) t2

                    ON t1.userID2 = t2.userID2
                ) t3 ";

        $commonFriends = mysqli_fetch_array(mysqli_query($GLOBALS['conn'], $q2, 0))['commonFriends'];

        if($commonFriends >= 1){ return True; }
        else { return False; }
    }

    function shareACircle() {
        // Do they share at least one circle?
        $q3 = " SELECT COUNT(*) AS commonCircles
                FROM
                (
                    SELECT *
                    FROM circle_participants
                    WHERE userID = 1
                    AND userStatus >= 1
                ) t1
                INNER JOIN
                (
                    SELECT *
                    FROM circle_participants
                    WHERE userID = 5
                    AND userStatus >= 1
                ) t2
                ON t1.circleID = t2.circleID ";

        $commonCircles = mysqli_fetch_array(mysqli_query($GLOBALS['conn'], $q3, 0))['commonCircles'];

        if($commonCircles >= 1){ return True; }
        else { return False; }
    }

}

?>

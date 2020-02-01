<?php
ob_start();
require_once( "common.inc.php" );
require_once( "DataObject.class.php" );

class Debate extends DataObject{

    protected $data = array (
        "debateId" => "",
        "debateTitle" => "",
        "userId" => "",
        "date" => "",
    );

    public function submit() {

        $conn = parent::connect();
        $sql = "INSERT INTO ".TBL_DEBATE ." (
			   debate_title,
			   user_id,
			   date_posted
			)  VALUES (
			   :debateTitle,
			   :userId,
			   NOW()
			)";
        try {
            $st = $conn->prepare( $sql );
            $st->bindValue( ":debateTitle", $this->data["debateTitle"], PDO::PARAM_STR );
            $st->bindValue( ":userId", $this->data["userId"], PDO::PARAM_STR );
            $st->execute();
            $last_id = $conn->lastInsertId();
            parent::disconnect ( $conn );
        }	catch ( PDOException $e ) {
            parent::disconnect( $conn );
            die( "Query Failed: " . $e->getMessage() );
        }
        return $last_id;
    }

    public static function getDebateData($debateId) {

        $conn = parent::connect();
        $sql = "SELECT * FROM " . TBL_DEBATE . " WHERE debate_id = :debateId";

        try {
            $st = $conn->prepare( $sql );
            $st->bindValue( ":debateId", $debateId, PDO::PARAM_INT );
            $st->execute();
            $result = $st->fetch();
            parent::disconnect ( $conn );
            return $result;
        }	catch ( PDOException $e ) {
            parent::disconnect( $conn );
            die( "Query Failed: " . $e->getMessage() );
        }

    }

    public static function getAllDebates() {

        $conn = parent::connect();
        $sql = "SELECT * FROM " . TBL_DEBATE . " ORDER BY debate_id DESC";

        try {
            $st = $conn->prepare( $sql );
            $st->execute();
            $rows = $st->fetchAll();
            parent::disconnect( $conn );
            return $rows;
        }	catch ( PDOException $e ) {
            parent::disconnect( $conn );
            die( "Query failed: " . $e->getMessage() );
        }

    }

}
?>
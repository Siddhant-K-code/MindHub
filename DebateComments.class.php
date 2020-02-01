<?php
ob_start();
require_once( "common.inc.php" );
require_once( "DataObject.class.php" );


class DebateComments extends DataObject{

    protected $data = array (
        "commentId" => "",
        "comment" => "",
        "debateId" => "",
        "userId" => "",
        "date" => "",
        "commentType" => ""
    );

    public function submit() {

        $conn = parent::connect();
        $sql = "INSERT INTO ".TBL_DEBATE_COMMENTS ." (
               comment,
			   debate_id,
			   user_id,
			   comment_type,
			   date_posted
			)  VALUES (
			   :comment,
			   :debateId,
			   :userId,
			   :commentType,
			   NOW()
			)";
        try {
            $st = $conn->prepare( $sql );
            $st->bindValue( ":comment", $this->data["comment"], PDO::PARAM_STR );
            $st->bindValue( ":debateId", $this->data["debateId"], PDO::PARAM_INT );
            $st->bindValue( ":userId", $this->data["userId"], PDO::PARAM_INT );
            $st->bindValue( ":commentType", $this->data["commentType"], PDO::PARAM_STR );
            $st->execute();
            $last_id = $conn->lastInsertId();
            parent::disconnect ( $conn );
        }	catch ( PDOException $e ) {
            parent::disconnect( $conn );
            die( "Query Failed: " . $e->getMessage() );
        }
        return $last_id;
    }

    public static function getAllDebatesComments($debateId, $commentType) {

        $conn = parent::connect();
        $sql = "SELECT * FROM " . TBL_DEBATE_COMMENTS . " WHERE debate_id=".$debateId." and comment_type='".$commentType."' ORDER BY comment_id DESC";

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
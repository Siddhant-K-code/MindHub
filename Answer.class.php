<?php
ob_start();
require_once( "common.inc.php" );
require_once( "DataObject.class.php" );

class Answer extends DataObject{

    protected $data = array (
        "answer_Id" => "",
        "answer" => "",
        "query_Id" => "",
        "userId" => "",
        "date" => ""
    );

    public function submit() {

        $conn = parent::connect();
        $sql = "INSERT INTO ".TBL_ANS. " (
               answer,
			   query_Id,
			   answeredBy,
			   answeredOn
			)  VALUES (
			   :answer,
			   :query_Id,
			   :userId,
			   NOW()
			)";
        try {
            $st = $conn->prepare( $sql );
            $st->bindValue( ":answer", $this->data["answer"], PDO::PARAM_STR );
            $st->bindValue( ":query_Id", $this->data["query_Id"], PDO::PARAM_INT );
            $st->bindValue( ":userId", $this->data["userId"], PDO::PARAM_INT );
            $st->execute();
            $last_id = $conn->lastInsertId();
            parent::disconnect ( $conn );
        }	catch ( PDOException $e ) {
            parent::disconnect( $conn );
            die( "Query Failed: " . $e->getMessage() );
        }
        return $last_id;
    }

    public static function getAllAnswers($query_Id) {

        $conn = parent::connect();
        $sql = "SELECT * FROM " . TBL_ANS . " WHERE query_Id=".$query_Id." ORDER BY answer_Id DESC";

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
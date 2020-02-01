<?php
ob_start();
require_once( "common.inc.php" );
require_once( "DataObject.class.php" );

class Query extends DataObject{

    protected $data = array (
		"query_id" =>"",
        "queryId" => "",
        "question" => "",
        "userId" => "",
		"quesType" => "",
		"selectedUsersId" => "",
		"askedOn" => "",
		"firstName" => "",
		"lastName" => ""
    );

    public function submit() {
		if ($this->data["quesType"]=="U"){
			$conn = parent::connect();
			$sql = "INSERT INTO ".TBL_QUERY ." (
				   question,
				   askedBy,
				   askedOn,
				   quesType
				)  VALUES (
				   :question,
				   :userId,
				   NOW(),
				   :quesType
				)";
			try {
				$st = $conn->prepare( $sql );
				$st->bindValue( ":question", $this->data["question"], PDO::PARAM_STR );
				$st->bindValue( ":userId", $this->data["userId"], PDO::PARAM_STR );
				$st->bindValue( ":quesType", $this->data["quesType"], PDO::PARAM_STR );
				$st->execute();
				$last_id = $conn->lastInsertId();
				parent::disconnect ( $conn );
			}	catch ( PDOException $e ) {
				parent::disconnect( $conn );
				die( "Query Failed: " . $e->getMessage() );
			}
			return $last_id;

		}	else {

			$conn = parent::connect();
			$sql = "INSERT INTO ".TBL_QUERY ." (
				   question,
				   askedBy,
				   askedOn,
				   quesType
				)  VALUES (
				   :question,
				   :userId,
				   NOW(),
				   :quesType
				)";
			try {
				$st = $conn->prepare( $sql );
				$st->bindValue( ":question", $this->data["question"], PDO::PARAM_STR );
				$st->bindValue( ":userId", $this->data["userId"], PDO::PARAM_STR );
				$st->bindValue( ":quesType", $this->data["quesType"], PDO::PARAM_STR );
				$st->execute();
				$last_id = $conn->lastInsertId();
				parent::disconnect ( $conn );
			}	catch ( PDOException $e ) {
				parent::disconnect( $conn );
				die( "Query Failed: " . $e->getMessage() );
			}
			foreach ( explode(',', $this->data["selectedUsersId"] ) as $asked_to ) {
				$sql = "INSERT INTO ".TBL_PRIVATE_QUERY." (
						query_id,
						asked_to
					)	VALUES (
						:query_id,
						:asked_to
					)";
				try{
					$st = $conn->prepare( $sql );
					$st->bindValue( ":query_id", $last_id, PDO::PARAM_STR );
					$st->bindValue( ":asked_to", $asked_to , PDO::PARAM_STR );
					$st->execute();
					$last_id_2 = $conn->lastInsertId();
					parent::disconnect ( $conn );
				}	catch ( PDOException $e ) {
					parent::disconnect( $conn );
					die( "Query Failed: " . $e->getMessage() );
				}
			}	
			
			return $last_id;
			
		}
    }

    public static function getQuery($query_Id) {

        $conn = parent::connect();
        $sql = "SELECT * FROM " . TBL_QUERY . " WHERE query_Id = :query_Id";

        try {
            $st = $conn->prepare( $sql );
            $st->bindValue( ":query_Id", $query_Id, PDO::PARAM_INT );
            $st->execute();
            $result = $st->fetch();
            parent::disconnect ( $conn );
            return $result;
        }	catch ( PDOException $e ) {
            parent::disconnect( $conn );
            die( "Query Failed: " . $e->getMessage() );
        }

    }

    public static function getAllQueries() {

        $conn = parent::connect();
        $sql = "SELECT * FROM " . TBL_QUERY . " ORDER BY query_Id DESC";

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
	
	public static function getMyPrivateQueries( $asked_to ) {
		
		$conn = parent::connect();
		$sql = "SELECT * FROM ".TBL_QUERY . ', '.TBL_PRIVATE_QUERY . ', '. TBL_MEMBERS ." WHERE ask.query_Id = private_questions.query_id and ask.askedBy = members.ID and asked_to = :asked_to";
		
		try{
			$st = $conn->prepare( $sql );
			$st->bindValue( ":asked_to", $asked_to, PDO::PARAM_INT );
			$st->execute();
			$private_queries = array();
			foreach ( $st->fetchAll() as $row ){
				$private_queries[] = new Query( $row );
			}
			parent::disconnect( $conn );
			return $private_queries;
		}	catch ( PDOException $e ) {
			parent::disconnect( $conn );
			die( "Query Failed: " . $e->getMessage() );
		}
	}
	
	public function getQuestionString() {
		return ( $this->data["question"] );
	}
	
	public function getQueryId() {
		return ( $this->data["query_id"] );
	}
	
	public function getAskedDate() {
		return ( date("F jS, Y", strtotime($this->data["askedOn"]) ));
	}
	
	public function getFirstNameString() {
		return ( $this->data["firstName"] );
	}
	
	public function getLastNameString() {
		return ( $this->data["lastName"] );
	}

}
?>
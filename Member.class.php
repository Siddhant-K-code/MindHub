<?php

require_once( "common.inc.php" );
require_once( "DataObject.class.php" );

class Member extends DataObject {

	protected $data = array(
		"ID" => "",
		"username" => "",
		"password" => "",
		"emailAddress" => "",
		"aadharNo" => ""
	);
	
	public static function getMembers( $startRow, $numRows, $order ) {
		$conn = parent::connect();
		$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . TBL_MEMBERS . " ORDER BY $order LIMIT :startRow, :numRows";

		try {
			$st = $conn->prepare( $sql );
			$st->bindValue( ":startRow", $startRow, PDO::PARAM_INT );
			$st->bindValue( ":numRows", $numRows, PDO::PARAM_INT );
			$st->execute();
			$members = array();
			foreach ( $st->fetchAll() as $row ) {
				$members[] = new Member( $row );
			}
			$st = $conn->query( "SELECT found_rows() AS totalRows" );
			$row = $st->fetch();
			parent::disconnect ( $conn );
			return array( $members, $row["totalRows"] );
		}	catch ( PDOException $e ) {
			parent::disconnect( $conn );
			die( "Query Failed: " . $e->getMessage() );
		}
	}

	public static function getMember( $id ) {
		$conn = parent::connect();
		$sql = "SELECT * FROM " . TBL_MEMBERS . " WHERE id = :id";
		
		try {
			$st = $conn->prepare( $sql );
			$st->bindvalue( ":id", $id, PDO::PARAM_INT );
			$st->execute();
			$row = $st->fetch();
			parent::disconnect( $conn );
			if ( $row ) return new Member( $row );
		}	catch ( PDOException $e ) {
			parent::disconnect( $conn );
			die( "Query failed: " . $e->getMessage() );
		}
	}
	
	public static function getByUsername( $username ) {
		$conn = parent::connect();
		$sql = "SELECT * FROM " . TBL_MEMBERS . " WHERE username = :username";

		try {
			$st = $conn->prepare( $sql );
			$st->bindValue( ":username", $username, PDO::PARAM_STR );
			$st->execute();
			$row = $st->fetch();
			parent::disconnect( $conn );
			if ( $row ) return new Member( $row );
		}	catch ( PDOException $e ) {
			parent::disconnect( $conn );
			die( "Query Failed: " . $e->getMessage() );
		}
	}

	public static function getByEmailAddress( $emailAddress ) {
		$conn = parent::connect();
		$sql = "SELECT * FROM " . TBL_MEMBERS . " WHERE emailAddress = :emailAddress";

		try {
			$st = $conn->prepare( $sql );
			$st->bindValue( ":emailAddress", $emailAddress, PDO::PARAM_STR );
			$st->execute();
			$row = $st->fetch();
			parent::disconnect( $conn );
			if ( $row ) return new Member( $row );
		}	catch ( PDOException $e ) {
			parent::disconnect( $conn );
			die( "Query Failed: " . $e->getMessage() );
		}
	}
	
	public function insert() {
		$conn = parent::connect();
		$sql = "INSERT INTO ".TBL_MEMBERS ." (
			   username,
			   password,
			   emailAddress,
			   aadharNo
			)  VALUES (
			   :username,
			   password(:password),
			   :emailAddress,
			   :aadharNo
			)";
		try {
			$st = $conn->prepare( $sql );
			$st->bindValue( ":username", $this->data["username"], PDO::PARAM_STR );
			$st->bindValue( ":password", $this->data["password"], PDO::PARAM_STR );
			$st->bindValue( ":emailAddress", $this->data["emailAddress"], PDO::PARAM_STR );
			$st->bindValue( ":aadharNo", $this->data["aadharNo"], PDO::PARAM_STR );
			$st->execute();
			parent::disconnect ( $conn );
		}	catch ( PDOException $e ) {
			parrent::disconnect( $conn );
			die( "Query Failed: " . $e->getMessage() );
		}
	}
	
	public function authenticate() {
		$conn = parent::connect();
		$sql = "SELECT * FROM " . TBL_MEMBERS . " WHERE username = :username AND password = password(:password)";
				
		try {
			$st = $conn->prepare( $sql );
			$st->bindValue( ":username", $this->data["username"], PDO::PARAM_STR );
			$st->bindValue( ":password", $this->data["password"], PDO::PARAM_STR );
			$st->execute();
			$row = $st->fetch();
			parent::disconnect( $conn );
			if ( $row ) return new Member( $row );
		}	catch ( PDOExpection $e ) {
			parent::disconnect( $conn );
			die( "Query Failed: " . $e->getMessage() );
		}
	}
	
	public function update( $id ) {
		$conn = parent::connect();
		$passwordSql = $this->data["password"] ? "password = password(:password)," : "";
		$sql = "UPDATE " . TBL_MEMBERS . " SET
			username = :username,
			$passwordSql
			position = :position,
			institute = :institute
			WHERE ID = :id";
		try {
			$st = $conn->prepare( $sql );
			$st->bindValue( ":id", $_SESSION['member']->getIdString() , PDO::PARAM_INT );
			$st->bindValue( ":username", $this->data["username"], PDO::PARAM_STR );
			if ( $this->data["password"] ) $st->bindValue( ":password", $this->data["password"], PDO::PARAM_STR );
			$st->bindValue( ":position", $this->data["position"], PDO::PARAM_STR );
			$st->bindValue( ":institute", $this->data["institute"], PDO::PARAM_STR );
			$st->execute();
			parent::disconnect( $conn );
		} catch ( PDOException $e ) {
			parent::disconnect( $conn );
			die( "Query failed: " . $e->getMessage() );
		}
	}
	
	public function delete() {
			$conn = parent::connect();
			$sql = "DELETE FROM " . TBL_MEMBERS . " WHERE id = :id";
			try {
			$st = $conn->prepare( $sql );
			$st->bindValue( ":id", $this->data["id"], PDO::PARAM_INT );
			$st->execute();
			parent::disconnect( $conn );
		} catch ( PDOException $e ) {
			parent::disconnect( $conn );
			die( "Query failed: " . $e->getMessage() );
		}
	}

	
	public function getIdString() {
		return ( $this->data["ID"] );
	}

	public function getFirstNameString() {
		return ( $this->data["firstName"] );
	}

	public function getLastNameString() {
		return ( $this->data["lastName"] );
	}

	public function getGenderString() {
		return ( $this->data["gender"] == "F" ) ? "Female" : "Male";
	}
	
	public function getPositionString() {
		return ( $this->data["position"] == "S" ) ? "Student" : "Teacher";
	}

    public function getUsernameString() {
        return ( $this->data["username"] );
    }

    public function getEmailString() {
        return ( $this->data["emailAddress"] );
    }

    public function getDOBString() {
        return ( $this->data["dateOfBirth"] );
    }
	
	public function getInstituteString() {
		return ( $this->data["institute"] );
	}
}

?>
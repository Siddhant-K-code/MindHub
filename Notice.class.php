<?php
require_once("DataObject.class.php");

class Notice extends DataObject {
	
	protected $data = array(
		"user_id" => "",
		"notice" => ""
	);
	
	public static function getNotifications( $user_id ) {
		$conn = parent::connect();
		$sql = "SELECT * FROM " . TBL_NOTICE . " WHERE user_id = :user_id";
		
		try{
			$st = $conn->prepare( $sql );
			$st->bindValue( ":user_id", $user_id, PDO::PARAM_INT );
			$st->execute();
			$notifications = array();
			foreach ( $st->fetchAll() as $row ){
				$notifications[] = new Notice( $row );
			}
			parent::disconnect( $conn );
			return $notifications;
		}	catch ( PDOException $e ) {
			parent::disconnect( $conn );
			die( "Query failed: " . $e->getMessage() );
		}
	}
	
	public function getNoticeString() {
		return ( $this->data["notice"] );
	}

}
?>
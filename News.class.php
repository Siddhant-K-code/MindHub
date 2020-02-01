<?php
ob_start();
require_once( "common.inc.php" );
require_once( "DataObject.class.php" );

class News extends DataObject {

    protected $data = array (
        "newsId" => "",
        "newsTitle" => "",
        "newsUrl" => "",
        "newsContent" => "",
        "userId" => "",
        "date" => "",
    );

    public function submit() {

        $conn = parent::connect();
        $sql = "INSERT INTO ".TBL_NEWS ." (
			   news_title,
			   news_description,
			   news_url,
			   user_id,
			   date_posted
			)  VALUES (
			   :newsTitle,
			   :newsContent,
			   :newsUrl,
			   :userId,
			   NOW()
			)";
        try {
            $st = $conn->prepare( $sql );
            $st->bindValue( ":newsTitle", $this->data["newsTitle"], PDO::PARAM_STR );
            $st->bindValue( ":newsContent", $this->data["newsContent"], PDO::PARAM_STR );
            $st->bindValue( ":newsUrl", $this->data["newsUrl"], PDO::PARAM_STR );
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

    public static function getNewsData($newsId) {

        $conn = parent::connect();
        $sql = "SELECT * FROM " . TBL_NEWS . " WHERE news_id = :newsId";

        try {
            $st = $conn->prepare( $sql );
            $st->bindValue( ":newsId", $newsId, PDO::PARAM_INT );
            $st->execute();
            $result = $st->fetch();
            parent::disconnect ( $conn );
            return $result;
        }	catch ( PDOException $e ) {
            parent::disconnect( $conn );
            die( "Query Failed: " . $e->getMessage() );
        }

    }

    public static function getAllNews() {

        $conn = parent::connect();
        $sql = "SELECT * FROM " . TBL_NEWS . " ORDER BY news_id DESC";

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
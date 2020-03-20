class DB_Database
{

    // constructor
    function __construct() {
        include_once $_SERVER['DOCUMENT_ROOT'].'/class/DB_Connect.php';

        // connecting to database
        $db = new DB_Connect();
        $this->db = $db->databaseName;
        $this->conn = $db->connect();
    }
}
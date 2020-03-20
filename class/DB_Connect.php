class DB_Connect {
    public $databaseName = "mydatabase";
    // Connecting to database
    public function connect() {
        $pdo = new PDO('mysql:host=localhost;dbname='.$this->databaseName, 'root', '');
        $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

        return $pdo;
    }
}
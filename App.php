<?
class App {
    private $db_pdo;

    function __construct($host, $db, $user, $pass, $charset) {

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        ];

        try {
            $this->db_pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function addBook() {

    }

    public function viewBook() {

    }

    public function updateBook() {

    }

    public function deleteBook() {

    }
}
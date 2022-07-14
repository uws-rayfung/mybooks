<?
class App {
    private $db;

    function __construct($host, $db, $user, $pass, $charset) {

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        ];

        try {
            $this->db = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function addBook($vars) {
        try {
            $this->db->beginTransaction();
            $sql = "INSERT INTO books (title, subject, year) VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$vars['title'], $vars['subject'], $vars['year']]);
        
            $this->db->commit();
        }catch (Exception $e){
            $this->db->rollback();
            throw $e;
        }
    }

    public function viewBook($id) {
        $sql = "select * from books where id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $book = $stmt->fetch();
        
        return $book;
    }

    public function updateBook() {

    }

    public function deleteBook() {

    }
}
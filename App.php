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

    public function updateBook($fields) {
        try {
            $this->db->beginTransaction();
            $sql = "UPDATE books SET title=?, subject=?, year=? WHERE id=?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$fields['title'], $fields['subject'], $fields['year'], $fields['id']]);
        
            $this->db->commit();
        }catch (Exception $e){
            $this->db->rollback();
            throw $e;
        }
    }

    public function deleteBook($id) {
        try {
            $this->db->beginTransaction();
            $sql = "DELETE FROM books WHERE id=?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
        
            $this->db->commit();
        }catch (Exception $e){
            $this->db->rollback();
            throw $e;
        }
    }

    public function listBooks() {
        $books = array();

        try {
            $sql = "select * from books";
            $stmt = $this->db->query($sql);
            while ($book = $stmt->fetch()) {
                $books[] = $book;
            }
        }catch (Exception $e){
            throw $e;
        }

        return $books;
    }    

    function login($username, $password) {
        try {
            $sql = "select * from users where email = ? and password = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$_POST['email'], $_POST['password']]);
            $user = $stmt->fetch();

            if ($user) {
 
                $_SESSION['isLoggedIn'] = true;
                $_SESSION['user'] =  $user->name;          
    
                return true;
            } else {
                $_SESSION['isLoggedIn'] = false;            

            }
            return false;
    
        }catch (Exception $e){
            throw $e;
        }
    }

}
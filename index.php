<?
require "config.inc.php";
require "App.php";

session_start();

$myapp = new App($mysql_host, $mysql_db, $mysql_user, $mysql_pass, $mysql_charset);

switch ($_GET['action']) {
    case "delete":
        $myapp->deleteBook($_GET['id']);
        header("Location: /");
        break;
    case "logout":
        $_SESSION['isLoggedIn'] = false;
        $_SESSION['user'] = "";
        break;
}

switch ($_POST['submit']) {
    case "add-book":
        $myapp->addBook($_POST);
        break;        
    case "edit-book":
        $myapp->updateBook($_POST);
        break;
    case "login":
        $myapp->login($_POST['email'], $_POST['password']);
        if (!$_SESSION['isLoggedIn']) {
            die('Invalid password. <a href="/login.php">Try again</a>');
        }
        break;    
}

if (!$_SESSION['isLoggedIn']) 
    header("Location: /login.php");

$books = $myapp->listBooks();
?>
<html>
        <body>
            <h1>My Books</h1>
            <p>Welcome <?=$_SESSION['user']?>! <a href="/?action=logout">Logout</a></p>
            <? if (count($books) > 0) { ?>
            <table>
                <tr><th>Year</th><th>Subject</th><th>Title</th><th></th><th></th></tr>
                <?
                    foreach ($books as $book) {
                        echo '<tr>';
                        echo '<td style="padding:3px">'.$book->year."</td>";
                        echo '<td style="padding:3px">'.$book->subject."</td>";
                        echo '<td style="padding:3px">'.$book->title."</td>";
                        echo '<td style="padding:3px"><a href="/edit-book.php?id='.$book->id.'">Edit</a></td>';
                        echo '<td style="padding:3px"><a href="/?action=delete&id='.$book->id.'">Delete</a></td>';
                        echo '</tr>';
                    }
                ?>
            </table>
            <? } else echo "<p>No books found. Please add some!</p>"; ?>
            <a href="add-book.php">
                <button type="button">Add Book</button>
            </a>
        </body>
</html>
<?
require "config.inc.php";
require "App.php";

$myapp = new App($mysql_host, $mysql_db, $mysql_user, $mysql_pass, $mysql_charset);

switch ($_GET['action']) {
    case "delete":
        $myapp->deleteBook($_GET['id']);
        header("Location: /");
        break;
}

switch ($_POST['submit']) {
    case "add-book":
        $myapp->addBook($_POST);
        break;        
    case "edit-book":
        $myapp->updateBook($_POST);
        break;        
    
}

$books = $myapp->listBooks();
?>
<html>
        <body>
            <h1>My Books</h1>
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
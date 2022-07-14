<? 
require "config.inc.php";
require "App.php";

$myapp = new App($mysql_host, $mysql_db, $mysql_user, $mysql_pass, $mysql_charset);

$id = $_GET['id']; 

$book = $myapp->viewBook($id);
?>


<html>
    <head></head>
    <body>
        <form method="post" action="/">
        <h1>Edit Book</h1>
            <p>Title: <input type="text" name="title" value="<?=$book->title?>"></p>
            <p>Subject: <input type="text" name="subject" value="<?=$book->subject?>"></p>
            <p>Year Published: <input type="text" name="year" value="<?=$book->year?>"></p>
            <p><button type="submit" name="submit" value="edit-book">Edit Book</button></p>
            <input type="hidden" name="id" value="<?=$id?>">
        </form>
    </body>
</html>
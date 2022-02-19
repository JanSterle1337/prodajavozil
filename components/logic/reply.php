<?Php 

session_start();
require("../../config/db_connect.php");

if (isset($_SESSION['id'])) {
    echo "Sem prijavlen in poskusam replyat";
    if (isset($_POST['replyingTo'])) {
        echo "Post je settan";
    }
} else {
    echo "Nisem prijavlen in poskusam replyat";
    Header("Location: ../templates/prijava.php");
}


?>
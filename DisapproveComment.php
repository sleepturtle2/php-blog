<?php require_once("./includes/DB.php"); ?>
<?php require_once("./includes/Functions.php"); ?>
<?php require_once("./includes/Sessions.php"); ?>

<?php
if (isset($_GET["id"])) {
    $SearchQueryParameter = $_GET["id"];
    global $ConnectingDB;
    $Admin = $_SESSION["AdminName"];
    $sql = "UPDATE comments SET status='OFF', approvedBy='$Admin' WHERE id='$SearchQueryParameter'";
    $Execute = $ConnectingDB->query($sql);

    if ($Execute) {
        $_SESSION["SuccessMessage"] = 'Comment Disapproved Successfully';
        Redirect_to("Comments.php");
    } else {
        $_SESSION["ErrorMessage"] = 'Something went wrong, Try Again!';
        Redirect_to("Comments.php");
    }
}
?>
<?php require_once("./includes/DB.php"); ?>
<?php require_once("./includes/Functions.php"); ?>
<?php require_once("./includes/Sessions.php"); ?>

<?php
if (isset($_GET["id"])) {
    $SearchQueryParameter = $_GET["id"];
    global $ConnectingDB;
    
    $sql = "DELETE FROM category WHERE id='$SearchQueryParameter'";
    $Execute = $ConnectingDB->query($sql);

    if ($Execute) {
        $_SESSION["SuccessMessage"] = 'Category Deleted Successfully';
        Redirect_to("Categories.php");
    } else {
        $_SESSION["ErrorMessage"] = 'Something went wrong, Try Again!';
        Redirect_to("Categories.php");
    }
}
?>
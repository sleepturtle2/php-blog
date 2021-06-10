<?php require_once("./includes/DB.php"); ?>
<?php require_once("./includes/Functions.php"); ?>
<?php require_once("./includes/Sessions.php"); ?>

<?php
$_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
Confirm_Login();
?>
<?php

if (isset($_POST["Submit"])) {
  print_r($_POST);
  $Category = $_POST["categoryTitle"];

  $Admin = $_SESSION["Username"];;
  date_default_timezone_set("Asia/Kolkata");
  $CurrentTime = time();
  $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);
  echo $DateTime;

  if (empty($Category)) {
    $_SESSION['ErrorMessage'] = "All fields must be filled out";
    Redirect_to("Categories.php");
  } elseif (strlen($Category) < 2) {
    $_SESSION['ErrorMessage'] = "Category title must be atleast 2 characters";
    Redirect_to("Categories.php");
  } elseif (strlen($Category) > 200) {
    $_SESSION['ErrorMessage'] = "Category title must be less than 200 characters";
    Redirect_to("Categories.php");
  } else {
    global $ConnectingDB;
    //Query to insert category in DB when everything is fine
    $sql = "INSERT INTO category(title, author,datetime)";
    $sql .= "VALUES(:categoryName, :adminName, :dateTime)";
    $stmt = $ConnectingDB->prepare($sql); //-> pdo object notation
    $stmt->bindValue(':categoryName', $Category);
    $stmt->bindValue(':adminName', $Admin);
    $stmt->bindValue(':dateTime', $DateTime);
    $Execute = $stmt->execute();


    if ($Execute) {
      $_SESSION['SuccessMessage'] = "Category Added!";
      Redirect_to("Categories.php");
      print_r($_POST);
    } else {
      $_SESSION['ErrorMessage'] = "Something went wrong. Please try again.";
      Redirect_to("Categories.php");
    }
  }
}
?>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link href="./icon-fonts/css/all.css" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


  <link rel="stylesheet" href="./css/styles.css">
  <title>Categories</title>
</head>

<body>
  <!--NAVBAR-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a href="#" class="navbar-brand logo">Blog</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarcollapseCMS" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class=" navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarcollapseCMS">
        <ul class="navbar-nav nav-ul">
          <li class="nav-item">
            <a href="MyProfile.php" class="nav-link">My Profile</a>
          </li>
          <li class="nav-item">
            <a href="Dashboard.php" class="nav-link">Dashboard</a>
          </li>
          <li class="nav-item">
            <a href="Posts.php" class="nav-link">Posts</a>
          </li>
          <li class="nav-item">
            <a href="Categories.php" class="nav-link"><i class="lni lni-adobe"></i>Categories</a>
          </li>
          <li class="nav-item">
            <a href="Admins.php" class="nav-link">Manage Admins</a>
          </li>
          <li class="nav-item">
            <a href="Comments.php" class="nav-link">Comments</a>
          </li>
          <li class="nav-item">
            <a href="Blog.php?page=1" class="nav-link">Live Blog</a>
          </li>

        </ul>
        <ul class="navbar-nav logout">
          <li class="nav-item "><a href="Logout.php" class="nav-link">Logout <i class="fas fa-sign-out-alt"></i></a></li>
        </ul>
      </div>
    </div>
  </nav>
  <!--NAVBAR END-->

  <!--HEADER-->

  <header class="bg-dark text-white py-3">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1><i class="far fa-edit"></i> Edit Categories</h1>
        </div>
      </div>
    </div>
  </header>
  <!--END OF HEADER-->

  <!--MAIN SECTION-->
  <section class="container py-2 mb-4">
    <div class="row">
      <div class="offset-lg-1 col-lg-10" style="min-height: 400px;">
        <?php
        echo ErrorMessage();
        echo SuccessMessage();
        ?>
        <form action='Categories.php' method="post">
          <div class="card bg-secondary text-light mb-3">
            <div class="card-header">
              <h1>Add New Category</h1>
            </div>
            <div class="card-body bg-dark">
              <div class="form-group">
                <label for="title"><span class="FieldInfo">Category title: </span></label>
                <input class="form-control" type="text" name="categoryTitle" id="title" placeholder="Tyle your title here">
              </div>
              <div class="row">
                <div class="col-lg-6 mb-2">
                  <a href="Dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
                </div>
                <div class="col-lg-6 mb-2">
                  <button type="submit" name="Submit" class="btn btn-success btn-block"><i class="far fa-check-circle"></i> Publish</button>
                </div>
              </div>
            </div>
        </form>

      </div>
    </div>
  </section>
  <section class="container py-2 mb-4">
    <div class="row" style="min-height:300px;">
      <div class="col-lg-12" style="min-height:400px;">
        <h2>Existing Categories</h2>
        <table class="table table-striped table-hover">
          <thead class="thead-dark">
            <tr>
              <th>No. </th>
              <th>Date & Time</th>
              <th>Category Name </th>
              <th>Creator Name </th>
              <th>Action </th>
            </tr>
          </thead>


          <?php
          global $ConnectingDB;
          $sql = "SELECT * FROM category ORDER BY id desc";
          $Execute = $ConnectingDB->query($sql);
          $SrNo = 0;
          while ($DataRows = $Execute->fetch()) {
            $CategoryId = $DataRows["id"];
            $CategoryDate = $DataRows["datetime"];
            $CategoryName = $DataRows["title"];
            $CreatorName = $DataRows["author"];
            
            $SrNo++;

          ?>
            <tbody>
              <tr>
                <td><?php echo htmlentities($SrNo); ?></td>
                <td><?php echo htmlentities($CategoryDate); ?></td>
                <td><?php echo htmlentities($CategoryName); ?></td>
                <td><?php echo htmlentities($CreatorName); ?></td>

                <td> <a class="btn btn-danger" href="DeleteCategory.php?id=<?php echo $CategoryId; ?>">Delete</a> </td>
              </tr>
            </tbody>
          <?php } ?>
        </table>
      </div>
    </div>
  </section>


        <!--END OF MAIN SECION-->

        <!--FOOTER-->
        <footer class="bg-dark text-white">
          <div class="container">
            <div class="row">
              <div class="col">
                <p class="lead text-center footer">
                  Theme By | Sayantan Mukherjee | &copy; <span id="year"></span> All rights Reserved
                </p>
              </div>
            </div>
          </div>
        </footer>
        <!--FOOTER-->
        <!--EXT JS FILES-->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script>
          const d = new Date();
          const n = d.getFullYear();
          document.getElementById("year").innerHTML = n;
        </script>
</body>

</html>
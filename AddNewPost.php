<?php require_once("./includes/DB.php"); ?>
<?php require_once("./includes/Functions.php"); ?>
<?php require_once("./includes/Sessions.php"); ?>

<?php 
    $_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
    Confirm_Login();
?>
<?php
ini_set('display_errors', 1);

if (isset($_POST["Submit"])) {
 
  $PostTitle = $_POST["PostTitle"];
  $CategoryTitle = $_POST["CategoryTitle"]; 
  
  if(strlen($_FILES["Image"]["name"])>0)
  $Image = $_FILES["Image"]["name"]; //stores only image name 
  else
  $Image = 'no-image.jpg';

  $Target = "uploads/".basename($Image); 
  $PostText = $_POST["PostDescription"]; 
  $Admin ='admin';
  date_default_timezone_set("Asia/Kolkata");
  $CurrentTime = time();
  $DateTime = strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);
  
  // echo $DateTime; 
  if(empty($PostTitle)){
    $_SESSION["ErrorMessage"]= "Title Cant be empty";
    Redirect_to("AddNewPost.php");
  }elseif (strlen($PostTitle)<5) {
    $_SESSION["ErrorMessage"]= "Post Title should be greater than 5 characters";
    Redirect_to("AddNewPost.php");
  }else{
    // Query to insert Post in DB When everything is fine
    
    global $ConnectingDB;
    $sql = "INSERT INTO post(datetime,title,category,author,image,post)";
    $sql .= "VALUES(:dateTime,:postTitle,:categoryName,:adminName,:imageName,:postDescription)";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':dateTime',$DateTime);
    $stmt->bindValue(':postTitle',$PostTitle);
    $stmt->bindValue(':categoryName',$CategoryTitle);
    $stmt->bindValue(':adminName',$Admin);
    $stmt->bindValue(':imageName',$Image);
    $stmt->bindValue(':postDescription',$PostText);
    $Execute=$stmt->execute();

    //had to change htdocs permission to 777 to execute this command
    //apache owner is daemon
    move_uploaded_file($_FILES["Image"]["tmp_name"], $Target); 
  
    if($Execute){
      $_SESSION["SuccessMessage"]="Post with id : " .$ConnectingDB->lastInsertId()." added Successfully";
      //Redirect_to("AddNewPost.php");

    }else {
      $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
      Redirect_to("AddNewPost.php");
    }
  }
} //Ending of Submit Button If-Condition
 ?>
 

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link href="./icon-fonts/css/all.css" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


  <link rel="stylesheet" href="./css/styles.css">
  <title>Add New Post</title>
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
          <h1><i class="far fa-edit"></i> Add New Post </h1>
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
        <form action='AddNewPost.php' method="post" enctype="multipart/form-data">
          <div class="card bg-secondary text-light mb-3">
            <div class="card-body bg-dark">
              <div class="form-group">
                <label for="title"><span class="FieldInfo">Post title: </span></label>
                <input class="form-control" type="text" name="PostTitle" id="title" placeholder="Tyle your title here">
              </div>
              <div class="form-group">
                <label for="CategoryTitle"><span class="FieldInfo">Choose Category:</span></label>
                <select class="form-control" id="CategoryTitle" name="CategoryTitle">
                 
                <?php 
                  //fetching all the categories from the category table 
                  global $ConnectingDB; 
                  $sql = "SELECT id,title FROM category"; 
                  $stmt = $ConnectingDB->query($sql); 
                  while($DataRows = $stmt->fetch()){
                    $Id = $DataRows["id"]; 
                    $CategoryName = $DataRows["title"]; 
                  
                ?>
                <option><?php echo $CategoryName; ?></option>
                <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <div class="custom-file">
                  <input class="custom-file-input" type="File" name="Image" id="imageSelect" value="">
                  <label for="imageSelect" class="custom-file-label" name="Image" id="imageSelect" value="">Select Image</label>
                </div>
              </div>
              <div class="form-group">
                <label for="Post"><span class="FieldInfo">Post: </span></label>
                <textarea name="PostDescription" rows="8" cols="80" class="form-control" id="Post"></textarea>
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
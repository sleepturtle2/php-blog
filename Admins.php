<?php require_once("./includes/DB.php"); ?>
<?php require_once("./includes/Functions.php"); ?>
<?php require_once("./includes/Sessions.php"); ?>

<?php 
    $_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
    Confirm_Login();
?>

<?php
 
  if(isset($_POST["Submit"])){
    print_r($_POST); 
    $Username = $_POST["Username"];
    $Name = $_POST["Name"];
    $Password = $_POST["Password"];
    $ConfirmPassword = $_POST["ConfirmPassword"];

    $Admin= $_SESSION["Username"];
    date_default_timezone_set("Asia/Kolkata"); 
    $CurrentTime=time(); 
    $DateTime=strftime("%B-%d-%Y %H:%M:%S", $CurrentTime);
    
    
    if(empty($Username) || empty($Password) || empty($ConfirmPassword)){
      $_SESSION['ErrorMessage']="All fields must be filled out"; 
      Redirect_to("Admins.php");   
    }elseif(strlen($Password)<3){
      $_SESSION['ErrorMessage']="Password must be atleast 3 characters"; 
      Redirect_to("Admins.php");  
    }elseif($Password !== $ConfirmPassword){
      $_SESSION['ErrorMessage']="Passwords don't match"; 
      Redirect_to("Admins.php");  
    }elseif(CheckUserNameExists($Username)){
      $_SESSION["ErrorMessage"]="UserName exists. Try another one!";
      Redirect_to("Admins.php");
    }
    else{
      global $ConnectingDB; 
      //Query to insert admin in DB when everything is fine
      $sql = "INSERT INTO admins(datetime, username,password, aname, addedBy)"; 
      $sql.="VALUES(:DateTime, :UserName, :Password, :AdminName, :AddedBy)"; 
      $stmt=$ConnectingDB->prepare($sql); //-> pdo object notation
      $stmt->bindValue(':DateTime', $DateTime); 
      $stmt->bindValue(':UserName', $Username);
      $stmt->bindValue(':Password', $Password);
      $stmt->bindValue(':AdminName', $Admin);
      $stmt->bindValue(':AddedBy', $Name);
    
      $Execute=$stmt->execute(); 

   
      if($Execute){
        $_SESSION['SuccessMessage']="New Admin Added Successfully!"; 
        Redirect_to("Admins.php");
        print_r($_POST); 
      }
      else{
        $_SESSION['ErrorMessage']="Something went wrong. Please try again.";
        Redirect_to("Admins.php");   
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
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


  <link rel="stylesheet" href="./css/styles.css">
  <title>Admin Page</title>
</head>

<body>

  <!--NAVBAR-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a href="#" class="navbar-brand logo">Blog</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarcollapseCMS"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
          <h1><i class="far fa-user"></i> Manage Admins </h1>
        </div>
      </div>
    </div>
  </header>
  <!--END OF HEADER-->

  <!--MAIN SECTION-->
  <section class="container py-2 mb-4">
    <div class="row">
      <div class="offset-lg-1 col-lg-10" style="min-height: 80vh;">
      <?php echo ErrorMessage(); 
            echo SuccessMessage(); 
      ?>
        <form action='Admins.php' method="post">
          <div class="card bg-secondary text-light mb-3">
            <div class="card-header">
              <h1>Add New Admin</h1>
            </div>
            <div class="card-body bg-dark">
              <div class="form-group">
                <label for="Username"><span class="FieldInfo" >Username: </span></label>
                <input class="form-control" type="text" name="Username" id="username" >
              </div>
              <div class="form-group">
                <label for="Name"><span class="FieldInfo" >Name: </span></label>
                <small class="text-muted">Optional</small>
                <input class="form-control" type="text" name="Name" id="title" >
                
              </div>
              <div class="form-group">
                <label for="Password"><span class="FieldInfo" >Password: </span></label>
                <input class="form-control" type="password" name="Password" id="title" >
              </div>
              <div class="form-group">
                <label for="Password"><span class="FieldInfo" >Confirm Password: </span></label>
                <input class="form-control" type="password" name="ConfirmPassword" id="title">
              </div>
              <div class="row">
              <div class="col-lg-6 mb-2">
                <a href="Dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>                
              </div>
              <div class="col-lg-6 mb-2" >
                <button type="submit" name="Submit" class="btn btn-success btn-block"><i class="far fa-check-circle"></i>   Publish</button>
            </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
  <!--show admin list -->
  <section class="container py-2 mb-4">
    <div class="row" style="min-height:300px;">
      <div class="col-lg-12" style="min-height:400px;">
        <h2>Existing Admins</h2>
        <table class="table table-striped table-hover">
          <thead class="thead-dark">
            <tr>
              <th>No. </th>
              <th>Date & Time</th>
              <th>UserName </th>
              <th>Admin Name </th>
              <th>Added By</th>
              <th>Action </th>
            </tr>
          </thead>


          <?php
          global $ConnectingDB;
          $sql = "SELECT * FROM admins ORDER BY id desc";
          $Execute = $ConnectingDB->query($sql);
          $SrNo = 0;
          while ($DataRows = $Execute->fetch()) {
            $AdminId = $DataRows["id"];
            $DateTime = $DataRows["datetime"];
            $AdminUserName = $DataRows["username"];
            $AdminName = $DataRows["aname"];
            $AddedBy = $DataRows["addedBy"];           
            $SrNo++;

          ?>
            <tbody>
              <tr>
                <td><?php echo htmlentities($SrNo); ?></td>
                <td><?php echo htmlentities($DateTime); ?></td>
                <td><?php echo htmlentities($AdminUserName); ?></td>
                <td><?php echo htmlentities($AdminName); ?></td>
                <td><?php echo htmlentities($AddedBy); ?></td>


                <td> <a class="btn btn-danger" href="DeleteAdmin.php?id=<?php echo $AdminId; ?>">Delete</a> </td>
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
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
    crossorigin="anonymous"></script>
  <script>
    const d = new Date(); const n = d.getFullYear();
    document.getElementById("year").innerHTML = n;

  </script>
</body>

</html>
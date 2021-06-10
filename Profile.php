<?php require_once("./includes/DB.php"); ?>
<?php require_once("./includes/Functions.php"); ?>
<?php require_once("./includes/Sessions.php"); ?>
<?php 

    $SearchQueryParameter = $_GET["username"]; 
    global $ConnectingDB; 
    $sql = "SELECT aname,aheadline,abio,aimage FROM admins WHERE username=:userName";
    $stmt = $ConnectingDB->prepare($sql); 
    $stmt->bindValue(":userName", $SearchQueryParameter);
    $stmt->execute();
    $Result = $stmt->rowcount(); 

    if($Result ==1){
        while($DataRows = $stmt->fetch()){
            $ExistingName = $DataRows["aname"]; 
            $ExistingBio = $DataRows["abio"]; 
            $ExistingImage = $DataRows["aimage"]; 
            $ExistingHeadline = $DataRows["aheadline"]; 
        }
    }else{
        $_SESSION["ErrorMessage"]="Bad request"; 
        Redirect_to("Blog.php");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link href="./icon-fonts/css/all.css" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


  <link rel="stylesheet" href="./css/styles.css">
  <title>Profile</title>
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
                        <a href="Blog.php" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a href="Blog.php" class="nav-link">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="lni lni-adobe"></i>Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Features</a>
                    </li>
                </ul>
                <ul class="navbar-nav logout">
                    <form class="form-inline d-none d-sm-block" action="Blog.php">
                        <div class="form-group">
                            <input class="form-control mr-2" type="text" name="Search" placeholder="Search By Text/Date" value="">
                            <button class="btn btn-primary" name="SearchButton">Go</button>

                        </div>

                    </form>
                </ul>
            </div>
        </div>
    </nav>
    <!--NAVBAR END-->
  <!--HEADER-->

  <header class="bg-dark text-white py-3">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h1><i class="fas fa-user mr-2"></i><?php echo $ExistingName; ?></h1>
          <h3><?php echo htmlentities($ExistingHeadline); ?></h3>
        </div>
      </div>
    </div>
  </header>
  <!--END OF HEADER-->


<section class="container mt-4">

    <div class="row">
        <div class="col-md-3">
            <img src="images/<?php echo $ExistingImage; ?>" class="d-block img-fluid mb-3 rounded-circle" alt="">
        </div>
        <div class="col-md-9" style="min-height:400px;">
            <div class="card">
                <div class="card-body">
                    <p class="lead"><?php echo $ExistingBio; ?></p>
                </div>
            </div>
        </div>
    </div>
</section>
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
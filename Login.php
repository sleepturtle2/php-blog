<?php require_once("./includes/DB.php"); ?>
<?php require_once("./includes/Functions.php"); ?>
<?php require_once("./includes/Sessions.php"); ?>

<?php 
    if(isset($_SESSION["User_ID"])){
        Redirect_to("Dashboard.php");
    }
    if(isset($_POST["Submit"])){
        $UserName = $_POST["Username"];
        $Password = $_POST["Password"];

        if(empty($UserName) || empty($Password)){
            $_SESSION['ErrorMessage'] = 'All fields must be filled out';
            Redirect_to("Login.php");
        }
        else{
            //check username and password from db 
           $Found_Account = Login_Attempt($UserName, $Password); 
           if($Found_Account){
               $_SESSION["User_ID"] = $Found_Account["id"];
               $_SESSION['Username'] = $Found_Account['username'];
               $_SESSION['AdminName'] = $Found_Account['aname'];
               $_SESSION["SuccessMessage"] = 'Welcome '.$_SESSION['AdminName']; 
               
               if(isset($_SESSION["TrackingURL"])){
                   Redirect_to($_SESSION['TrackingURL']);
               }else{
                   Redirect_to('Dashboard.php');
               }
               
           }else{
               $_SESSION['ErrorMessage'] = 'Incorrect UserName/Password';
               Redirect_to('Login.php');
           }
        }

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
  <title>Login</title>
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
        
      </div>
    </div>
  </nav>
  <!--NAVBAR END-->

  <!--HEADER-->

  <header class="bg-dark text-white py-3">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
        </div>
      </div>
    </div>
  </header>
  <!--END OF HEADER-->
    <!--main area start-->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="offfset-sm-3 col-sm-6" style="min-height:500px;">
            <?php echo ErrorMessage(); 
            echo SuccessMessage(); 
      ?>
            <br><br>
            <div class="card bg-secondary text-light">
            <div class="card-header">
                <h4>Welcome Back</h4>
                </div>
                <div class="card-body bg-dark">

                
                <form class="" action="Login.php" method="post">
                <div class="form-group">
                    <label for="username"><span class="FieldInfo">Username: </span></label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text text-white bg-info"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control" name="Username" id="username" value="">
                     </div>
                </div>
                <div class="form-group">
                    <label for="password"><span class="FieldInfo">Password: </span></label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text text-white bg-info"><i class="fas fa-lock"></i></span>
                        </div>
                        <input type="password" class="form-control" name="Password" id="password" value="">
                     </div>
                </div>
                <input type="submit" name="Submit" class="btn btn-info btn-block" value="Login">
            </form>
            </div>
            </div>
            </div>
        </div>
    </section>
    <!--end of main area-->
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
<?php require_once("./includes/DB.php"); ?>
<?php require_once("./includes/Functions.php"); ?>
<?php require_once("./includes/Sessions.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="./icon-fonts/css/all.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


    <link rel="stylesheet" href="./css/styles.css">
    <title>Blog Page</title>
    <style media="screen">
        .heading {
            font-family: Bitter, Georgia, "Times New Roman", Times, serif;
            font-weight: bold;
            color: #005E90;
        }

        .heading:hover {
            color: #0090DB;
        }
    </style>
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
    <div class="container mb-4">
        <div class="row mt-4">

            <!--Main area-->
            <div class="col-sm-8">
                <h1>The Complete Responsive CMS Blog</h1>
                <h2 class="lead"> The Complete blog by using Php by Sayantan Mukherjee</h2>
                <?php
                echo ErrorMessage();
                echo SuccessMessage();
                ?>
                <?php



                //get data from the search button 
                global $ConnectingDB;

                if (isset($_GET["SearchButton"])) {
                    $Search = $_GET["Search"];

                    $sql = "SELECT * FROM post 
                    WHERE datetime LIKE :search
                    OR title LIKE :search
                    OR category LIKE :search
                    OR post LIKE :search
                     ";
                    $stmt = $ConnectingDB->prepare($sql);
                    $stmt->bindValue(":search", '%' . $Search . '%');
                    $stmt->execute();
                } else if (isset($_GET["page"])) {
                    $Page = $_GET["page"];
                    if ($Page < 1)
                        $ShowPostFrom = 0;
                    else
                        $ShowPostFrom = ($Page * 5) - 5;
                    $sql = "SELECT * FROM post ORDER by id desc LIMIT $ShowPostFrom,5";
                    $stmt = $ConnectingDB->query($sql);
                } elseif (isset($_GET["category"])) {
                    $Category = $_GET["category"];
                    $sql = "SELECT * FROM post WHERE category='$Category' ORDER BY id desc";
                    $stmt = $ConnectingDB->query($sql);
                } else {
                    // $PostIdFromURL = $_GET["id"];
                    $sql = "SELECT * FROM post ORDER BY id desc";
                    $stmt = $ConnectingDB->query($sql);
                }

                while ($DataRows = $stmt->fetch()) {
                    $PostId = $DataRows["id"];
                    $DateTime = $DataRows["datetime"];
                    $PostTitle = $DataRows["title"];
                    $Category = $DataRows["category"];
                    $Admin = $DataRows["author"];
                    $Image = $DataRows["image"];
                    $PostDescription = $DataRows["post"];

                ?>
                    <div class="card" style="border-radius: 5px;">



                        <div class="card-body">
                            <?php

                            if ($Image != 'no-image.jpg') : ?>

                                <img src="./uploads/<?php echo ($Image); ?>" style="max-height:450px; padding: 10px;" class="img-fluid card-img-top" alt="<?php echo $Image; ?>">
                            <?php endif ?>

                            <h4 class="card-title">

                                <?php
                                echo htmlentities($PostTitle);
                                ?>
                            </h4>
                            <small class="text-muted"><b>Category:</b> <?php echo $Category; ?> <br> <b>Written By:</b> <a href="Profile.php?username=<?php echo htmlentities(($Admin)); ?>"><?php echo htmlentities($Admin); ?> </a> On 
                                <?php
                                echo htmlentities($DateTime);
                                ?></small>
                            <small><span style="float:right;" class="text-muted">Comments <?php
                                                                                            echo ApproveCommentCount($PostId);
                                                                                            ?></span></small>
                            </hr>
                            <p class="card-text">
                                <?php
                                if (strlen($PostDescription) > 150) {
                                    $PostDescription = substr($PostDescription, 0, 150) . '...';
                                }
                                echo htmlentities($PostDescription);
                                ?>
                            </p>
                            <a href="FullPost.php?id=<?php echo $PostId; ?>" style="float:right;">
                                <span class="btn btn-info">Read More >> </span>
                            </a>
                        </div>
                    </div>
                <?php } ?>


                <!-- Pagination -->
                <nav>
                    <ul class="pagination pagination-sm">
                        <!--creating backward button-->

                        <?php
                        if (isset($Page) && !empty($Page)) {
                            if ($Page > 1) {
                        ?>
                                <li class='page-item'>
                                    <a href="Blog.php?page=<?php echo $Page - 1; ?>" class="page-link">&laquo;</a>
                                </li>
                        <?php
                            }
                        }
                        ?>
                        <?php
                        global $ConnectingDB;
                        $sql = "SELECT COUNT(*) FROM post";
                        $stmt = $ConnectingDB->query($sql);
                        $RowPagination = $stmt->fetch();
                        $TotalPosts = array_shift($RowPagination);
                        $TotalPosts = 20;
                        $PostPagination = floor($TotalPosts / 5);

                        for ($i = 1; $i < $PostPagination; $i++) {
                            if (isset($Page)) {
                                if ($i == $Page) {
                        ?>
                                    <li class="page-item active">
                                        <a href="Blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                                    </li>
                                <?php } else { ?>
                                    <li class="page-item">
                                        <a href="Blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                                    </li>
                        <?php }
                            }
                        } ?>
                        <!--creating forward button-->
                        <?php
                        if (isset($Page) && !empty($Page)) {
                            if ($Page + 1 < $PostPagination) {
                        ?>
                                <li class='page-item'>
                                    <a href="Blog.php?page=<?php echo $Page + 1; ?>" class="page-link">&raquo;</a>
                                </li>
                        <?php
                            }
                        }
                        ?>
                    </ul>
                </nav>
            </div>

            <!--end of main area-->

            <!--Side area-->
            <div class=" col-sm-4">
                <div class="card mt-4">
                    <div class="card-body">
                        <img src="images/Ad-example.jpg" class="d-block img-fluid mb-3" alt="">
                        <div class='text-center'>
                            Advertisement Sample
                            <br><br>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione quas totam eius voluptatum ad aperiam inventore praesentium. Eligendi harum quidem optio commodi iure ex enim ad. Illum exercitationem dolore facere illo autem.
                        </div>
                    </div>
                </div>

                <br>
                <div class="card">
                    <div class="card-header bg-dark text-light">
                        <h2 class="lead"> Sign Up </h2>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-success btn-block text-center text-white mb-3" name="buttun">Join The Forum</button>
                        <button type="button" class="btn btn-danger btn-block text-center text-white mb-3" name="buttun">Login</button>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="" placeholder="Enter your email" value="">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary btn-sm text-center text-white" name="button">Subscribe</button>
                            </div>
                        </div>
                    </div>
                </div>

                <br>

                <div class="card">
                    <div class="card-header bg-primary text-light">
                        <h2 class="lead">Categories</h2>
                    </div>
                    <div class="card-body">
                        <?php
                        global $ConnectingDB;
                        $sql = 'SELECT * FROM category ORDER BY id desc';
                        $stmt = $ConnectingDB->query($sql);
                        while ($DataRows = $stmt->fetch()) {
                            $CategoryId = $DataRows["id"];
                            $CategoryName = $DataRows["title"];
                        ?>
                            <a href="Blog.php?category=<?php echo $CategoryName; ?>"><span class="heading"><?php echo $CategoryName; ?></span></a>
                            <br>
                        <?php } ?>

                    </div>
                </div>
                <br>

                <div class="card">
                    <div class="card-header bg-info text-white">
                    <h2 class="lead">Recent Posts</h2>
                    </div>
                    <div class="card-body">
                    <?php 
                        global $ConnectingDB; 
                        $sql = "SELECT * FROM post ORDER BY id desc LIMIT 0,5";
                        $stmt = $ConnectingDB->query($sql); 

                        while($DataRows=$stmt->fetch()){
                            $Id = $DataRows["id"]; 
                            $Title = $DataRows["title"]; 
                            $DateTime = $DataRows["datetime"]; 
                            $Image = $DataRows["image"]; 
                        
                    ?>
                    <div class="media">
                        <img src="uploads/<?php echo htmlentities($Image); ?>" class="d-block img-fluid align-self-start" width="90" height="94" alt="">
                        <div class="media-body ml-2">
                            <a href="FullPost.php?id=<?php echo htmlentities($Id); ?>" target="_blank"><h6 class="lead"><?php echo $Title; ?></h6></a>
                            <p class="small"><?php echo htmlentities($DateTime); ?></p>
                        </div>
                    </div>
                    <hr>
                    </div>
                    <?php } ?>
                </div>
            </div>

        </div>
    </div>
 

    <!--END OF HEADER-->

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
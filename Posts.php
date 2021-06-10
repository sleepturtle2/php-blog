<?php 
require_once("./includes/DB.php");
require_once("./includes/Functions.php");
 require_once("./includes/Sessions.php"); 

    $_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
    Confirm_Login();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="./icon-fonts/css/all.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


    <link rel="stylesheet" href="./css/styles.css">
    <title>Document</title>
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
                    <li class="nav-item "><a href="Logout.php" class="nav-link">Logout <i class="lni lni-arrow-right-circle"></i></a></li>
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
                    <h1><i class="fas fa-blog" style="color:#27aae1"></i> Blog Posts</h1>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="AddNewPost.php" class="btn btn-primary btn-block">
                        <i class="fas fa-edit"></i> Add New Post
                    </a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="Categories.php" class="btn btn-info btn-block">
                        <i class="fas fa-folder-plus"></i> Add New Category
                    </a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="Admins.php" class="btn btn-warning btn-block">
                        <i class="fas fa-user-plus"></i> Add New Admin
                    </a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="Comments.php" class="btn btn-success btn-block">
                        <i class="fas fa-check"></i> Approve Comments
                    </a>
                </div>
            </div>
        </div>
    </header>
    <!--END OF HEADER-->


    <!--Main Area-->
    <?php 
        echo ErrorMessage(); 
        echo SuccessMessage(); 
    ?>
    <section class="container py-4 mb-4">
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>DateTime</th>
                            <th>Author</th>
                            <th>Banner</th>
                            <th>Comments</th>
                            <th>Action</th>
                            <th>Live Preview</th>
                        </tr>
                    </thead>
                    <?php
                    global $ConnectingDB;
                    $sql = "SELECT * FROM post";
                    $stmt = $ConnectingDB->query($sql);
                    $SR = 0;
                    while ($DataRows = $stmt->fetch()) {
                        $Id = $DataRows["id"];
                        $DateTime = $DataRows["datetime"];
                        $PostTitle = $DataRows["title"];
                        $Category = $DataRows["category"];
                        $Admin = $DataRows["author"];
                        $Image = $DataRows["image"];
                        $PostText = $DataRows["post"];
                        $SR++;
                    ?>

                        <tbody>
                            <tr>
                                <td><?php echo $SR;  ?></td>
                                <td>
                                    <?php if (strlen($PostTitle) > 20) {
                                        $PostTitle = substr($PostTitle, 0, 20) . '...';
                                    }
                                    echo $PostTitle; ?>
                                </td>
                                <td><?php
                                    if (strlen($Category) > 8) {
                                        $Category = substr($Category, 0, 8) . '...';
                                    }
                                    echo $Category; ?></td>
                                <td><?php
                                    if (strlen($DateTime) > 11) {
                                        $DateTime = substr($DateTime, 0, 11) . '...';
                                    }
                                    echo $DateTime; ?></td>
                                <td>
                                    <?php
                                    if (strlen($Admin) > 6) {
                                        $Admin = substr($Admin, 0, 6) . '...';
                                    }
                                    echo $Admin;
                                    ?></td>
                                <td><img src="uploads/<?php echo $Image; ?>" width="100px;" height="50px;"><?php 
                                    if(strlen($Image) > 8){
                                        $Image = substr($Image, 0, 8) . '...'; 
                                    }
                                echo '<br>'.$Image; ?></td>
                                <td style="word-break:break-all;">
                                
                                    <?php
                                    $Total = ApproveCommentCount($Id);
                                    if ($Total > 0) {
                                    ?>
                                        <span class="badge badge-success">
                                            <?php
                                            echo $Total; ?>
                                        </span>
                                    <?php } ?>
                                    <?php
                                    $Total = DisApproveCommentCount($Id);
                                    if ($Total > 0) {
                                    ?>
                                        <span class="badge badge-danger">
                                            <?php
                                            echo $Total; ?>
                                        </span>
                                    <?php } ?>
                                    </span>
                                
                                </td>
                                <td style="word-break:break-all;">
                                    <a href="EditPost.php?id=<?php echo $Id; ?>"><span class="btn btn-warning">Edit</span></a>
                                    <a href="DeletePost.php?id=<?php echo $Id; ?>"><span class="btn btn-danger">Delete</span></a>
                                </td>
                                <td style="word-break:break-all;">
                                    <a href="FullPost.php?id=<?php echo $Id;?>" target="_blank"><span class="btn btn-primary">Live Previews</span></a>
                                </td>
                            </tr>
                        </tbody>
                    <?php } ?>
                </table>

            </div>
        </div>
    </section>


    <!--End of Main Area-->
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
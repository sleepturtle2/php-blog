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
    <title>Manage Comments</title>
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
                    <h1><i class="fas fa-comments"></i>Manage Comments</h1>
                </div>
            </div>
        </div>
    </header>
    <!--END OF HEADER-->


    <!--main section-->
    <section class="container py-2 mb-4">
        <div class="row" style="min-height:300px;">
            <div class="col-lg-12" style="min-height:400px;">
            <?php 
                echo ErrorMessage();
                echo SuccessMessage(); 
            ?>
            <h2>Un-Approved Comments</h2>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No. </th>
                            <th>Name </th>
                            <th>Date & Time</th>
                            <th>Comment </th>
                            <th>Approve </th>
                            <th>Delete </th>
                            <th>Details </th>
                        </tr>
                    </thead>


                    <?php
                    global $ConnectingDB;
                    $sql = "SELECT * FROM comments WHERE status='OFF' ORDER BY id desc";
                    $Execute = $ConnectingDB->query($sql);
                    $SrNo = 0;
                    while ($DataRows = $Execute->fetch()) {
                        $CommentId = $DataRows["id"];
                        $DateTimeOfComment = $DataRows["datetime"];
                        $CommenterName = $DataRows["name"];
                        $CommentContent = $DataRows["comment"];
                        $CommentPostID = $DataRows["post_id"];
                        $SrNo++;
                        /*
                        if(strlen($CommenterName)>10){
                            $CommenterName = substr($CommenterName, 0, 10).'..';
                        }
                        if(strlen($DateTimeOfComment)>11){
                            $DateTimeOfComment = substr($DateTimeOfComment, 0, 11).'..';
                        }*/
                   
                    ?>
                    <tbody>
                    <tr>
                        <td><?php echo htmlentities($SrNo); ?></td>
                        <td><?php echo htmlentities($CommenterName); ?></td>
                        <td><?php echo htmlentities($DateTimeOfComment); ?></td>
                        <td><?php echo htmlentities($CommentContent); ?></td>
                        <td> <a class="btn btn-success" href="ApproveComment.php?id=<?php echo $CommentId; ?>">Aprrove</a> </td>
                        <td> <a class="btn btn-danger" href="DeleteComment.php?id=<?php echo $CommentId; ?>">Delete</a> </td>
                        <td style="min-width: 140px;"><a class="btn btn-primary" href="FullPost.php?id=<?php echo $CommentPostID; ?>" target="_blank">Live Preview</a></td>
                        <td></td>
                    </tr>
                    </tbody>                         
                    <?php } ?>
                </table>
                <h2>Approved Comments</h2>
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                <tr>
                    <th>No. </th>
                    <th>Date & Time </th>
                    <th>Name </th>
                    <th>Comment </th>
                    <th>Approved By </th>
                    <th>Revert </th>
                    <th>Action </th>
                    <th>Details </th>
                </tr>
                </thead>
                <?php 
                global $ConnectingDB; 
                $sql = "SELECT * FROM comments WHERE status='ON' ORDER BY id desc"; 
                $Execute = $ConnectingDB->query($sql); 
                $SrNo=0; 
                while($DataRows = $Execute->fetch()){
                    $CommentId = $DataRows["id"]; 
                    $DateTimeOfComment = $DataRows["datetime"]; 
                    $CommenterName = $DataRows["name"]; 
                    $ApprovedBy = $DataRows["approvedBy"]; 
                    $CommentContent = $DataRows["comment"]; 
                    $CommentPostID = $DataRows["post_id"]; 
                    $SrNo++; 
                
                ?>
                <tbody>
                    <tr>
                    <td><?php echo htmlentities($SrNo); ?></td>
                    <td><?php echo htmlentities($DateTimeOfComment); ?></td>
                    <td><?php echo htmlentities($CommenterName); ?></td>
                    <td><?php echo htmlentities($CommentContent); ?></td>
                    <td><?php echo htmlentities($ApprovedBy); ?></td>
                    <td style="min-width:140px;"><a href="DisapproveComment.php?id=<?php echo $CommentId; ?>" class="btn btn-warning">Dis-Approve</a></td>
                    <td style="min-width:140px;"><a class="btn btn-primary" href="FullPost.php?id=<?php echo $CommentId; ?>" target="_blank">Live Preview</a></td>
                    </tr>
                </tbody>
                <?php } ?>
            </table>
            </div>
        </div>
    </section>
    <!--end of main section-->
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
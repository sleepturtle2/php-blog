<?php
    function Redirect_to($New_Location){
        header("Location:".$New_Location); 
        exit; 
    }

    function CheckUserNameExists($UserName){
        global $ConnectingDB;
        $sql = 'SELECT username FROM admins WHERE username=:username';
        $stmt = $ConnectingDB->prepare($sql);
        $stmt->bindValue(":username", $UserName);
        $stmt->execute(); 
        $Result = $stmt->rowcount(); 
        if($Result >0) return true; 
        else return false; 
    }

    function Login_Attempt($UserName, $Password){
        global $ConnectingDB; 
        $sql = 'SELECT * FROM admins WHERE username=:userName AND password=:passWord LIMIT 1';
        $stmt = $ConnectingDB->prepare($sql);
        $stmt->bindValue(':userName', $UserName);
        $stmt->bindValue(':passWord', $Password);
        $stmt->execute();
        $Result = $stmt->rowcount(); 
        if($Result >0){
           return $Found_Account = $stmt->fetch(); 
        }
        else{
            return null; 
        }
    }

    function Confirm_Login(){
        if(isset($_SESSION["User_ID"]))
        return true; 
        else 
        $_SESSION["ErrorMessage"] = "Login Required";
        Redirect_to("Login.php");
    }

    function Total_Posts(){
        global $ConnectingDB;
        $sql = "SELECT COUNT(*) FROM post"; 
        $stmt = $ConnectingDB->query($sql);
        $TotalRows = $stmt->fetch();
        $TotalPosts = array_shift($TotalRows);
        echo $TotalPosts;
    }

    function Total_Categories(){
        global $ConnectingDB;
        $sql = "SELECT COUNT(*) FROM category"; 
        $stmt = $ConnectingDB->query($sql);
        $TotalRows = $stmt->fetch();
        $TotalCategories = array_shift($TotalRows);
        echo $TotalCategories;
    }

    function Total_Admins(){
        global $ConnectingDB;
        $sql = "SELECT COUNT(*) FROM admins"; 
        $stmt = $ConnectingDB->query($sql);
        $TotalRows = $stmt->fetch();
        $TotalAdmins = array_shift($TotalRows);
        echo $TotalAdmins;
    }

    function Total_Comments(){
        global $ConnectingDB;
        $sql = "SELECT COUNT(*) FROM comments"; 
        $stmt = $ConnectingDB->query($sql);
        $TotalRows = $stmt->fetch();
        $TotalComments = array_shift($TotalRows);
        echo $TotalComments;
    }

    function ApproveCommentCount($PostId){
        
        global $ConnectingDB; 
        $sqlApprove  = "SELECT COUNT(*) FROM comments WHERE post_id='$PostId' AND status='ON'";
        $stmtApprove = $ConnectingDB->query($sqlApprove); 
        $TotalRows = $stmtApprove->fetch(); 
        $Total = array_shift($TotalRows); 
        return $Total ; 
    }

    function DisApproveCommentCount($PostId){
        global $ConnectingDB; 
        $sqlDisapprove  = "SELECT COUNT(*) FROM comments WHERE post_id='$PostId' AND status='OFF'";
        $stmtDisapprove = $ConnectingDB->query($sqlDisapprove); 
        $TotalRows = $stmtDisapprove->fetch(); 
        $Total = array_shift($TotalRows); 
        return $Total ; 
    }
?>
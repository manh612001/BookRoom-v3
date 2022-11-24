<?php
    require_once('./database/dbhelper.php');
    // $user = $_COOKIE['Id'];
    // if($user!=null)
    // {
    //     header('Location:index.php');
    //     die();
    // }
    $mess='';
    
    if(isset($_POST['login']))
    {
        $username = $_POST['username'];
        $pw = $_POST['password'];
        $sql = "select * from user where UserName = '$username' and Password = '$pw'";
        $result = $conn->query($sql);
        
        if($result == null){
            $mess = "Sai tên đăng nhập hoặc mật khẩu!";
        }
        else{
            
            $row = $result->fetch_assoc();
            $Id = $row['Id'];
            setcookie('Id',$Id,time()+(86400),'/');
            //$_SESSION['email'] = $email;
            
            header('location:index.php');
            die();
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
      crossorigin="anonymous"
    />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./assets/login.css">
    <title>Đăng nhập</title>
</head>
<body>
    <form action="" class="form-login" method="post" style="height:450px">
        <h1 style="margin-bottom:10px;">Đăng nhập</h1> 
        <h6 class="text-danger" style="text-align:center;"><?=$mess?></h6>
        <div class="txtb">
            <input type="text" placeholder="Tên đăng nhập" name="username" require="true">
        </div>
        <div class="txtb">
            <input type="password" placeholder="Mật khẩu" name="password" require>
        </div>
        <input type="submit" class="logbtn" value="Đăng nhập" name="login" >
     </form>
</body>
</html>
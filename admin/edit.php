<?php
    require_once '../database/dbhelper.php';
    session_start();
    if(!isset($_COOKIE['Id']))
    {
        header('location:../login.php');
        die();
    }
    else{
        $Id = $_COOKIE['Id'];
    }
    $sql = "select * from user where Id = '$Id'";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        $name = $row['Name'];
        $username = $row['UserName'];
        $pw = $row['Password'];
        $R = $row['Role'];
    }
    if($R!="admin")
    {
        header('location:../index.php');
    }
    $id = $_COOKIE['Id'];
    $query = "select * from user where Id = '$id'";
    $user = $conn->query($query);
    $row = $user->fetch_assoc();
    $Name = $row['Name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/style.css">
    <!-- jQuery library -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Document</title>
</head>
<body>
    <nav class="navbar navbar-expand-sm bg-primary ">
		<ul class="navbar-nav">
            <li class="nav-item">
				<a class="nav-link text-white navbar-brand" href="../index.php">Calendar</a>
			</li>
			<li class="nav-item">
				<a class="nav-link text-white" href="../admin/room.php">Quản lý phòng</a>
			</li>
			<li class="nav-item">
				<a class="nav-link text-white" href="./account.php">Quản lý tài khoản</a>
			</li>	
            <li class="nav-item">
				<a class="nav-link text-white" href="./history.php">Lịch sử đăng ký</a>
			</li>
  		</ul>
		<div class="nav-item  dropdown " style="position:absolute;right:30px;">
            <span class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa-solid fa-user"></i> <?=$Name?>
            </span>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="logout.php">Đăng xuất</a>
            </div>
        </div>
	</nav>
    <div class="container">
        <div class="box  w-50" style="margin:20px auto;" >
            <h4 style="text-align:center;">Chỉnh sửa thông tin</h4>
            <form  method ="post" >
                    <div class="form-group">
                            <label for="name">Tên tài khoản:</label>
                            <input type="text" class="form-control"  name = "name" value=<?=$name?> require>
                        </div>
                        <div class="form-group" >
                            <label for="email">Email:</label>
                            <input type="text" class="form-control"  name = "username" value=<?=$username?>  require >
                        </div>
                        <div class="form-group" >
                            <label for="email">Mật khẩu:</label>
                            <input type="password" class="form-control"  name = "password" value=<?=$pw?>  require >
                        </div>
                        <div class="form-group" >
                            <label for="email">Xác nhận lại mật khẩu:</label>
                            <input type="password" class="form-control"  name = "cf_password" value=<?=$pw?>  require >
                        </div>
                        <input type="hidden" name ="id" value =<?=$Id?>>
                        <div style="text-align: center;">
                            <button type="submit" class="btn btn-success" name="editUser">Lưu thông tin</button>
                        </div>
            </form>       
        </div>
    </div>

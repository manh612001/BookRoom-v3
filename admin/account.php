<?php
    require_once '../database/dbhelper.php';
    session_start();
    if(!isset($_COOKIE['Id']))
    {
        header('location:../login.php');
        die();
    }
    else{
        $id = $_COOKIE['Id'];
    }
    $query = "select * from user where Id = '$id'";
    $user = $conn->query($query);
    $row = $user->fetch_assoc();
    $Name = $row['Name'];
    
    $sql ="select * from user";
    $result = $conn->query($sql);
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
        <div>
            <h2 style="text-align:center;">Quản lý tài khoản</h2>
        </div>
        <div class="row mt-3">
            <div class="col-md-3">
                <div class="box ">
                    <h4>Đăng ký người dùng</h4>
                    <form  method ="post" action="process.php">
                        <div class="form-group" >
                            <span style="color:red">Mật khẩu mặc định là: 1</span>
                        </div>
                        <div class="form-group">
                            <label for="name">Tên nguời sử dụng <span style="color:red;">*</span>:</label>
                            <input type="text" class="form-control"  name = "name" require>
                        </div>
                        <div class="form-group" >
                            <label for="text">Tên đăng nhập <span style="color:red;">*</span>:</label>
                            <input type="text" class="form-control"  name = "username"   require >
                        </div>
                        <button type="submit" class="btn btn-success" name="addUser">Đăng ký</button>
                    </form>
                </div>
            </div>
            <div class="col-md-9 ">
                <table class="table table-bordered">
                    <thead>
                        <th style="width:50px;">STT</td>
                        <th>Tên người dùng</td>
                        <th>Tên đăng nhập</td>
                        <th style="width:50px;"></th>
                        <th style="width:50px;"></th>
                    </thead>
                    <tbody>
                        <?php
                            $stt = 1;
                            while($row = $result->fetch_assoc())
                            {
                                echo '
                                    <tr>    
                                        <td>'.$stt.'</td>
                                        <td>'.$row['Name'].'</td>
                                        <td>'.$row['UserName'].'</td>
                                        <td><a href="../admin/edit.php?id='.$row['Id'].'"><button class="btn btn-info">Sửa</button></td>
                                        <td>';
                                        $i = $row['Id'];
                                        $sql1 ="select * from user where Id ='$i'";
                                        $rs = $conn->query($sql1);
                                        $row = $rs->fetch_assoc();
                                        $role = $row['Role'];
                                        if($role!='admin')
                                        {
                                            echo'<button class="btn btn-danger" onclick="del('.$row['Id'].')">Xoá</button>';
                                        };
                                        echo'
                                        </td>
                                    </tr>
                                ';
                                $stt = $stt+1;
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    function del(id){
        $.post('process.php',{
            'id': id,
            'delUser':'del'
        },function(data){
            location.reload();
        })
        
    }
</script>


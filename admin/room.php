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
    $room = "select * from room";
    $rs = $conn->query($room);
    $t ="select * from time";
    $rsTime = $conn->query($t);
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
				<a class="nav-link text-white" href="./room.php">Quản lý phòng</a>
			</li>
			<li class="nav-item">
				<a class="nav-link text-white" href="../admin/account.php">Quản lý tài khoản</a>
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
            <h2 style="text-align:center;">Quản lý Phòng</h2>
        </div>
        <div class="row">
            <div class="col-md-6">
                <form class="form-inline" method="post">
                    <input class="form-control mr-sm-2" type="text" name ="room" placeholder="Phòng...">
                    <button class="btn btn-success" type="submit" name="addRoom" >Thêm phòng</button>
                </form>
                <table class="table table-bordered mt-2">
                    <thead>
                        <th style="width:50px;">STT</th>
                        <th>Phòng</th>
                        <th style="width:50px;"></th>
                    </thead>
                    <tbody>
                        <?php
                            $stt=1;
                            while($row=$rs->fetch_assoc())
                            {   
                                
                                echo '
                                    <tr>
                                        <td>'.$stt.'</td>
                                        <td>'.$row['Name'].'</td>
                                        <td><button class="btn btn-danger" onclick="del('.$row['Id'].')">Xoá</button></td>
                                    </tr>
                                ';
                                $stt=$stt+1;
                            }
                        ?>
                    </tbody>
            </table>   
            </div>
            <div class="col-md-6">
                <form class="form-inline" method="post">
                    <input class="form-control mr-sm-2" type="text" name ="time" placeholder="Thời gian...">
                    <button class="btn btn-success" type="submit" name="addTime" >Thêm </button>
                </form>
                <table class="table table-bordered mt-2">
                    <thead>
                        <th style="width:50px;">STT</th>
                        <th>Thời gian</th>
                        <th style="width:50px;"></th>
                    </thead>
                    <tbody>
                        <?php
                            $stt=1;
                            while($row=$rsTime->fetch_assoc())
                            {   
                                
                                echo '
                                    <tr>
                                        <td>'.$stt.'</td>
                                        <td>'.$row['Name'].'</td>
                                        <td><button class="btn btn-danger" onclick="del('.$row['Id'].')">Xoá</button></td>
                                    </tr>
                                ';
                                $stt=$stt+1;
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
            'delRoom':'del'
        },function(data){
            location.reload();
        })
        
    }
</script>
<?php
    if(isset($_POST['addRoom']))
    {
        $room = $_POST['room'];
        if($room !=''){
            $addRoom = "insert into Room values('','$room')";
            if ($conn->query($addRoom) === TRUE)
            {
                header('location:../admin/room.php');
            } 
            else 
            {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        else{
            echo'<script>alert("Vui lòng điền thông tin!")</script>';
        }
        
    }
    $conn->close();
?>
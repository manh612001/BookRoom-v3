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
    $sql = "select events.Created_at as Created_at, user.Name as Name  ,room.Name as room,Time.Name as time,events.Day as day,events.Cancel as cancel
    from events inner join user on events.Id_user = user.Id 
                inner join room on events.Id_room = room.Id
                inner join time on events.Id_time = time.Id
    order by events.Created_at DESC";
    $rs = $conn->query($sql);

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
<body data-spy="scroll" data-target=".navbar" data-offset="50">
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
    <div>
        <h1 style ="text-align:center">Lịch sử</h1>
    </div>
    <div class="container mt-3">
        <div >
            <a href="statistic.php"><button class="btn btn-info mb-2 ">Thống kê</button></a>
        </div>
        <?php
            while($row=$rs->fetch_assoc())
            {   
                $time = explode(" ",$row['Created_at'])[1];
                $h = explode(":",$time)[0];
                $m = explode(":",$time)[1];
                $format = date_create(explode(" ",$row['Created_at'])[0]);
                $day = date_format($format,"d/m/y"); 
                $name = $row['Name'];
                $room = $row['room'];
                $tg = $row['time'];
                $formatDay = date_create($row['day']);
                $d = date_format($formatDay,"d/m/y");
                if($row['cancel']==0)
                {
                    echo"
                        <div class='alert alert-info'>
                            <p>Vào {$h}h{$m} ngày {$day} {$name} đăng ký {$room} trong khoảng thời gian {$tg} ngày {$d}</p>
                        </div>
                    ";
                }
                else
                {
                    echo"
                        <div class='alert alert-danger'>
                            <p>Vào {$h}h{$m} ngày {$day} {$name}  đã huỷ đăng ký {$room} trong khoảng thời gian {$tg} ngày {$d}</p>
                        </div>
                    ";
                }
            }
        ?>
    </div>
</body>
</html>
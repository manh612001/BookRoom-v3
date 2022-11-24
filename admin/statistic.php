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
    <nav class="navbar navbar-expand-sm bg-primary">
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
        <h1 style="text-align:center;">Thống kê</h1>
    </div>
    <div class="container">
        <form class="form-inline" method="POST">
            <select name="n" class="form-control">
                <option value="">Chọn---</option>
                <option value="0">Đăng ký </option>
                <option value="1">Huỷ đăng ký</option>
            </select>
            <button type="submit"  class="btn btn-info" name="statistic">tra cứu</button>
        </form>
        <?php
            if(isset($_POST['statistic']))
            {
                $n=$_POST['n'];
                if($n==0)
                {
                    echo'<div><h1 style="text-align:center;">Đăng ký</h1></div>';
                }
                else{
                    echo'<div><h1 style="text-align:center;">Huỷ đăng ký</h1></div>';
            }}
        ?>
        <table class="table table-bordered mt-2">
            <thead>
                <th class="w-50">Tên</th>
                <th class="w-25">Tháng</th>
                <th class="w-25">Số lần</th>
            </thead>
            <tbody>
                <?php
                    if(isset($_POST['statistic']))
                    {
                        $n = $_POST['n'];
                        if($n=='')
                            $n = 0;
                        $sql = "select user.Name,MONTH(events.Day) as month,COUNT(*) as count from events inner join user on user.Id = events.Id_User where Cancel = {$n} group by MONTH(events.Day)" ;
                        
                        $rs = $conn->query($sql);
                        while($row = $rs->fetch_assoc())
                        {
                            echo'
                                <tr>
                                    <td>'.$row['Name'].'</td>
                                    <td>'.$row['month'].'</td>
                                    <td>'.$row['count'].'</td>
                                </tr>
                            ';
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
<script>
  
</script>
</html>

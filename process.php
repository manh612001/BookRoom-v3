<?php
    
    include_once './database/dbhelper.php';
    $msg = '';
    if(isset($_POST['submit']))
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = $_POST['date'];
        $time = $_POST['time'];
        $id = $_COOKIE['Id'];
        $Id_room = $_POST['room'];
        $cur_month = date('m');
		// $color = $_POST['color'];
        $arrColor = array('',' red',' blue',' green');
        $color = $arrColor[rand(1,4)];
        $sdt = $_POST['phone'];
        $create_at = date('y/m/d H:i:s');
        if($date<date("Y-m-d"))
        {
            $msg = "Bạn chỉ có thể đăng ký ngày hôm nay hoặc các ngày tiếp theo!";
        //   header('location:index.php');
        }
        else
        {
            if($date!='' && $Id_room != '' && $time!='' && $sdt != '')
            {
                $query = "select events.* from events inner join room on events.Id_room = room.Id 
                            where events.Day = '$date' 
                            and events.Time = '$time' 
                            and events.Id_room = '$Id_room'";
                $result = $conn->query($query);
                if ($result->num_rows == 0) {
                    
                    $d = explode("-",$date)[2];
                    $sql = "insert into events  values ('','$id','$Id_room','$sdt','$date','$time','$color','$create_at',0,'')";
                    if ($conn->query($sql) === TRUE)
                    {
                        header('location:day.php?d='.$d.'');
                    } 
                    else 
                    {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                } 
                else 
                {
                    echo "<script>alert('Phòng đã được đăng ký trong khoảng thời gian này!')</script>";
                }
            }
            else
            {
                echo"<script>alert('Vui lòng điền đầy đủ thông tin!')</script>";
            }
        } 
    }
    if(isset($_POST['del']))
    {
        $Id_event = $_POST['id'];
        $note = $_POST['del'];
        $delEvent = "update events set Cancel = 1, Note = '$note' where Id = '$Id_event'";
        $rs = $conn->query($delEvent);
    }
    if(isset($_POST['editUser']))
    {
        $name = $_POST['name'];
        $username = $_POST['username'];
        $pw= $_POST['password'];
        $pw_cf = $_POST['cf_password'];
        $id = $_POST['id'];
        if($name!=''&& $username!=''&& $pw!='' && $pw_cf!='')
        {
            if($pw==$pw_cf)
            {
                $editSql = "update user set Name= '$name',UserName = '$username',Password = '$pw' where Id = '$id'";
                $conn->query($editSql);
                
                header('location:account.php?id='.$id.'');
            }
            else{
                echo'<script>alert("Mật khẩu không trùng khớp!")</script>';
            }
        }
        else{
            echo'<script>alert("Vui lòng điền đầy đủ thông tin!")</script>';
            
        }
    }
    if(isset(($_GET['q'])))
    {
        $q = intval($_GET['q']);
        $sql = "select room.id as Id,room.Name as Name
                from room 
                WHERE room.Id NOT IN (SELECT room.id FROM events INNER JOIN room on events.Id_Room = room.Id INNER JOIN time on time.Id = events.ID_Time WHERE events.Day ='2022-11-23' and time.Id=$q)";
        $result = $conn->query($sql);
        echo '
        <select>';
            while($row = $result->fetch_assoc()) 
            {
                echo '<option>'.$row['Name'].'</option>';
            }
            echo'
        </select>';
    
        }
    $conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- jQuery library -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Thông báo</title>
</head>
<body>
    <h1><?=$msg?></h1>
    <a href="index.php"><Button class="btn btn-success"><i class="fa-solid fa-arrow-left"></i> Quay lại</Button></a>
</body>
</html>

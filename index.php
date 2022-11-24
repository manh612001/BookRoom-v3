<?php
    include 'calendar.php';
    include_once './database/dbhelper.php';
    session_start();
    if(!isset($_COOKIE['Id']))
    {
        header('location:login.php');
        die();
    }
    else{
        $id = $_COOKIE['Id'];
    }
    $calendar = new Calendar(date("Y-m-d"));
    $sql = "select events.Day as Day ,events.Label as Label,user.Name as name from events inner join user on events.Id_User = user.Id where events.Cancel=0";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $name = $row['name'];
            // $Id_r = $row['Id_Room'];
            // $Time = $row['Time'];
            $day = $row['Day'];
            $label = $row['Label'];
            // $calendar->add_event("$Id_user","$Id_r","$day",$Time,"$label");
            $calendar->add_event("$name","$day",$label);
        }
    }

    $room = "select * from room";
    $rs = $conn->query($room);
    $query = "select * from user where Id = '$id'";
    $user = $conn->query($query);
    $row = $user->fetch_assoc();
    $Name = $row['Name'];
    $role = $row['Role'];
    if($role == 'admin')
    {
        require_once './admin/layout/header.php';
    }
    else
        require_once './layout/header.php';
?>
		<div class="container-fluid">
			<div class="content home ">
				<?=$calendar?>
			</div>
		</div>
		</div>
	</body>
</html>

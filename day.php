<?php
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
    $day = $_GET['d'];
    $year = date("Y");
    $month = date("m");
    $sql = "select events.Id as ID, time.Name as time,user.name as user,user.id as id_user,events.sdt as phone,room.name as room 
    from events inner join user on events.Id_User = user.Id
                    inner join room on events.Id_Room = room.Id 
                    inner join time on events.Id_Time = Time.Id
    where events.Day = '$year-$month-$day' and events.Cancel =0";
    $room = "select * from room";
    $rsRoom = $conn->query($room);
    $result = $conn->query($sql);
    $t = "select * from time";
    $rsTime = $conn->query($t); 
    $getUser = "select * from user where Id = '$id'";
    $rs = $conn->query($getUser);
    while($row = $rs->fetch_assoc())
    {
        $Name = $row['Name'];
        $role = $row['Role'];
    }
    if($role =='admin')
    {
        require_once './admin/layout/header.php';
    }
    else{
        require_once './layout/header.php';
    }
    $conn->close();
?>
    <main>
        <div><h2 style="text-align:center;">Ngày: <?="$day-$month-$year"?></h2></div>
        <div class="container">
            <div class="row">
            <div clas="col-md-3">
            <?php
                $date = new DateTime(date("Y-m-d"));
                $this_week = $date->format("W");
                $y = date("Y");
                $m = date("m");
                $next_date = new DateTime("{$y}-{$m}-{$day}");
                $next_week = $next_date->format("W");
                if($day>=date("d") && $this_week==$next_week)
                {
                    $d = "$year-$month-$day";
                    echo '
                    <div class="box">
                    <h2>Đăng ký phòng</h2>
                    <form action="process.php" method ="post">
                            <input type="hidden" value='.$d.' name="date">
                            <div class="form-group" class="was-validated">
                                <label for="tel">Số điện thoại <span style="color:red;">*</span>:</label>
                                <input type="tel" class="form-control"  name = "phone" minlength="9" maxlenght="12" require >
                                
                            </div>
                            <div class="form-group">
                                <label for="time">Thời gian <span style="color:red;">*</span>:</label>
                                <select  class="form-control" name="time" require onchange="show(this.value)">
                                    <option value="">Chọn thời gian</option>';
                                    while($item = $rsTime->fetch_assoc())
                                    {
                                        $id = $item['Id'];
                                        $name = $item['Name'];
                                        echo'<option value = '.$id.'>'.$name.'</option>';
                                    }
                                    echo'
                                </select> 
                            </div>
                            <div class="form-group">
                                <label for="room">Phòng <span style="color:red;">*</span>:</label>
                                <select i class="form-control" id="txtHint" name="room" require>
                                >
                                    <option value="">Chọn phòng</option>';
                                        while($r = $rsRoom->fetch_assoc())
                                        {
                                            $id = $r['Id'];
                                            $name = $r['Name'];
                                        echo '<option value = '.$id.'>'.$name.'</option>';
                                        }
                                    echo'
                                </select> 
                            </div>
                            <button type="submit" class="btn btn-primary" name="submit">Đăng ký</button>
                        </form>
                    </div>
                    ';
                }
               
            ?>
            </div>
            <?php 
                $class = 'col-md-9';
                if($day<date("d") || $this_week!=$next_week)
                    $class = 'col-md-12';
            ?>
            <div class="<?=$class?>">
            <table class="table table-bordered table-hover">
                <thead>
                    <th>Phòng</th>
                    <th>Tên người đăng ký</th>
                    <th>Số điện thoại</th>
                    <th>thời gian</th>
                    <td></td>
                </thead>
                <tbody>
                    <?php
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo'
                                    <tr>
                                        <td>'.$row['room'].'</td>
                                        <td>'.$row['user'].'</td>
                                        <td>'.$row['phone'].'</td>
                                        <td>'.$row['time'].'</td>
                                        <td>';
                                            if($role == 'admin' ||  $id == $row['id_user'] )
                                            {
                                                echo '<button class="btn btn-danger"onclick = "Delete('.$row['ID'].')">Huỷ</button>';
                                            }
                                            echo '    
                                        </td>
                                    </tr>
                                ';
                            }
                        }
                        else{
                            echo '<div><h1 style="text-align:center;">Không có lịch đặt phòng trong ngày !</h1></div>';
                        }
                    ?>
                </tbody>
            </table>
            </div>
            </div>
        </div>

    </main>
</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    function Delete(id){
        let note = prompt('Lý do huỷ lịch!');
        if(!note) return;
        $.post('process.php',{
            'id': id,
            'del':note
        },function(data){
            location.reload();
        })
    }
    function show(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("txtHint").innerHTML = this.responseText;
            //console.log(this.responseText);
        }
        };
        xmlhttp.open("GET","process.php?q="+str,true);
        xmlhttp.send();
    }
    }
</script>

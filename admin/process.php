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
</html>
<?php
    include_once '../database/dbhelper.php';
    if(isset($_POST['delRoom']))
    {
        $Id_room = $_POST['id'];
        $delRoom = "delete from room where Id = '$Id_room'";
        $rs = $conn->query($delRoom);
    }
    if(isset($_POST['delUser']))
    {
        $Id_room = $_POST['id'];
        $delRoom = "delete from user where Id = '$Id_room'";
        $rs = $conn->query($delRoom);
    }
    if(isset($_POST['addUser']))
    {
        $name = $_POST['name'];
        $username = $_POST['username'];
        
        $checkUser = "select * from user where UserName = '$username'";
        $rs = $conn->query($checkUser);
        if ($rs->num_rows == 0) {
            if($name!='' && $username!='')
            {
                $addUser = "insert into User values('','$name','$username','1','user')";
                if ($conn->query($addUser) === TRUE)
                {
                    header('location:../admin/account.php');
                    die();
                } 
                else 
                {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
                
            }
            else{
                echo'<script>alert("Vui lòng điền thông tin!")</script>';
                echo'<a href="../admin/account.php"><button class="btn btn-info m-2">Quay lại</button></a>';
            }
        }
        else{
            echo'<script>alert("Email đã tồn tại!")</script>';
            echo'<a href="../admin/account.php"><button class="btn btn-info m-2">Quay lại</button></a>';
        }
        $conn->close();
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
                header('location:../admin/edit.php?id='.$id.'');
            }
            else{
                
                echo'<script>alert("Mật khẩu không trùng khớp!")</script>';
                echo'<a href="../admin/edit.php?id='.$id.'"><button class="btn btn-info m-2">Quay lại</button></a>';
            }
        }
        else{
            echo'<script>alert("Vui lòng điền đầy đủ thông tin!")</script>';
            echo'<a href="../admin/edit.php?id='.$id.'"><button class="btn btn-info m-2">Quay lại</button></a>';
        }
    }
?>
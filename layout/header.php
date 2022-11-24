<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Event Calendar</title>
		<link href=".../../assets/style.css" rel="stylesheet" type="text/css">
		<link href=".../../assets/calendar.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
		<link href="./layout/style.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
		<!-- jQuery library -->
		<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>

		<!-- Popper JS -->
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

		<!-- Latest compiled JavaScript -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
	</head>
	<body>
	    <nav class="navbar navbar-expand-sm bg-primary fixed-top" style ="height:50px;">
            <ul class="navbar-nav">
                <li class="nav-item">
					<a class="nav-link text-white navbar-brand" href="index.php">Calendar</a>
				</li>
                <li class="nav-item">
					<a class="nav-link text-white" href="./account.php?id=<?=$id?>">Quản lý tài khoản</a>
				</li>
            </ul> 
        
			<div class="nav-item dropdown " style="position:absolute;right:30px;" >
                <span class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa-solid fa-user"></i> <?=$Name?>
                </span>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="logout.php">Đăng xuất</a>
                </div>
            </div>
	    </nav>
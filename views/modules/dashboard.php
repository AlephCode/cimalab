<div>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">

        <div class="container-fluid">
            <!-- Links -->
            <a class="navbar-brand" href="#">
                <img src="views/assets/img/navbar_logo.png" alt="Logo" style="width:40px;" class="rounded-pill">
            </a>

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-item nav-link">
                        <img src="<?php echo $_SESSION['user_image']?>" width="30" height="30" class="rounded-circle" alt="">
                    </a>
                </li>
                <li class="nav-item">
                    <label class="nav-item nav-link"><?php echo $_SESSION['user_email_adress']; ?></label>
                </li>
                <li class="nav-item">
                    <a class="nav-item nav-link"><?php echo $_SESSION['user_first_name'].' '.$_SESSION['user_last_name']; ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-item nav-link" href="views/modules/logout.php">Logout</a>
                </li>
            </ul>
        </div>

    </nav>


</div>


<div class="navbar">
    <nav>
        <ul class="nav nav-pills pull-right">
            <li><a href="index.php">Home</a></li>
            <?php if($_SESSION['loggedInUser']) { ?>
                <li><a href="logout.php">Logout</a></li>
            <?php } else { ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
            <?php } ?>
        </ul>
    </nav>
    <h3 class="text-muted"><a href="/">My Forum</a></h3>
</div>
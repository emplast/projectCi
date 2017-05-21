<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">

        <a class="navbar-brand" href="<?php echo base_url('index.php/Admin/index'); ?>">Wynajem samochodów</a>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav"id="pagination">
                <li><a href="<?php echo base_url('index.php/Aplikacja/index'); ?>"><?php echo 'Home' ?></a></li>
                <li><a href="<?php echo base_url('index.php/Aplikacja/index'); ?>"><?php echo 'O nas'; ?></a></li>
                <li><a href="<?php echo base_url('index.php/Kontakt/index'); ?>"><?php echo'Kontakt'; ?></a></li>
                <li><a href="<?php echo base_url('index.php/Login/index'); ?>"><?php echo 'Zaloguj' ?></a></li>
                <li style="float: right;margin-left: 0px;"><a href="<?php echo base_url('index.php/Out/index'); ?>">Wyloguj</a></li>
                <li style="float: right;margin-left:  0px;"><a href="#"><?php echo $name; ?></a></li>
                <li style="float: right;margin-left: 250px"><a href="#">Zalogowany:</a></li>
            </ul>
        </div>
    </div>
</nav>


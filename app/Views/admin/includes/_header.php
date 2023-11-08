<!-- Navbar -->
<nav class="main-header navbar navbar-expand <?php echo check_dark_mode_enabled() ? 'navbar-dark' : 'navbar-white' ?> navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-sm-inline-block">
            <span id="ct7" class="nav-link"></span>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">


        <!-- Messages Dropdown Menu -->

        <!-- Notifications Dropdown Menu -->

        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item dropdown">

            <a data-toggle="dropdown" href="#">
                <img src="<?php echo get_user_avatar(user()->avatar); ?>" class="img-circle elevation-2 user-image mt-1" width="30px" alt="User Image">
            </a>

            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">


                <a href="<?php echo admin_url() ?>profile" class="dropdown-item">
                    <?php echo trans('settings') ?>

                    <span class="float-right text-muted text-sm"><i class="fas fa-cog"></i></span>
                </a>
                <?php echo form_open('vr-switch-mode', ['id' => 'swith_dark_mode']); ?>
                <?php if (check_dark_mode_enabled() == 1) : ?>
                    <input type="hidden" name="dark_mode" value="0" />
                    <a href="javascript: void(0);" class="dropdown-item" onclick="document.getElementById('swith_dark_mode').submit();">
                        Swith Light Mode
                        <span class="float-right text-muted text-sm"><i class="fa fa-sun"></i></span>
                    </a>
                <?php else : ?>
                    <input type="hidden" name="dark_mode" value="1" />
                    <a href="javascript: void(0);" class="dropdown-item" onclick="document.getElementById('swith_dark_mode').submit();">
                        Swith Dark Mode
                        <span class="float-right text-muted text-sm"><i class="fa fa-moon"></i></span>
                    </a>
                <?php endif; ?>
                <?php echo form_close(); ?>


                <div class="dropdown-divider"></div>

                <a href="<?php echo base_url('auth/logout'); ?>" class="dropdown-item">
                    <?php echo trans('logout') ?>
                    <span class="float-right text-muted text-sm"><i class="fas fa-sign-out-alt"></i></span>
                </a>


            </div>
        </li>

    </ul>
</nav>
<!-- /.navbar -->
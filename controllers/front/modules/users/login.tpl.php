<script type="text/javascript">

    <?php
       if($oSession->getSession('sDisplayMessage'))
       { 
    ?>
        $(document).ready(function() {
            showNotification("<?php echo $oSession->getSession('sDisplayMessage',1); ?>");
        });
        
    <?php
       }
    ?>
</script>
<div class="middle-box text-center loginscreen  animated fadeInDown">
    <div>
        
        <div class="controlapp_logo">
            <img src="<?php echo getConfig('siteUrl').'/images/logo.png' ?>" alt="logo">
        </div>
        <h3><?php echo __('welcome_to_ctrl');?></h3>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
            <!--Continually expanded and constantly improved Inspinia Admin Them (IN+)-->
        </p>
        <p><?php echo __('login_to_see_action');?></p>
        <form class="m-t" role="form" action="<?php echo getConfig('siteUrl').'/users/login' ?>" id="loginForm" method="POST" novalidate="novalidate">
            <div class="form-group">
                <input type="text" class="form-control" id="login_name" placeholder="<?php echo __("enter_login_name")?>" name="login_name" >
                <?php
                if($oSession->hasError('login_name'))
                {
                       echo "<span class='alert alert-danger'>".$oSession->getError('login_name')."</span>";
                }
                ?>
            </div>
            <div class="form-group">
                <input class="form-control" id="password" type="password" placeholder="<?php echo __("enter_password")?>" name="password" >
                <?php
                if($oSession->hasError('password'))
                {
                       echo "<span class='alert alert-danger'>".$oSession->getError('password')."</span>";
                }
                ?>
            </div>
            <button type="submit" class="btn btn-primary block full-width m-b" title="<?php echo __('login');?>" id="loginBtn"><?php echo __('login') ?></button>
            
            <a href="<?php echo getConfig('siteUrl').'/users/forgotpassword' ?>"><small><?php echo __('forgotten_password');?></small></a>
            <p class="text-muted text-center"><small><?php echo __("have_an_account")?></small></p>
            <a class="btn btn-sm btn-white btn-block" href="<?php echo getConfig('siteUrl').'/users/adduser' ?>"><?php echo __("create_an_account")?></a>
        </form>
        <p class="m-t"> Copyright <small><?php echo __('bootstrap_copy');?></small> </p>
    </div>
</div>


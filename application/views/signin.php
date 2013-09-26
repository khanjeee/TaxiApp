<div class="content">
    <div class="wrapper">
        <div class="signin-page">
            <?php
            if($message != "")
            {
                ?>
                <div align="center" style="border:red 1px solid; color:red;"><?php echo $message;?></div>
                <?php
            }
            ?>
            <div class="signin-box">
                <h1>Sign In</h1>
                <form action="<?php echo base_url();?>authenticate/login" method="post" onsubmit="return check_login();" accept-charset="utf-8">
                    <ul>
                        <li>Enter Username or Email</li>
                        <li><input name="identity" id="identity" type="text" class="input" /></li>
                        <li></li>
                        <li>Password</li>
                        <li><input name="password" id="password" type="password" class="input" /><strong><a href="<?php echo base_url();?>authenticate/forgot_password">Forgot?</a></strong></li>
                        <li><input name="remember" id="remember" type="checkbox" value="1" /> Keep me signed in</li>
                        <li><input name="" type="submit" class="signin-btn" value="Sign In" /></li>
                    </ul>
                </form>
                <div id="signin_error" style="clear:both; color:red;"></div>
                <div class="signin-sep"></div>
            </div>
            <div class="signin-page-txt">
                <h1><span style="color:white;font-size: 29px">Learn</span><span style="color:black"> anywhere </span><?php //echo ($header['total_users'] * 1234);?></h1>
                <h2>"Stay Connected Everywhere..." </h2>
                <h2><span style="color:white">LMS</span> <span style="color:black">Student Portal</span> </h2>
            </div>
        </div>


        <div class="bottom-banner">

            <!-- <div><div class="set">
        <a class="item" href="#engage">
            <img alt="Engage" src="<?php echo asset_img("engage.jpg");?>" class="avatar">
            <h2>Engage</h2>
            Tools that bring classrooms<br>to life.                </a>
        <a class="item" href="#connect">
            <img alt="Connect" src="<?php echo asset_img("connect.png");?>" class="avatar">
            <h2>Connect</h2>
            Recommendations on resources and educator connections.                </a>
        <a class="item" href="#measure">
            <img alt="Measure" src="/img/about/track.png" class="avatar">
            <h2>Measure</h2>
            Deeper insights into student performance.                </a>
        <a class="item last" href="#personalize">
            <img alt="Personalize" src="/images/about/access.png" class="avatar">
            <h2>Personalize</h2>
            Educational apps to augment in-classroom learning.                </a>
    </div></div>
-->
            <?php //echo bottom_advertisement_box($center['bottom_advertisement']);?>
        </div>
    </div>
</div>


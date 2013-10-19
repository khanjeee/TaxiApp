<div class="content">
    <div class="wrapper">
        <div class="signin-pagee">
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
                <form action="<?php echo base_url();?>admin/login/verify_login" method="post" onsubmit="return check_login();" accept-charset="utf-8">
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
            
        </div>


    </div>
</div>


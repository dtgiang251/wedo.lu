<div class="heading-tab">
    <ul class="main-menu">
        <?php
        $main_page 		= admin_url('admin.php?page='.BX_Admin::$main_setting_slug);
        $escrow_link 	= add_query_arg('section','escrow', $main_page);
        $general_link 	= add_query_arg('section','general', $main_page);
        $install_link 	= add_query_arg('section','install', $main_page);
        $email_link 	= add_query_arg('section','email', $main_page);
        $payment_link 	= add_query_arg('section','currency_package', $main_page);
        $gateway_link 	= add_query_arg('section','payment_gateways', $main_page);
        $plugin_link   = add_query_arg('section','plugins', $main_page);
        ?>
        <li><a href="<?php echo $general_link;?>">General</a></li>
        <li><a href="<?php echo $payment_link;?>">Currency and Packages</a></li>
        <li><a href="<?php echo $gateway_link;?>">Payment Gateways</a></li>
        <li><a href="<?php echo $escrow_link;?>">Escrrow</a></li>
        <li><a href="<?php echo $email_link;?>">Email</a></li>
        <li><a href="<?php echo $install_link;?>">Install</a></li>
        <li><a href="<?php echo $plugin_link;?>">Plugins</a></li>
    </ul>
</div>

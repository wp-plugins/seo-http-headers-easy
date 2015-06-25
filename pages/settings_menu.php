<?php
/**
 * @author Smiling_Hemp
 * @copyright 2013
 */
?>
<div class="wrap">
    <div class="donate-form">
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
            <input type="hidden" name="cmd" value="_s-xclick" />
            <input type="hidden" name="hosted_button_id" value="6HDLU3LLSN634" />
            <input type="image" src="<?php echo $this->plUrl; ?>css/images/donate.png" name="submit" alt="<?php _e('PayPal - the safer, easier way to pay online!', self::slug);?>" />
        </form>
    </div>
    <h2><span class="dashicons dashicons-hammer dashicons-http"></span><?php _e('HTTP 1.1 headers', self::slug); ?></h2>
    <form id="http-form" action="" method="POST">
        <div id="tabs">
            <ul>
                <li><a href="#tabs-1" class="titlepage"><b><?php _e('HOME', self::slug);?></b></a></li>
                <li><a href="#tabs-2" class="titlepage"><b><?php _e('SINGLE', self::slug);?></b></a></li>
                <li><a href="#tabs-3" class="titlepage"><b><?php _e('PAGE', self::slug);?></b></a></li>
                <li><a href="#tabs-4" class="titlepage"><b><?php _e('AUTHOR', self::slug);?></b></a></li>
                <li><a href="#tabs-5" class="titlepage"><b><?php _e('CATEGORY', self::slug);?></b></a></li>
                <li><a href="#tabs-6" class="titlepage"><b><?php _e('TAG', self::slug);?></b></a></li>
                <li><a href="#tabs-7" class="titlepage"><b><?php _e('SEARCH', self::slug);?></b></a></li>
            </ul>
            <div id="tabs-1">
                <?php include"t_index.php"; ?>
            </div>
            <div id="tabs-2">
                <?php include"t_single.php"; ?>
            </div>
            <div id="tabs-3">
                <?php include"t_page.php"; ?>
            </div>
            <div id="tabs-4">
                <?php include"t_autor.php"; ?>
            </div>
            <div id="tabs-5">
                <?php include"t_category.php"; ?>
            </div>
            <div id="tabs-6">
                <?php include"t_tag.php"; ?>
            </div>
            <div id="tabs-7">
                <?php include"t_search.php"; ?>
            </div>
            <div id="url-for-headers">
                <?php printf( __(' To %scheck%s headings', self::slug), '<b>', '</b>' );?> <a target="_blank" class="url-for-headers-a" href="http://last-modified.com/ru/"><?php echo $_SERVER['HTTP_HOST'];?></a></p>
            </div>
            <div style="text-align: center;">
                <div id="loaderImage"></div><input id="http_submit" type="submit" name="avk-submit" class="button-primary" value="<?php _e('Save Changes', self::slug); ?>"/>
            </div>
        </div>
    </form>
</div>
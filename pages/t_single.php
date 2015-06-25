<?php $option = $this->getOptions['single'];?>
<table id="settings-headers" cellspacing="0">
    <?php include"tabel_head.php";?>
    <tr>
        <td class="tit" rowspan="5"><p><b>SINGLE</b>.php</p></td>
        <td class="lab tdfirst"><label for="singlelm">Last-Modified</label></td>
        <td class="inp tdfirst">
            <select id="singlelm" name="singlelm">
                <option value="set" <?php selected($option['lm'], 'set'); ?>><?php _e('Send', self::slug);?></option>
                <option value="unset" <?php selected($option['lm'], 'unset'); ?>><?php _e('Do not send', self::slug);?></option>
            </select>
        </td>
        <td id="single" class="res" rowspan="5"><?php $this->_print_headers($option);?></td>
    </tr>
    <tr>
        <td class="lab"><label for="singlecc">Cache-Control</label></td>
        <td class="inp">
            <select id="singlecc" name="singlecc">
                <option value="public" <?php selected($option['cc'], 'public'); ?>><?php _e('Cache', self::slug);?></option>
                <option value="no-cache" <?php selected($option['cc'], 'no-cache'); ?>><?php _e('To cache with check', self::slug);?></option>
                <option value="no-store" <?php selected($option['cc'], 'no-store'); ?>><?php _e('Do not cache', self::slug);?></option>
            </select>
        </td>
    </tr>
    <tr>
        <td class="lab"><label for="singlecctm"><?php _e('Time for Cache', self::slug);?></label></td>
        <td class="inp">
            <input type="text" id="singlecctm" title="<?php printf( __('The entered time must be in the format %sHH:ii:ss%s', self::slug), '&laquo;', '&raquo;' );?>" name="singlecctm" value="<?php echo $option['cctm']; ?>"/>
            <div id="slider-range-min-single"></div>
        </td>
    </tr>
    <tr>
        <td class="lab tdlast"><label for="singleping">X-Pingback</label></td>
        <td class="inp tdlast">
            <select id="singleping" name="singleping">
                <option value="set" <?php selected($option['ping'], 'set'); ?>><?php _e('Send', self::slug);?></option>
                <option value="unset" <?php selected($option['ping'], 'unset'); ?>><?php _e('Do not send', self::slug);?></option>
            </select>
        </td>
    </tr>
</table>
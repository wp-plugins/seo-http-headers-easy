<?php $option = $this->getOptions['index'];?>
<table id="settings-headers" cellspacing="0">
    <?php include"tabel_head.php";?>
    <tr>
        <td class="tit" rowspan="5"><p><b>INDEX</b>.php</p></td>
        <td class="lab tdfirst"><label for="indexlm">Last-Modified</label></td>
        <td class="inp tdfirst">
            <select id="indexlm" name="indexlm">
                <option value="set" <?php selected($option['lm'], 'set'); ?>><?php _e('Send', self::slug);?></option>
                <option value="unset" <?php selected($option['lm'], 'unset'); ?>><?php _e('Do not send', self::slug);?></option>
            </select>
        </td>
        <td id="index" class="res" rowspan="5"><?php $this->_print_headers($option);?></td>
    </tr>
    <tr>
        <td class="lab"><label for="indexcc">Cache-Control</label></td>
        <td class="inp">
            <select id="indexcc" name="indexcc">
                <option value="public" <?php selected($option['cc'], 'public'); ?>><?php _e('Cache', self::slug);?></option>
                <option value="no-cache" <?php selected($option['cc'], 'no-cache'); ?>><?php _e('To cache with check', self::slug);?></option>
                <option value="no-store" <?php selected($option['cc'], 'no-store'); ?>><?php _e('Do not cache', self::slug);?></option>
            </select>
        </td>
    </tr>
    <tr>
        <td class="lab"><label for="indexcctm"><?php _e('Time for Cache', self::slug);?></label></td>
        <td class="inp">
            <input type="text" id="indexcctm" title="<?php printf( __('The entered time must be in the format %sHH:ii:ss%s', self::slug), '&laquo;', '&raquo;' );?>" name="indexcctm" value="<?php echo $option['cctm']; ?>"/>
            <div id="slider-range-min-index"></div>
        </td>
    </tr>
    <tr>
        <td class="lab tdlast"><label for="indexping">X-Pingback</label></td>
        <td class="inp tdlast">
            <select id="indexping" name="indexping">
                <option value="set" <?php selected($option['ping'], 'set'); ?>><?php _e('Send', self::slug);?></option>
                <option value="unset" <?php selected($option['ping'], 'unset'); ?>><?php _e('Do not send', self::slug);?></option>
            </select>
        </td>
    </tr>
</table>
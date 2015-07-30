<?php 
/**
 * 	Plugin Name: "SEO-HEADERS-Easy" Protocol HTTP 1.1
 * 	Plugin URI: http://avkproject.ru/useful-articles/headers-in-wordpress.html
 *  Description: Отправляет клиенту корректные заголовки HTTP протокола
 * 	Author: Smiling_Hemp
 * 	Version: 1.1.0
 * 	Author URI: https://profiles.wordpress.org/smiling_hemp#content-plugins
 */

/**
    Copyright (C) 20013-2015 Smiling_Hemp, avkproject.ru (support AT avkproject DOT ru)
    
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or
    (at your option) any later version.
    
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    
    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

class Seo_Http_Head{
    
    protected $host, $plUrl, $plPath, $includePage, $setOptions, $getOptions = '', $arrKey, $temp, $jsArr, $pluginBase;
    
    const slug = 'http-head-protokol-avk';
    const func = 'http_ajax_settings';
    const settings = 'http_headers_avk';
    
    public function __construct(){
        /** Загрузка перевода */
        add_action( 'plugins_loaded' , array( &$this, 'load_plugin_lang' ) );
        
        $this->host = $_SERVER['HTTP_HOST'] . '/';
        $this->siteUrl = site_url();
        $this->plUrl = plugin_dir_url(__FILE__);
        $this->plPath = plugin_dir_path(__FILE__);
        $this->arrKey = array('lm','cc','cctm','ping');
        $this->setOptions = array(
            "index"   => array( "indexlm"   => "set",
                                "indexcc"   => "no-store",
                                "indexcctm" => "0",
                                "indexping" => "unset" ),
            "single"  => array( "singlelm"   => "set",
                                "singlecc"   => "no-store",
                                "singlecctm" => "0",
                                "singleping" => "unset" ),
            "page"    => array( "pagelm"   => "set",
                                "pagecc"   => "no-store",
                                "pagecctm" => "0",
                                "pageping" => "unset" ),
            "author"  => array( "authorlm"   => "set",
                                "authorcc"   => "no-store",
                                "authorcctm" => "0",
                                "authorping" => "unset" ),
            "category"=> array( "catlm"   => "set",
                                "catcc"   => "no-store",
                                "catcctm" => "0",
                                "catping" => "unset" ),
            "tag"     => array( "taglm"   => "set",
                                "tagcc"   => "no-store",
                                "tagcctm" => "0",
                                "tagping" => "unset" ),
            "search"  => array( "searchlm"   => "set",
                                "searchcc"   => "no-store",
                                "searchcctm" => "0",
                                "searchping" => "unset" )
        );
        $this->getOptions = get_option( self::settings );
        $this->jsArr = array(
            "index"  => $this->getOptions['index']['cctm'],
            "single" => $this->getOptions['single']['cctm'],
            "page"   => $this->getOptions['page']['cctm'],
            "author" => $this->getOptions['author']['cctm'],
            "cat"    => $this->getOptions['category']['cctm'],
            "tag"    => $this->getOptions['tag']['cctm'],
            "search" => $this->getOptions['search']['cctm']            
        );
        $this->pluginBase = basename( __DIR__ ) . '/' . basename( __FILE__ );
               
        /** Подключение страници плагина */
        add_action( 'admin_menu', array( &$this, 'add_http_page_settings' ) );
        /** Подключение скриптов */
        add_action( 'admin_enqueue_scripts', array( &$this, 'avk_admin_styles' ) );
        /** Обработка AJAX запроса CMS WordPress в администраторской части сайта*/
        add_action( 'wp_ajax_' . self::func, array( &$this, 'ajax_query_save' ) );
        register_activation_hook( __FILE__, array( &$this, 'add_set_http_head' ) );
        register_deactivation_hook( __FILE__, array( &$this, 'del_set_http_head' ) );
        add_action( 'wp', array( &$this, 'clear_http_headrs' ), 1 );
        add_filter( 'plugin_action_links', array( &$this, 'add_http_link_tools' ), 10, 2);
        add_filter( 'plugin_row_meta', array( &$this, 'add_link_dashplugins'), 10, 2);
    }
    
    public function add_set_http_head(){
        if( version_compare(PHP_VERSION, '5.3.0', '<') ) {
            deactivate_plugins( $this->pluginBase );
			wp_die( sprintf( __( 'This plugin requires PHP version %sTo return back%s', self::slug ), '>= 5.3.0. <a href="' . admin_url( 'plugins.php' ) . '"><strong>', '</strong></a>' ) );
        }
        foreach( $this->setOptions as $key => $value ){
            $outArray[$key] = array_combine( $this->arrKey, $value );
        }
        if( empty( $this->getOptions ) ){
            add_option( self::settings, $outArray );
        }
    }
    
    public function del_set_http_head(){
        delete_option( self::settings );
    }
    
    public function add_http_page_settings(){
        $this->includePage = add_management_page( __( 'General settings', self::slug ), __( 'HTTP 1.1 headers', self::slug ), 'import', self::slug, array( &$this, 'set_page' ) );
    }
    
    public function avk_admin_styles() {
        $page = basename( $_SERVER['PHP_SELF'] );
        if( $page == 'post-new.php' || $page == 'post.php' ){
            wp_enqueue_style( self::slug . '-style', $this->plUrl . 'css/admin-style.css', array( 'wp-admin' ), '1.10.1' );
        }
        if( isset( $_GET['page'] ) ){
            if( $_GET['page'] == self::slug ){
                wp_enqueue_style( self::slug . '-style', $this->plUrl . 'css/admin-style.css', array( 'wp-admin' ),'1.0.0' );            
                wp_enqueue_style( self::slug . '-style-ui', $this->plUrl . 'css/jquery-ui.min.css', array( 'wp-admin' ),'1.10.1' );
                wp_enqueue_script( 'jquery' );
                wp_enqueue_script( 'jquery-ui-core',      null, array( 'jquery' ) );
                wp_enqueue_script( 'jquery-ui-tabs',      null, array( 'jquery', 'jquery-ui-core' ) );
                wp_enqueue_script( 'jquery-ui-slider',    null, array( 'jquery', 'jquery-ui-core' ) );
                wp_enqueue_script( 'jquery-effects-core', null, array( 'jquery', 'jquery-ui-core' ) );
                wp_enqueue_script( 'jquery-effects-drop', null, array( 'jquery', 'jquery-ui-core', 'jquery-effects-core' ) );
                wp_enqueue_script( self::slug . '-script', $this->plUrl . 'js/script.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-tabs', 'jquery-effects-core' ), '1.0.7' );
                wp_enqueue_script( self::slug . '-script-ajax', $this->plUrl . 'js/ajax.js', array('jquery'), '1.0.1' );
                wp_localize_script( self::slug . '-script-ajax', 'httpVar', array( 'dateHttp'  => date('d.m.Y'),
                                                                                   'nonceHttp' => wp_create_nonce('http-nonce'),
                                                                                   'action'    => self::func,
                                                                                   'setMyTime' => $this->jsArr ) );
            }
        }
	}
    
    public function set_page(){
        include_once "pages/settings_menu.php";
    }
    
    protected function _optins_ajax_query_save( $array ){
        if( !is_array( $array ) ) exit( sprintf( __( 'The problem AJAX request!', self::slug ), '<p>', '</p>' ) ) ;
        $mainArray = array();
        foreach( $this->setOptions as $keyMain => $toArray ){
            $i=0;
            $outArray = array();
            foreach( $toArray as $key => $value ){
                if( $key == 'indexcctm' || $key == 'singlecctm' || $key == 'pagecctm' || $key == 'authorcctm' || $key == 'catcctm' || $key == 'tagcctm' || $key == 'searchcctm' ){
                    $outArray[$this->arrKey[$i++]] = $this->get_time_unix( '01.01.1970 ' . $array[$key] );
                }else{
                    $outArray[$this->arrKey[$i++]] = $array[$key];   
                }
            }
            $mainArray[$keyMain] = $outArray;
        }
        return $mainArray;
    }
    
    public function ajax_query_save(){
        if( !isset( $_POST['nonceHttp'] ) || $_POST['nonceHttp'] != wp_create_nonce( 'http-nonce' ) ){
            $result = json_encode( array( 'type'=>false, 'msg' => '<p>' . __( 'Error in data verification !!!', self::slug ) . '</p>' ) );
            exit( $result );
        }
        $arr = json_decode( stripslashes( $_POST['massiv'] ), true );
        $this->getOptions = $this->_optins_ajax_query_save( $arr );
        update_option( self::settings, $this->getOptions );
        foreach( $this->getOptions as $key => $value ){
            $result[$key] = $this->_print_headers( $value, false );
        }
        if( is_array( $result ) ){
            $result['type'] = true;
            $result = json_encode( $result );
        }else{
            $result = json_encode( array( 'type' => false, 'msg' => '<p>' . __( 'Error', self::slug ) . '<p>' ) );
        }
        header( 'Content-Type: text/html; charset=UTF-8' );
        exit( $result );
    }
    
    public function clear_http_headrs(){
        if( is_home() ){
            $this->remuve_headers( $this->getOptions['index'] );
            $this->_set_headers( $this->getOptions['index'] );
        }
        if( is_single() ){
            $this->remuve_headers( $this->getOptions['single'] );
            $this->_set_headers( $this->getOptions['single'] );
        }
        if( is_page() ){
            $this->remuve_headers( $this->getOptions['page'] );
            $this->_set_headers( $this->getOptions['page'] );
        }
        if( is_author() ){
            $this->remuve_headers( $this->getOptions['author'] );
            $this->_set_headers( $this->getOptions['author'] );
        }
        if( is_category() ){
            $this->remuve_headers( $this->getOptions['category'] );
            $this->_set_headers( $this->getOptions['category'] );
        }
        if( is_tag() ){
            $this->remuve_headers( $this->getOptions['tag'] );
            $this->_set_headers( $this->getOptions['tag'] );
        }
    }
    
    public function remuve_headers( $array ){
        if( !is_array( $array ) ) return;

        foreach( headers_list() as $header ) {
            if( strpos( $header, "Expires:" ) !== false ){ header_remove("Expires"); }
            if( strpos( $header, "X-Pingback:" )!== false && $array['ping'] == 'unset' ){ header_remove( "X-Pingback" ); }
            if( strpos( $header, "Pragma:" ) !== false ){ header_remove("Pragma"); }
        }
    }
    
    private function _set_headers($array){
        if( !is_array( $array ) ) return;
        
        $post = get_post( null );
        
        if( !empty( $post ) ){
            $comment = array_shift( get_comments( 'post_id=' . $post->ID . '&number=1&orderby=comment_date&order=DESC' ) );
            if( $comment === null ){
                $lastModifiedUnix = mysql2date( 'U', $post->post_modified_gmt, false );
            }else{
                $commentModifiedUnix = ( int ) mysql2date( 'U', $comment->comment_date_gmt, false );
                $postModifiedUnix = ( int ) mysql2date( 'U', $post->post_modified_gmt, false );
                
                if( $commentModifiedUnix > $postModifiedUnix ){
                    $lastModifiedUnix = $commentModifiedUnix;
                }elseif( $commentModifiedUnix < $postModifiedUnix ){
                    $lastModifiedUnix = $postModifiedUnix;
                }else{
                    $lastModifiedUnix = false;
                }
            }
        }else{
            global $wp_query;
            
            $curauth = $wp_query->get_queried_object();
            
            echo '<pre>';
            print_r( $curauth );
            echo '</pre>';
            $comment = array_shift( get_comments( 'user_id=' . $curauth->ID . '&number=1&order=DESC' ) );
            
            if( !empty( $comment ) && is_object( $comment ) ){
                $postDate = $comment->comment_date_gmt;
            }else{
                $postDate = $curauth->user_registered;
            }
            
            $lastModifiedUnix = ( int ) mysql2date('U', $postDate, false);
        }
        
        if( $lastModifiedUnix !== false && $array['lm'] == 'set' ) header( "Last-Modified: " . date( 'D, d M Y H:i:s', $lastModifiedUnix ) . " GMT" );
        $cctm = '';
        if( $array['cc'] == 'no-cache' || $array['cc'] == 'public' ) $cctm = ', max-age=' . $array["cctm"];
        header( "Cache-Control: " . $array['cc'] . $cctm );
    }
    
    private function _print_headers( $array, $echo = true ){
        if( !is_array( $array ) ) return;
        if( $array['lm'] == 'set' ) $lastmod = '<li>Last-Modified: Tue, 15 Jan 2013 22:25:15 GMT</li>';
        switch( $array['cc'] ){
            case'public'  : $cache = '<li>Cache-Control: public, max-age=' . $array['cctm'] . '</li>'; break;
            case'no-cache': $cache = '<li>Cache-Control: no-cache, max-age=' . $array['cctm'] . '</li>'; break;
            case'no-store': $cache = '<li>Cache-Control: no-store</li>'; break;
        }
        if( $array['ping'] == 'set' ) $ping = '<li>X-Pingback: http://' . $_SERVER['HTTP_HOST'] . '/xmlrpc.php</li>';
        $outStr = '<ul class="headers_http_avk">' . $lastmod . $cache . $expir . $ping . '</ul>';
        if( $echo ) 
            echo $outStr;
        else 
            return $outStr;
    }
    
    public function get_time_unix( $time, $format='U' ){
        $date = new DateTime( $time );
        return $date->format( $format );
    }
        
    /** Фильтрация  данных */
    protected function clear_data_avk( $data, $type="str" ){
        switch( $type ){
            case "str": $data = htmlspecialchars( trim( strip_tags( $data ) ), ENT_QUOTES ); break;
            case "int": $data = abs( ( int ) $data ); break;
        }
        return $data;
    }
    
    /** Получения ID или типа */
    protected function get_post_info( $var = 'id' ){
        global $post;
        switch( $var ){
            case 'id'  : 
                        $postInfo = $post;
                        if( is_object( $postInfo ) ) $postInfo = $postInfo->ID;
                                break;
            case 'type': 
                        $postInfo = $post->post_type;
                                break;
        }
        return $postInfo;
    }
    
    /** Добавляет ссылку настроек */
    public function add_http_link_tools( $links, $file ){
			static $this_plugin;
			if( empty( $this_plugin ) )
				$this_plugin = $this->pluginBase;
			if( $file == $this_plugin ){
				$settings_link = '<a href="' . admin_url( 'tools.php?page=' . self::slug ) . '">' . __( 'Settings', self::slug ) . '</a>';
				array_unshift( $links, $settings_link );
            }		
		return $links;
    }
    
    /** Добавляет ссылки на странице плагинов */
    public static function add_link_dashplugins( $links, $file ) {
		$baseName = plugin_basename( __FILE__ );
        
		if($file == $baseName) {
			$links[] = '<a href="http://goo.gl/qnrM08">' . __('Donate', self::slug) . '</a>';
            $links[] = '<a href="https://wordpress.org/plugins/seo-http-headers-easy/faq/" target="_blank">F.A.Q.</a>';
            $links[] = '<a href="http://avkproject.ru/plugins/seo-headers-full.html" title="' . __( 'Responds to a search engine to the request HTTP_IF_MODIFIED_SINCE, sending header 304 Not Modified', self::slug ) . '">' . __('Updated to full version', self::slug) . '</a>';
		}
        
		return $links;
	}
    
    public function load_plugin_lang(){
        load_plugin_textdomain( self::slug, false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
    }
}

new Seo_Http_Head();
?>
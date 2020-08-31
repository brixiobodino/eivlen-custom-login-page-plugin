<?php

/*
Plugin Name: Eivlen Custom Login Page
Plugin URI: http://wordpress.org/plugins/eivlen-custom-login-page/
Description: A simple plugin to customize wordpress login page
Author: Brixio Bodino
Version: 1.0
Author URI: http://brixiobodino.ml/
*/
// require dirname(__FILE__).'/functions/functions.php';
function eclp_admin_menu(){
    add_menu_page( 'eclp_custom_login_page', 'Eivlen Custom Login Page', 'manage_options', 'eclp-custom-login-page','eclp_main_function', 'dashicons-admin-page');
}
add_action('admin_menu','eclp_admin_menu');
function eclp_activated(){
    global $wpdb;
    $eclp_db = "wp_eclp_custom_db_table";
    if($wpdb->get_var("show tables like wp_eclp_custom_db_table") != $eclp_db){
        $eclp_db_sql="CREATE TABLE wp_eclp_custom_db_table ( `id` int(11) NOT NULL AUTO_INCREMENT,
  `eclp_message` varchar(500) DEFAULT NULL,
   `eclp_login_bg` varchar(500) DEFAULT NULL,
    `eclp_login_bg_image` varchar(500) DEFAULT NULL,
   `eclp_logo_url` varchar(500) DEFAULT NULL,
    `eclp_text_color` varchar(500) DEFAULT NULL,
   `eclp_form_width` int(11) DEFAULT NULL,
   `eclp_form_bg_color` varchar(500) DEFAULT NULL,
   `eclp_form_text_color` varchar(500) DEFAULT NULL,
   `status` varchar(500) DEFAULT NULL,
   PRIMARY KEY (`id`)) ENGINE = InnoDB;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($eclp_db_sql);
    }
}
register_activation_hook(__FILE__,'eclp_activated');

function eclp_style_func(){ // Start of referencing style.css and fontawesome
        $plugin_url = plugin_dir_url( __FILE__ );
        wp_enqueue_style('eclp_style',$plugin_url . "/Assets/style.css");
        // Include our custom jQuery file with WordPress Color Picker dependency
        wp_enqueue_script( 'media_uploader_js', $plugin_url . '/Assets/eclp_media_uploader.js'); 
        wp_enqueue_script( 'customjs', $plugin_url . '/Assets/script.js'); 
}
add_action( 'admin_enqueue_scripts', 'eclp_style_func' ); 
    // End of referencing style.css 


 

function eclp_main_function(){
    wp_enqueue_script('jquery');
    wp_enqueue_media(); // This will enqueue the Media Uploader script
    eclp_db_ops();
   
    global $wpdb;
    $results2=$wpdb->get_results("SELECT  * From wp_eclp_custom_db_table");
    foreach ($results2 as $row2 ){
       $eclp_logo_url_data = $row2->eclp_logo_url;
        $eclp_login_bg_data=$row2->eclp_login_bg;
        $eclp_login_bg_image_data=$row2->eclp_login_bg_image;
        $eclp_header_text=$row2->eclp_message;
        $eclp_form_width_data=$row2->eclp_form_width;
        $eclp_text_color=$row2->eclp_text_color;
        $eclp_form_bg_color=$row2->eclp_form_bg_color;
        $eclp_form_text_color=$row2->eclp_form_text_color;
   }
    
?>
<div class="wrap">
	<div class="eclp_container" style="">
    <div class="eclp_wrapper" >
        <h1>Custom Login Page</h1>
        <div class="eclp_form_container" >
            <form action="<?php  get_admin_url();?>?page=eclp-custom-login-page" method="post">
                <h3>Logo</h3>
                <div class="input_wrapper"  style="margin-bottom: 10px;">
                    <input type="text" name="eclp_logo_url" id="logo_url" placeholder="Logo Url" value="<?php echo $eclp_logo_url_data ?>">
                </div>
                <div class="input_wrapper">
                    <button class="select_logo">Upload Logo</button>
                </div>
                <h3>Header Text</h3>
                 <div class="input_wrapper">
                    <input type="text" name="eclp_header_text" placeholder="Header Text" value="<?php echo $eclp_header_text; ?>">
                </div>
                <h3>Background Image <span class="eclp_note">( Note : If background image is empty background color will be used )</span></h3>
                <div class="input_wrapper" style="margin-bottom: 10px;">
                    <input type="text" name="eclp_login_bg_image"  id="eclp_bg_image" placeholder="Background Image Url" value="<?php echo $eclp_login_bg_image_data; ?>">
                </div>
                <div class="input_wrapper">
                    <button class="select_bg_image">Upload Image</button>
                </div>
                <div style="margin-bottom: 20px;">
                    <div class="eclp_color_div">
                        <h3 style="margin-top: 0px;">Background color</h3>
                        <input type="text" name="login_bg_color" class="color-field" value="<?php echo $eclp_login_bg_data ?>">
                    </div>
                    <div class="eclp_color_div" style="margin-left: 20px;">
                        <h3 style="margin-top: 0px;">Text color</h3>
                        <input type="text" name="eclp_text_color" class="color-field" value="<?php echo $eclp_text_color ?>">
                    </div>
                </div>
               


                <div class="eclp_style_wrapper">
                    <h2>Form Style</h2>
                    <h3>Form Width</h3>
                    <div class="input_wrapper" style="margin-bottom: 10px;">
                        <input type="text" name="eclp_form_width" placeholder="Form Width" value="<?php echo $eclp_form_width_data; ?>">
                    </div>
                    <div class="eclp_color_div_wrapper">
                        <div class="eclp_color_div">
                            <h3>Background color</h3>
                            <input type="text" name="eclp_form_bg_color" class="color-field" value="<?php echo $eclp_form_bg_color;?>">
                        </div>
                        <div class="eclp_color_div" style="margin-left: 20px;">
                            <h3>Text color</h3>
                            <input type="text" name="eclp_form_text_color" class="color-field" value="<?php echo $eclp_form_text_color ?>">
                        </div>
                    </div>
                </div>
                <div class="eclp_submit_btn" style="text-align: right;">
                    <input type="submit" name="eclp_save_btn">
                </div>
            </form>
        </div> <!-- eclp container -->
    </div> <!-- eclp wrapper -->
    <div class="eclp_option" id="eclp_option2">
        <div class="eclp_option_wrapper" style="">
            <h1>Option</h1>

            <form action="<?php  get_admin_url();?>?page=eclp-custom-login-page" method="post">
                <div class="eclp_current" id="eclp_default"></div>
                <input name="eclp_restore" type="submit" value="Default" class="eclp_option_btn" >
                <br>
                <div id="eclp_custom" class="eclp_current"></div>
                <input name="eclp_custom_style" type="submit" value="Custom" class="eclp_option_btn" >
            </form>
            <?php
                if (isset($_POST['eclp_restore'])) {
                  $wpdb->update('wp_eclp_custom_db_table', array('status' => "default"),array('id'=>1));  
                }  
                if (isset($_POST['eclp_custom_style'])) {
                   $wpdb->update('wp_eclp_custom_db_table', array('status' => "custom"),array('id'=>1));  
                }  
            ?>
            <input type="hidden" id="eclp_status" value="<?php  eclp_get_status(); ?>">
            
            
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
  var eclp_default=document.getElementById('eclp_default');
    var eclp_custom=document.getElementById('eclp_custom');
    var eclp_status=document.getElementById('eclp_status');
    var eclp_option=document.getElementById('eclp_option');
    if (eclp_status.value=="default") {
    eclp_default.style.background="rgb(26, 188, 156)";
    eclp_custom.style.background="transparent";
    
    }else{
     eclp_default.style.background="transparent";
    eclp_custom.style.background="rgb(26, 188, 156)";
  
    

}

</script>
<?php
}
function eclp_get_status(){
    global $wpdb;
    $results=$wpdb->get_var("SELECT status From wp_eclp_custom_db_table");
    echo $results;
}
function eclp_db_ops(){
    global $wpdb;
    $results=$wpdb->get_results("SELECT  * From wp_eclp_custom_db_table");
    if( sizeof($results) > 0 ){
        if (isset($_POST['eclp_save_btn'])) {
            $wpdb->update('wp_eclp_custom_db_table', array('eclp_logo_url' => $_POST['eclp_logo_url'],'eclp_login_bg' => $_POST['login_bg_color'],'eclp_login_bg_image' => $_POST['eclp_login_bg_image'],'eclp_message' => $_POST['eclp_header_text'],'eclp_form_width' => $_POST['eclp_form_width'],'eclp_text_color' => $_POST['eclp_text_color'],'eclp_form_bg_color' => $_POST['eclp_form_bg_color'],'eclp_form_text_color' => $_POST['eclp_form_text_color']),array('id'=>1));
        }
    }else{
        if (isset($_POST['eclp_save_btn'])) {
        $wpdb->insert( 'wp_eclp_custom_db_table', array('eclp_logo_url' => $_POST['eclp_logo_url'],'eclp_login_bg' => $_POST['login_bg_color'],'eclp_login_bg_image' => $_POST['eclp_login_bg_image'],'eclp_message' => $_POST['eclp_header_text'],'eclp_form_width' => $_POST['eclp_form_width'],'eclp_text_color' => $_POST['eclp_text_color'],'eclp_form_bg_color' => $_POST['eclp_form_bg_color'],'eclp_form_text_color' => $_POST['eclp_form_text_color']));  
        }
    }
} // end of eclp_db_ops
function eclp_style() { 
    global $wpdb;
    $results=$wpdb->get_results("SELECT  * From wp_eclp_custom_db_table");
    foreach ($results as $row ){
        $eclp_logo=$row->eclp_logo_url;
        $eclp_login_bg=$row->eclp_login_bg;
        $eclp_login_bg_image=$row->eclp_login_bg_image;
        $eclp_form_width_data=$row->eclp_form_width;
        $eclp_text_color=$row->eclp_text_color;
        $eclp_form_bg_color=$row->eclp_form_bg_color;
        $eclp_form_text_color=$row->eclp_form_text_color;
        $status=$row->status;   
    }
?>
    <style type="text/css"> 
        #login h1 a, .login h1 a {
        background-image: <?php if ($status=="default") {}else{echo "url(" . $eclp_logo . ")";}?>;
        height:<?php if ($status=="default") { echo "84px";}else{echo "150px";}?>;
        width:<?php if ($status=="default") { echo "84px";}else{echo "150px";}?>;
        background-size: <?php if ($status=="default") { echo "84px 84px";}else{echo "150px 150px";}?>;
        background-repeat: no-repeat;
        
        border-radius: 50%;
        }
        #login{
            width:<?php if ($status=="default") {}else{echo $eclp_form_width_data . "px"; }    ?>!important;
            color:<?php  if ($status=="default") {}else{ echo $eclp_text_color; }   ?>!important;
        }
        #login a{
            color:<?php  if ($status=="default") {}else{ echo $eclp_text_color;  }    ?>!important;
        }
        #login h1{
            margin: 10px;
        }
        #login p.message{
            display: none !important;
        }
        body.login{
            background:<?php  if ($status=="default") {}else{ if(empty($eclp_login_bg_image)){echo $eclp_login_bg;}else{echo "url(" . $eclp_login_bg_image . ")";}}?>;
            background-size: cover;
        }
        body.login div#login form#loginform{
            background: <?php if ($status=="default") {}else{ echo $eclp_form_bg_color; }  ?> !important;
            color:<?php if ($status=="default") {}else{ echo $eclp_form_text_color; }   ?> !important;
            border:1px solid <?php if ($status=="default") { echo "#ccd0d4" ; }else{ echo $eclp_form_bg_color; }    ?>  ;
            box-shadow: 0 1px 3px rgba(0,0,0,.04);
            margin: auto;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'eclp_style'); 
//end of eclp_style
function eclp_login_message($message) {
    global $wpdb;
    $results2=$wpdb->get_results("SELECT  * From wp_eclp_custom_db_table");
    foreach ($results2 as $row2 ){
    $eclp_header_text=$row2->eclp_message;
    $status=$row2->status;
    }
    if ( empty($message) ){
        if ($status=="default") {
              
        }else{
            return "<h1>" . $eclp_header_text . "</h1>";
        }
      
    } else {
        echo  $message ;
    }
}
add_filter( 'login_message', 'eclp_login_message' );


function eclp_color_picker( $hook ) {
 
    if( is_admin() ) { 
     
        // Add the color picker css file       
        wp_enqueue_style( 'wp-color-picker' ); 
         
        // Include our custom jQuery file with WordPress Color Picker dependency
        wp_enqueue_script( 'custom-script-handle', plugins_url( 'Assets/custom-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true ); 
    }   
}
add_action( 'admin_enqueue_scripts', 'eclp_color_picker' );
//end of eclp_color_picker
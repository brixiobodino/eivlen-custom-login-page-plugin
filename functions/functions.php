
<?php
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

function eclp_db_query(){
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
}
function eclp_get_status(){
    global $wpdb;
    $results=$wpdb->get_var("SELECT status From wp_eclp_custom_db_table");
    echo $results;
}
function eclp_style() { 
   eclp_db_query();
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
            width:<?php echo $eclp_form_width_data . "px"; ?>!important;
            color:<?php echo $eclp_text_color; ?>!important;
        }
        #login a{
            color:<?php echo $eclp_text_color; ?>!important;
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
            background: <?php echo $eclp_form_bg_color ?> !important;
            color:<?php echo $eclp_form_text_color ?> !important;
            border:1px solid <?php echo $eclp_form_bg_color ?>  ;
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
    }
    if ( empty($message) ){
      return "<h1>" . $eclp_header_text . "</h1>";
    } else {
        echo  $message ;
    }
}
add_filter( 'login_message', 'eclp_login_message' );
//end of eclp_login_message
?>
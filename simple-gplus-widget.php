<?php
/*
Plugin Name: Simple Gplus Widget
Plugin URI: https://wordpress.org/support/profile/amybeagh
Description: Simple Gplus Widget - is the common way to display your google plus profile on your Wordpress website. With our Simple Gplus Widget you can do more.
Version: 1.0
Author :Amy Beagh
Author URI: https://wordpress.org/support/profile/amybeagh
*/

/*Main gpw class for google plus*/
class gpw_GplusWidgets{
    
    public $options;
    
    public function __construct() {
        $this->options = get_option('gpw_badge_config_options');
        $this->gpw_real_google_register_settings_and_fields();
    }
    
    public function gpw_add_real_fb_tools_options_page(){
        add_options_page('Simple Gplus Widget Settings', 'Simple Gplus Widget', 'administrator', __FILE__, array('gpw_GplusWidgets','gpw_badge_options'));
    }
    
    public function gpw_badge_options(){
?>

<div class="wrap">
  <div class="gpw-outer">
    <form method="post" action="options.php" enctype="multipart/form-data">
      <?php settings_fields('gpw_badge_config_options'); ?>
      <?php do_settings_sections(__FILE__); ?>
      <p class="submit">
        <input name="submit" type="submit" class="button-primary" value="Save Changes"/>
      </p>
    </form>
  </div>
</div>
<?php
    }
    public function gpw_real_google_register_settings_and_fields(){
		
        register_setting('gpw_badge_config_options', 'gpw_badge_config_options',array($this,'gpw_real_google_validate_settings'));
		
        add_settings_section('gpw_badge_attribute_option', 'Simple Gplus Widget Settings', array($this,'gpw_badge_attribute_option_cb'), __FILE__);
		
		 //Start Creating Fields and Options
         //pageURL
        add_settings_field('gpw_pageURL', 'Gplus Pofile ID', array($this,'gpw_pageURL_settings'), __FILE__,'gpw_badge_attribute_option');
          
		//marginTop
        add_settings_field('gpw_marginTop', 'Margin Top', array($this,'gpw_marginTop_settings'), __FILE__,'gpw_badge_attribute_option');
        //width
        add_settings_field('gpw_width', 'Width', array($this,'gpw_width_settings'), __FILE__,'gpw_badge_attribute_option');
        //height
      
	   //layout options
        add_settings_field('gpw_layout', 'Layout', array($this,'gpw_layout_settings'),__FILE__,'gpw_badge_attribute_option');
        //color_scheme options
        add_settings_field('gpw_color_scheme', 'Cover Theme', array($this,'gpw_color_scheme_settings'),__FILE__,'gpw_badge_attribute_option');
        //show_faces options
        add_settings_field('gpw_showcover', 'Cover Photo', array($this,'gpw_show_faces_settings'),__FILE__,'gpw_badge_attribute_option');
         
        //alignment option
         add_settings_field('gpw_alignment', 'Alignment Position', array($this,'gpw_position_settings'),__FILE__,'gpw_badge_attribute_option');
		 
        //show hide options
	     add_settings_field('gpw_status', 'Show on frontend', array($this,'gpw_status_settings'),__FILE__,'gpw_badge_attribute_option');
    	
    }
    public function gpw_real_google_validate_settings($gpw_plugin_options){
        return($gpw_plugin_options);
    }
    public function gpw_badge_attribute_option_cb(){
        //optional
    }

    //marginTop_settings
    public function gpw_marginTop_settings() {
        if(empty($this->options['gpw_marginTop'])) $this->options['gpw_marginTop'] = "100";
        echo "<input name='gpw_badge_config_options[gpw_marginTop]' type='text' value='{$this->options['gpw_marginTop']}' />";
    }
    //pageURL_settings
    public function gpw_pageURL_settings() {
        if(empty($this->options['gpw_pageURL'])) $this->options['gpw_pageURL'] = "";
        echo "<input name='gpw_badge_config_options[gpw_pageURL]' type='text' value='{$this->options['gpw_pageURL']}' />";
    }
   
    //width_settings
    public function gpw_width_settings() {
        if(empty($this->options['gpw_width'])) $this->options['gpw_width'] = "300";
        echo "<input name='gpw_badge_config_options[gpw_width]' type='text' value='{$this->options['gpw_width']}' />";
    }
   
    //layout_settings
    public function gpw_layout_settings(){
        if(empty($this->options['gpw_layout'])) $this->options['gpw_layout'] = "portrait";
        $items = array('portrait','landscape');
       
	   	 foreach($items as $item){
            $selected = ($this->options['gpw_layout'] === $item) ? 'checked = "checked"' : '';
            
			echo "<input type='radio' name='gpw_badge_config_options[gpw_layout]' value='$item' $selected> ".ucfirst($item)."&nbsp;";
        }
       
    }
    //color_scheme_settings
    public function gpw_color_scheme_settings(){
        if(empty($this->options['gpw_color_scheme'])) $this->options['gpw_color_scheme'] = "light";
        $items = array('light','dark');
          
		 foreach($items as $item){
            $selected = ($this->options['gpw_color_scheme'] === $item) ? 'checked = "checked"' : '';
            
			echo "<input type='radio' name='gpw_badge_config_options[gpw_color_scheme]' value='$item' $selected> ".ucfirst($item)."&nbsp;";
        }
		
       
    }
    //showcover_settings
    public function gpw_show_faces_settings(){
        if(empty($this->options['gpw_showcover'])) $this->options['gpw_showcover'] = "true";
        $items = array('true','false');
		
        foreach($items as $item){
            $selected = ($this->options['gpw_showcover'] === $item) ? 'checked = "checked"' : '';
            
			echo "<input type='radio' name='gpw_badge_config_options[gpw_showcover]' value='$item' $selected> ".ucfirst($item)."&nbsp;";
        }
       
    }
    
      //alignment_settings
    public function gpw_position_settings(){
        if(empty($this->options['gpw_alignment'])) $this->options['gpw_alignment'] = "left";
        $items = array('left','right');
        
	   foreach($items as $item){
            $selected = ($this->options['gpw_alignment'] === $item) ? 'checked = "checked"' : '';
            
			echo "<input type='radio' name='gpw_badge_config_options[gpw_alignment]' value='$item' $selected> ".ucfirst($item)."&nbsp;";
        }
    }
	
	
	 //show hide settings
    public function gpw_status_settings(){
        if(empty($this->options['gpw_status'])) $this->options['gpw_status'] = "on";
        $items = array('on','off');
        
	   foreach($items as $item){
            $selected = ($this->options['gpw_status'] === $item) ? 'checked = "checked"' : '';
			echo "<input type='radio' name='gpw_badge_config_options[gpw_status]' value='$item' $selected> ".ucfirst($item)."&nbsp;";
        }
		
    }
	
    // put jQuery settings before here
}

/*@Function initialization */
add_action('admin_menu', 'gpw_real_google_trigger_options_function');

function gpw_real_google_trigger_options_function(){
    gpw_GplusWidgets::gpw_add_real_fb_tools_options_page();
}

add_action('admin_init','gpw_real_google_trigger_create_object');
function gpw_real_google_trigger_create_object(){
    new gpw_GplusWidgets();
}

/*@Function to display badge*/
add_action('wp_footer','gpw_real_google_add_content_in_footer');

function gpw_real_google_add_content_in_footer(){
		
	$gpl_options = get_option('gpw_badge_config_options');
	
	extract($gpl_options);
	$print_google = '';
	if($gpw_pageURL == ''){
	
		$print_google.='<div class="error_gpw">Please Fill Out The Simple Gplus Widget Configuration First</div>';	
	
	} else {
	
		$print_google .= '<div class="g-person" data-href="//plus.google.com/u/0/'.stripslashes($gpw_pageURL).'" 
		data-theme="'.stripslashes($gpw_color_scheme).'" data-showcoverphoto="'.stripslashes($gpw_showcover).'" data-layout="'.stripslashes($gpw_layout).'"  data-rel="author" style="width: '.stripslashes($gpw_width).'px"></div>';
	
	}
	$sidebarImgURL = plugins_url( 'assets/googlesgw-icon2.png', __FILE__ );

	if($gpw_status == 'on'):
	 ?>
	<script type="text/javascript">
	jQuery(document).ready(function(){
	  jQuery('#gpw1').click(function(){
		 jQuery(this).parent().toggleClass('gpw_p');
	});
	});
	</script> 
	<script src="https://apis.google.com/js/platform.js" async defer></script>

<?php if($gpw_alignment=='left'){?>
		<style>
			#gpw1{
				transition: all 0.5s ease-in-out 0s;
				left: -<?php echo trim($gpw_width+10);?>px; top: <?php echo $gpw_marginTop;?>px; z-index: 10000; 
			}
			#gpw2{
				 text-align: left;
				 width:<?php echo trim($gpw_width);?>px;
				 }
			#gpw2 img{
				top: 0px;right:-50px;
			}
			.gpw_p #gpw1{
				left:0px;
			}
		</style>
		<div id="gpw_gplus_badge_display">
		  <div id="gpw1">
			<div id="gpw2"> <a class="open" id="fblink" href="#"></a><img src="<?php echo stripslashes($sidebarImgURL);?>" alt=""> <?php echo stripslashes($print_google); ?> </div>
		  </div>
		</div>
	<?php } else { ?>
	<style>
		#gpw1{
			transition: all 0.5s ease-in-out 0s;
			right: -<?php echo trim($gpw_width+10);?>px;
			top: <?php echo $gpw_marginTop;?>px; 
			z-index: 10000;
			}
		#gpw2{
			text-align: left;
			width:<?php echo trim($gpw_width);?>px;
				}
		#gpw2 img{
			top: 0px;left:-50px;
		}
		.gpw_p #gpw1{
			right:0px;
		}
	</style>
	<div id="gpw_gplus_badge_display">
	  <div id="gpw1">
		<div id="gpw2"> <a class="open" id="fblink" href="#"></a> <img src="<?php echo stripslashes($sidebarImgURL);?>" alt=""> <?php echo stripslashes($print_google); ?> </div>
	  </div>
	</div>
	<?php } ?>
	<?php
	
	endif;
}

/*@Function for add css on front and admin*/
add_action( 'wp_enqueue_scripts', 'gpw_register_add_csss' );
add_action( 'admin_enqueue_scripts', 'gpw_register_add_csss' );

function gpw_register_add_csss() {
    wp_register_style( 'gpw_add_css', plugins_url( 'assets/gpw.css' , __FILE__ ) );
    wp_enqueue_style( 'gpw_add_css' );
}

/* shortcode function */
function shortcode_sgw_functions()
{
	$gpl_options1 = get_option('gpw_badge_config_options');
	
	extract($gpl_options1);
	$print_google_shortcode = '';
	if($gpw_pageURL == ''){
	
		$print_google_shortcode.='<div class="error_gpw">Please Fill Out The Simple Gplus Widget Configuration First</div>';	
	
	} else {
	
		$print_google_shortcode .= '<div class="g-person" data-href="//plus.google.com/u/0/'.stripslashes($gpw_pageURL).'" 
		data-theme="'.stripslashes($gpw_color_scheme).'" data-showcoverphoto="'.stripslashes($gpw_showcover).'" data-layout="'.stripslashes($gpw_layout).'"  data-rel="author" style="width: '.stripslashes($gpw_width).'px"></div>';
	
	}
	return $print_google_shortcode;
}
add_shortcode('sgw_simple_gplus_widget', 'shortcode_sgw_functions');

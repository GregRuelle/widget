<?php
/*
* Plugin Name: Media Upload Widget
* Plugin URI: http://stackoverflow.com/questions/17466631/wordpress-media-uploader-in-widget
* Description: A widget that allows you to upload media from a widget
* Version: 1.0


/**
 * Register the Widget
 */


class my_plugin extends WP_Widget {

  // constructor
  function my_plugin() {
    parent::WP_Widget(false, $name = __('My Widget', 'wp_widget_plugin') );
    
  }

  // widget form creation
  function form($instance) {

      // Check values
    if( $instance) {
       $title = esc_attr($instance['title']);
       $textarea = $instance['textarea'];
       $img = $instance['image_uri'];
       $url = $instance['url'];
    } else {
       $title = '';
       $textarea = '';
       $img = '';
       $url = '';
    } ?>

    <p>
      <label for="<?php echo $this->get_field_id('image_uri'); ?>">Photo</label><br/>
      <?php if ( $img ){ ?>
        <img src="<?php echo $instance['image_uri']; ?>">
      <?php } ?>
      <input type="text" class="img widefat" name="<?php echo $this->get_field_name('image_uri'); ?>" id="<?php echo $this->get_field_id('image_uri'); ?>" value="<?php echo $instance['image_uri']; ?>" style="display:none"/>
      <input type="button" class="select-img button button-primary" value="Sélectionner une photo" style="margin-top:10px"/>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>">Titre</label>
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('textarea'); ?>">Description</label>
      <textarea class="widefat" id="<?php echo $this->get_field_id('textarea'); ?>" name="<?php echo $this->get_field_name('textarea'); ?>" rows="7" cols="20" ><?php echo $textarea; ?></textarea>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('url'); ?>">Url</label>
      <input class="widefat" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo $url; ?>" />
    </p>

  <?php }

  
  function update($new_instance, $old_instance) {
    $instance = $old_instance;
    // Fields
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['textarea'] = strip_tags($new_instance['textarea']);
    $instance['image_uri'] = strip_tags($new_instance['image_uri']);
    $instance['url'] = strip_tags($new_instance['url']);
   return $instance;
  }
    

     // display widget
  function widget($args, $instance) {
    extract( $args );
     
    // these are the widget options
    $title = apply_filters('widget_title', $instance['title']);
    $textarea = apply_filters( 'wp_widget_plugin', $instance['textarea'], $instance );;
    $img = $instance['image_uri'];
    $url = $instance['url'];
    
    
    echo $before_title . $title . $after_title ;
    echo '<img src="'.$img.'" />';
    echo '<p>'.$textarea.'</p>';
    echo '<a href="'.$url.'">Link</a>';
  }
}
add_action('widgets_init', create_function('', 'return register_widget("my_plugin");')); 



// queue up the necessary js
function hrw_enqueue(){
  wp_enqueue_style('thickbox');
  wp_enqueue_script('media-upload');
  wp_enqueue_script('thickbox');
  // moved the js to an external file, you may want to change the path
  wp_enqueue_script('hrw', '/wp-content/plugins/media-upload-widget/script.js', null, null, true);
}
add_action('admin_enqueue_scripts', 'hrw_enqueue');

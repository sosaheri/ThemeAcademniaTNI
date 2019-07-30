<?php

/**
 * FILE: class.php 
 * Author: Mr.Vibe 
 * Credits: www.VibeThemes.com
 * Project: WPLMS
 */
if ( !defined( 'ABSPATH' ) ) exit;
add_action( 'customize_register', 'themename_customize_register' );
function themename_customize_register($wp_customize) {

    class Vibe_Customize_Slider_Control extends WP_Customize_Control {
        public $type = 'text';
     
        public function render_content() {
            ?>
            <label>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <input type="text" class="slider_value text" data-min="<?php echo esc_html( $this->min ); ?>" data-max="<?php echo esc_html( $this->max ); ?>" <?php $this->link(); ?> value="<?php echo $this->value(); ?>" />
            <div class="customizer_slider"></div>
            </label>
            <?php
        }
    }

    class Vibe_Customize_Textarea_Control extends WP_Customize_Control {
        public $type = 'textarea';
     
        public function render_content() {
            ?>
            <label>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
            </label>
            <?php
        }
    }


    class Vibe_Customize_ImgSelect_Control extends WP_Customize_Control {
        
        public $type = 'hidden';
        public function render_content() {
            $control = 'vibe_'.rand(0,9999999);
            $type = 'hidden';
            ?>
            <div class="vibe_customizer_<?php echo $control; ?>">
                <label><span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span></label>
                <ul class="imgselect_choices">
                <?php

                    foreach($this->choices as $key=>$choice){
                        echo '<li><span class="'.(($this->value() == $key)?'selected':'').'" data-val="'.$key.'"><img src="'.$choice.'" ></span></li>';
                    }
                ?>
                </ul><input type="<?php echo $type; ?>"  <?php echo $this->get_link(); ?> />
                <script>
                    jQuery('.vibe_customizer_<?php echo $control; ?> input[type="<?php echo $type; ?>"]').val(jQuery('.vibe_customizer_<?php echo $control; ?> .imgselect_choices span.selected').attr('data-val'));
                    jQuery('.vibe_customizer_<?php echo $control; ?> .imgselect_choices span').on('click',function(){
                        jQuery('.vibe_customizer_<?php echo $control; ?> .imgselect_choices span.selected').removeClass('selected');
                        jQuery(this).addClass('selected');
                        jQuery('.vibe_customizer_<?php echo $control; ?> input[type="<?php echo $type; ?>"]').val(jQuery(this).attr('data-val'));
                        jQuery('.vibe_customizer_<?php echo $control; ?> input[type="<?php echo $type; ?>"]').trigger('change');
                    });
                </script>
            </div>
            <?php
        }
    }

    class Vibe_Customize_Checkbox_control extends WP_Customize_Control{
        public $type = 'toogle_checkbox';
        public function render_content(){
            ?>
            <div class="checkbox_switch">
                <div class="onoffswitch">
                    <input type="checkbox" id="<?php echo esc_attr($this->id); ?>" name="<?php echo esc_attr($this->id); ?>" class="onoffswitch-checkbox" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); checked( $this->value() ); ?>>
                    <label class="onoffswitch-label" for="<?php echo esc_attr($this->id); ?>"></label>
                </div>
                <span class="customize-control-title onoffswitch_label"><?php echo esc_html( $this->label ); ?></span>
                <p><?php echo wp_kses_post($this->description); ?></p>
            </div>
            <?php
        }
    }
}

?>

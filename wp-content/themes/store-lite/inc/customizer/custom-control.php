<?php
/**
* Layouts Settings.
*
* @package Store Lite
*/

/** Customizer Custom Control **/
if ( class_exists( 'WP_Customize_Control' ) ) {
    
    // Radio Image Custom Control Class.
    class Store_Lite_Custom_Radio_Image_Control extends WP_Customize_Control {

    	public $type = 'radio-image';
    
    	public function render_content() {
    	   
    		if ( empty( $this->choices ) ) {
    			return;
    		}			
    		
    		$name = '_customize-radio-' . $this->id; ?>
            
    		<span class="customize-control-title">
    			<?php echo esc_attr( $this->label ); ?>
    			<?php if ( ! empty( $this->description ) ) : ?>
    				<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
    			<?php endif; ?>
    		</span>
            
    		<div id="input_<?php echo esc_attr($this->id); ?>" class="image radio-image-buttenset">
    			<?php foreach ( $this->choices as $value => $label ) : ?>
    				<input class="image-select" type="radio" value="<?php echo esc_attr( $value ); ?>" id="<?php echo esc_attr($this->id) . esc_attr($value); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?>>
    					<label for="<?php echo esc_attr($this->id) . esc_attr($value); ?>">
    						<img src="<?php echo esc_html( $label ); ?>" alt="<?php echo esc_attr( $value ); ?>" title="<?php echo esc_attr( $value ); ?>">
    					</label>
    				</input>
    			<?php endforeach; ?>
    		</div>
            
   		<?php }
    }
    
}

/** Customizer Custom Control **/
if ( class_exists( 'WP_Customize_Control' ) ) {
    
    // Radio Image Custom Control Class.
    class Store_Lite_Info_Notiece_Control extends WP_Customize_Control {

        public $type = 'infonotice';
    
        public function render_content() {
           
            $name = '_customize-radio-' . $this->id; ?>
            
            <span class="customize-control-title">
                <span class="twp-notiect-bar"><?php echo esc_html( $this->label ); ?></span>

                <div class="twp-info-icon">
                    <div class="icon-notice-wrap">
                        <span class="dashicons dashicons-move twp-filter-icon"></span>
                        <p><?php esc_html_e( 'Click hold and drag to re-order.', 'store-lite' ); ?></p>
                    </div>
                    <div class="icon-notice-wrap">
                        <span class="dashicons dashicons-arrow-down twp-filter-icon"></span>
                        <p><?php esc_html_e( 'Click to expand settings.', 'store-lite' ); ?></p>
                    </div>
                </div>
            </span>
            
        <?php }
    }
    
}

/**
 * Upsell customizer section.
 *
 * @since  1.0.0
 * @access public
 */
class Store_Lite_Customize_Section_Upsell extends WP_Customize_Section {

    /**
     * The type of customize section being rendered.
     *
     * @since  1.0.0
     * @access public
     * @var    string
     */
    public $type = 'upsell';

    /**
     * Custom button text to output.
     *
     * @since  1.0.0
     * @access public
     * @var    string
     */
    public $pro_text = '';

    /**
     * Custom pro button URL.
     *
     * @since  1.0.0
     * @access public
     * @var    string
     */
    public $pro_url = '';

    public $notice = '';
    public $nonotice = '';

    /**
     * Add custom parameters to pass to the JS via JSON.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function json() {
        $json = parent::json();

        $json['pro_text'] = $this->pro_text;
        $json['pro_url']  = esc_url( $this->pro_url );
        $json['notice']  = esc_attr( $this->notice );
        $json['nonotice']  = esc_attr( $this->nonotice );

        return $json;
    }

    /**
     * Outputs the Underscore.js template.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    protected function render_template() { ?>

        <li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">

                <# if ( data.notice ) { #>
                    <h3 class="accordion-section-notice">
                        {{ data.title }}
                    </h3>
                <# } #>

                <# if ( !data.notice ) { #>
                    <h3 class="accordion-section-title">
                        {{ data.title }}

                        <# if ( data.pro_text && data.pro_url ) { #>
                            <a href="{{ data.pro_url }}" class="button button-secondary alignright" target="_blank">{{ data.pro_text }}</a>
                        <# } #>
                    </h3>
                <# } #>
            
        </li>
    <?php }
}

/**
 * Repeater Custom Control
*/
class Store_Lite_Repeater_Controler extends WP_Customize_Control {
    /**
     * The control type.
     *
     * @access public
     * @var string
    */
    public $type = 'repeater';

    public $store_lite_box_label = '';

    public $store_lite_box_add_control = '';

    private $cats = '';

    /**
     * The fields that each container row will contain.
     *
     * @access public
     * @var array
     */
    public $fields = array();

    /**
     * Repeater drag and drop controler
     *
     * @since  1.0.0
     */
    public function __construct( $manager, $id, $args = array(), $fields = array() ) {
        $this->fields = $fields;
        $this->store_lite_box_label = $args['store_lite_box_label'] ;
        $this->store_lite_box_add_control = $args['store_lite_box_add_control'];
        $this->cats = get_categories(array( 'hide_empty' => false ));
        parent::__construct( $manager, $id, $args );
    }

    public function render_content() {

        $values = json_decode($this->value());
        ?>
        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>

        <?php if($this->description){ ?>
            <span class="description customize-control-description">
            <?php echo wp_kses_post($this->description); ?>
            </span>
        <?php } ?>

        <ul class="store-lite-repeater-field-control-wrap">
            <?php
            $this->store_lite_get_fields();
            ?>
        </ul>

        <input type="hidden" <?php esc_attr( $this->link() ); ?> class="store-lite-repeater-collector" value="<?php echo esc_attr( $this->value() ); ?>" />
        <button type="button" class="button store-lite-add-control-field"><?php echo esc_html( $this->store_lite_box_add_control ); ?></button>
        <?php
    }

    private function ToObject($Array) { 
      
        // Create new stdClass object 
        $object = new stdClass(); 
          
        // Use loop to convert array into 
        // stdClass object 
        foreach ($Array as $key => $value) { 
            if (is_array($value)) { 
                $value = $this->ToObject($value); 
            } 
            $object->$key = $value; 
        } 
        return $object; 
    } 

    private function store_lite_get_fields(){

        $fields = $this->fields;

        $values = json_decode( $this->value() );

        if( is_array( $values ) ){
        foreach($values as $value){
        ?>
        <li class="store-lite-repeater-field-control">

        <div class="title-rep-wrap">
            <span class="dashicons dashicons-move twp-filter-icon"></span>
            <h3 class="store-lite-repeater-field-title"><?php echo esc_html( $this->store_lite_box_label ); ?></h3>
            <span class="dashicons dashicons-arrow-down twp-filter-icon"></span>
        </div>

        <div class="store-lite-repeater-fields">
        <?php
            foreach ($fields as $key => $field) {
            $class = isset($field['class']) ? $field['class'] : '';
            ?>
            <div class="store-lite-fields store-lite-type-<?php echo esc_attr($field['type']).' '.esc_attr( $class ); ?>">
                <?php 
                    $label = isset($field['label']) ? $field['label'] : '';
                    $description = isset($field['description']) ? $field['description'] : '';
                    if($field['type'] != 'checkbox'){ ?>
                        <span class="customize-control-title"><?php echo esc_html( $label ); ?></span>
                        <span class="description customize-control-description"><?php echo esc_html( $description ); ?></span>
                    <?php 
                    }

                    $new_value = isset($value->$key) ? $value->$key : '';
                    $default = isset($field['default']) ? $field['default'] : '';

                    switch ($field['type']) {
                        case 'text':
                            echo '<input data-default="'.esc_attr($default).'" data-name="'.esc_attr($key).'" type="text" value="'.esc_attr($new_value).'"/>';
                            break;

                        case 'link':
                            echo '<input data-default="'.esc_attr($default).'" data-name="'.esc_attr($key).'" type="text" value="'.esc_url($new_value).'"/>';
                            break;

                        case 'textarea':
                            echo '<textarea data-default="'.esc_attr($default).'"  data-name="'.esc_attr($key).'">'.esc_textarea($new_value).'</textarea>';
                            break;

                        case 'select':
                            $options = $field['options'];
                            echo '<div class="twp-select-customizer">';
                            echo '<select  data-default="'.esc_attr($default).'"  data-name="'.esc_attr($key).'">';
                                foreach ( $options as $option => $val )
                                {
                                    printf('<option value="%s" %s>%s</option>', esc_attr($option), selected($new_value, $option, false), esc_html($val));
                                }
                            echo '</select>';
                            echo '</div>';
                            break;

                        case 'checkbox':
                            echo '<label>';
                            echo '<input data-default="'.esc_attr($default).'" value="'.esc_attr( $new_value ).'" data-name="'.esc_attr($key).'" type="checkbox" '.checked($new_value, 'yes', false).'/>';
                            echo esc_html( $label );
                            echo '<span class="description customize-control-description">'.esc_html( $description ).'</span>';
                            echo '</label>';
                            break;

                        case 'selector':
                            $options = $field['options'];
                            echo '<div class="selector-labels">';
                            foreach ( $options as $option => $val ){
                                $class = ( $new_value == $option ) ? 'selector-selected': '';
                                echo '<label class="'.esc_attr( $class ).'" data-val="'.esc_attr($option).'">';
                                echo '<img src="'.esc_url($val).'"/>';
                                echo '</label>'; 
                            }
                            echo '</div>';
                            echo '<input data-default="'.esc_attr($default).'" type="hidden" value="'.esc_attr($new_value).'" data-name="'.esc_attr($key).'"/>';
                            break;

                        case 'upload':
                                $image = $image_class= "";
                                if($new_value){ 
                                    $image = '<img src="'.esc_url($new_value).'" style="max-width:100%;"/>';    
                                    $image_class = ' hidden';
                                }
                                echo '<div class="twp-img-fields-wrap">';
                                echo '<div class="attachment-media-view">';
                                echo '<div class="placeholder'.esc_attr( $image_class ) .'">';
                                esc_html_e('No image selected', 'store-lite');
                                echo '</div>';
                                echo '<div class="thumbnail thumbnail-image">';
                                echo $image;
                                echo '</div>';
                                echo '<div class="actions clearfix">';
                                echo '<button type="button" class="button twp-img-delete-button align-left">'.esc_html__('Remove', 'store-lite').'</button>';
                                echo '<button type="button" class="button twp-img-upload-button alignright">'.esc_html__('Select Image', 'store-lite').'</button>';
                                echo '<input data-default="'.esc_attr($default).'" class="upload-id" data-name="'.esc_attr($key).'" type="hidden" value="'.esc_attr($new_value).'"/>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';                          
                                break;

                        default:
                            break;
                    }
                ?>
            </div>
            <?php
            } ?>

            <div class="clearfix store-lite-repeater-footer">
                <div class="alignright">
                <a class="store-lite-repeater-field-remove" href="#remove"><?php esc_html_e('Delete', 'store-lite') ?>|</a> 
                <a class="store-lite-repeater-field-close" href="#close"><?php esc_html_e('Close', 'store-lite') ?></a>
                </div>
            </div>
        </div>
        </li>
        <?php   
        }
        }
    }

}
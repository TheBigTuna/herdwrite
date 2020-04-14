<?php
/**
* Image Metabox.
*
* @package Store Lite
*/
 
add_action( 'add_meta_boxes', 'store_lite_image_metabox' );

if( ! function_exists( 'store_lite_image_metabox' ) ):


    function  store_lite_image_metabox() {
        
        add_meta_box(
            'store_lite_post_image_metabox',
            esc_html__( 'Image Setting', 'store-lite' ),
            'store_lite_post_image_ed_metafield_callback',
            'post', 
            'normal', 
            'high'
        );
        add_meta_box(
            'store_lite_page_image_metabox',
            esc_html__( 'Image Setting', 'store-lite' ),
            'store_lite_post_image_ed_metafield_callback',
            'page',
            'normal', 
            'high'
        ); 
    }

endif;

$store_lite_post_image_fields = array(
    'global-image' => array(
                    'id'        => 'post-global-image',
                    'value' => 'global-image',
                    'label' => esc_html__( 'Global image', 'store-lite' ),
                ),
    'enable-image' => array(
                    'id'        => 'post-enable-image',
                    'value' => 'enable-image',
                    'label' => esc_html__( 'Enable image', 'store-lite' ),
                ),
    'disable-image' => array(
                    'id'		=> 'post-disable-image',
                    'value'     => 'disable-image',
                    'label'     => esc_html__( 'Disable image', 'store-lite' ),
                ),
);

/**
 * Callback function for post option.
*/
if( ! function_exists( 'store_lite_post_image_ed_metafield_callback' ) ):
	function store_lite_post_image_ed_metafield_callback() {
		global $post, $store_lite_post_image_fields;
		wp_nonce_field( basename( __FILE__ ), 'store_lite_post_image_meta_nonce' ); ?>
        <table class="form-table">
        
            <tr>
                <td>
                    <?php
                    $store_lite_post_image = esc_html( get_post_meta( $post->ID, 'store_lite_post_image_option', true ) ); 
                    if( $store_lite_post_image == '' ){ $store_lite_post_image = 'global-image'; }

                    foreach ( $store_lite_post_image_fields as $store_lite_post_image_field) { ?>
                            
                            <div class="radio-button-wrapper" style="float:left; margin-right:30px;">
                                <label class="description">
                                    <input type="radio" name="store_lite_post_image_option" value="<?php echo esc_attr( $store_lite_post_image_field['value'] ); ?>" <?php if( $store_lite_post_image_field['value'] == $store_lite_post_image ){ echo "checked='checked'";} if( empty( $store_lite_post_image ) && $store_lite_post_image_field['value']=='right-image' ){ echo "checked='checked'"; } ?>/>&nbsp;<?php echo esc_html( $store_lite_post_image_field['label'] ); ?>
                                </label>
                            </div>
                    <?php } ?>
                    <div class="clear"></div>
                </td>
            </tr>
            
        </table>
    <?php }
endif;

// Save metabox value.
add_action( 'save_post', 'store_lite_save_post_image_meta' );

if( ! function_exists( 'store_lite_save_post_image_meta' ) ):

function store_lite_save_post_image_meta( $post_id ) {

    global $post, $store_lite_post_image_fields;

    if ( !isset( $_POST[ 'store_lite_post_image_meta_nonce' ] ) || !wp_verify_nonce( wp_unslash( $_POST['store_lite_post_image_meta_nonce'] ), basename( __FILE__ ) ) )
        return;

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )  
        return;
        
    if ( 'page' == $_POST['post_type'] ) {  
        if ( !current_user_can( 'edit_page', $post_id ) )  
            return $post_id;  
    } elseif ( !current_user_can( 'edit_post', $post_id ) ) {  
            return $post_id;  
    }


    foreach ( $store_lite_post_image_fields as $store_lite_post_image_field ) {  
        
        $old = esc_html( get_post_meta( $post_id, 'store_lite_post_image_option', true ) ); 
        $new = store_lite_sanitize_image_option( wp_unslash( $_POST['store_lite_post_image_option'] ) );
        if ( $new && $new != $old ) {  
            update_post_meta ( $post_id, 'store_lite_post_image_option', $new );  
        } elseif ( '' == $new && $old ) {  
            delete_post_meta( $post_id,'store_lite_post_image_option', $old );  
        }
    }
}
endif;   
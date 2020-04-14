<?php
/**
* Sidebar Metabox.
*
* @package Store Lite
*/
 
add_action( 'add_meta_boxes', 'store_lite_metabox' );

if( ! function_exists( 'store_lite_metabox' ) ):


    function  store_lite_metabox() {
        
        add_meta_box(
            'store_lite_post_metabox',
            esc_html__( 'Sidebar Layouts', 'store-lite' ),
            'store_lite_post_metafield_callback',
            'post', 
            'normal', 
            'high'
        );
        add_meta_box(
            'store_lite_page_metabox',
            esc_html__( 'Sidebar Layouts', 'store-lite' ),
            'store_lite_post_metafield_callback',
            'page',
            'normal', 
            'high'
        ); 
    }

endif;

$store_lite_post_sidebar_fields = array(
    'global-sidebar' => array(
                    'id'        => 'post-global-sidebar',
                    'value' => 'global-sidebar',
                    'label' => esc_html__( 'Global sidebar', 'store-lite' ),
                ),
    'right-sidebar' => array(
                    'id'        => 'post-left-sidebar',
                    'value' => 'right-sidebar',
                    'label' => esc_html__( 'Right sidebar', 'store-lite' ),
                ),
    'left-sidebar' => array(
                    'id'		=> 'post-right-sidebar',
                    'value'     => 'left-sidebar',
                    'label'     => esc_html__( 'Left sidebar', 'store-lite' ),
                ),
    'no-sidebar' => array(
                    'id'		=> 'post-no-sidebar',
                    'value'     => 'no-sidebar',
                    'label'     => esc_html__( 'No sidebar', 'store-lite' ),
                ),
);

/**
 * Callback function for post option.
*/
if( ! function_exists( 'store_lite_post_metafield_callback' ) ):
	function store_lite_post_metafield_callback() {
		global $post, $store_lite_post_sidebar_fields;
		wp_nonce_field( basename( __FILE__ ), 'store_lite_post_meta_nonce' ); ?>
        <table class="form-table">
        
            <tr>
                <td>
                    <?php
                    $default = store_lite_get_default_theme_options();
                    $global_sidebar_layout = esc_html( get_theme_mod( 'global_sidebar_layout',$default['global_sidebar_layout'] ) );
                    $store_lite_post_sidebar = esc_html( get_post_meta( $post->ID, 'store_lite_post_sidebar_option', true ) ); 
                    if( $store_lite_post_sidebar == '' ){ $store_lite_post_sidebar = 'global-sidebar'; }

                    foreach ( $store_lite_post_sidebar_fields as $store_lite_post_sidebar_field) { ?>
                            
                            <div class="radio-button-wrapper" style="float:left; margin-right:30px;">
                                <label class="description">
                                    <input type="radio" name="store_lite_post_sidebar_option" value="<?php echo esc_attr( $store_lite_post_sidebar_field['value'] ); ?>" <?php if( $store_lite_post_sidebar_field['value'] == $store_lite_post_sidebar ){ echo "checked='checked'";} if( empty( $store_lite_post_sidebar ) && $store_lite_post_sidebar_field['value']=='right-sidebar' ){ echo "checked='checked'"; } ?>/>&nbsp;<?php echo esc_html( $store_lite_post_sidebar_field['label'] ); ?>
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
add_action( 'save_post', 'store_lite_save_post_meta' );

if( ! function_exists( 'store_lite_save_post_meta' ) ):

function store_lite_save_post_meta( $post_id ) {

    global $post, $store_lite_post_sidebar_fields;

    if ( !isset( $_POST[ 'store_lite_post_meta_nonce' ] ) || !wp_verify_nonce( wp_unslash( $_POST['store_lite_post_meta_nonce'] ), basename( __FILE__ ) ) )
        return;

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )  
        return;
        
    if ( 'page' == $_POST['post_type'] ) {  
        if ( !current_user_can( 'edit_page', $post_id ) )  
            return $post_id;  
    } elseif ( !current_user_can( 'edit_post', $post_id ) ) {  
            return $post_id;  
    }


    foreach ( $store_lite_post_sidebar_fields as $store_lite_post_sidebar_field ) {  
        
        $old = esc_html( get_post_meta( $post_id, 'store_lite_post_sidebar_option', true ) ); 
        $new = store_lite_sanitize_sidebar_option( wp_unslash( $_POST['store_lite_post_sidebar_option'] ) );
        if ( $new && $new != $old ) {  
            update_post_meta ( $post_id, 'store_lite_post_sidebar_option', $new );  
        } elseif ( '' == $new && $old ) {  
            delete_post_meta( $post_id,'store_lite_post_sidebar_option', $old );  
        }
    }
}
endif;   
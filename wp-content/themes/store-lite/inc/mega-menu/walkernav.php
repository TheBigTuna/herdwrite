<?php

namespace store_lite;

use Walker_Nav_Menu;

class Store_lite_Walkernav extends Walker_Nav_Menu
{

    public $megaMenuID;

    public $count;

    public function __construct()
    {
        $this->megaMenuID = 0;

        $this->count = 0;
    }

    public function start_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $submenu = ($depth > 0) ? ' sub-menu' : '';
        $output .= "\n$indent<ul class=\"dropdown-menu$submenu depth_$depth\" >\n";

        
    }

    public function end_lvl(&$output, $depth = 0, $args = array())
    {

        $output .= "</ul>";
    }

    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {   

        $hasMegaMenu = get_post_meta( $item->ID, 'menu-item-mm-megamenu', true );
        $hasColumnDivider = get_post_meta( $item->ID, 'menu-item-mm-column-divider', true );
        $hasDivider = get_post_meta( $item->ID, 'menu-item-mm-divider', true );
        $hasFeaturedImage = get_post_meta( $item->ID, 'menu-item-mm-featured-image', true );
        $hasDescription = get_post_meta( $item->ID, 'menu-item-mm-description', true );

        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $li_attributes = '';
        $class_names = $value = '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;

        if ($this->megaMenuID != 0 && $this->megaMenuID != intval($item->menu_item_parent) && $depth == 0) {
            $this->megaMenuID = 0;
        }

        // $column_divider = array_search('column-divider', $classes);
        if( $hasColumnDivider && $depth == 1 ){
            array_push($classes, 'column-divider');
            $output .= "<li class=\"megamenu-column\"><ul>\n";
        }
        
        if( $hasMegaMenu && $depth == 0 ) {
            array_push($classes, 'megamenu');
            $this->megaMenuID = $item->ID;
        }

        if( isset($args->has_children) ){
            $classes[] = ($args->has_children) ? 'dropdown' : '';
        }
        $classes[] = ($item->current || $item->current_item_ancestor) ? 'active' : '';
        $classes[] = 'menu-item-'.$item->ID;

        if( isset($args->has_children) ){
            if ($depth && $args->has_children) {
                $classes[] = 'dropdown-submenu';
            }
        }

        if(  $item->type_label == 'Product' ||  $item->type_label == 'Page' ||  $item->type_label == 'Post' ){
            if ($hasFeaturedImage && $depth != 0) {
                array_push($classes, 'featured-image');
            }
        }

        if ($hasDescription  && $depth != 0) {
            array_push($classes, 'description');
        }

        $class_names = implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = ' class="'.esc_attr($class_names).'"';

        $id = apply_filters('nav_menu_item_id', 'menu-item-'.$item->ID, $item, $args);
        $id = strlen($id) ? ' id="'.esc_attr($id).'"' : '';

        $output .= $indent.'<li'.esc_attr( $id ).$value.$class_names.$li_attributes.'>';

        $attributes = !empty($item->attr_title) ? ' title="'.esc_attr($item->attr_title).'"' : '';
        $attributes .= !empty($item->target) ? ' target="'.esc_attr($item->target).'"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="'.esc_attr($item->xfn).'"' : '';
        $attributes .= !empty($item->url) ? ' href="'.esc_attr($item->url).'"' : '';

        if( isset($args->has_children) ){
            $attributes .= ($args->has_children) ? '' : '';
        }
        $item_output = '';
        if( isset($args->before) ){
            $item_output = $args->before;
        }
        $item_output .= '<a'.$attributes.'>';

        // Check if item has featured image
        // $has_featured_image = array_search('featured-image', $classes);
        if(  $item->type_label == 'Product' ||  $item->type_label == 'Page' ||  $item->type_label == 'Post' ){
            if ($hasFeaturedImage && $this->megaMenuID != 0  && $depth != 0 ) {
                $postID = url_to_postid( $item->url );
                $item_output .= "<img alt=\"" . esc_attr($item->attr_title) . "\" src=\"" . esc_url( get_the_post_thumbnail_url( $postID ) ) . "\"/>";
            }
        }
        $link_before = '';
        $link_after = '';
        if( isset($args->link_before) ){
            $link_before = $args->link_before;
        }
        if( isset($args->link_after) ){
            $link_after = $args->link_after;
        }
        $item_output .= $link_before.apply_filters('the_title', $item->title, $item->ID).$link_after;

            // add support for menu item title
            if ( strlen($item->attr_title) > 2 ) {
                $item_output .= '<h3 class="tit">'.esc_html( $item->attr_title ).'</h3>';
            }
            // add support for menu item descriptions
            if (strlen($item->description) > 2) {
                $item_output .= '</a> <span class="sub">'.esc_html( $item->description ).'</span>';
            }

        $has_children = '';
        if( isset( $args->has_children ) ){
            $has_children = $args->has_children;
        }
        $item_output .= (($depth == 0 || 1) && $has_children ) ? ' <span class="ion ion-ios-arrow-down"></span></a>' : '</a>';
        if( isset($args->after) ){
            $item_output .= $args->after;
        }

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    public function display_element($element, &$children_elements, $max_depth, $depth, $args, &$output)
    {
        if (!$element) {
            return;
        }

        $id_field = $this->db_fields['id'];

        //display this element
        if (is_array($args[0])) {
            $args[0]['has_children'] = !empty($children_elements[$element->$id_field]);
        } elseif (is_object($args[0])) {
            $args[0]->has_children = !empty($children_elements[$element->$id_field]);
        }

        $cb_args = array_merge(array(&$output, $element, $depth), $args);
        call_user_func_array(array(&$this, 'start_el'), $cb_args);

        $id = $element->$id_field;

        // descend only when the depth is right and there are childrens for this element
        if (($max_depth == 0 || $max_depth > $depth + 1) && isset($children_elements[$id])) {
            foreach ($children_elements[ $id ] as $child) {
                if (!isset($newlevel)) {
                    $newlevel = true;
              //start the child delimiter
              $cb_args = array_merge(array(&$output, $depth), $args);
                    call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
                }
                $this->display_element($child, $children_elements, $max_depth, $depth + 1, $args, $output);
            }
            unset($children_elements[ $id ]);
        }

        if (isset($newlevel) && $newlevel) {
            //end the child delimiter
          $cb_args = array_merge(array(&$output, $depth), $args);
            call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
        }

        //end this element
        $cb_args = array_merge(array(&$output, $element, $depth), $args);
        call_user_func_array(array(&$this, 'end_el'), $cb_args);
    }

    public function end_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

         $hasMegaMenu = get_post_meta( $item->ID, 'menu-item-mm-megamenu', true );
            $hasColumnDivider = get_post_meta( $item->ID, 'menu-item-mm-column-divider', true );
            $hasDivider = get_post_meta( $item->ID, 'menu-item-mm-divider', true );
            $hasFeaturedImage = get_post_meta( $item->ID, 'menu-item-mm-featured-image', true );
            $hasDescription = get_post_meta( $item->ID, 'menu-item-mm-description', true );

            $indent = ($depth) ? str_repeat("\t", $depth) : '';

            $li_attributes = '';
            $class_names = $value = '';

            // managing divider: add divider class to an element to get a divider before it.
            // $divider_class_position = array_search('divider', $classes);
            if ($hasDivider  && $depth != 0) {
                $output .= "<li class=\"divider\"></li>\n";
            }
        
            $classes = empty($item->classes) ? array() : (array) $item->classes;

            if ($this->megaMenuID != 0 && $this->megaMenuID != intval($item->menu_item_parent) && $depth == 0) {
                $this->megaMenuID = 0;
            }

            // $column_divider = array_search('column-divider', $classes);
            if ($hasColumnDivider && $depth == 1 ) {
                array_push($classes, 'column-divider');
                $output .= "</ul></li>\n";
            }
        $output .= "</li>\n";
    }
}

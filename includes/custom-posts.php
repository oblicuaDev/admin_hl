<?php

function myPostTypes(){
    // create_post_types('NOVEDADES', 'NOVEDAD', 'dashicons-text-page', 'novedades-bilingual');
    create_post_types('Sliders principales', 'Slider Principal', 'dashicons-images-alt2', 'hl_sliders');
}

function create_post_types($name, $singularName, $icon, $slug){
    register_post_type( $slug, array(
        'exclude_from_search' => true,
        'has_archive' => true,
        'rest_controller_class' => 'WP_REST_Posts_Controller',
        'rest_base' =>  $slug,
        'labels' => array(
            'name' => ($name),
            'singlar_name' => ($singularName),
            'add_new' => ('Agregar ' . $singularName),
            'add_new_item' => ('Agregar ' . $singularName),
            'edit_item' => ('Editar ' . $singularName),
            'new_item' => ('Agregar ' . $singularName),
            'view_item' => ('Ver ' . $singularName),
            'not_found' => ('No se encontraron ' . $name)
        ),
        'menu_icon' => $icon,
        'public' => true,
        'publicly_queryable' => true,
        'show_in_rest' => true,
        'hierarchical' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'rewrite' => array('slag' => $slug),
        'rest_controller_class' => 'WP_REST_Posts_Controller'
    ));
}
add_filter( 'manage_planessemanales_posts_columns', 'agregar_columnas_personalizadas' );
function agregar_columnas_personalizadas( $columns ) {
    $columns['publicacion'] = 'Fecha de publicación';
    $columns['requiere'] = '¿Requiere plantilla?';
    $columns['plantilla'] = 'Plantilla';
    $columns['curriculum'] = 'Curriculum';
    $columns['tipo_de_actividad'] = 'Tipo de actividad';
    $columns['autor'] = 'Autor';
    return $columns;
}

add_action( 'manage_planessemanales_posts_custom_column', 'mostrar_valor_de_campo_personalizado', 10, 2 );
function mostrar_valor_de_campo_personalizado( $column, $post_id ) {
    switch ( $column ) {
        case 'curriculum':
            $value = get_field( "curriculum", $post_id );
            if ( is_array( $value ) ) {
                $titles = array();
                foreach ( $value as $post_id ) {
                    $titles[] = get_the_title( $post_id );
                }
                echo implode( ', ', $titles );
            }
            break;
        case 'publicacion':
            $value = get_field( "dia_especifico", $post_id );
            if ( is_array( $value ) ) {
                $titles = array();
                foreach ( $value as $post_id ) {
                    $titles[] = get_the_title( $post_id );
                }
                echo implode( ', ', $titles );
            }else{
                echo $value;
            }
            break;
        case 'requiere':
            $value = get_field( "requiere_plantilla", $post_id );
            if ( is_array( $value ) ) {
                $titles = array();
                foreach ( $value as $post_id ) {
                    $titles[] = get_the_title( $post_id );
                }
                echo implode( ', ', $titles );
            }else{
                echo $value == '1' ? "Si" : "No";
            }
            break;
        case 'plantilla':
            $value = get_field( "multimedia", $post_id );
            $requiere = get_field( "requiere_plantilla", $post_id );
            if ( is_array( $value ) ) {
                $titles = array();
                foreach ( $value as $post_id ) {
                    $titles[] = get_the_title( $post_id );
                }
                echo implode( ', ', $titles );
            }else{
                if($requiere == "1"){
                    echo $value != ""  ? "✔️" : "Pendiente";
                }else{
                    echo "";
                }
            }
            break;
        case 'autor':
            $author = get_the_author_meta( 'display_name', get_post_field( 'post_author', $post_id ) );
            echo $author;
            break;
        case 'tipo_de_actividad':
            $value = get_field( "tipo_de_actividad", $post_id );
            echo $value;
            break;
        default:
            break;
    }
}


add_action('init', 'myPostTypes');

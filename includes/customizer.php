<?php

add_action( 'customize_register', 'brinkmann_customize_register' );

function brinkmann_customize_register( WP_Customize_Manager $wp_customize ) {
    $transport = 'postMessage';

    //$wp_customize->get_setting( 'footer_company_description' )->transport = 'postMessage';

    $wp_customize->add_section( 'site_footer_section', [
        'title'    => 'Footer',
        'priority' => 20,
    ] );

    $wp_customize->add_setting( 'footer_company_description', [
        'type'      => 'theme_mod',
        'default'   => '',
        'transport' => $transport
    ] );
    $wp_customize->add_setting( 'footer_logo', [
        'type'      => 'theme_mod',
        'default'   => '',
        'transport' => $transport
    ] );

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'logo',
        [
            'label' => __('Footer logo', 'text-domain'),
            'section' => 'site_footer_section',
            'settings' => 'footer_logo',
        ]));
    $wp_customize->add_control( 'footer_company_description',
        [
            'label'       => 'Company description',
            'type'        => 'textarea',
            'section'     => 'site_footer_section',
        ]
    );

    $wp_customize->selective_refresh->add_partial( 'footer_company_description', [
        'selector'        => '.footer__description',
        'render_callback' => function(){
            echo get_theme_mod( 'footer_company_description' );
        }
    ] );
}
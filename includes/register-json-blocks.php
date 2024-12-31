<?php

add_filter( 'block_categories_all', 'exf_category_register', 10, 2 );
add_action( 'init', 'exf_register_acf_blocks' );

function exf_register_acf_blocks(){
	$pathes = glob( get_stylesheet_directory() . '/blocks/' . '*', GLOB_ONLYDIR );
	foreach ( $pathes as $path ) {
		$dirname = basename( $path );
		register_block_type( __DIR__ . '/../blocks/'. $dirname );

		$props = [
			'key' => "exf_block_{$dirname}",
			'title' => "Block: {$dirname}"
		];
		$location = [
			'location' => [
				[
					[
						'param'     => 'block',
						'operator'  => '==',
						'value'     => "acf/{$dirname}",
					],
				],
			],
		];
		$fields = require(__DIR__ . '/../blocks/'. $dirname . '/fields.php');
		
		acf_add_local_field_group(array_merge( $props, $fields, $location));
	}
}

function exf_category_register( $categories ) {
	return array_merge(
		array(
			array(
				'slug'  => 'exf',
				'title' => 'ExF'
			),
		),
		$categories
	);
}

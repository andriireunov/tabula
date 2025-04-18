<?php

function enable_svg_upload( $upload_mimes ) {
	$upload_mimes['svg'] = 'image/svg+xml';
	$upload_mimes['svgz'] = 'image/svg+xml';
	$upload_mimes['ico'] = 'image/x-icon';
	return $upload_mimes;
}
add_filter( 'upload_mimes', 'enable_svg_upload', 10, 1 );
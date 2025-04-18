<?php

$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
	$anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

$class_name = 'block-class';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}

?>
<div <?php echo $anchor; ?> class="<?php echo esc_attr( $class_name ); ?>">
	<div class="container">
		block content should be here...
	</div>
</div>

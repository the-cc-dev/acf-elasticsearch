<?php

namespace makeandship\elasticsearch;

abstract class MappingBuilder {
	const EXCLUDE_TAXONOMIES = array(
        'post_tag',
        'post_format'
	);

	const EXCLUDE_POST_TYPES = array(
        'revision',
        'attachment',
        'json_consumer',
        'nav_menu',
        'nav_menu_item',
        'post_format',
        'link_category',
        'acf-field-group',
        'acf-field'
    );
	
	abstract function build( $o );
}
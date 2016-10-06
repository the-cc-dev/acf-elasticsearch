<?php

namespace makeandship\elasticsearch;

class TermMappingBuilder extends MappingBuilder {

	const EXCLUDE_TAXONOMIES = array(
		'nav_menu',
		'post_format',
		'link_category',
	);

	const CORE_FIELDS = array(
		'post_content' => array(
			'type' => 'string', 
			'suggest' => true
		),
		'post_title' => 'string',
		'post_type' => array(
			'type' => 'string', 
			'index' => 'not_analyzed'
		),
		'post_date' => 'date'
	);

	/**
	 *
	 */
	public function build ( $taxonomy ) {
		$properties = array();

		error_log($taxonomy.' is '.$this->valid($taxonomy));
		if (!$this->valid( $taxonomy )) {
			return null;
		}

		// TODO implement (this is post)

		// base post fields
		foreach( TermMappingBuilder::CORE_FIELDS as $field => $options) {
			if (isset( $field ) && isset($options)) {
				$properties = array_merge( 
					$properties, 
					$this->build_field( $field, $options ) 
				);	
			}
		}

		return $properties;
	}

	public function valid( $taxonomy ) {
		if (in_array( $taxonomy, self::EXCLUDE_TAXONOMIES)) {
			return false;
		}
		return true;
	}

	function build_field( $field, $options) {
		$properties = array();

		if (isset( $field ) && isset( $options )) {
			$properties = array( 
				'name_suggest' => array(
					'analyzer' => 'ngram_analyzer',
					'search_analyzer' => 'whitespace_analyzer',
					'type' => 'string'
				),
				'name' => array(
					'type' => 'string'
				),
				'slug' => array( 
					'type' => 'string',
					'index' => 'not_analyzed'
					)
			);
		}

		return $properties;
	}
}
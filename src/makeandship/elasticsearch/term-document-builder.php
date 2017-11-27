<?php

namespace makeandship\elasticsearch;

class TermDocumentBuilder extends DocumentBuilder
{
    /**
     * Is this document private
     */
    public function is_private($term)
    {
        return false;
    }

    /**
     * Does this document have private fields
     */
    public function has_private_fields()
    {
        return false;
    }

    /**
     *
     */
    public function build($term, $include_private=false)
    {
        $document = null;

        if (isset($term)) {
            foreach (TermMappingBuilder::CORE_FIELDS as $name => $definition) {
                $value = $term->{$name};

                // transform if required
                if (is_array($definition) && array_key_exists('transformer', $definition)) {
                    $transformer = new $definition['transformer'];
                    
                    if (isset($transformer)) {
                        $value = $transformer->transform($value);
                    }
                }
                
                $document[$name] = $value;
                
                if (is_array($definition) && array_key_exists('suggest', $definition)) {
                    if ($definition['suggest']) {
                        $document[$name.'_suggest'] = $value;
                    }
                }
            }
        }

        return $document;
    }

    /**
     *
     */
    public function get_id($term)
    {
        return $term->term_id;
    }

    /**
     *
     */
    public function get_type($term)
    {
        return $term->taxonomy;
    }
}

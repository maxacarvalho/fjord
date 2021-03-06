<?php

namespace Fjord\Crud\Fields;

use Fjord\Crud\Field;

class Checkboxes extends Field
{
    /**
     * Field Vue component.
     *
     * @var string
     */
    protected $component = 'fj-field-checkboxes';

    /**
     * Required attributes.
     *
     * @var array
     */
    protected $required = [
        'title',
        'options'
    ];

    /**
     * Available Field attributes.
     *
     * @var array
     */
    protected $available = [
        'title',
        'options',
        'hint'
    ];

    /**
     * Default Field attributes.
     *
     * @var array
     */
    protected $defaults = [];

    /**
     * Cast field value.
     *
     * @param mixed $value
     * @return boolean
     */
    public function cast($value)
    {
        if (is_array($value)) {
            return $value;
        }

        return json_decode($value, 0);
    }
}

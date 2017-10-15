<?php

namespace Cerpus\CoreClient\Traits;


trait CreateTrait
{
    public static function create(array $attributes = null)
    {
        $self = new self();
        if (is_array($attributes)) {
            $properties = get_object_vars($self);
            foreach ($attributes as $attribute => $value) {
                if (array_key_exists($attribute, $properties)) {
                    $self->$attribute = $value;
                }
            }
        }
        return $self;
    }
}
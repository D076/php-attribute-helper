<?php

namespace D076\PhpAttributeHelper;

use Illuminate\Support\Collection;
use ReflectionAttribute;
use ReflectionObject;

class AttributeCollection extends Collection
{
    static function fromObject($object, $subTarget = null, $propertyNamePrefix = ''): static
    {
        $instance = new static;

        $reflected = new ReflectionObject($subTarget ?? $object);

        foreach ($reflected->getAttributes(Attribute::class, ReflectionAttribute::IS_INSTANCEOF) as $attribute) {
            $instance->push(tap($attribute->newInstance(), function ($attribute) use ($object) {
                $attribute->__boot($object, AttributeLevel::ROOT);
            }));
        }

        foreach ($reflected->getMethods() as $method) {
            foreach ($method->getAttributes(Attribute::class, ReflectionAttribute::IS_INSTANCEOF) as $attribute) {
                $instance->push(tap($attribute->newInstance(), function ($attribute) use ($object, $method, $propertyNamePrefix) {
                    $attribute->__boot($object, AttributeLevel::METHOD, $propertyNamePrefix . $method->getName());
                }));
            }
        }

        foreach ($reflected->getProperties() as $property) {
            foreach ($property->getAttributes(Attribute::class, ReflectionAttribute::IS_INSTANCEOF) as $attribute) {
                $instance->push(tap($attribute->newInstance(), function ($attribute) use ($object, $property, $propertyNamePrefix) {
                    $attribute->__boot($object, AttributeLevel::PROPERTY, $propertyNamePrefix . $property->getName());
                }));
            }
        }

        return $instance;
    }
}

<?php

namespace D076\PhpAttributeHelper;

trait HandlesAttributes
{
    protected AttributeCollection $attributeCollection;

    function getAttributes(): AttributeCollection
    {
        return $this->attributeCollection ??= AttributeCollection::fromObject($this);
    }

    function setPropertyAttribute($property, $attribute): void
    {
        $attribute->__boot($this, AttributeLevel::PROPERTY, $property);

        $this->mergeOutsideAttributes(new AttributeCollection([$attribute]));
    }

    function mergeOutsideAttributes(AttributeCollection $attributeCollection): void
    {
        $this->attributeCollection = $this->getAttributes()->concat($attributeCollection);
    }
}

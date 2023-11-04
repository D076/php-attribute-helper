<?php

namespace D076\PhpAttributeHelper;

abstract class Attribute
{
    protected object $object;

    protected AttributeLevel $level;

    protected ?string $levelName;

    function __boot($object, AttributeLevel $level, $name = null): void
    {
        $this->object = $object;
        $this->level = $level;
        $this->levelName = $name;
    }

    function getObject(): object
    {
        return $this->object;
    }

    function getLevel(): AttributeLevel
    {
        return $this->level;
    }

    function getName(): ?string
    {
        return $this->levelName;
    }

    function getValue()
    {
        if ($this->level !== AttributeLevel::PROPERTY) {
            throw new \Exception('Can\'t set the value of a non-property attribute.');
        }

        return data_get($this->object, $this->levelName);
    }

    function setValue($value): void
    {
        if ($this->level !== AttributeLevel::PROPERTY) {
            throw new \Exception('Can\'t set the value of a non-property attribute.');
        }

        data_set($this->object, $this->levelName, $value);
    }
}

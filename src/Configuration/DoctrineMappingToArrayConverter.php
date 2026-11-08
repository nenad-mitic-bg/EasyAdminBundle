<?php

namespace EasyCorp\Bundle\EasyAdminBundle\Configuration;

use ArrayAccess;
use ReflectionClass;
use ReflectionProperty;

class DoctrineMappingToArrayConverter
{
    private static array $properties = [];

    public static function convert(ArrayAccess $instance): array
    {
        $className = get_class($instance);

        if (!isset(self::$properties[$className])) {
            self::initProperties($className);
        }

        $result = [];

        foreach (self::$properties[$className] as $prop) {
            $result[$prop] = $instance[$prop];
        }

        return $result;
    }

    private static function initProperties(string $className): void
    {
        $reflection = new ReflectionClass($className);

        self::$properties[$className] = array_map(
            static fn(ReflectionProperty $prop) => $prop->getName(),
            $reflection->getProperties(ReflectionProperty::IS_PUBLIC)
        );
    }
}
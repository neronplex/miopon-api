<?php
namespace Neronplex\MioponApi;

use InvalidArgumentException;
use ReflectionObject;

/**
 * Class Enum
 * Base class of enumeration type.
 *
 * @author    暖簾 <admin@neronplex.info>
 * @copyright Copyright (c) 2017 暖簾
 * @link      https://github.com/neronplex/miopon-api
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @package   Neronplex\MioponApi
 * @since     0.0.1
 */
abstract class Enum
{
    /**
     * enum value.
     *
     * @var mixed
     */
    private $value;

    /**
     * Enum constructor.
     *
     * @param mixed $value
     */
    public function __construct($value)
    {
        if (!$this->isValid($value))
        {
            throw new InvalidArgumentException("value [{$value}] is not defined.");
        }

        $this->value = $value;
    }

    /**
     * Returns a value when called statically like so
     *
     * @param  mixed $label
     * @param  mixed $args
     * @return mixed
     */
    final public static function __callStatic($label, $args)
    {
        $class = get_called_class();
        $const = constant("$class::$label");
        return new $class($const);
    }

    /**
     * String cast behavior.
     *
     * @return string
     */
    final public function __toString(): string
    {
        return (string) $this->value;
    }

    /**
     * Get value.
     *
     * @return mixed
     */
    final public function value()
    {
        return $this->value;
    }

    /**
     * Get constants list.
     *
     * @return array
     */
    final public function constants(): array
    {
        return (new ReflectionObject($this))->getConstants();
    }

    /**
     * Is defined value?
     *
     * @param  mixed $value
     * @return bool
     */
    private function isValid($value): bool
    {
        return in_array($value, $this->constants(), true);
    }
}

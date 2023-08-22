<?php

namespace Salesteer;

use ArrayAccess;
use Countable;
use JsonSerializable;

class SalesteerObject implements ArrayAccess, Countable, JsonSerializable
{
    const OBJECT_NAME = 'object';

    /** @var array */
    protected $_values;

    /** @var bool */
    //TODO: setted to bool to find errors
    protected $_opts;

    /** @var array */
    protected $_headers;

    /**
     * @param array $values
     * @param null|array $headers
     *
     * @return self
     */
    public function __construct(protected $id = null, $headers = [])
    {
        $this->_values = [];
        $this->_values = $headers;

        if (null !== $id) {
            $this->_values['id'] = $id;
        }
    }

    /**
     * @param array $values
     * @param null|array $headers
     *
     * @return static the object constructed from the given values
     */
    public static function constructFrom($values, $headers = null)
    {
        $obj = new static($values['id'] ?? null, $headers);
        $obj->refreshFrom($values);

        return $obj;
    }

    /**
     * Refreshes this object using the provided values.
     *
     * @param array $values
     */
    public function refreshFrom($values)
    {
        if ($values instanceof SalesteerObject) {
            $values = $values->toArray();
        }

        $removed = new Util\Set(array_diff(array_keys($this->_values), array_keys($values)));

        foreach ($removed->toArray() as $k) {
            unset($this->{$k});
        }

        $this->updateAttributes($values);
    }

    /**
     * Mass assigns attributes on the model.
     *
     * @param array $values
     */
    public function updateAttributes($values)
    {
        foreach ($values as $k => $v) {
            $this->_values[$k] = Util\Util::convertToSalesteerObject($v);
        }
    }

    /**
     * @return Util\Set Attributes that should not be sent to the API because they're not updatable (e.g. ID).
     */
    public static function getPermanentAttributes()
    {
        static $permanentAttributes = null;
        if (null === $permanentAttributes) {
            $permanentAttributes = new Util\Set(['id']);
        }

        return $permanentAttributes;
    }

    public function toArray()
    {
        $maybeToArray = function ($value) {
            if (null === $value) {
                return null;
            }

            return is_object($value) && method_exists($value, 'toArray') ? $value->toArray() : $value;
        };

        return array_reduce(array_keys($this->_values), function ($acc, $k) use ($maybeToArray) {
            if ('_' === substr((string) $k, 0, 1)) {
                return $acc;
            }
            $v = $this->_values[$k];
            if (Util\Util::isList($v)) {
                $acc[$k] = array_map($maybeToArray, $v);
            } else {
                $acc[$k] = $maybeToArray($v);
            }

            return $acc;
        }, []);
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toJSON()
    {
        return json_encode($this->toArray(), JSON_PRETTY_PRINT);
    }

    public function __toString()
    {
        $class = static::class;

        return $class . ' JSON: ' . $this->toJSON();
    }

    public function isDeleted()
    {
        return isset($this->_values['deleted_at']) ? $this->_values['deleted_at'] : false;
    }

    /**
     * Standard accessor magic methods
     */
    public function __set($k, $v)
    {
        if (static::getPermanentAttributes()->includes($k)) {
            throw new Exception\InvalidArgumentException(
                "Cannot set {$k} on this object. HINT: you can't set: " .
                \implode(', ', static::getPermanentAttributes()->toArray())
            );
        }

        if ('' === $v) {
            throw new Exception\InvalidArgumentException(
                'You cannot set \'' . $k . '\'to an empty string. '
                . 'We interpret empty strings as NULL in requests. '
                . 'You may set obj->' . $k . ' = NULL to delete the property'
            );
        }

        $this->_values[$k] = Util\Util::convertToSalesteerObject($v, $this->_opts);
    }

    public function __isset($k)
    {
        return isset($this->_values[$k]);
    }

    public function __unset($k)
    {
        unset($this->_values[$k]);
    }

    public function &__get($k)
    {
        // function should return a reference, using $nullval to return a reference to null
        $nullval = null;
        if (!empty($this->_values) && array_key_exists($k, $this->_values)) {
            return $this->_values[$k];
        }

        $class = static::class;
        // Salesteer::getLogger()->error("Salesteer Notice: Undefined property of {$class} instance: {$k}");

        return $nullval;
    }

    /**
     *  ArrayAccess methods
     */
    public function offsetSet($k, $v) : void
    {
        $this->{$k} = $v;
    }

    public function offsetExists($k) : bool
    {
        return array_key_exists($k, $this->_values);
    }

    public function offsetUnset($k) : void
    {
        unset($this->{$k});
    }

    public function offsetGet($k) : bool
    {
        return array_key_exists($k, $this->_values) ? $this->_values[$k] : null;
    }

    public function count() : int
    {
        return count($this->_values);
    }

    public function keys()
    {
        return array_keys($this->_values);
    }

    public function values()
    {
        return array_values($this->_values);
    }

    public function __debugInfo()
    {
        return $this->_values;
    }
}

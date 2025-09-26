<?php

namespace Salesteer;

use ArrayAccess;
use Countable;
use JsonSerializable;

class SalesteerObject implements ArrayAccess, Countable, JsonSerializable
{
    const OBJECT_NAME = 'object';

    const RELATION_TO_CLASS = [];

    private ?SalesteerClientInterface $_client = null;

    private array $_values;

    public function __construct(
        protected $id = null,
        ?SalesteerClientInterface $client = null,
        private ?array $_headers = [])
    {
        $this->_client = $client ?? Salesteer::getClient();

        if ($this->_client === null) {
            throw new Exception\InvalidArgumentException('SalesteerClient cannot be null');
        }

        $this->_values = [];

        if ($id !== null) {
            $this->_values['id'] = $id;
        }
    }

    public static function constructFrom(
        $values,
        ?SalesteerClient $client = null,
        ?array $headers = null,
    ) {
        $obj = new static($values['id'] ?? null, $client, $headers);
        $obj->refreshFrom($values);

        return $obj;
    }

    public function refreshFrom($values): void
    {
        if ($values instanceof SalesteerObject) {
            $values = $values->toArray();
        }
        if (! is_array($values)) {
            $values = [];
        }

        $removed = new Util\Set(array_diff(array_keys($this->_values), array_keys($values)));

        foreach ($removed->toArray() as $k) {
            unset($this->{$k});
        }

        $this->updateAttributes($values);
    }

    public function fill($values): void
    {
        $this->updateAttributes($values);
    }

    public function updateAttributes($values): void
    {
        foreach ($values as $k => $v) {
            if (static::getPermanentAttributes()->includes($k)) {
                continue;
            }

            $obj = Util\Util::convertToSalesteerObject(
                $v,
                $this->_client,
                $this->_headers,
                $this->getRelationClass($k)
            );

            $this->_values[$k] = $obj;
        }
    }

    public function getRelationClass($key)
    {
        return static::RELATION_TO_CLASS[$key] ?? null;
    }

    public static function getPermanentAttributes(): Util\Set
    {
        static $permanentAttributes = null;
        if ($permanentAttributes === null) {
            $permanentAttributes = new Util\Set(['id']);
        }

        return $permanentAttributes;
    }

    public function toArray(): array
    {
        $maybeToArray = function ($value) {
            if ($value === null) {
                return null;
            }

            return is_object($value) && method_exists($value, 'toArray') ? $value->toArray() : $value;
        };

        return array_reduce(array_keys($this->_values), function ($acc, $k) use ($maybeToArray) {
            if (substr((string) $k, 0, 1) === '_') {
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

    public function serializeToParameters()
    {
        $updateParams = [];

        foreach ($this->_values as $k => $v) {
            $updateParams[$k] = $this->serializeParamsValue(
                $this->_values[$k], $k
            );
        }

        return array_filter(
            $updateParams,
            function ($v) {
                return $v !== null;
            }
        );
    }

    public function serializeParamsValue($value, $key = null)
    {
        if ($value === null) {
            return null;
        }

        if (is_array($value)) {
            if (Util\Util::isList($value)) {
                // Standard array
                $update = [];
                foreach ($value as $v) {
                    $update[] = $this->serializeParamsValue($v);
                }

                return $update;
            } else {
                // Relationships
                return Util\Util::convertToSalesteerObject(
                    $value,
                    $this->_client,
                    $this->_headers,
                    static::RELATION_TO_CLASS[$key] ?? null
                )->serializeToParameters();
            }
        } elseif ($value instanceof SalesteerObject) {
            // Relationships
            return $value->serializeToParameters();
        } else {
            return $value;
        }
    }

    public function jsonSerialize(): mixed
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

        return $class.' JSON: '.$this->toJSON();
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
                "Cannot set {$k} on this object. HINT: you can't set: ".
                \implode(', ', static::getPermanentAttributes()->toArray())
            );
        }

        if ($v === '') {
            throw new Exception\InvalidArgumentException(
                'You cannot set \''.$k.'\'to an empty string. '
                .'We interpret empty strings as NULL in requests. '
                .'You may set obj->'.$k.' = NULL to delete the property'
            );
        }

        $this->_values[$k] = Util\Util::convertToSalesteerObject(
            $v,
            $this->_client,
            $this->_headers,
            $this->getRelationClass($k)
        );
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
        if (! empty($this->_values) && array_key_exists($k, $this->_values)) {
            return $this->_values[$k];
        }

        $class = static::class;
        Salesteer::getLogger()->warning("Salesteer Notice: Undefined property of {$class} instance: {$k}");

        return $nullval;
    }

    /**
     *  ArrayAccess methods
     */
    public function offsetSet($k, $v): void
    {
        $this->{$k} = $v;
    }

    public function offsetExists($k): bool
    {
        return array_key_exists($k, $this->_values);
    }

    public function offsetUnset($k): void
    {
        unset($this->{$k});
    }

    public function offsetGet($k): bool
    {
        return array_key_exists($k, $this->_values) ? $this->_values[$k] : null;
    }

    public function count(): int
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

    /**
     * Client methods
     */
    public function getClient()
    {
        return $this->_client;
    }

    protected function request($method, $path, $params, $headers, $responseClass = null)
    {
        return $this->_client->request($method, $path, $responseClass ?? static::class, $params, $headers);
    }
}

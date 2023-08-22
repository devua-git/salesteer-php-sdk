<?php

namespace Salesteer\Api\Operation;

/**
 * Trait for retrievable resources. Adds a `retrieve()` static method to the
 * class.
 *
 * This trait should only be applied to classes that derive from StripeObject.
 */
trait Retrieve
{
    /**
     * @param array|string $id the ID of the API resource to retrieve, or an options array containing an `id` key
     * @param null|array $headers
     *
     * @throws \Stripe\Exception\ApiErrorException if the request fails
     *
     * @return static
     */
    public static function retrieve($id, $headers = null)
    {
        $instance = new static($id, $headers);
        $instance->refresh();

        return $instance;
    }
}

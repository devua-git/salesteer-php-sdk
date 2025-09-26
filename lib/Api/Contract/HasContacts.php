<?php

namespace Salesteer\Api\Contract;

use Salesteer\Api\Resource as ApiResource;

/**
 * @property ?array<ApiResource\Contact> $contacts
 */
trait HasContacts
{
    public function getContactsByTypes(array|int $types): array
    {
        if (! is_array($types)) {
            $types = [$types];
        }

        $contacts = $this->contacts ?? [];

        $contacts = array_filter($contacts, function ($contact) use ($types) {
            return in_array($contact->type, $types);
        });

        return $contacts;
    }
}

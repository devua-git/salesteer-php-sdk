<?php

namespace Salesteer\Api\Resource;

class Contact extends ApiResource
{
    const TYPE_EMAIL = 1;
    const TYPE_PHONE = 2;
    const TYPE_FAX = 3;
    const TYPE_PEC = 4;
    const TYPE_MOBILE = 5;

    const OBJECT_NAME = 'contact';
}

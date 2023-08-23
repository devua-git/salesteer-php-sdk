<?php

namespace Salesteer;

use Salesteer\Exception as Exception;

class WebhookSignature
{
    public static function verifyHeader($payload, $secret,  $tolerance = null)
    {
        $signature = $_SERVER['HTTP_X_SALESTEER_HMAC_SHA256'];
        $timestamp = $_SERVER['HTTP_X_SALESTEER_TIMESTAMP'];

        $signedPayload = "{$timestamp}.{$payload}";

        $expectedSignature = self::computeSignature($signedPayload, $secret);

        if (!hash_equals($expectedSignature, $signature)) {
            throw Exception\SignatureVerificationException::factory(
                'No signatures found matching the expected signature for payload', $payload, $signature
            );
        }

        // Check if timestamp is within tolerance
        if (($tolerance > 0) && (abs(time() - $timestamp) > $tolerance)) {
            throw Exception\SignatureVerificationException::factory(
                'Timestamp outside the tolerance zone', $payload, $signature
            );
        }

        return true;
    }

    private static function computeSignature($payload, $secret)
    {
        return hash_hmac('sha256', $payload, $secret);
    }
}
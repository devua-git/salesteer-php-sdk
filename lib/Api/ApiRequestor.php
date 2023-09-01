<?php

namespace Salesteer\Api;

use GuzzleHttp\Client;
use Salesteer\Salesteer;
use Salesteer\Exception as Exception;

class ApiRequestor
{
    public function __construct(
        private string $_apiKey,
        private string $_apiBase,
        private array $_configs = [])
    {
    }

    /**
     * @param 'delete'|'get'|'post' $method
     * @param string     $url
     * @param null|array $params
     * @param null|array $headers
     *
     * @throws Exception\ApiErrorException
     *
     * @return ApiResponse
     */
    public function request($method, $url, $params = null, $headers = null)
    {
        $params = $params ?: [];
        $headers = $headers ?: [];

        list($rbody, $rcode, $rheaders) = $this->_requestRaw($method, $url, $params, $headers);

        $json = $this->_interpretResponse($rbody, $rcode, $rheaders);
        $resp = new ApiResponse($rbody, $rcode, $rheaders, $json);

        return $resp;
    }

    /**
     * @static
     *
     * @param string $apiKey
     * @param null   $clientInfo
     *
     * @return array
     */
    private static function _defaultHeaders($apiKey, $tenantDomain = null)
    {
        $uaString = 'Salesteer/v1 PHP/' . Salesteer::VERSION. ' ';

        $langVersion = PHP_VERSION;
        $uname_disabled = self::_isDisabled(ini_get('disable_functions'), 'php_uname');
        $uname = $uname_disabled ? '(disabled)' : php_uname();

        $ua = [
            'bindings_version' => Salesteer::VERSION,
            'lang' => 'php',
            'lang_version' => $langVersion,
            'publisher' => 'salesteer',
            'uname' => $uname,
        ];

        $headers = [
            'X-Salesteer-Version' => Salesteer::getApiVersion(),
            'X-Salesteer-Client-User-Agent' => json_encode($ua),
            'User-Agent' => $uaString,
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $apiKey,
        ];

        $tenantDomain = $tenantDomain ?? Salesteer::getTenantDomain();

        if (null !== $tenantDomain) {
            $headers['X-Tenant'] = $tenantDomain;
        }

        return $headers;
    }

    private function _prepareRequest($method, $url, $params, $headers)
    {
        if (!$this->_apiKey) {
            $msg = 'No API key provided.  (HINT: set your API key using '
              . '"Salesteer::setApiKey(<API-KEY>)".  You can generate API keys from '
              . 'the Salesteer web interface. Email support@salesteer.com if you have any questions.';

            throw new Exception\AuthenticationException($msg);
        }

        $absUrl = $this->_apiBase . $url;

        $defaultHeaders = self::_defaultHeaders(
            $this->_apiKey,
            $this->_configs['tenant_domain']
        );

        $defaultHeaders['Content-Type'] = 'application/json';
        $finalHeaders = array_merge($defaultHeaders, $headers);

        //TODO: strictly related to Guzzle remove in future
        if('get' === $method){
            $params = ['query' => $params];
        }else{
            $params = ['json' => $params];
        }

        return [$absUrl, $finalHeaders, $params];
    }

    /**
     * @param 'delete'|'get'|'post'|'patch'|'put' $method
     * @param string $url
     * @param array $params
     * @param array $headers
     *
     * @throws Exception\AuthenticationException
     * @throws Exception\ApiConnectionException
     *
     * @return array
     */
    private function _requestRaw($method, $url, $params, $headers)
    {
        list($absUrl, $headers, $params) = $this->_prepareRequest($method, $url, $params, $headers);

        Salesteer::getLogger()->debug(json_encode(array_merge(
            $params,
            [
                'method' => $method,
                'url' => $absUrl,
                'headers' => $headers,
            ],
        ), JSON_PRETTY_PRINT));

        // TODO: improve with PSR HTTP, see HttpClient\Http
        $client = new Client();
        $res = $client->request((string) $method, $absUrl, array_merge(
            $params,
            [
                'headers' => $headers,
            ]
        ));

        return [
            $res->getBody(),
            $res->getStatusCode(),
            $res->getHeaders()
        ];
    }

    /**
     * @param string $rbody
     * @param int    $rcode
     * @param array  $rheaders
     *
     * @throws Exception\UnexpectedValueException
     * @throws Exception\ApiErrorException
     *
     * @return array
     */
    private function _interpretResponse($rbody, $rcode, $rheaders)
    {
        $resp = json_decode($rbody, true);
        $jsonError = json_last_error();

        if (
            204 !== $rcode
            && null === $resp
            && JSON_ERROR_NONE !== $jsonError
        ) {
            $msg = "Invalid response body from API: {$rbody} "
              . "(HTTP response code was {$rcode}, json_last_error() was {$jsonError})";

            throw new Exception\UnexpectedValueException($msg, $rcode);
        }

        if ($rcode < 200 || $rcode >= 300) {
            $this->handleErrorResponse($rbody, $rcode, $rheaders, $resp);
        }

        Salesteer::getLogger()->error(json_encode([
            $rcode,
            $resp ?? [],
        ],JSON_PRETTY_PRINT));

        return $resp ?? [];
    }

    /**
     * @param string $rbody a JSON string
     * @param int $rcode
     * @param array $rheaders
     * @param array $resp
     *
     * @throws Exception\UnexpectedValueException
     * @throws Exception\ApiErrorException
     */
    public function handleErrorResponse($rbody, $rcode, $rheaders, $resp)
    {
        if (!is_array($resp) || !isset($resp['error'])) {
            $msg = "Invalid response object from API: {$rbody} "
              . "(HTTP response code was {$rcode})";

            throw new Exception\UnexpectedValueException($msg);
        }

        $errorData = $resp['error'];

        $error = self::_specificAPIError($rbody, $rcode, $rheaders, $resp, $errorData);

        throw $error;
    }

    /**
     * @static
     *
     * @param string $rbody
     * @param int    $rcode
     * @param array  $rheaders
     * @param array  $resp
     * @param array  $errorData
     *
     * @return Exception\ApiErrorException
     */
    private static function _specificAPIError($rbody, $rcode, $rheaders, $resp, $errorData)
    {
        $msg = isset($errorData['message']) ? $errorData['message'] : null;
        $param = isset($errorData['param']) ? $errorData['param'] : null;
        $code = isset($errorData['code']) ? $errorData['code'] : null;
        $type = isset($errorData['type']) ? $errorData['type'] : null;

        switch ($rcode) {
            case 400:
                return Exception\BadRequestException::factory($msg, $rcode, $rbody, $resp, $rheaders, $code);

            case 404:
                return Exception\InvalidRequestException::factory($msg, $rcode, $rbody, $resp, $rheaders, $code, $param);

            case 401:
                return Exception\AuthenticationException::factory($msg, $rcode, $rbody, $resp, $rheaders, $code);

            case 403:
                return Exception\PermissionException::factory($msg, $rcode, $rbody, $resp, $rheaders, $code);

            case 429:
                return Exception\RateLimitException::factory($msg, $rcode, $rbody, $resp, $rheaders, $code, $param);

            default:
                return Exception\UnknownApiErrorException::factory($msg, $rcode, $rbody, $resp, $rheaders, $code);
        }
    }

    /**
     * @static
     *
     * @param string $disableFunctionsOutput - String value of the 'disable_function' setting, as output by ini_get('disable_functions')
     * @param string $functionName - Name of the function we are interesting in seeing whether or not it is disabled
     *
     * @return bool
     */
    private static function _isDisabled($disableFunctionsOutput, $functionName)
    {
        $disabledFunctions = explode(',', $disableFunctionsOutput);
        foreach ($disabledFunctions as $disabledFunction) {
            if (trim($disabledFunction) === $functionName) {
                return true;
            }
        }

        return false;
    }
}

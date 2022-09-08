<?php

namespace Language\Api;

use Language\ApiCall;
use Language\Exceptions\Api\ApiErrorExcepiton;
use Language\Exceptions\Api\BadApiContentException;
use Language\Exceptions\Api\BadApiResponseException;

class LanguageApi
{
    public static function get($data)
    {
        list($target, $mode, $getParameters, $postParameters) = $data;
        $response = ApiCall::call($target, $mode, $getParameters, $postParameters);

        return self::transformResponse($response);
    }

    public static function getAppletLanguageFile($applet, $language)
    {
        $data = [
            'system_api',
            'language_api',
            [
                'system' => 'LanguageFiles',
                'action' => 'getAppletLanguageFile',
            ],
            [
                'applet'   => $applet,
                'language' => $language,
            ],
        ];
        return self::get($data);
    }

    private static function transformResponse($response)
    {
        self::checkResponse($response);
        return $response['data'];
    }

    public static function checkResponse($response)
    {
        if (!$response || !isset($response['status'])) {
            throw new ApiErrorExcepiton('Error during the API call');
        }

        if ($response['status'] != 'OK') {
            throw new BadApiResponseException('Bad response: '
                . (!empty($response['error_type']) ? 'Type(' . $response['error_type'] . ') ' : '')
                . (!empty($response['error_code']) ? 'Code(' . $response['error_code'] . ') ' : '')
                . ((string)$response['data']));
        }

        if ($response['data'] === false) {
            throw new BadApiContentException('Bad content!');
        }
    }
}
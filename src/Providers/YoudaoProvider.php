<?php

namespace Yong\Translate\Providers;

use Yong\Translate\Contracts\ProviderInterface;
use Yong\Translate\Exceptions\TranslateException;
use Yong\Translate\Translate;

/**
 * Class YoudaoProvider.
 *
 * @see http://ai.youdao.com/docs/doc-trans-api.s#p02
 */
class YoudaoProvider extends AbstractProvider implements ProviderInterface
{
    const HTTP_URL = 'http://openapi.youdao.com/api';

    const HTTPS_URL = 'https://openapi.youdao.com/api';

    protected function getRequestParams($q, $from = 'zh-CHS', $to = 'EN')
    {
        $salt = time();

        $params = [
            'q' => $q,
            'from' => $from,
            'to' => $to,
            'appKey' => $this->appId,
            'salt' => $salt,
            'ext' => 'mp3',
            'voice' => 0,
        ];

        $params['sign'] = $this->makeSignature($params);

        return $params;
    }

    protected function makeSignature(array $params)
    {
        return md5($this->appId.$params['q'].$params['salt'].$this->appKey);
    }

    /**
     * {@inheritdoc}
     */
    public function translate($q, $from = 'zh-CHS', $to = 'EN')
    {
        $response = $this->post($this->getTranslateUrl(), $this->getRequestParams($q, $from, $to));
        // var_dump( $this->getTranslateUrl());
        // var_dump( $response);exit;

        if ('0' != $response['errorCode']) {
            throw new TranslateException("请求接口错误，错误码：{$response['errorCode']}", $response['errorCode']);
        }

        return new Translate($this->mapTranslateResult($response));
    }

    protected function mapTranslateResult(array $translateResult)
    {
        return [
            'src' => $translateResult['query'],
            'dst' => $translateResult['translation'],
            'original' => $translateResult,
        ];
    }
}

<?php

namespace Yan\Translate\Providers;

use Stichoza\GoogleTranslate\TranslateClient;
use Yan\Translate\Contracts\ProviderInterface;
use Yan\Translate\Exceptions\TranslateException;
use Yan\Translate\Translate;

class JinShanProvider extends AbstractProvider implements ProviderInterface
{
    const HTTP_URL = 'http://fy.iciba.com/ajax.php?a=fy';

    protected function getTranslateUrl(): string
    {
        return static::HTTP_URL;
    }

    protected function getRequestParams(array $args)
    {
        return [
            'f' => $args['from'],
            't' => $args['to'],
            'w' => $args['q'],
        ];
    }

    protected function makeSignature(array $params) {}

    /**
     * {@inheritdoc}
     */
    public function translate(string $q, $from = 'auto', $to = 'auto')
    {
        $response = $this->post($this->getTranslateUrl(), $this->getRequestParams(compact('q', 'from', 'to')));

        $response = json_decode($response, true);

        if ($response['content']['error_code']) {
            throw new TranslateException($response['content']['message'], $response['content']['error_code']);
        }

        return new Translate($this->mapTranslateResult([
            'src' => $q,
            'dst' => $response['content']['out'],
            'original' => $response,
        ]));
    }

    protected function mapTranslateResult(array $translateResult): array
    {
        return [
            'src' => $translateResult['src'],
            'dst' => $translateResult['dst'],
            'original' => $translateResult['original'],
        ];
    }
}

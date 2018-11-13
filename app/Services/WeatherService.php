<?php

declare(strict_types = 1);

namespace App\Services;

use GuzzleHttp\Client;

/**
 * Class WeatherService
 * @package App\Services
 */
class WeatherService
{
    /**
     * @var string
     */
    private $apiUrl;
    /**
     * @var string
     */
    private $apiAppId;
    /**
     * @var string
     */
    private $town;
    /**
     * @var Client
     */
    private $client;

    /**
     * @var array
     */
    private $directions = [
        [
            'from' => 0,
            'to' => 22,
            'value' => 'Š',
        ],
        [
            'from' => 23,
            'to' => 67,
            'value' => 'ŠR',
        ],
        [
            'from' => 68,
            'to' => 112,
            'value' => 'R',
        ],
        [
            'from' => 113,
            'to' => 157,
            'value' => 'PR',
        ],
        [
            'from' => 158,
            'to' => 202,
            'value' => 'P',
        ],
        [
            'from' => 203,
            'to' => 247,
            'value' => 'PV',
        ],
        [
            'from' => 248,
            'to' => 292,
            'value' => 'V',
        ],
        [
            'from' => 293,
            'to' => 337,
            'value' => 'ŠV',
        ],
        [
            'from' => 338,
            'to' => 360,
            'value' => 'Š',
        ],
    ];

    /**
     * WeatherService constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->apiUrl = env('W_URL');
        $this->apiAppId = env('W_APPID');
        $this->town = env('W_TOWN');

        $this->client = $client;
    }

    /**
     * @return \stdClass
     */
    public function getCurrent(): \stdClass
    {
        $result = $this->client->get($this->apiUrl . '/weather', [
            'query' => [
                'q' => $this->town,
                'appid' => $this->apiAppId,
                'lang' => 'lt',
                'units' => 'metric',
            ],
        ]);

        return json_decode($result->getBody()->getContents());
    }

    /**
     * @param int|null $deg
     * @return string
     */
    public function getDirectionByDeg(int $deg = null): string
    {
        if (!$deg) {
            return '-';
        }

        foreach ($this->directions as $direction) {
            if ($deg >= $direction['from'] && $deg <= $direction['to']) {
                return $direction['value'];
            }
        }

        return '-';
    }
}

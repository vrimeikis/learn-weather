<?php

declare(strict_types = 1);

namespace App\Services;

use App\Events\WindChanged;
use App\Parameter;
use GuzzleHttp\Client;
use phpDocumentor\Reflection\Types\Self_;

/**
 * Class WeatherService
 * @package App\Services
 */
class WeatherService
{
    const WIND_CHANGE_POINT = 10;
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
    private $parameterService;

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
     * @param ParameterService $parameterService
     */
    public function __construct(Client $client, ParameterService $parameterService)
    {
        $this->apiUrl = env('W_URL');
        $this->apiAppId = env('W_APPID');
        $this->town = env('W_TOWN');

        $this->client = $client;
        $this->parameterService = $parameterService;
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

    /**
     * @param float $speed
     */
    public function checkWindForEmail(float $speed): void
    {
        $oldSpeed = $this->parameterService->getValue(Parameter::PARAMETER_WIND_SPEED);

        if ($oldSpeed !== null) {
            if ($oldSpeed > self::WIND_CHANGE_POINT && $speed < self::WIND_CHANGE_POINT) {
                event(new WindChanged());
            }
            if ($oldSpeed < self::WIND_CHANGE_POINT && $speed > self::WIND_CHANGE_POINT) {
                event(new WindChanged('up'));
            }
        }

        $this->parameterService->setValue(Parameter::PARAMETER_WIND_SPEED, $speed);
    }
}

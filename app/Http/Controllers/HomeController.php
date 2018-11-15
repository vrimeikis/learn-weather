<?php

namespace App\Http\Controllers;

use App\Services\WeatherService;
use Illuminate\Contracts\View\View;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * @var WeatherService
     */
    private $weatherService;

    /**
     * HomeController constructor.
     * @param $weatherService
     */
    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $weatherData = $this->weatherService->getCurrent();
        $weatherData->wind->deg = array_get((array)$weatherData->wind, 'deg');
        $weatherData->wind->degHuman = $this->weatherService->getDirectionByDeg(
            array_get((array)$weatherData->wind, 'deg')
        );

        $this->weatherService->checkWindForEmail($weatherData->wind->speed);

        return view('home', compact('weatherData'));
    }




















}

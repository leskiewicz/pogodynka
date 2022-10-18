<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Location;
use App\Repository\MeasurementRepository;
use App\Repository\LocationRepository;

class WeatherController extends AbstractController
{
    #[Route('/weather', name: 'app_weather')]
    public function cityAndCountryAction(string $country, string $city, LocationRepository $locationRepository, MeasurementRepository $measurementRepository): Response
    {
		$cityrep = $locationRepository->findBy([
			'country' => $country,
			'city' => $city,
		]);
		
		$measurements = $measurementRepository->findByLocation($cityrep[0]);
		
        return $this->render('weather/countrycity.html.twig', [
			'country' => $country,
			'city' => $city,
            'measurements' => $measurements,
        ]);
    }
	
	public function cityAction(Location $city, MeasurementRepository $measurementRepository): Response
    {
		$measurements = $measurementRepository->findByLocation($city);
		
        return $this->render('weather/city.html.twig', [
			'location' => $city,
            'measurements' => $measurements,
        ]);
    }
}

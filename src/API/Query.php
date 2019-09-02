<?php

namespace Shela\DisplayPurposes\API;

class Query
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function tags($query = '')
    {
        $response = $this->request->request($this->_prepareTagRequest($query));

        return $response;
    }

    public function map($latitude, $longitude, $radius)
    {
        $bbox = $this->getBoundingBox($latitude, $longitude, $radius);
        $params = [
            'bbox' => implode(',', $bbox),
            'zoom' => $radius,
        ];
        $response = $this->request->request($this->_prepareMapRequest($params));

        return $response;
    }

    private function getBoundingBox($latitude, $longitude, $radius)
    {
        if ($radius == 0) {
            return [];
        }
        if ($latitude < -90.0 || $longitude > 90.0) {
            return [];
        }
        if ($longitude < -180.0 || $longitude > 180.0) {
            return [];
        }

        $radius_km = $radius * 1.609344;
        $lat = deg2rad($latitude);
        $lon = deg2rad($longitude);

        $radius = 6371;
        // Radius of the parallel at given latitude
        $parallel_radius = $radius * cos($lat);

        $lat_min = $lat - $radius_km / $radius;
        $lat_max = $lat + $radius_km / $radius;
        $lon_min = $lon - $radius_km / $parallel_radius;
        $lon_max = $lon + $radius_km / $parallel_radius;

        $lat_min = rad2deg($lat_min);
        $lon_min = rad2deg($lon_min);
        $lat_max = rad2deg($lat_max);
        $lon_max = rad2deg($lon_max);

        return [
            'lon_min' => $lon_min,
            'lat_min' => $lat_min,
            'lon_max' => $lon_max,
            'lat_max' => $lat_max,
        ];
    }

    private function _prepareTagRequest($query)
    {
        return 'https://query.displaypurposes.com/tag/'.$query;
    }

    private function _prepareMapRequest($query_params)
    {
        return 'https://query.displaypurposes.com/local?'.http_build_query($query_params);
    }
}

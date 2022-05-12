<?php
  /**
   * This page talks to weatherapi.com.
   */

  // API URL.
  // You can register for free to get your own api key (fb0... below). 
  // this is the api key for current need to change to forecast
  // $url = "http://api.weatherapi.com/v1/current.json?key=fb0b4c5c22d04c22be2202032210112&aqi=no&q=";
  $url = "http://api.weatherapi.com/v1/forecast.json?key=fb0b4c5c22d04c22be2202032210112&days=3&q=";
  // Check and filter query parameters.
  $query = filter_input(INPUT_GET, 'query', FILTER_DEFAULT);

  if ($query) {
    $query = urlencode($query);
    // $days = urlencode("&days=3&aqi=no&alerts=no");

    // Call the api with the user input query (zip, city, etc.).
    // $data = file_get_contents($url . $query . $days);
    $data = file_get_contents($url . $query);
    $parsed = json_decode($data);

    // echo $parsed;

    // You can use PHP's error_log to output a string to the log for debugging.
    
   
    $result['city'] = $parsed->location->name;
    $result["state"] = $parsed->location->region;
    // error_log($result->city);
    // error_log($parsed->location->name);

    // $result["forecast"] = $parsed->forecast>->forecastday[0]->day;

    $result["weather1"] = $parsed->current->condition->text;
    $result["temp1"] = $parsed->current->temp_f;
    $result["icon1"] = $parsed->current->condition->icon;

    $result["weather2"] = $parsed->forecast->forecastday[0]->day->condition->text;
    $result["temp2"] = $parsed->forecast->forecastday[0]->day->avgtemp_f;
    $result["icon2"] = $parsed->forecast->forecastday[0]->day->condition->icon;

    $result["weather3"]= $parsed->forecast->forecastday[1]->day->condition->text;
    $result["temp3"]= $parsed->forecast->forecastday[1]->day->avgtemp_f;
    $result["icon3"]= $parsed->forecast->forecastday[1]->day->condition->icon;

    header('Content-Type: application/json');
    echo json_encode($result);
  }
// yeet
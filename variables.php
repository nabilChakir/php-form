<?php

$sanitization_options = array(
        'bdate' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'event' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'artist' => FILTER_SANITIZE_NUMBER_INT,
        'description' => FILTER_SANITIZE_FULL_SPECIAL_CHARS, 
        'promo' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'venue_name' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'venue_address_1' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'venue_address_2' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'city' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'region' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'postal' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'country' => FILTER_SANITIZE_NUMBER_INT,
        'capacity' => FILTER_SANITIZE_NUMBER_INT,
        'attendance' => FILTER_SANITIZE_NUMBER_INT,
        'performance' => FILTER_SANITIZE_NUMBER_INT,
        'time' => FILTER_SANITIZE_NUMBER_INT,
        'contact_firstname' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'contact_lastname' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'email' => FILTER_SANITIZE_EMAIL,
        'number' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'recorded' => FILTER_SANITIZE_FULL_SPECIAL_CHARS
    );

$validation_options = array();
foreach ($sanitization_options as $key => $value) {
    if ($key === 'email') {
        $validation_options[$key] = FILTER_VALIDATE_EMAIL;
    } else {
        $validation_options[$key] = FILTER_VALIDATE_REGEXP;
    }
}

$regex = array(
    'bdate' => '/^\d{4}-\d{2}-\d{2}$/',
    'event' => '/^\d{2}:\d{2}$/',
    'artist' => '/^[1-4]$/',
    'description' => '/^[^\\\\]{2,300}$/',
    'promo' => '/^[A-Za-z\s\-]{2,25}$/',
    'venue_name' => '/^[a-zA-Z\s-]{2,60}$/',
    'venue_address_1' => '/^[\w\s\-]{2,60}$/',
    'venue_address_2' => '/^[\w\s\-]{2,60}$/',
    'city' => '/^[a-zA-Z\s-]{2,60}$/',
    'region' => '/^[a-zA-Z\s-]{2,60}$/',
    'postal' => '/^\d{2,15}$/',
    'country' => '/^[1-5]$/',
    'capacity' => '/^\d{1,5}$/',
    'attendance' => '/^\d{1,5}$/',
    'performance' => '/^[1-2]$/',
    'time' => '/^\d{1,4}$/',
    'contact_firstname' => '/^[A-Za-z\s-]{2,25}$/',
    'contact_lastname' => '/^[A-Za-z\s-]{2,25}$/',
    'email' => null,
    'number' => '/^\+?\d{2,35}$/',
    'recorded' => '/^(yes|no)$/'
);

?>
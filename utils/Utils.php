<?php

function formatDate($date, $format = 'd M Y')
{
    $dateTime = new DateTime($date);
    $formatter = new IntlDateFormatter(
        'es_ES',
        IntlDateFormatter::LONG,
        IntlDateFormatter::NONE,
        'Europe/Madrid',
        IntlDateFormatter::GREGORIAN
    );
    return $formatter->format($dateTime);
}

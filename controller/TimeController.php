<?php

namespace Controller;

class TimeController
{
    private $time;
    private $date;

    public function __construct()
    {
        date_default_timezone_set('Europe/Paris');
        $this->time = date('H:i:s');

        $date = new \DateTime();
        $formatter = new \IntlDateFormatter('fr_FR', \IntlDateFormatter::FULL, \IntlDateFormatter::NONE);

        $this->date = $formatter->format($date);
    }

    public function getTime()
    {
        return $this->time;
    }

    public function getDate()
    {
        return $this->date;
    }
}
$timeController = new TimeController();
echo json_encode(['time' => $timeController->getTime(), 'date' => $timeController->getDate()]);

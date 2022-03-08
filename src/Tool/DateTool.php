<?php

namespace App\Tool;

use DateTime;

class DateTool
{
    // public function getDate(): string
    public function getDate(): DateTime
    {
        // $date = new DateTime();
        // return $date->format("Y-m-d");
        // return $date->format("Y-m-d");
        return new DateTime();
    }
}
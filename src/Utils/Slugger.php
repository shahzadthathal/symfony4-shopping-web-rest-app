<?php

// src/Utils/Slugger.php
namespace App\Utils;

class Slugger
{
    public function slugify(string $value): string
    {
        return preg_replace('/\s+/', '-', mb_strtolower(trim(strip_tags($value)), 'UTF-8'));

    }
}
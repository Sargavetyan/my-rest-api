<?php

namespace App\Model;

use App\Entity\Team;

interface Formatter
{
    /**
     * @param Team[] $teams
     * @return mixed
     */
    public function responseFormatting(array $teams);
}
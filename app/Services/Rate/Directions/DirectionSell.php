<?php


namespace App\Services\Rate\Directions;


class DirectionSell implements Direction
{
    public function getDirection(): string
    {
        return 'sell';
    }
}

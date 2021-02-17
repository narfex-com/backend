<?php


namespace App\Services\Rate\Directions;


class DirectionBuy implements Direction
{

    public function getDirection(): string
    {
        return 'buy';
    }
}

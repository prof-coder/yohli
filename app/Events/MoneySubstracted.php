<?php

namespace App\Events;

use Spatie\EventSourcing\ShouldBeStored;

class MoneySubstracted implements ShouldBeStored
{

    /** @var int */
    public $amount;

    public function __construct(int $amount)
    {

        $this->amount = $amount;
    }
}

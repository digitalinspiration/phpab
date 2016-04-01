<?php

namespace PhpAb\Participation;

class LotteryFilter implements FilterInterface
{
    /**
     * @float
     */
    private $propability;

    /**
     * @param int $propability The probability for the lottery in percent
     *                         Should be 0 <=> 100
     *                         0 is lowest probability for participation
     *                         100 is the highest probability for participation
     *
     */
    public function __construct($propability)
    {
        $this->propability = $propability;
    }


    /**
     * @inheritDoc
     */
    public function shouldParticipate()
    {
        $propability = $this->propability;

        // ensure that we have a float since we cannot typehint
        // it in the constructor for PHP versions < 7
        if (! is_int($propability)) {
            throw new \InvalidArgumentException('The propability must be of type int.'.gettype($propability).' given');
        }

        if ($propability < 0 || $propability > 100) {
            throw new \InvalidArgumentException('the probability must be 0 <=> 100');
        }

        if (0 === $propability) {
            // since we allow 0 as a value we have to check for it
            // to prevent division by zero error.
            return false;
        }

        if (100 === $propability) {
            return true;
        }

        return  0 === mt_rand(0, $propability);
    }
}

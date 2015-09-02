<?php

namespace KataArgs;

class FlagParser
{
    /**
     * @param string $args
     * @return array
     */
    public function parse($args)
    {
        $splittedArgs = preg_split("/\s+\-/ui", $args);

        $flags = [];

        foreach ($splittedArgs as $argument) {
            if (!empty($argument)) {
                $flags[] = $this->createFlagObject($argument);
            }
        }

        return $flags;
    }

    /**
     * @param string $argument
     * @return Flag
     */
    private function createFlagObject($argument)
    {
        $flagAndValue = preg_replace("/^-/ui", "", $argument);

        $splittedFlagAndValue = $this->splitFlagKeyAndValue($flagAndValue);

        $values = $this->convertValueToArray($splittedFlagAndValue);

        return new Flag($splittedFlagAndValue[0], $values);
    }

    /**
     * @param $flagAndValue
     * @return array
     */
    private function splitFlagKeyAndValue($flagAndValue)
    {
        return preg_split("/\s+/ui", $flagAndValue, 2);
    }

    /**
     * @param $splittedFlagAndValue
     * @return array
     */
    private function convertValueToArray($splittedFlagAndValue)
    {
        if (!isset($splittedFlagAndValue[1])) {
            $splittedFlagAndValue[1] = "";
        }

        return preg_split("/,\s*/ui", $splittedFlagAndValue[1]);
    }
}

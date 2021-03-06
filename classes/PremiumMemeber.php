<?php

/**
 * Class PremiumMemeber
 * @author Ryan Guelzo
 * @copyright 2019
 */
    class PremiumMemeber extends Member
    {
        private $_inDoorInterests;
        private $_outDoorInterests;

        /**
         * @return mixed
         */
        public function getInDoorInterests()
        {
            return $this->_inDoorInterests;
        }

        /**
         * @param mixed $inDoorInterests
         */
        public function setInDoorInterests($inDoorInterests)
        {

                $this->_inDoorInterests = $inDoorInterests;

        }

        /**
         * @return mixed
         */
        public function getOutDoorInterests()
        {
            return $this->_outDoorInterests;
        }

        /**
         * @param mixed $outDoorInterests
         */
        public function setOutDoorInterests($outDoorInterests)
        {
            $this->_outDoorInterests = $outDoorInterests;
        }

    }
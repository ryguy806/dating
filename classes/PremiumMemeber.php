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
            if(empty($_inDoorInterests)){
                $this->_inDoorInterests = array($inDoorInterests);
            }else{
                array_push($_inDoorInterests, $inDoorInterests);
            }
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
            if(empty($_outDoorInterests)){
                $this->_outDoorInterests = array($outDoorInterests);
            }else{
                array_push($_outDoorInterests, $outDoorInterests);
            }
        }

    }
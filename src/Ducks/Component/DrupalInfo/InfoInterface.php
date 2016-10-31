<?php

namespace Ducks\Component\DrupalInfo {

    /**
     *
     */
    interface InfoInterface {

        public function valid();

        public function getConfig();

        public function getFile($filename);

    }

}

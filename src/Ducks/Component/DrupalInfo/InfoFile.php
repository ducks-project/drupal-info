<?php

namespace Ducks\Component\DrupalInfo {

    /**
     * this class should extends splfileinfo?
     */
    class InfoFile extends \SplFileObject {

        protected $config;

        /**
         *
         */
        public function __construct($filename, $open_mode='r', $use_include_path=false, $context=null) {
            parent::__construct($filename, $open_mode, $use_include_path, $context);
            return $this;
        }

        /**
         * @todo
         * like http://php.net/manual/fr/splfileobject.fgetcsv.php
         */
        public function fgetinfo() {
            $this->rewind();
            return ($this->getSize()) ? Parser::parse($this->fread($this->getSize())) : array();
        }

        /**
         * @todo
         * http://php.net/manual/fr/splfileobject.fputcsv.php
         */
        public function fputinfo(array $config) {
            $output = Dumper::dump($config);
            return $this->fwrite($output);
        }

        /**
         * @todo
         */
        public function getInfo() {

        }

        /**
         *
         */
        public function __toString() {
            return (empty(parent::__toString())) ? \SplFileInfo::__toString() : parent::__toString();
        }

    }

}

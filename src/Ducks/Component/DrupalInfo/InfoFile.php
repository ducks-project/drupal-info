<?php

namespace Ducks\Component\DrupalInfo {

    /**
     * @todo a save method?
     */
    class InfoFile extends \SplFileInfo implements \RecursiveIterator, \SeekableIterator {

        protected $config;

        protected $splFileObject;

        /**
         *
         */
        public function __construct($filename) {
            parent::__construct($filename);
            return $this;
        }

        /**
         *
         */
        protected function getSplFileObject($open_mode='r', $use_include_path=false, $context=null) {
            if (!$this->splFileObject instanceof SplFileObject) {
                if (is_resource($context)) {
                    $this->splFileObject = $this->openFile($open_mode, $use_include_path, $context);
                } else {
                    $this->splFileObject = $this->openFile($open_mode, $use_include_path);
                }
            }
            return $this->splFileObject;
        }

        /**
         * {@inheritdoc}
         */
        public function getChildren() {
            return $this->getSplFileObject()->getChildren();
        }

        /**
         * {@inheritdoc}
         */
        public function hasChildren() {
            return $this->getSplFileObject()->hasChildren();
        }

        /**
         * {@inheritdoc}
         */
        public function current() {
            return $this->getSplFileObject()->current();
        }

        /**
         * {@inheritdoc}
         */
        public function key() {
            return $this->getSplFileObject()->key();
        }

        /**
         * {@inheritdoc}
         */
        public function next() {
            return $this->getSplFileObject()->next();
        }

        /**
         * {@inheritdoc}
         */
        public function rewind() {
            return $this->getSplFileObject()->rewind();
        }

        /**
         * {@inheritdoc}
         */
        public function valid() {
            return $this->getSplFileObject()->valid();
        }

        /**
         * {@inheritdoc}
         */
        public function seek($position) {
            return $this->getSplFileObject()->seek($position);
        }

        /**
         *
         */
        public function eof() {
            return $this->getSplFileObject()->eof();
        }

        /**
         * @todo
         * like http://php.net/manual/fr/splfileobject.fgetcsv.php
         */
        public function fgetinfo() {
            $this->rewind();
            return ($this->getSize()) ? Parser::parse($this->getSplFileObject()->fread($this->getSize())) : array();
        }

        /**
         * @todo
         * http://php.net/manual/fr/splfileobject.fputcsv.php
         */
        public function fputinfo(array $config) {
            $dumper = new Dumper();
            $output = $dumper->dump($config);
            $splFileObject = $this->openFile('w', false);
            return $splFileObject->fwrite($output);
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
            return \SplFileInfo::__toString();
        }

    }

}

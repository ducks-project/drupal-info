<?php

namespace Ducks\Component\DrupalInfo {

    /**
     *
     */
    class Info implements InfoInterface {

        protected $availableKeys;

        protected $config;

        /**
         *
         */
        public function __construct(array $config) {
            if (!empty($this->availableKeys)) {
                foreach ($config as $key => $value) {
                    if (!in_array($key, $this->availableKeys)) {
                        unset($config[$key]);
                    }
                }
            }
            $this->config = $config;
        }

        /**
         *
         */
        public function valid() {
            return true;
        }

        /**
         * @todo an array with the properties merged?
         */
        public function getConfig() {
            return $this->config;
        }

        /**
         *
         */
        public function getFile($filename, $path=null) {
            return $this->saveFile($filename, $path);
        }

        /**
         *
         */
        public function saveFile($filename, $path=null) {
            if (!$this->valid()) {
                throw new \Exception('Config invalid'); // TODO own exception
            }
            if (empty($path)) {
                $path = getcwd();
            }
            $file = new InfoFile($path.DIRECTORY_SEPARATOR.$filename.'.info');
            $file->fputinfo($this->getConfig());
            return $file;
        }

    }

}

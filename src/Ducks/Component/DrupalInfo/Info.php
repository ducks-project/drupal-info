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
        public function __call($name, $arguments) {
            if (strpos($name, 'get') === 0) {
                return $this->get(strtolower(substr($name, 3)));
            }
            elseif (strpos($name, 'set') === 0) {
                return $this->set(strtolower(substr($name, 3)), reset($arguments));
            }
        }

        /**
         *
         */
        protected function get($name) {
            if (!empty($this->availableKeys) && !in_array($name, $this->availableKeys)) {
                throw new \OutOfBoundsException('['.$name.'] is not available for the class: '.__CLASS__);

            }
            return (isset($this->config[$name])) ? $this->config[$name] : null;
        }

        /**
         *
         */
        protected function set($name, $value) {
            if (!empty($this->availableKeys) && !in_array($name, $this->availableKeys)) {
                throw new \OutOfBoundsException('['.$name.'] is not available for the class: '.__CLASS__);

            }
            if (isset($this->config[$name])) {
                $this->config[$name] = $value;
            }
            return $this;
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

            $config = $this->getConfig();
            foreach ($config as $key => $value) {
                if (empty($value)) {
                    unset($config[$key]);
                }
            }

            if (empty($path)) {
                $path = getcwd();
            }

            switch ($this->getCore()) {
                case '8.x':
                    $file = new InfoFile($path.DIRECTORY_SEPARATOR.$filename.'.info.yml');
                    $file->fputyaml($config);
                    break;

                default:
                    $file = new InfoFile($path.DIRECTORY_SEPARATOR.$filename.'.info');
                    $file->fputinfo($config);
                    break;
            }

            return $file;
        }

    }

}

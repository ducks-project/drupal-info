<?php

namespace Ducks\Component\DrupalInfo {

    /**
     * this class is an object for a .info?
     */
    class ThemeInfo extends Info {

        /**
         *
         */
        public function __construct(array $config) {
            $this->availableKeys = array(
                'name',
                'core',
                'screenshot',
                'description',
                'version',
                'base theme',
                'regions',
                'features',
                'settings',
                'stylesheets',
                'scripts',
                'php'
            );
            parent::__construct($config);
        }

        /**
         * check if config is valid
         */
        public function valid() {
            if(empty($this->config['name'])) {
                return false;
            }
            if(empty($this->config['core'])) {
                return false;
            }
            return true;
        }

    }

}

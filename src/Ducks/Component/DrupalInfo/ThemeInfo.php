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

        /**
         *
         */
        public function getBaseTheme() {
            return $this->get('base theme');
        }

        /**
         *
         */
        public function getDrupalizedBaseTheme() {
            $baseTheme = $this->getBaseTheme();
            if (strpos($baseTheme, '/') !== false) {
                list($vendor, $baseTheme) = explode('/', $baseTheme);
            }
            return $baseTheme;
        }

        /**
         *
         */
        public function getFullVersion() {
            $version = $this->get('version');

            // TODO helper
            // replace _ - by . (@see version_compare)
            $semantic = explode('.', $version);
            if (count($semantic) < 3) {
                $major = (isset($semantic[0])) ? $semantic[0] : '1';
                $minor = (isset($semantic[1])) ? $semantic[1] : '0';
                $patch = (isset($semantic[2])) ? $semantic[2] : '0';
                $version = $major.'.'.$minor.'.'.$patch;
            }
            return $version;
        }

        /**
         *
         */
        public function saveFile($filename, $path=null) {
            $baseTheme = $this->getBaseTheme();
            $this->config['base theme'] = $this->getDrupalizedBaseTheme();
            $result = parent::saveFile($filename, $path);
            $this->config['base theme'] = $baseTheme;
            return $result;
        }

    }

}

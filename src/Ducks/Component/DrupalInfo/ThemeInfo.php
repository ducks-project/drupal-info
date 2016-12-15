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
                'type',
                'description',
                'package',
                'version',
                'core',

                'base theme',
                'screenshot',

                'libraries',
                'libraries-override',
                'libraries-extend',

                'stylesheets',
                'regions',
                'features',
                'settings',

                'scripts',
                'php',

                // d8
                'stylesheets-remove',
                'stylesheets-override',
                'regions_hidden',
            );
            $config['type'] = 'theme';
            parent::__construct($config);
        }

        /**
         *
         */
        public function getLibrariesOverride() {
            return $this->config['libraries-override'];
        }

        /**
         *
         */
        public function setLibrariesOverride(array $librariesOverride) {
            $this->config['libraries-override'] = $librariesOverride;
            return $this;
        }

        /**
         *
         */
        public function getLibrariesExtend() {
            return $this->config['libraries-extend'];
        }

        /**
         *
         */
        public function setLibrariesExtend(array $librariesExtend) {
            $this->config['libraries-extend'] = $librariesExtend;
            return $this;
        }

        /**
         * @deprecated
         */
        public function getStylesheetsRemove() {
            return $this->config['stylesheets-remove'];
        }

        /**
         * @deprecated
         */
        public function setStylesheetsRemove(array $stylesheetsRemove) {
            $this->config['stylesheets-remove'] = $stylesheetsRemove;
            return $this;
        }

        /**
         * @deprecated
         */
        public function getStylesheetsOverride() {
            return $this->config['stylesheets-override'];
        }

        /**
         * @deprecated
         */
        public function setStylesheetsOverride(array $stylesheetsOverride) {
            $this->config['stylesheets-override'] = $stylesheetsOverride;
            return $this;
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

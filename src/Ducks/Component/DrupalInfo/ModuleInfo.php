<?php

namespace Ducks\Component\DrupalInfo {

    /**
     * this class is an object for a .info?
     */
    class ModuleInfo extends Info {

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

                'dependencies',
                'test_dependencies',

                'stylesheets',
                'regions',
                'features',

                'files',
                'scripts',

                'configure',
                'required',
                'hidden',

                'project',
                'project status url',

                'php',
            );
            $config['type'] = 'module';
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

    }

}

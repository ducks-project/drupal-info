<?php

namespace Ducks\Component\DrupalInfo {

    class Inline {

        /**
         * @todo
         * @see Yaml::Inline::Parse
         */
        public static function parse($value) {
            $result = trim($value);
            if ($value !== '') {
                $result = Parser::parse($value);
            }
            return $result;
        }

        /**
         * @todo
         * @see Yaml::Inline::Parse
         */
        public static function dump($value, $section=null) {
            switch (true) {
                case is_null($value):
                    $output = '';
                    break;
                case is_bool($value):
                    $output = ($value) ? 'true' : 'false';
                    break;
                case is_resource($value):
                    $output = 'null';
                    break;
                case is_object($value):
                    return 'null';
                    break;
                case is_array($value):
                    $output = static::dumpArray($value, $section);
                    break;
                default:
                    $output = $value;
                    break;
            }

            return $output;
        }

        /**
         * (array_keys($values) !== range(0, count($value)-1) is slower than a foreach
         */
        public static function isHash(array $value) {
            $expectedKey = 0;
            foreach ($value as $key => $val) {
                if ($key !== $expectedKey++) {
                    return true;
                }
            }
            return false;
        }

        /**
         * @todo with section
         */
        public static function dumpArray(array $value, $section=null) {
            $output = array();
            if ($value && !static::isHash($value) && !empty($section)) {
                $format = '%s';
                foreach ($value as $val) {
                    $output[] = sprintf('%s[] = %s', static::dump($section), static::dump($val));
                }
            }
            else {
                $format = '%s';
                foreach ($value as $key => $val) {
                    $output[] = sprintf('%s[] = %s', static::dump($key), static::dump($val));
                }
            }
            return trim(sprintf($format, implode(PHP_EOL, $output)));
        }

    }

}

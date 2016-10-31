<?php

namespace Ducks\Component\DrupalInfo {

    class Dumper {

        /**
         * @todo
         * @see Inline in yaml
         */
        public function dump($input, $isRoot=true) {
            $output = '';
            if ($isRoot && is_array($input)) {
                foreach ($input as $key => $value) {
                    $inline = empty($value);
                    $output .= is_array($value) ? sprintf('%s%s', Inline::Dump($value, $key), ($inline) ? '' : PHP_EOL) : sprintf('%s = %s%s', Inline::Dump($key), Inline::Dump($value), PHP_EOL);
                }
            } else {
                $output .= Inline::Dump($input);
            }
            return $output;
        }

    }

}

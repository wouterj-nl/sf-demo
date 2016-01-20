<?php

namespace AppBundle\Util;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class Csv
{
    /**
     * @param       $table
     * @param array $columnNames
     *
     * @return
     */
    public static function parse($table, array $columnNames = array())
    {
        $rows = preg_split('/\R/', $table);

        return array_filter(array_map(function ($c) use ($columnNames) {
            $columns = array_map('json_decode', explode(',', $c));

            for ($i = 0; $i < count($columns); $i++) {
                if (isset($columnNames[$i]) && isset($columns[$i])) {
                    $columns[$columnNames[$i]] = $columns[$i];
                }
            }

            return $columns;
        }, $rows), function ($v) {
            return [null] !== $v && !empty($v);
        });
    }
}

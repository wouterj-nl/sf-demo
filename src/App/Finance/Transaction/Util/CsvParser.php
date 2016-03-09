<?php

/*
 * This file is part of the WouterJ Symfony Example package.
 *
 * (c) 2016 Wouter de Jong
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Finance\Transaction\Util;

/**
 * @author Wouter J <wouter@wouterj.nl>
 */
class CsvParser
{
    /**
     * @param       $table
     * @param array $columnNames
     *
     * @return
     */
    public static function parse($table, array $columnNames = [])
    {
        $rows = preg_split('/\R/', $table);

        return array_filter(
            array_map(function ($c) use ($columnNames) {
                $columns = array_map('json_decode', explode(',', $c));

                for ($i = 0; $i < count($columns); $i++) {
                    if (isset($columnNames[$i]) && isset($columns[$i])) {
                        $columns[$columnNames[$i]] = $columns[$i];
                    }
                }

                return $columns;
            }, $rows),
            function ($v) {
                return [null] !== $v && !empty($v);
            }
        );
    }
}

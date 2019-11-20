<?php

namespace Akiltech\AccountingDashboardBundle\Helpers;

class ArrayGroupBy
{
    const IDX_PRIMARY = 0;

    static function groupBy(
        $array = [],
        $keysToGroup = [],
        $indexesToGroup = [],
        $indexesToSum = [],
        $indexesToCount = []
    )
    {
        $arrayResult = [];
        $indexesKeys = [];
        foreach ($array as $item) {
            if (!isset($indexesKeys[0])) {
                $indexesKeys[0] = [];
            }
            $idx0 = array_search($item[$keysToGroup[0][self::IDX_PRIMARY]], $indexesKeys[0]);
            if ($idx0 === false) {
                $indexesKeys[0][] = $item[$keysToGroup[0][self::IDX_PRIMARY]];
            }
            $idx0 = array_search($item[$keysToGroup[0][self::IDX_PRIMARY]], $indexesKeys[0]);

            foreach ($keysToGroup[0] as $key) {
                if (in_array($key, array_merge($indexesToSum, $indexesToCount))) {
                    if(in_array($key, $indexesToSum)) {
                        if (!isset($arrayResult[$idx0][$key])) {
                            $arrayResult[$idx0][$key] = 0;
                        }
                        $arrayResult[$idx0][$key] += $item[$key];
                    } else {
                        if (!isset($arrayResult[$idx0]['nbEcriture'])) {
                            $arrayResult[$idx0]['nbEcriture'] = 0;
                        }
                        $arrayResult[$idx0]['nbEcriture'] += 1;
                    }
                } else {
                    $arrayResult[$idx0][$key] = $item[$key];
                }
            }

            if (!isset($indexesKeys[1][$idx0])) {
                $indexesKeys[1][$idx0] = [];
            }

            if(isset($keysToGroup[1])) {
                $idx1 = array_search($item[$keysToGroup[1][self::IDX_PRIMARY]], $indexesKeys[1][$idx0]);
                if ($idx1 === false) {
                    $indexesKeys[1][$idx0][] = $item[$keysToGroup[1][self::IDX_PRIMARY]];
                }
                $idx1 = array_search($item[$keysToGroup[1][self::IDX_PRIMARY]], $indexesKeys[1][$idx0]);

                if (isset($indexesToGroup[1])){
                    foreach ($keysToGroup[1] as $key) {
                        if (in_array($key, array_merge($indexesToSum, $indexesToCount))) {
                            if(in_array($key, $indexesToSum)) {
                                if (!isset($arrayResult[$idx0][$indexesToGroup[0]][$idx1][$key])) {
                                    $arrayResult[$idx0][$indexesToGroup[0]][$idx1][$key] = 0;
                                }
                                $arrayResult[$idx0][$indexesToGroup[0]][$idx1][$key] += $item[$key];
                            } else {
                                if (!isset($arrayResult[$idx0][$indexesToGroup[0]][$idx1]['nbEcriture'])) {
                                    $arrayResult[$idx0][$indexesToGroup[0]][$idx1]['nbEcriture'] = 0;
                                }
                                $arrayResult[$idx0][$indexesToGroup[0]][$idx1]['nbEcriture'] += 1;
                            }


                        } else {
                            $arrayResult[$idx0][$indexesToGroup[0]][$idx1][$key] = $item[$key];
                        }
                    }
                }

                if (!isset($indexesKeys[2][$idx0][$idx1])) {
                    $indexesKeys[2][$idx0][$idx1] = [];
                }
                if (isset($keysToGroup[2])) {
                    $idx2 = array_search($item[$keysToGroup[2][self::IDX_PRIMARY]], $indexesKeys[2][$idx0][$idx1]);
                    if ($idx2 === false) {
                        $indexesKeys[2][$idx0][$idx1][] = $item[$keysToGroup[2][self::IDX_PRIMARY]];
                    }
                    $idx2 = array_search($item[$keysToGroup[2][self::IDX_PRIMARY]], $indexesKeys[2][$idx0][$idx1]);
                    if (isset($indexesToGroup[1])) {
                        foreach ($keysToGroup[2] as $key) {
                            if (in_array($key, array_merge($indexesToSum, $indexesToCount))) {
                                if(in_array($key, $indexesToSum)) {
                                    if (!isset($arrayResult[$idx0][$indexesToGroup[0]][$idx1][$indexesToGroup[1]][$idx2][$key])) {
                                        $arrayResult[$idx0][$indexesToGroup[0]][$idx1][$indexesToGroup[1]][$idx2][$key] = 0;
                                    }
                                    $arrayResult[$idx0][$indexesToGroup[0]][$idx1][$indexesToGroup[1]][$idx2][$key] += $item[$key];
                                } else {
                                    if (!isset($arrayResult[$idx0][$indexesToGroup[0]][$idx1][$indexesToGroup[1]][$idx2]['nbEcriture'])) {
                                        $arrayResult[$idx0][$indexesToGroup[0]][$idx1][$indexesToGroup[1]][$idx2]['nbEcriture'] = 0;
                                    }
                                    $arrayResult[$idx0][$indexesToGroup[0]][$idx1][$indexesToGroup[1]][$idx2]['nbEcriture'] += 1;
                                }
                            } else {
                                $arrayResult[$idx0][$indexesToGroup[0]][$idx1][$indexesToGroup[1]][$idx2][$key] = $item[$key];
                            }
                        }
                        $debit = $arrayResult[$idx0][$indexesToGroup[0]][$idx1][$indexesToGroup[1]][$idx2]['debit'];
                        $credit = $arrayResult[$idx0][$indexesToGroup[0]][$idx1][$indexesToGroup[1]][$idx2]['credit'];
                        if(($debit - $credit) == 0) {
                            unset($arrayResult[$idx0][$indexesToGroup[0]][$idx1][$indexesToGroup[1]][$idx2]);
                            unset($indexesKeys[2][$idx0][$idx1][$idx2]);
                            $indexesKeys[2][$idx0][$idx1] = array_values($indexesKeys[2][$idx0][$idx1]);
                            $arrayResult[$idx0][$indexesToGroup[0]][$idx1][$indexesToGroup[1]] =
                                array_values($arrayResult[$idx0][$indexesToGroup[0]][$idx1][$indexesToGroup[1]]);
                        }
                    } else {
                        foreach ($keysToGroup[2] as $key) {
                            if (in_array($key, array_merge($indexesToSum, $indexesToCount))) {
                                if(in_array($key, $indexesToSum)) {
                                    if (!isset($arrayResult[$idx0][$indexesToGroup[0]][$idx1][$idx2][$key])) {
                                        $arrayResult[$idx0][$indexesToGroup[0]][$idx1][$idx2][$key] = 0;
                                    }
                                    $arrayResult[$idx0][$indexesToGroup[0]][$idx1][$idx2][$key] += $item[$key];
                                } else {
                                    if (!isset($arrayResult[$idx0][$indexesToGroup[0]][$idx1][$idx2]['nbEcriture'])) {
                                        $arrayResult[$idx0][$indexesToGroup[0]][$idx1][$idx2]['nbEcriture'] = 0;
                                    }
                                    $arrayResult[$idx0][$indexesToGroup[0]][$idx1][$idx2]['nbEcriture'] += 1;
                                }


                            } else {
                                $arrayResult[$idx0][$indexesToGroup[0]][$idx1][$idx2][$key] = $item[$key];
                            }

                            $arrayResult[$idx0][$indexesToGroup[0]][$idx1][$idx2][$key] = $item[$key];
                        }
                    }
                }

                if (isset($keysToGroup[3])) {
                    if (!isset($indexesKeys[3][$idx0][$idx1][$idx2])) {
                        $indexesKeys[3][$idx0][$idx1][$idx2] = [];
                    }
                    $idx3 = array_search($item[$keysToGroup[3][self::IDX_PRIMARY]], $indexesKeys[3][$idx0][$idx1][$idx2]);
                    if ($idx3 === false) {
                        $indexesKeys[3][$idx0][$idx1][$idx2][] = $item[$keysToGroup[3][self::IDX_PRIMARY]];
                    }
                    $idx3 = array_search($item[$keysToGroup[3][self::IDX_PRIMARY]], $indexesKeys[3][$idx0][$idx1][$idx2]);

                    foreach ($keysToGroup[3] as $key) {
                        $arrayResult[$idx0][$indexesToGroup[0]][$idx1][$indexesToGroup[1]][$idx2][$indexesToGroup[2]][$idx3][$key] = $item[$key];
                    }
                }

                if(isset($indexesToGroup[1]) && $indexesToGroup[1] !== '') {
                    if(empty($arrayResult[$idx0][$indexesToGroup[0]][$idx1][$indexesToGroup[1]])) {
                        unset($arrayResult[$idx0][$indexesToGroup[0]][$idx1]);
                        $arrayResult[$idx0][$indexesToGroup[0]] = array_values($arrayResult[$idx0][$indexesToGroup[0]]);
                        unset($indexesKeys[1][$idx0][$idx1]);
                        $indexesKeys[1][$idx0] = array_values($indexesKeys[1][$idx0]);
                    }
                }
                if(isset($indexesToGroup[0]) && $indexesToGroup[0] !== '') {
                    if(empty($arrayResult[$idx0][$indexesToGroup[0]])) {
                        unset($arrayResult[$idx0]);
                        $arrayResult = array_values($arrayResult);
                        unset($indexesKeys[0][$idx0]);
                        $indexesKeys[0] = array_values($indexesKeys[0]);
                    }
                }
            }

        }



        return $arrayResult;
    }

    /**
     * Groups an array into arrays by a given key, or set of keys, shared between all array members.
     *
     * @param array $array The array to have grouping performed on.
     * @param array $keysToGroup The array of key to group or split by
     * @param array $indexesToGroup The array of index to group or split by
     * @param array $indexesToSum The array of key attributes to sum
     * @param $isLastIteration
     *
     * @return array Returns a multidimensional array or `null` if `$key` is invalid.
     */
    public static function arrayGroupBy(
        array $array = [],
        array $keysToGroup = [],
        array $indexesToGroup = [],
        array $indexesToSum = [],
        $isLastIteration = false
    )
    {
        // Get the first array of keys
        $firstKeys = array_shift($keysToGroup);
        // Get the primary index
        $primaryKey = $firstKeys[self::IDX_PRIMARY];
        // Get the name of index to keep grouped data
        $indexToGroup = array_shift($indexesToGroup);
        // Load the new array, splitting by the target key

        $grouped = self::groupArrayByIndex(
            $array,
            $primaryKey,
            $firstKeys,
            $indexToGroup,
            $indexesToSum,
            $isLastIteration,
            $keysToGroup
        );

        // Recursively build a nested grouping if more parameters are supplied
        // Each grouped array value is grouped according to the next sequential key
        if (count($keysToGroup) > 0) {
            $lastIteration = count($keysToGroup) == 0;

            self::recursiveArrayGroupBy(
                $grouped,
                func_get_args(),
                $indexToGroup,
                $lastIteration,
                $keysToGroup
            );
        }

        return $grouped;
    }

    private static function groupArrayByIndex(
        $array,
        $primaryKey,
        $keys,
        $keyToGroup,
        $keysToSum,
        $isLastIteration = false,
        $remainsIndexesToGroup = []
    )
    {
        // Get if is a function
        $func = (
        !is_string($primaryKey) &&
        is_callable($primaryKey)
            ?
            $primaryKey :
            null
        );
        $grouped = [];

        foreach ($array as $value) {
            $key = null;
            if (is_callable($func)) {
                $key = call_user_func($func, $value);
            } elseif (is_object($value) && property_exists($value, $primaryKey)) {
                $key = $value->{$primaryKey};
            } elseif (isset($value[$primaryKey])) {
                $key = $value[$primaryKey];
            }

            if ($key === null) {
                continue;
            }

            if (count($keys) > 1) {
                foreach ($keys as $firstKey) {
                    // If some indexes have to be sum
                    if (in_array($firstKey, $keysToSum)) {
                        if (!isset($grouped[$key][$firstKey])) {
                            $grouped[$key][$firstKey] = 0;
                        }
                        $grouped[$key][$firstKey] += $value[$firstKey];
                    } else {
                        $grouped[$key][$firstKey] = $value[$firstKey];
                    }
                }
            }

            if ($keyToGroup) {
                $grouped[$key][$keyToGroup][] = $value;
            } elseif ($isLastIteration) {
                $grouped[$key][] = $value;
            } else {

            }

        }

        return $grouped;
    }

    private static function recursiveArrayGroupBy(
        &$grouped,
        $args,
        $indexToGroup,
        &$lastIteration,
        $remainsIndexesToGroup
    )
    {
        foreach ($grouped as $key => $value) {

            $params = array_merge(
                [
                    $value[$indexToGroup]
                ],
                array_slice($args, 1)
            );

            $params[] = $lastIteration;
            $params[] = $remainsIndexesToGroup;

            $grouped[$key][$indexToGroup] = call_user_func_array(
                __NAMESPACE__ . '\ArrayGroupBy::arrayGroupBy',
                $params
            );

            $grouped[$key][$indexToGroup] = array_values(
                $grouped[$key][$indexToGroup]
            );
        }

        return $grouped;
    }
}

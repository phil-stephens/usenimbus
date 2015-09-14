<?php

function filesystem()
{
    return app('storage');
}

/*
 * String-related functions
 */
function jsSafeString($str)
{
    return str_replace("\n", '\\n', addslashes($str));
}

function sanitizeStr($str, $separator = '')
{
    $q_separator = preg_quote($separator, '#');

    $trans = array(
        '&.+?;'                 => '',
        '[^a-z0-9 _-]'          => '',
        '\s+'                   => $separator,
        '('.$q_separator.')+'   => $separator
    );

    $str = strip_tags($str);

    foreach ($trans as $key => $val)
    {
        $str = preg_replace('#'.$key.'#i', $val, $str);
    }

    return trim(trim(strtolower($str), $separator));
}

function random_number_string($digits)
{
    $temp = '';

    for ($i = 0; $i < $digits; $i++) {
        $temp .= rand(0, 9);
    }

    return $temp;
}

/*
 * Number-related functions
 */
function byte_format($num, $precision = 1)
{
    if ($num >= 1000000000000)
    {
        $num = round($num / 1099511627776, $precision);
        $unit = 'TB';
    }
    elseif ($num >= 1000000000)
    {
        $num = round($num / 1073741824, $precision);
        $unit = 'GB';
    }
    elseif ($num >= 1000000)
    {
        $num = round($num / 1048576, $precision);
        $unit = 'MB';
    }
    elseif ($num >= 1000)
    {
        $num = round($num / 1024, $precision);
        $unit = 'KB';
    }
    else
    {
        $unit = 'B';
        return number_format($num).' '.$unit;
    }

    return number_format($num, $precision).' '.$unit;
}

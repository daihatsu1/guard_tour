<?php

function convert_bulan($params)
{
    $con = strtoupper($params);
    switch ($con) {
        case 'JANUARI':
            $bulan = '01';
            break;
        case 'FEBRUARI':
            $bulan = '02';
            break;
        case 'MARET':
            $bulan = '03';
            break;
        case 'APRIL':
            $bulan = '04';
            break;
        case 'MEI':
            $bulan = '05';
            break;
        case 'JUNI':
            $bulan = '06';
            break;
        case 'JULI':
            $bulan = '07';
            break;
        case 'AGUSTUS':
            $bulan = '08';
            break;
        case 'SEPTEMBER':
            $bulan = '09';
            break;
        case 'OKTOBER':
            $bulan = '10';
            break;
        case 'NOVEMBER':
            $bulan = '11';
            break;
        case 'DESEMBER':
            $bulan = '12';
            break;
        default:
            $bulan = "format bulan salah";
            break;
    }

    return $bulan;
}

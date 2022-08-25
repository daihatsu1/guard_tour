<?php

function convertbulanina($params)
{
    $con = strtoupper($params);
    switch ($con) {
        case '01':
            $bulan = 'JANUARI';
            break;
        case '02':
            $bulan = 'FEBRUARI';
            break;
        case '03':
            $bulan = 'MARET';
            break;
        case '04':
            $bulan = 'APRIL';
            break;
        case '05':
            $bulan = 'MEI';
            break;
        case '06':
            $bulan = 'JUNI';
            break;
        case '07':
            $bulan = 'JULI';
            break;
        case '08':
            $bulan = 'AGUSTUS';
            break;
        case '09':
            $bulan = 'SEPTEMBER';
            break;
        case '10':
            $bulan = 'OKTOBER';
            break;
        case '11':
            $bulan = 'NOVEMBER';
            break;
        case '12':
            $bulan = 'DESEMBER';
            break;
        default:
            $bulan = "format bulan salah";
            break;
    }

    return $bulan;
}

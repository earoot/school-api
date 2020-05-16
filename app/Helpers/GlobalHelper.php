<?php

function maskRut($rut)
{
  $rut = substr_replace($rut, ".", -7, 0);
  $rut = substr_replace($rut, ".", -4, 0);
  $rut = substr_replace($rut, "-", -1, 0);

  return $rut;
}

function clearRut($rut)
{
  $rut = str_replace(".", "", $rut);
  $rut = str_replace("-", "", $rut);

  return mb_strtoupper($rut);
}

function validateRut($rut)
{
    $rut = preg_replace('/[^k0-9]/i', '', $rut);
    $dv  = substr($rut, -1);
    $number = substr($rut, 0, strlen($rut)-1);
    $i = 2;
    $sum = 0;
    foreach(array_reverse(str_split($number)) as $v)
    {
        if($i==8)
            $i = 2;

        $sum += $v * $i;
        ++$i;
    }

    $dvr = 11 - ($sum % 11);

    if($dvr == 11)
        $dvr = 0;
    if($dvr == 10)
        $dvr = 'K';

    if($dvr == strtoupper($dv))
        return true;
    else
        return false;
}

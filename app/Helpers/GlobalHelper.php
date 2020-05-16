<?php

function maskRut($rut)
{
  $rut = substr_replace($rut, ".", -7, 0);
  $rut = substr_replace($rut, ".", -4, 0);
  $rut = substr_replace($rut, "-", -1, 0);

  return $rut;
}

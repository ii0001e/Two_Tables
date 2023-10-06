<?php
$serverinimi = "localhost";
$kasutajanimi = "ivanivanenko";
$parool = "556625";
$andmebaas = "ivanivanenko";
$yhendus = new mysqli($serverinimi,$kasutajanimi,$parool,$andmebaas);
$yhendus -> set_charset("UTF8");

<?php

use GoodCode\Distance;

include "../vendor/autoload.php";


$distance = Distance::measure(200.056);


echo sprintf("My distance has %.2f meters as value", $distance->meters());

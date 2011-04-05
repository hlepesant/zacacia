<?php
/*
 *
 */

 $colors = Array(
    '000000',
    '896969',
    '222222',
    'eeeeee',
    'cc4444',
    'fff4f4',
    'ffffea',
    'fffff0',
    'e09010',
    'f0c020',
    '008000',
    '00aa00',
    '0072b9',
    '00375a',
    '004a73',
    'edf1f3',
    'dddddd',
    'efefef',
    '666666',
    '999999',
    'c7e7fc',
    'f8f8f8',
    'c0c0c0',
    '7dbbe2',
    'ffffff',
    '131f5b',
    '00245e',
    '00255c',
    '00245b',
    '404040',
    '4e95fe',
    '79b9e2',
    '01265b',
    '333333',
    '99ff66',
    '220000',
    '339900' 
 );

 $nbc = count($colors);
 $i = 0;
 ?>
 <html>
 <head>
 <title>Combo Color Zacacia</title>
 </head>
 <body>
 <?php for ( $i; $i < $nbc; $i++ ) : ?>
 <div id="color<?php echo $i ?>" style="clear: both; height: 22px; width: 200px; padding: 1px;">
 <div style="background-color: <?php echo $colors[ $i ] ?>;width: 100px; height: 20px; border: 1px solid #000000; float: left;"></div>
 <div style="background-color: #FFFFFF;width: 90px; height: 20px; border: 1px solid #000000; float: left; text-align: right; font-size: 12px;">#<?php echo strtoupper($colors[ $i ]) ?></div>
 </div>
 <?php
 endfor;
 ?>
 </body>
 </html>

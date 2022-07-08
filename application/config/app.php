<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$app['actDefault'] = 'D';
$app['actList'] = ['D'=>'datang','P'=>'pergi','S'=>'stop','E'=>'selesai'];
$app['provinsi'] = ['31'=>'DKI Jakarta','33'=>'Jawa Tengah',
'34'=>'Di Yogyakarta',
'35'=>'Jawa Timur',
'36'=>'Banten',
'51'=>'Bali',
'52'=>'Nusa Tenggara Barat',
'53'=>'Nusa Tenggara Timur',
'61'=>'Kalimantan Barat',
'62'=>'Kalimantan Tengah'];
$app['provinsiDefault'] = '31';
$app['pmiInNews'] = ['id'=>'1.nik001','act'=>'D',
'id'=>'1.nik002','act'=>'D',
'id'=>'1.nik003','act'=>'P',
'id'=>'1.nik004','act'=>'P',
'id'=>'2.nik005','act'=>'D',
'id'=>'2.nik006','act'=>'S',
'id'=>'2.nik007','act'=>'E'];
$app['pmiKronologi'] = ['2.nik006.34'=>['tiba di jogja','stop di jogja'],
'2.nik007.35'=>['tiba di Jatim','stop di Jatim','selesai di Jatim'],
'1.nik003.31'=>['tiba di Jakarta'],
'1.nik005.61'=>['tiba di Kalimantan Barat','pergi dari Kalimantan Barat']];


$config = $app;
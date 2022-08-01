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
$app['pmiInNews'] = [['id'=>'1.nik001','act'=>'P0'],
['id'=>'1.nik002','act'=>'P'],
['id'=>'1.nik003','act'=>'D'],
['id'=>'2.nik006','act'=>'S'],
['id'=>'2.nik007','act'=>'E']];
$app['pmiKronologi'] = ['1.nik002.34'=>['P0->D:tiba di jogja','D->P:berangkat dari jogja'],
'1.nik003.31'=>['P0->D:tiba di Jakarta'],
'2.nik006.31'=>['P0->D:tiba di Jakarta','D->S:tujuan akhir di jakarta'],
'2.nik007.61'=>['P0->D:tiba di Kalimantan Barat','D->P:pergi dari Kalimantan Barat'],
'2.nik007.36'=>['P->D:tiba di Banten','D->S:tujuan akhir di Banten','S->E:selesai di Banten']
];
$app['statusDesc'] = [
    'P0'=>'bertolak pulang',
    'D'=>'tiba',
    'P'=>'bertolak menuju tujuan berikutnya',
    'S'=>'sampai di tujuan',
    'E'=>'pemulangan selesai'
];


$config = $app;
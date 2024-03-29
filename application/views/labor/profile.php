<? //var_dump($config);
$GLOBALS['C'] = $config;
function write_val($key,$j,$deep=FALSE){
    $config = $GLOBALS['C'];
    if($deep){
        switch($key){
            case 'TK-jenis_pekerjaan' : $key = 'jenis_profesi'; break;
            case 'TK-negara' : $key = 'negara'; break;
            default : return $j; break;
        }
    }
    return isset($config[$key][$j])?$config[$key][$j]:write_val($key,$j,TRUE); 
}

$J = json_decode($d['json_v'],true)?>
<section class="content" id="app">
    <div>
    <div class="col-md-12">
    <div class="box box-widget widget-user-2">
    <!-- Add the bg color to the header using any of the bg-* classes -->
    <div class="widget-user-header bg-<?= $J['jenis_kelamin'] == 'L'?'blue':'purple'?>">
        <div class="widget-user-image">
        <? /*<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">*/?>
        </div>
        <!-- /.widget-user-image -->
        <h3 class="widget-user-username"><?= $d['nama']?></h3>
        <h5 class="widget-user-desc"></h5>
    </div>
    
    <div class="box-body">
                <table class="table table-hover">
                    <tr> <th>NIK</th> <th><?= $d['nik']?></th> </tr>
                    <?foreach($J as $key=>$j){
                        ?><tr> <th><?= ucwords(str_replace(['-','_'],' ',$key))?></th> <th><?= write_val($key,$j)?></th> </tr><?
                    }?>
                </table>
    </div>
    <div class="box-footer">
            <a href="<?=BASEURL?>/labor" class="btn btn-primary">Kembali</a>
            </div>
    </div>
    </div>
</div>   
</section> 
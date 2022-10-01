<section class="content-header">
    <div class="row">
    <div class="col-md-12">
<ul class="timeline">
    <?foreach($d as $v){ $J = json_decode($v['desc'],true);
        $R = [];
        array_walk($J,function($v,$k) use (&$R){
            if(!in_array($k,['rute','tanggal_tindak_lanjut'])) $R[$k] = $v;
        });
        ?>
    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-red"><?= date_format(date_create($v['created_at']),"d-m-Y")?></span>
    </li>
    <!-- /.timeline-label -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-envelope bg-blue"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> <?= date_format(date_create($v['created_at']),"H:i")?></span>

            <h3 class="timeline-header"><a href="#"><?= $this->config->item('statusDesc')[$v['status_kronologi']]?></a></h3>

            <div class="timeline-body">
                <?array_walk($R,function($v,$k){echo $k.' : '.$v.'<br>';});?>
            </div>

            <div class="timeline-footer"></div>
        </div>
    </li>
    <!-- timeline item -->
    <?}?>
    

    <li class="time-label">
        <span class="bg-red"><?= date_format(date_create($d0['created_at']),"d-m-Y")?></span>
    </li>
    <!-- /.timeline-label -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-envelope bg-blue"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> <?= date_format(date_create($d0['created_at']),"H:i")?></span>

            <h3 class="timeline-header"><a href="#"><?= $this->config->item('statusDesc')['P0']?></a></h3>

            <div class="timeline-body">
                
            </div>

            <div class="timeline-footer"></div>
        </div>
    </li>
    
</ul>
</div>
</div>
</section>
<section class="content" id="app">
    <div>
    <div class="col-md-12">
    <div class="box box-widget widget-user-2">
    <!-- Add the bg color to the header using any of the bg-* classes -->
    <div class="widget-user-header bg-<?= $d['jenis_kelamin'] == 'L'?'blue':'purple'?>">
        <div class="widget-user-image">
        <? /*<img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">*/?>
        </div>
        <!-- /.widget-user-image -->
        <h3 class="widget-user-username"><?= $d['nama']?></h3>
        <h5 class="widget-user-desc"></h5>
    </div>
    <div class="box-footer no-padding">
        <ul class="nav nav-stacked">
        <li>
            <div style="padding: 10px 15px;">
            <h5 class="description-header">NKK</h5>
            <span class="description-text"><?= $d['nomor_kk']?></span>
            </div>
        </li>
        <li>
            <div style="padding: 10px 15px;">
            <h5 class="description-header">NIK</h5>
            <span class="description-text"><?= $d['nik']?></span>
            </div>
        <li>
            <div style="padding: 10px 15px;">
            <h5 class="description-header">ALAMAT</h5>
            <span class="description-text"><?= $d['alamat_jalan']?></span>
            </div>
        </li>
        </ul>
    </div>
    </div>
    </div>
</div>   
</section> 
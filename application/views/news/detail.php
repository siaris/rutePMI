<section class="content-header"><h1>Detail Berita Kepulangan</h1>
</section>
<section class="content">
  <div class="row">
      <form action="" method="post">
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Detail Berita Kepulangan</h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <?
          $J = json_decode($news['json_v'],true);
          ?>
          <form role="form">
            <div class="box-body">
                <table class="table table-hover">
                    <tr> <th>Nomor Berita</th> <th><?= $news['judul']?></th> </tr>
                    <tr> <th>Negara Penempatan</th> <th><?= config_item('negara')[$J['negara']]?></th> </tr>
                    <tr> <th>Sumber Berita</th> <th><?= 'BP2MI'?></th> </tr>
                    <tr> <th>Media Berita</th> <th><?= $J['media_berita']?></th> </tr>
                    <tr> <th>Jenis Berita</th> <th><?= 'Berita Kepulangan'?></th> </tr>
                    <tr> <th>Perwakilan RI</th> <th><?= $J['perwakilan_sumber_referensi']?></th> </tr>
                    <tr> <th>Jenis Kepulangan</th> <th><?= 'Campuran (Bervariasi)'?></th> </tr>
                    <tr> <th>Tanggal Dokumen</th> <th><?= $J['tgl_dokumen']?></th> </tr>
                    <tr> <th>Tanggal Input</th> <th><?= date($news['created_at'])?></th> </tr>
                    <tr> <th>Input Oleh</th> <th><?= 'User'?></th> </tr>
                    <tr> <th>Terakhir Diupdate</th> <th><?= date($news['updated_at'])?></th> </tr>
                </table>
            </div>
            <div class="box-header with-border"> <h3 class="box-title">Perihal Berita</h3> </div>
            <div class="box-body"> <?= $news['deskripsi']?></div>
            <!-- /.box-body -->

            <div class="box-footer">
            <a href="<?=BASEURL?>/news" class="btn btn-primary">Kembali</a>
            </div>
          </form>
        </div>
        <!-- /.box -->
      </div>
      </form>
  </div>
</section>
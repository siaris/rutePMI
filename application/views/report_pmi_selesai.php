<section class="content">
<div class="col-xs-12 col-sm-12">
    <div class="box">
        <div class="box-content">
        <h3 class="page-header">PMI Selesai Dipulangkan</h3>    
        <?/*
        <form name="form_search"  class="form-horizontal o" method="post" action="">
            <div class="row">
                <div class="col-xs-8">
                    <label class="col-sm-3 control-label">Nama</label>
                    <div class="col-sm-8">
                        <input type="text" name="nama" id="nama" placeholder="Nama" value="<?php echo (isset($_POST['nama']) ? $_POST['nama'] : '') ; ?>" autocomplete="off" class="form-control" />
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-xs-8">
            <label class="col-sm-3 control-label"></label>
                <input class="btn btn-primary" type="submit" value="View" style="margin-bottom:10px; margin-left:155px;">
                <input class="btn btn-primary" name="print" value="Print" type="button" style="margin-bottom:10px; margin-left:155px;">
            </div>
            </div>
        </form>
        */?>

        <div style="overflow-y:auto;">
        <div id="toPrint">
			<table id="tblExport" width="100%"><tr><td>
            <table class="table table-bordered table-condensed print" style="font-size:12px;" >
            <thead><tr>
				  <th><center>No.</center></th>
					<th><center>No Identitas</center></th>
					<th><center>Nama PMI</center></th>
					<th><center>Jenis Kelamin</center></th>
					<th><center>Deskripsi Masalah</center></th>
					<th><center>Status Kepulangan</center></th>
					<th><center>UPT Pelaksana</center></th>
					<th><center>Tanggal Proses</center></th>
					<th><center>Sumber Info Kepulangan</center></th>
				</tr>

					 </thead>
                     <tbody>
                         <? if(!empty($R)){
                             foreach($R as $k=>$r){ $JL = json_decode($r['l_json_v'],true);$JN = json_decode($r['json_v'],true);?>
                             <tr>
                                 <td><?= ($k + 1)?></td>
                                 <td><?= $r['nik']?></td>
                                 <td><?= $r['nama']?></td>
                                 <td><?= $this->config->item('jenis_kelamin')[$JL['jenis_kelamin']]?></td>
                                 <td>-</td>
                                 <td><?= $this->config->item('statusDesc')[$r['status']]?></td>
                                 <td>-</td>
                                 <td>-</td>
                                 <td>-</td>
                             </tr>
                             <?}}?>    
                    </tbody>    
            </table>
            </table>
            </div>
            <div class="col-xs-8">
            <label class="col-sm-3 control-label"></label>
                <input class="btn btn-primary" name="print" value="Print" type="button" style="margin-bottom:10px; margin-left:155px;">
            </div>
        </div>
    </div>
</div>
</section>
<script>
    var printClicked = function(){
        function inti(){
            $('[name="print"]').click(function(){
                var head = $('.page-header').clone()
                var printContents = $("#toPrint").clone()
                var myWindow = window.open("", "popup","width=1000,height=600,scrollbars=yes,resizable=yes," +  
                "toolbar=no,directories=no,location=no,menubar=no,status=no,left=0,top=0");
                var doc = myWindow.document;
                doc.open();
                var css = `<link rel="stylesheet" href="http://127.0.0.1/si-rt/components/bootstrap/dist/css/bootstrap.min.css">`
                doc.write($(printContents).prepend(head).prepend(css).html());
                doc.close();
            })
            return
        }
        return{
            init: inti
        }
    }()
$(document).ready(function () {
    printClicked.init()
})
</script>
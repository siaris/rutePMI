<section class="content">
<div class="col-xs-12 col-sm-12">
    <div class="box">
        <div class="box-content">
        <h3 class="page-header">Laporan Master Warga</h3>    
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

        <div id="toPrint" style="overflow-y:auto;">
			<table id="tblExport" width="100%"><tr><td>
            <table class="table table-bordered table-condensed print" style="font-size:12px;" >
            <thead><tr>
				  <th><center>NO.</center></th>
					<th><center>Nama</center></th>
					<th><center>NIK</center></th>
				</tr>

					 </thead>
                     <tbody>
                         <? if(!empty($R)){
                             foreach($R as $k=>$r){?>
                             <tr>
                                 <td><?= ($k + 1)?></td>
                                 <td><?= $r['nama']?></td>
                                 <td><?= $r['nik']?></td>
                             </tr>
                             <?}}?>    
                    </tbody>    
        </table>
            </table>
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
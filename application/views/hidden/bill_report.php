<section id="content" class="content">
<div class="box">
    <div class="box-content">
    <div id="toPrint" style="overflow-y:auto;">
			<table id="tblExport" width="100%"><tr><td>
            <table class="table table-bordered table-condensed print" style="font-size:12px;" >
            <thead><tr>
				  <th><center>NO.</center></th>
					<th><center>konten</center></th>
					<th><center>update</center></th>
				</tr>

					 </thead>
                     <tbody>
                         <? if(!empty($R)){
                             foreach($R as $k=>$r){?>
                             <tr>
                                 <td><?= ($k + 1)?></td>
                                 <td><?= $r['u_id']?></td>
                                 <td><?= $r['updated']?></td>
                             </tr>
                             <?}}?>    
                    </tbody>    
        </table>
            </table>
        </div>    
</div>
</div>
<span><?= $previous?></span>
</section>
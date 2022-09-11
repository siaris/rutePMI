<section class="content-header">
<h1><small>Staff <?= $allP[$my_province]?> melayani PMI:</small></h1>
<h1><small>{{pmi}}</small></h1>
</section>
<div class="col-md-12">
<div class="box box-primary">
<table class="table table-bordered table-condensed print">
    <tr><td>Nomor Surat</td><td>{{no_news}}</td>
    <tr><td>Perihal Kepulangan</td><td><div v-html="desc_news" /></td>
    <tr><td>Daftar PMI</td><td>{{list_pmi}}</td>
    </tr>
</table>
</div>
</div>
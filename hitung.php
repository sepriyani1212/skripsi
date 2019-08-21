<div class="page-header">
    <h1>Diagnosis</h1>
</div>
<form action="?m=hasil" method="post">
    <div class="panel panel-default">
        <div class="panel-heading">        
            <h3 class="panel-title">Pilih Gejala</h3>
        </div>
        <table class="table table-bordered table-hover table-striped">
        <thead>
            <tr>
                <th><input type="checkbox" id="checkAll" /></th>
                <th>No</th>
                <th>Nama Gejala</th>
            </tr>
        </thead>
        <?php
        $q = esc_field($_GET['q']);
        $rows = $db->get_results("SELECT * FROM tb_gejala ORDER BY kode_gejala");
        $no=1;
        foreach($rows as $row):?>
        <tr>
            <td><input type="checkbox" name="gejala[]" value="<?=$row->kode_gejala?>" /></td>
            <td><?=$no++?></td>
            <td><?=$row->nama_gejala?></td>
        </tr>
        <?php endforeach;
        ?>
        </table>
        <div class="panel-footer">
            <button class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Submit Penyakit</button>
        </div>
    </div>
</form>
<script>
$(function(){
    $("#checkAll").click(function(){
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
});
</script>
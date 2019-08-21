<?php
    $row = $db->get_row("SELECT * FROM tb_penyakit WHERE kode_penyakit='$_GET[ID]'"); 
?>
<div class="page-header">
    <h1>Ubah Penyakit</h1>
</div>
<div class="row">
    <div class="col-sm-6">
        <?php if($_POST) include'aksi.php'?>
        <form method="post">
            <div class="form-group">
                <label>Kode <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="kode" readonly="readonly" value="<?=$row->kode_penyakit?>"/>
            </div>
            <div class="form-group">
                <label>Nama Alternatif <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="nama" value="<?=$row->nama_penyakit?>"/>
            </div>
            <div class="form-group">
                <label>Penyebab </label>
                <i><select class="form-control" name="penyebab">
                <textarea class="form-control" name="penyebab"><?=set_value('penyebab', $row->penyebab)?></textarea>
                </select></i>
            </div>
            <div class="form-group">
                <label>Solusi</label>
                <textarea class="form-control" name="solusi"><?=set_value('solusi', $row->solusi)?></textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                <a class="btn btn-danger" href="?m=penyakit"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
            </div>
        </form>
    </div>
</div>
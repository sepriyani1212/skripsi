<?php
    $row = $db->get_row("SELECT * FROM tb_gejala WHERE kode_gejala='$_GET[ID]'"); 
?>
<div class="page-header">
    <h1>Ubah Gejala</h1>
</div>
<div class="row">
    <div class="col-sm-6">
        <?php if($_POST) include'aksi.php'?>
        <form method="post">
            <div class="form-group">
                <label>Kode <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="kode" readonly="readonly" value="<?=$row->kode_gejala?>"/>
            </div>
            <div class="form-group">
                <label>Nama Gejala <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="nama" value="<?=$row->nama_gejala?>"/>
            </div>
            <div class="form-group">
                <label>Bobot<span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="bobot" value="<?=$row->bobot?>"/>
            </div>
            <div class="form-group">
            <label class="control-label">Gambar</label>
            <input class="form-control" name="gambar" accept="image/*" type="file">
        </div>
      </div>
            <div class="form-group">
                <input type="submit"class="btn btn-primary" name="update" value="Update"></input>
                <a class="btn btn-danger" href="?m=gejala"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
            </div>
        </form>
    </div>
</div>
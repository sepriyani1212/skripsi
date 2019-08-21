<div class="page-header">
    <h1>Tambah Penyakit</h1>
</div>
<div class="row">
    <div class="col-sm-6">
        <?php if($_POST) include'aksi.php'?>
        <form method="post">
            <div class="form-group">
                <label>Kode <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="kode" value="<?=$_POST['kode']?>"/>
            </div>
            <div class="form-group">
                <label>Nama Penyakit <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="nama" value="<?=$_POST['nama']?>"/>
            </div>
            <div class="form-group">
                <label>Penyebab </label>
                <i><textarea class="form-control" name="penyebab"><?=set_value('penyebab')?></textarea></i>
            </div>
            <div class="form-group">
                <label>Solusi</label>
                <textarea class="form-control" name="solusi"><?=set_value('solusi')?></textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                <a class="btn btn-danger" href="?m=penyakit"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
            </div>
        </form>
    </div>
</div>
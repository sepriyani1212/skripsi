<div class="page-header">
    <h1>Ubah Kasus</h1>
</div>
<div class="row">
    <div class="col-sm-6">
        <?php 
        $kasus = $KASUS[$_GET['ID']];
        if($_POST) include'aksi.php'?>
        <form method="post">
            <div class="form-group">
                <label>Kode <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="kode_kasus" value="<?=$kasus->kode_kasus?>"/>
            </div>
            <div class="form-group">
                <label>Penyakit <span class="text-danger">*</span></label>
                <select class="form-control" name="kode_penyakit">
                    <option value=""></option>
                    <?=get_penyakit_option(set_value('kode_penyakit', $kasus->kode_penyakit))?>
                </select>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead><tr>
                        <th>No</th>
                        <th>Gejala</th>
                    </tr></thead>
                    <?php 
                    $no = 1;
                    foreach($GEJALA as $key => $val): ?>
                    <tr>
                        <td><?=$no++?></td>
                        <td>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="gejala[<?=$key?>]" value="<?=$key?>" <?=in_array($key, $kasus->gejala) ? 'checked' : ''?> /> [<?=$key?>] <?=$val->nama_gejala?>
                                </label>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach?>
                </table>
            </div>
            <div class="form-group">
                <button class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                <a class="btn btn-danger" href="?m=relasi"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
            </div>
        </form>
    </div>
</div>
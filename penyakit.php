<div class="page-header">
    <h1>Penyakit</h1>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <form class="form-inline">
            <input type="hidden" name="m" value="penyakit" />
            <div class="form-group">
                <input class="form-control" type="text" placeholder="Pencarian. . ." name="q" value="<?=$_GET['q']?>" />
            </div>
            <div class="form-group">
                <button class="btn btn-success"><span class="glyphicon glyphicon-refresh"></span> Refresh</button>
            </div>
            <div class="form-group">
                <a class="btn btn-primary" href="?m=penyakit_tambah"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
            </div>
        </form>
    </div>

    <table class="table table-bordered table-hover table-striped">
    <thead>
        <tr class="nw">
            <th>No</th>
            <th>Kode</th>
            <th>Nama Penyakit</th>            
            <th>Aksi</th>
        </tr>
    </thead>
    <?php
    $q = esc_field($_GET['q']);
    $rows = $db->get_results("SELECT * FROM tb_penyakit 
        WHERE kode_penyakit LIKE '%$q%' OR nama_penyakit LIKE '%$q%' OR penyebab LIKE '%$q%' 
        ORDER BY kode_penyakit");
    $no=0;

    foreach($rows as $row):?>
    <tr>
        <td><?=++$no ?></td>
        <td><?=$row->kode_penyakit?></td>
        <td><?=$row->nama_penyakit?></td>        
        <td class="nw">
            <a class="btn btn-xs btn-warning" href="?m=penyakit_ubah&ID=<?=$row->kode_penyakit?>"><span class="glyphicon glyphicon-edit"></span></a>
            <a class="btn btn-xs btn-danger" href="aksi.php?act=penyakit_hapus&ID=<?=$row->kode_penyakit?>" onclick="return confirm('Hapus data?')"><span class="glyphicon glyphicon-trash"></span></a>
        </td>
    </tr>
    <?php endforeach;?>
    </table>
</div>
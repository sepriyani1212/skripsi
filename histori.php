<div class="page-header">
    <h1>Histori Konsultasi</h1>
</div>
<div class="panel panel-default">
    <div class="panel-heading">        
        <form class="form-inline">
            <input type="hidden" name="m" value="histori" />
            <div class="form-group">
                <input class="form-control" type="text" placeholder="Pencarian. . ." name="q" value="<?=$_GET['q']?>" />
            </div>
            <div class="form-group">
                <button class="btn btn-success"><span class="glyphicon glyphicon-refresh"></span> Refresh</button>
            </div>
            <div class="form-group hidden">                                                        
                <a class="btn btn-primary" href="?m=produk_tambah"><span class="glyphicon glyphicon-plus"></span> Tambah</a>            
                <a class="btn btn-default" href="cetak.php?m=produk&q=<?=$_GET[q]?>" target="_blank"><span class="glyphicon glyphicon-plus"></span> Cetak</a>            
                <a class="btn btn-warning" href="excel.php?m=produk&q=<?=$_GET[q]?>" target="_top"><span class="glyphicon glyphicon-export"></span> Excel</a>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr class="nw">
                    <th>No</th>
                    <th>Waktu</th>
                    <th>Gejala</th>
                    <th>Penyakit</th>
                    <th>Hasil</th>
                </tr>
            </thead>
            <?php
            $q = esc_field($_GET['q']);
            $pg = new Paging();        
            $limit = 25;
            $offset = $pg->get_offset($limit, $_GET['page']);
            
            $where = "WHERE penyakit LIKE '%$q%'";
            $from = "FROM tb_histori";
            $rows = $db->get_results("SELECT * $from $where ORDER BY waktu DESC LIMIT $offset, $limit");
            
            $no = $offset;
            
            $jumrec = $db->get_var("SELECT COUNT(*) $from $where");
            
            foreach($rows as $row):?>
            <tr>
                <td><?=++$no?></td>
                <td><?=$row->waktu ?></td>
                <td><?=$row->gejala?></td>
                <td><?=$row->penyakit?></td>
                <td><?=round($row->hasil, 2)?></td>
            </tr>
            <?php endforeach;?>
        </table>
    </div>
    <div class="panel-footer">
        <ul class="pagination"><?=$pg->show("m=histori&q=$_GET[q]&page=", $jumrec, $limit, $_GET['page'])?></ul>
    </div>
</div>
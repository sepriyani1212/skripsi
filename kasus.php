<div class="page-header">
    <h1>Kasus</h1>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
	    <form class="form-inline">
	        <input type="hidden" name="m" value="kasus" />
	        <div class="form-group">
	            <input class="form-control" type="text" placeholder="Pencarian. . ." name="q" value="<?=$_GET['q']?>" />
	        </div>
	        <div class="form-group">
	            <button class="btn btn-success"><span class="glyphicon glyphicon-refresh"></span> Refresh</button>
	        </div>
	        <div class="form-group">
	            <a class="btn btn-primary" href="?m=kasus_tambah"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
	        </div>
	    </form>
	</div>
	<div class="table-responsive">	
		<table class="table table-bordered table-hover table-striped">
			<thead>
			    <tr class="nw">
			        <th>No</th>
			        <th>Penyakit</th>
			        <th>Gejala</th>
			        <th>Aksi</th>
			    </tr>
			</thead>
			<?php
			$q = esc_field($_GET['q']);

			$rows = $db->get_results("SELECT kode_kasus, k.kode_penyakit, nama_penyakit
			    FROM tb_kasus k INNER JOIN tb_penyakit d ON d.kode_penyakit=k.kode_penyakit
			    WHERE k.kode_kasus LIKE '%$q%'
			        OR k.kode_penyakit LIKE '%$q%'			        
			        OR d.nama_penyakit LIKE '%$q%' 
			    GROUP BY kode_kasus
			    ORDER BY k.kode_kasus");
			$no=0;

			foreach($rows as $row):?>
			<tr>
			    <td><?=$row->kode_kasus?></td>
			    <td><?=$row->nama_penyakit?></td>
			    <td><?=implode(', ', array_keys($KASUS[$row->kode_kasus]->gejala))?></td>
			    <td class="nw">
			        <a class="btn btn-xs btn-warning" href="?m=kasus_ubah&ID=<?=$row->kode_kasus?>"><span class="glyphicon glyphicon-edit"></span></a>
			        <a class="btn btn-xs btn-danger" href="aksi.php?act=kasus_hapus&ID=<?=$row->kode_kasus?>" onclick="return confirm('Hapus data?')"><span class="glyphicon glyphicon-trash"></span></a>
			    </td>
			</tr>
			<?php endforeach;
			?>
		</table>
	</div>
</div>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><a href="#c1" data-toggle="collapse">Perhitungan</a></h3>
	</div>
	<div class="panel-body collapse" id="c1">
		<?php
		//echo '<pre>';
		$cbr = new CBR($KASUS, $selected, $GEJALA);
		//echo '</pre>';?>
		<?php foreach($cbr->data as $kasus_key => $kasus_val):?>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><a href="#cbr_<?=$kasus_key?>" data-toggle="collapse">Kasus <?=$kasus_key?> (<?=$PENYAKIT[$KASUS[$kasus_key]->kode_penyakit]?>)</a></h3>
			</div>
			<div class="table-responsive collapse" id="cbr_<?=$kasus_key?>">
				<table class="table table-bordered">
					<thead><tr>
						<th>No</th>
						<th>Gejala1</th>
						<th>Gejala2</th>
						<th>Similarity</th>
						<th>Bobot</th>
						<th>Kali</th>
					</tr></thead>
					<?php 
					$no = 1;
					foreach($kasus_val as $key => $val):?>
					<tr>
						<td><?=$no++?></td>
						<td><?=$val['kode1']?></td>
						<td><?=$val['kode2']?></td>
						<td><?=$val['similarity']?></td>
						<td><?=$val['bobot']?></td>
						<td><?=$val['kali']?></td>
					</tr>
					<?php endforeach?>
					<tfoot><tr>
						<td colspan="4">Total</td>
						<td><?=$cbr->total[$kasus_key]['bobot']?></td>
						<td><?=$cbr->total[$kasus_key]['kali']?></td>
					</tr></tfoot>
				</table>
			</div>
			<div class="panel-footer">
				Total: <?=round($cbr->total[$kasus_key]['similarity'] * 100, 2)?>%
			</div>
		</div>
	<?php endforeach?>	
	</div>
</div>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><a href="#c2" data-toggle="collapse">Hasil Akhir</a></h3>
	</div>
	<div class="table-responsive collapse in" id="c2">
		<table class="table table-bordered">
			<thead><tr>
				<th>Kode</th>
				<th>Nama</th>
				<th>Similarity</th>
			</tr></thead>
			<?php 
			$no = 1;
			foreach($cbr->total as $key => $val):
				if($val['similarity']):?>
			<tr>
				<td><?=$no++?></td>
				<td><?=$PENYAKIT[$KASUS[$key]->kode_penyakit]?></td>
				<td><?=round($val['similarity'] * 100, 2)?>%</td>
			</tr>
			<?php endif; endforeach?>
		</table>
	</div>
</div>
<?php 

$kode_penyakit = $KASUS[$cbr->hasil['key']]->kode_penyakit;

$penyakit = $PENYAKIT[$kode_penyakit];
$hasil = $cbr->hasil['val'];

$db->query("INSERT INTO tb_histori (waktu, gejala, penyakit, hasil) VALUES (NOW(), '".implode(', ', $selected)."', '$penyakit', '$hasil')");

$row = $db->get_row("SELECT * FROM tb_penyakit WHERE kode_penyakit='$kode_penyakit'");

?>
Nilai terbesar adalah <b><?=round($hasil * 100, 3)?> %</b>, maka didapatkan hasil <b><?=$penyakit?></b>.

<h3><?=$row->nama_penyakit?></h3>
<p><b>Penyebab:</b> <i><?=$row->penyebab?></i></p>
<p><b>Solusi</b>: <i><?=$row->solusi?></i></p>
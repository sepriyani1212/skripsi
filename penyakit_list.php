<div class="page-header">
    <h1>Daftar Penyakit</h1>
</div>
<?php

$q = esc_field($_GET['q']);
$rows = $db->get_results("SELECT * FROM tb_penyakit 
    WHERE kode_penyakit LIKE '%$q%' OR nama_penyakit LIKE '%$q%' OR penyebab LIKE '%$q%' 
    ORDER BY kode_penyakit");
$no=0;

foreach($rows as $row):?>
<h3><?=$row->nama_penyakit?></h3>        
<h4>Penyebab</h4>
<i><p><?=$row->penyebab?></p></i>
<h4>Solusi</h4>
<p><?=$row->solusi?></p>
<hr>
<?php endforeach?>
<?php
require_once'functions.php';
$demo = false;

/** LOGIN */ 
if ($mod=='login'){
    $user = esc_field($_POST['user']);
    $pass = esc_field($_POST['pass']);
    
    $row = $db->get_row("SELECT * FROM tb_admin WHERE user='$user' AND pass='$pass'");
    if($row){
        $_SESSION['login'] = $row->user;
        redirect_js("index.php");
    } else{
        print_msg("Salah kombinasi username dan password.");
    }          
}else if ($mod=='password'){
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    $pass3 = $_POST['pass3'];
    
    $row = $db->get_row("SELECT * FROM tb_admin WHERE user='$_SESSION[login]' AND pass='$pass1'");        
    
    if($pass1=='' || $pass2=='' || $pass3=='')
        print_msg('Field bertanda * harus diisi.');
    elseif(!$row)
        print_msg('Password lama salah.');
    elseif( $pass2 != $pass3 )
        print_msg('Password baru dan konfirmasi password baru tidak sama.');
    else{        
        $db->query("UPDATE tb_admin SET pass='$pass2' WHERE user='$_SESSION[login]'");                    
        print_msg('Password berhasil diubah.', 'success');
    }
} elseif($act=='logout'){
    unset($_SESSION['login']);
    header("location:index.php");
}

/** penyakit */
elseif($mod=='penyakit_tambah'){
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $penyebab = $_POST['penyebab'];
    $solusi = $_POST['solusi'];

    if($kode=='' || $nama=='')
        print_msg("Field yang bertanda * tidak boleh kosong!");
    elseif($db->get_results("SELECT * FROM tb_penyakit WHERE kode_penyakit='$kode'"))
        print_msg("Kode sudah ada!");
    else{
        $db->query("INSERT INTO tb_penyakit (kode_penyakit, nama_penyakit, penyebab, solusi) 
            VALUES ('$kode', '$nama', '$penyebab', '$solusi')");                       
        redirect_js("index.php?m=penyakit");
    }
} else if($mod=='penyakit_ubah'){
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $penyebab = $_POST['penyebab'];
    $solusi = $_POST['solusi'];

    if($kode=='' || $nama=='')
        print_msg("Field yang bertanda * tidak boleh kosong!");
    else{
        $db->query("UPDATE tb_penyakit SET nama_penyakit='$nama', penyebab='$penyebab', solusi='$solusi' WHERE kode_penyakit='$_GET[ID]'");
        redirect_js("index.php?m=penyakit");
    }
} else if ($act=='penyakit_hapus'){
    $db->query("DELETE FROM tb_penyakit WHERE kode_penyakit='$_GET[ID]'");    
    $db->query("DELETE FROM tb_kasus WHERE kode_penyakit='$_GET[ID]'");
    header("location:index.php?m=penyakit");
} 

/** gejala */    
elseif($mod=='gejala_tambah'){
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $bobot = $_POST['bobot'];
    
    if(!$kode || !$nama || !$bobot)
        print_msg("Field bertanda * tidak boleh kosong!");

    elseif($db->get_results("SELECT * FROM tb_gejala WHERE kode_gejala='$kode'"))
        print_msg("Kode sudah ada!");

    else{
        $db->query("INSERT INTO tb_gejala (kode_gejala, nama_gejala,gambar, bobot) VALUES ('$kode', '$nama','gambar', '$bobot')");
        

        if($_POST['upload']){
            $ekstensi_diperbolehkan = array('png','jpg');
            $nama = $_FILES['gambar']['name'];
            $x = explode('.', $nama);
            $ekstensi = strtolower(end($x));
            $ukuran = $_FILES['gambar']['size'];
            $file_tmp = $_FILES['gambar']['tmp_name'];  
            move_uploaded_file($file_tmp, 'gambar/'.$nama);                 
        }

        redirect_js("index.php?m=gejala");

    }                    
} else if($mod=='gejala_ubah'){
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $bobot = $_POST['bobot'];
    

    
    if(!$kode || !$nama || !$bobot)
        print_msg("Field bertanda * tidak boleh kosong!");
    else{
        $db->query("UPDATE tb_gejala SET nama_gejala='$nama', bobot='$bobot' WHERE kode_gejala='$_GET[ID]'");

    if($_POST['update']){
            $ekstensi_diperbolehkan = array('png','jpg');
            $nama = $_FILES['gambar']['name'];
            $x = explode('.', $nama);
            $ekstensi = strtolower(end($x));
            $ukuran = $_FILES['gambar']['size'];
            $file_tmp = $_FILES['gambar']['tmp_name'];  
            move_uploaded_file($file_tmp, 'gambar/'.$nama);                 
        }    
        redirect_js("index.php?m=gejala");
    }    
} else if ($act=='gejala_hapus'){
    $db->query("DELETE FROM tb_gejala WHERE kode_gejala='$_GET[ID]'");
    $db->query("DELETE FROM tb_kasus WHERE kode_gejala='$_GET[ID]'");
    header("location:index.php?m=gejala");
}     

/** kasus */ 
else if ($mod=='kasus_tambah'){
    $kode_kasus = $_POST['kode_kasus'];
    $kode_penyakit = $_POST['kode_penyakit'];
    $gejala = $_POST['gejala'];
    
    if($kode_kasus=='' || $kode_penyakit=='')
        print_msg("Field bertanda * tidak boleh kosong!");
    elseif($db->get_results("SELECT * FROM tb_kasus WHERE kode_kasus='$kode_kasus'"))
        print_msg("Kode kasus sudah ada!");
    elseif(!$gejala)
        print_msg("Silahkan pilih gejala");
    else{        
        foreach($gejala as $key => $val){
            $db->query("INSERT INTO tb_kasus (kode_kasus, kode_penyakit, kode_gejala) 
                VALUES ('$kode_kasus', '$kode_penyakit', '$key')");
        }        
        redirect_js("index.php?m=kasus");
    }   
}else if ($mod=='kasus_ubah'){
    $kode_kasus = $_POST['kode_kasus'];
    $kode_penyakit = $_POST['kode_penyakit'];
    $gejala = $_POST['gejala'];
    
    if($kode_kasus=='' || $kode_penyakit=='')
        print_msg("Field bertanda * tidak boleh kosong!");
    elseif(!$gejala)
        print_msg("Silahkan pilih gejala");
    else{
        $db->query("DELETE FROM tb_kasus WHERE kode_kasus='$kode_kasus'");
        foreach($gejala as $key => $val){
            $db->query("INSERT INTO tb_kasus (kode_kasus, kode_penyakit, kode_gejala) 
                VALUES ('$kode_kasus', '$kode_penyakit', '$key')");
        }  
        redirect_js("index.php?m=kasus");
    }  
    header("location:index.php?m=kasus");
} else if ($act=='kasus_hapus'){
    $db->query("DELETE FROM tb_kasus WHERE kode_kasus='$_GET[ID]'");
    header("location:index.php?m=kasus");
}     
?>

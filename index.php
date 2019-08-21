<?php
include'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="description" content="Sistem pakar metode Dempster Shafer berbasis web dengan PHP dan MySQL. Studi kasus: menpenyakit penyakit pada manusia."/>
    <meta name="keywords" content="Sistem Pakar, Dempster Shafer, Penyakit Penyakit, Tugas Akhir, Skripsi, Jurnal, Source Code, PHP, MySQL, CSS, JavaScript, Bootstrap, jQuery"/>
    <meta name="author" content="tugasakhir.id"/>
    <link rel="icon" href="assets/favicon.ico"/>

    <title>Sistem Pakar Metode Case Base Reasoning</title>
    <link href="assets/css/simplex-bootstrap.min.css" rel="stylesheet"/>
    <link href="assets/css/general.css" rel="stylesheet"/>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>           
  </head>
  <body>
    <div class="wrapper">
      <div class="header">
        <div class="row">
          <div class="col-md-3">
            <img src="assets/images/test1.jpg" height="195px">
          </div>
          <div class="col-md-9">
            
            
          </div>
        </div>
      </div>
      <nav class="navbar navbar-default navbar-static-top">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="?">Home</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <?php if($_SESSION['login']):?>
              <li><a href="?m=penyakit"><span class="glyphicon glyphicon-pushpin"></span> Penyakit</a></li>
              <li><a href="?m=gejala"><span class="glyphicon glyphicon-flash"></span> Gejala</a></li>
              <li><a href="?m=kasus"><span class="glyphicon glyphicon-time"></span> Kasus</a></li> 
              <li><a href="?m=hitung"><span class="glyphicon glyphicon-stats"></span> Hitung</a></li>  
              <li><a href="?m=password"><span class="glyphicon glyphicon-lock"></span> Password</a></li>
              <li><a href="aksi.php?act=logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>  
              <?php else:?>            
              <li><a href="?m=hitung"><span class="glyphicon glyphicon-stats"></span> Diagnosis</a></li> 
              <li><a href="?m=penyakit_list"><span class="glyphicon glyphicon-th"></span> Daftar Penyakit</a></li>
              <li><a href="?m=bantuan"><span class="glyphicon glyphicon-th-large"></span> Bantuan</a></li>
              <li><a href="?m=tentang"><span class="glyphicon glyphicon-th-list"></span> Tentang</a></li> 
              <li><a href="?m=login"><span class="glyphicon glyphicon-log-in"></span> Login</a></li> 
              <?php endif?>          
            </ul>          
          </div>
        </div>
      </nav>
      <div class="container-fluid content">
      <?php
          if(file_exists($mod.'.php'))
              include $mod.'.php';
          else
              include 'home.php';
      ?>
      </div>
      <footer class="footer">
        <div class="container-fluid">
          <p>Copyright &copy; <?=date('Y')?> Sepriyani Ilmu Komputer Unila <em class="pull-right"></em></p>
        </div>
      </footer>
    </div>
  </body>
</html>
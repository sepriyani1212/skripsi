<?php
error_reporting(~E_NOTICE);
session_start();

include'config.php';
include'includes/db.php';
include'includes/paging.php';
$db = new DB($config['server'], $config['username'], $config['password'], $config['database_name']);
    
$mod = $_GET['m'];
$act = $_GET['act'];

$GEJALA  = array();
$rows = $db->get_results("SELECT * FROM tb_gejala ORDER BY kode_gejala");
foreach ($rows as $row) {
    $GEJALA[$row->kode_gejala] = $row;
}

$PENYAKIT  = array();
$rows = $db->get_results("SELECT * FROM tb_penyakit ORDER BY kode_penyakit");
foreach ($rows as $row) {
    $PENYAKIT[$row->kode_penyakit] = $row->nama_penyakit;
}

$KASUS  = array();
$rows = $db->get_results("SELECT * FROM tb_kasus ORDER BY kode_kasus, kode_gejala");
foreach ($rows as $row) {
    if(!isset($KASUS[$row->kode_kasus])){
        $KASUS[$row->kode_kasus] = new Kasus();
        $KASUS[$row->kode_kasus]->kode_kasus = $row->kode_kasus;
        $KASUS[$row->kode_kasus]->kode_penyakit = $row->kode_penyakit;
    }    

    $KASUS[$row->kode_kasus]->gejala[$row->kode_gejala] = $row->kode_gejala;
}

class Kasus{
    public $kode_kasus;
    public $kode_penyakit;
    public $gejala;
}

class CBR{
    public $kasus;
    public $selected;
    private $gejala;

    function __construct($kasus, $selected, $gejala){
        $this->kasus = $kasus;
        $this->selected = $selected;
        $this->gejala = $gejala;

        $this->hitung();
        $this->total();
        $this->hasil();
    }
    function hasil(){
        $arr = array();
        foreach($this->total as $key => $val){
            $arr[$key] = $val['similarity'];
        }

        $keys = array_keys($arr, max($arr));

        $this->hasil['key'] = $keys[0];
        $this->hasil['val'] = max($arr);

        //print_r($this->hasil);
    }
    function total(){
        $arr = array();
        foreach($this->data as $key => $val){
            foreach($val as $k => $v){
                $arr[$key]['kali']+=$v['kali'];
                $arr[$key]['bobot']+=$v['bobot'];
            }
            $arr[$key]['similarity'] = $arr[$key]['kali'] / $arr[$key]['bobot'];
        }
        $this->total = $arr;
    }

    function hitung(){
        $arr = array();
        foreach($this->kasus as $key => $val){
            foreach($this->gejala as $k => $v){   
                if(in_array($k, array_keys($val->gejala)) || in_array($k, $this->selected)){
                    $kode1 = in_array($k, array_keys($val->gejala)) ? $k : null;
                    $kode2 = in_array($k, $this->selected) ? $k : null;
                    $similarity = $kode1==$kode2 ? 1 : 0;

                    $arr[$key][] = array(
                        'kode1' => $kode1,
                        'kode2' => $kode2,
                        'similarity' => $similarity,
                        'bobot' => $v->bobot,
                        'kali' => $similarity * $v->bobot,
                    );
                }                           
            }
        }
        $this->data = $arr;
    }
}

function set_value($key = null, $default = null){
    global $_POST;
    if(isset($_POST[$key]))
        return $_POST[$key];

    if(isset($_GET[$key]))
        return $_GET[$key];

    return $default;
}

function kode_oto($field, $table, $prefix, $length){
    global $db;
    $var = $db->get_var("SELECT $field FROM $table WHERE $field REGEXP '{$prefix}[0-9]{{$length}}' ORDER BY $field DESC");
    if($var){
        return $prefix . substr( str_repeat('0', $length) . (substr($var, - $length) + 1), - $length );
    } else {
        return $prefix . str_repeat('0', $length - 1) . 1;
    }
}

function get_words($str, $limit = 20){
    $str = strip_tags($str);
    $str_arr = explode(' ', $str, $limit + 1);
    
    if(count($str_arr) > $limit){
        array_pop($str_arr);
        $str = implode(' ', $str_arr) . '. . .';    
    } else {
        $str = implode(' ', $str_arr);
    }
    return $str;
}
    
function esc_field($str){
    if (!get_magic_quotes_gpc())
        return addslashes($str);
    else
        return $str;
}

function redirect_js($url){
    echo '<script type="text/javascript">window.location.replace("'.$url.'");</script>';
}

function alert($url){
    echo '<script type="text/javascript">alert("'.$url.'");</script>';
}

function print_msg($msg, $type = 'danger'){
    echo('<div class="alert alert-'.$type.' alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.$msg.'</div>');
}

function get_penyakit_option($selected = ''){
    global $db;
    $rows = $db->get_results("SELECT kode_penyakit, nama_penyakit FROM tb_penyakit ORDER BY kode_penyakit");
    foreach($rows as $row){
        if($row->kode_penyakit==$selected)
            $a.="<option value='$row->kode_penyakit' selected>[$row->kode_penyakit] $row->nama_penyakit</option>";
        else
            $a.="<option value='$row->kode_penyakit'>[$row->kode_penyakit] $row->nama_penyakit</option>";
    }
    return $a;
}

function get_gejala_option($selected = ''){
    global $db;
    $rows = $db->get_results("SELECT kode_gejala, nama_gejala FROM tb_gejala ORDER BY kode_gejala");
    foreach($rows as $row){
        if($row->kode_gejala==$selected)
            $a.="<option value='$row->kode_gejala' selected>[$row->kode_gejala] $row->nama_gejala</option>";
        else
            $a.="<option value='$row->kode_gejala'>[$row->kode_gejala] $row->nama_gejala</option>";
    }
    return $a;
}

function get_penyebab_option($selected = ''){
    $arr = array(
        'Hama' => 'Hama',
        'Penyakit' => 'Penyakit',
    );
    foreach($arr as $key => $val){
        if($key==$selected)
            $a.="<option value='$key' selected>$val</option>";
        else
            $a.="<option value='$key'>$val</option>";
    }
    return $a;
}

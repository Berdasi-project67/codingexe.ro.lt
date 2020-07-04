<?php require_once('Connections/koneksi.php'); ?>
<?php
$cari = $_GET['cari'];

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_n = 10;
$pageNum_n = 0;
if (isset($_GET['pageNum_n'])) {
  $pageNum_n = $_GET['pageNum_n'];
}
$startRow_n = $pageNum_n * $maxRows_n;

mysql_select_db($database_koneksi, $koneksi);
$query_n = "SELECT nomor,NIM, NAM, `FOR`, UTS, UAS FROM nilai_bd";

if ($cari != "")
	$query_n .= " WHERE NAM LIKE '%$cari%'";

$query_limit_n = sprintf("%s LIMIT %d, %d", $query_n, $startRow_n, $maxRows_n);
$n = mysql_query($query_limit_n, $koneksi) or die(mysql_error());
$row_n = mysql_fetch_assoc($n);

if (isset($_GET['totalRows_n'])) {
  $totalRows_n = $_GET['totalRows_n'];
} else {
  $all_n = mysql_query($query_n);
  $totalRows_n = mysql_num_rows($all_n);
}
$totalPages_n = ceil($totalRows_n/$maxRows_n)-1;

$queryString_n = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_n") == false && 
        stristr($param, "totalRows_n") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_n = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_n = sprintf("&totalRows_n=%d%s", $totalRows_n, $queryString_n);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Lihat Data Nilai B.INDONESIA</title>
<style>
	.btn_style{
		border: 2px solid #cecece;
		border-radius: 3px;
		padding: 10px 10px;
		box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.6);
		color: white;
		background-color: green;
	}
	.btn_style:hover{
		border: 1px solid #b1b1b1;
		box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.5);
	}
	</style>
<style>
<!--
a:link {
	color: #000000;
	text-decoration: none;
}
a:visited {
	color: #000000;
	text-decoration: none;
}
a:hover {
	color: #99CC66;
	text-decoration: underline;
}
a:active {
	text-decoration: none;
}
td {font-family: Verdana, Arial;font-size: 12px;color:#000000;}
-->

</style>
</head>
<?php 
session_start();
if($_SESSION['status']!="login"){
	header("location:../index.php?pesan=belum_login");
}
?>
<body>
	<form action="laporan-pdf/index.php" method="post">
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="627" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="627"><div align="center"><img src="images/power.jpg" width="800" height="65"></div></td>
  </tr>
  <tr>
    <td><div align="center">
      <p> <img src="images/garis2.gif" width="800" height="31"></p>
      </div></td>
  </tr>
  <tr>
    <td><div align="center"><img src="images/SEKOLAH.jpg" width="800" height="200"></div></td>
  </tr>
  <tr>
    <td class="style3">&nbsp;</td>
  </tr>
  <tr>
    <td class="style3">&nbsp;</td>
  </tr>
  <tr>
    <td class="style3">
    <table width=100% align="center"><tr valign="baseline"><td width="49%" height="59">
    <form>
      
        <div align="left"></div>
    </form>
    </td>
    <td width="51%" align=right><form>
      <div align="right">Nama :
               <input type=text name=cari size=24>
               <button type=submit value=Cari>
      </div>
    </form>
      <div align="right"></span>
            </div>
      </div></td></tr></table></td>
  </tr>
  <tr>
    <td class="style3"><div align="right">    </div></td>
  </tr>
  <tr>
    <td class="style3"><div align="center"> NILAI B.INDONESIA</div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="style3"><table width="100%" border="1" align="center" cellpadding=3 cellspacing=1>
      <tr bgcolor=#cccccc height=20>
        <td><div align="center">NIS</div></td>
        <td><div align="center">NAMA</div></td>
        <td><div align="center">FOR</div></td>
        <td><div align="center">UTS</div></td>
        <td><div align="center">UAS</div></td>
        <td><div align="center">NILAI</div></td>
        <td><div align="center">KETERANGAN</div></td>
        <td><div align="center">EDIT</div></td>
        <td><div align="center">HAPUS</div></td>
      </tr>
 <tr bgcolor=#cccccc>
        <td colspan=9 height=1 bgcolor=#00000></td>
      </tr>	
     <?php 
	$rumus = $_GET['rumus'];
	
	if (empty($rumus))
		$rumus = 3;
	
	switch ($rumus) {
	case 1 : $x = 0.2; $y = 0.3; $z = 0.5; break;
	case 2 : $x = 0.1; $y = 0.3; $z = 0.6; break;
	case 3 : $x = 0.3; $y = 0.3; $z = 0.4; break;	
	}
      $i = 0;
     do { 
		$angka = ceil(($row_n['FOR']*$x) + ($row_n['UTS']*$y) + ($row_n['UAS']*$z));
		if ($angka >= 80)
			$huruf = "Lulus";
		elseif ($angka >= 68)
			$huruf = "Lulus";
		elseif ($angka >= 59)
			$huruf = "Remedial";
		elseif ($angka >= 49)
			$huruf = "Remedial";
		
		if ($i % 2 == 0) $bg = "#e8e8e8";
			else $bg = "#FFFFFF";
		$i++;
    ?>
      <tr align=center bgcolor=<?php echo $bg;?> onmouseover="this.style.backgroundColor='#dedede'" onmouseout="this.style.backgroundColor='<?php echo $bg;?>'">
          <td><?php echo $row_n['NIM']; ?>
            <div align="center"></div></td>
          <td><?php echo $row_n['NAM']; ?>
            <div align="center"></div></td>
          <td><?php echo $row_n['FOR']; ?>
            <div align="center"></div></td>
          <td><?php echo $row_n['UTS']; ?>
            <div align="center"></div></td>
          <td><?php echo $row_n['UAS']; ?>
            <div align="center"></div></td>
          <td><div align="center"><?php echo $angka; ?></div></td>
          <td><div align="center"><?php echo $huruf; ?></div></td>
          <td><div align="center"><a href="editdata_bd.php?id=<?php echo $row_n['nomor']; ?>"><img src="images/edit.png" width="16" height="16" border="0"></a></div></td>
          <td><div align="center"><a href="hapus_bd.php?id=<?php echo $row_n['nomor']; ?>"><img src="images/del.png" width="16" height="16" border="0"></a></div></td>
      </tr>
      <?php } while ($row_n = mysql_fetch_assoc($n)); ?>
    <tr bgcolor=#cccccc>
        <td colspan=9 height=1 bgcolor=#00000></td>
      </tr>	
    </table></td>
  </tr>
  <tr>
    <td class="style3">&nbsp;</td>
  </tr>
  <tr>
    <td class="style3"><div align="center"><span class="style3"><a href="isidata_bd.php">  Form Input Nilai Siswa</a> &middot; <a href="lihatdata_bd.php">Lihat Data Nilai Siswa</a>   &middot; <a href="index.htm">Home </a></span></div>
    
    <center><button src="laporan-pdf/index.php" class="btn_style">Cetak Data Ke PDF<button><center>
    
    </td>
  </tr>
  
  <tr>
    <td>&nbsp;
      <p align="center"><img src="images/sr.png" width="48" height="53"></p>
      <table border="0" width="50%" align="center">
        <tr>
          <td width="23%" align="center"><?php if ($pageNum_n > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_n=%d%s", $currentPage, 0, $queryString_n); ?>"><img src="images/First.gif" width="18" height="13" border=0></a>
            <?php } // Show if not first page ?>
          </td>
          <td width="31%" align="center"><?php if ($pageNum_n > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_n=%d%s", $currentPage, max(0, $pageNum_n - 1), $queryString_n); ?>"><img src="images/Previous.gif" width="14" height="13" border=0></a>
            <?php } // Show if not first page ?>
          </td>
          <td width="23%" align="center"><?php if ($pageNum_n < $totalPages_n) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_n=%d%s", $currentPage, min($totalPages_n, $pageNum_n + 1), $queryString_n); ?>"><img src="images/Next.gif" width="14" height="13" border=0></a>
            <?php } // Show if not last page ?>
          </td>
          <td width="23%" align="center"><?php if ($pageNum_n < $totalPages_n) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_n=%d%s", $currentPage, $totalPages_n, $queryString_n); ?>"><img src="images/Last.gif" width="18" height="13" border=0></a>
            <?php } // Show if not last page ?>
          </td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td height="91"><div align="center">
      <p><img src="images/garis.gif" width="782" height="31"><span class="style2">
        <marquee>
      Copyright &copy; Double-B ~ BukBuk
        </marquee>
        </span><br>
        <img src="images/powered.jpg" width="800" height="80"></p>
    </div></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($n);
?>

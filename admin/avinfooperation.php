    <?php require_once('../Connections/liaisondb.php'); ?>
<?php require_once('../bin/fonctions.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_rsOperation = "-1";
if (isset($_GET['id'])) {
  $idClient = $_GET['id'];
}
mysql_select_db($database_liaisondb, $liaisondb);
 $query_rsOperation = " SELECT * FROM clients WHERE clients.idcl = '$idClient' ";
$rsOperation = mysql_query($query_rsOperation, $liaisondb) or die(mysql_error());
$row_rsOperation = mysql_fetch_assoc($rsOperation);
$totalRows_rsOperation = mysql_num_rows($rsOperation);
?>
<link href="./include/style.css" rel="stylesheet" type="text/css" />
<link href="./include/_css.css" rel="stylesheet" type="text/css" />
<table class="table table-striped table-hover pull-right" width="100%" border="0" cellspacing="1" cellpadding="2">
  <thead>
  <tr>
    <th width="50%" align="right">Identité du client :</th>
    <td width="50%" align="left">
	<?php echo $row_rsOperation['civilite'], ' ',$row_rsOperation['nom'],' ',$row_rsOperation['prenoms']; ?></td>
  </tr>
  <tr>
    <th width="50%" align="right">Téléphone:</th>
    <td width="50%" align="left"><?php echo $row_rsOperation['cel']; ?></td>
  </tr>
  <tr>
      <th width="50%" align="right">Adresse email:</th>
      <td width="50%" align="left"><?php echo $row_rsOperation['email']; ?></td>
  </tr>
  <tr>
      <th width="50%" align="right">Date de crétion de son compte:</th>
      <td width="50%" align="left"><?php echo date('d/m/Y',strtotime($row_rsOperation['dateaj'])); ?></td>
  </tr>
  </thead>
  <tbody>
  </tbody>
</table>
<?php 
mysql_free_result($rsOperation);
?>

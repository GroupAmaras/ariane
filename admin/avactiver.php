<?php require_once('../Connections/liaisondb.php'); ?>
<?php require_once('../bin/fonctions.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_name('arianebo');
  session_start();
}

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

if ((isset($_POST['action'])) && ($_POST['action']=='valider') && (isset($_POST['idav'])) && !empty($_POST['idav'])){

  $updateSQL = sprintf("UPDATE valertes SET status = 1, dateserv=%s, idc=%s WHERE idav=%s",
                       GetSQLValueString(date('Y-m-d H:i:s'), "date"),
                       GetSQLValueString($_SESSION['ariane_admin_id'], "int"),
                       GetSQLValueString($_POST['idav'], "int"));

  mysql_select_db($database_liaisondb, $liaisondb);
  $Result1 = mysql_query($updateSQL, $liaisondb) or die(mysql_error());
	
	if ($Result1){
		echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>La validation du service Alertes Voyages s\'est faite avec succès !</div>';
	}
	else { echo '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>La validation du service Alertes Voyages a échoué... Veuillez recommencer !</div>';
	}
}

if ((isset($_POST['action'])) && ($_POST['action']=='annuler') && (isset($_POST['idav'])) && !empty($_POST['idav'])){
	
	$motif = $_POST['motif'];
	$message = $_POST['observation'];
						
  $updateSQL = sprintf("UPDATE valertes SET annule = 1, motif = %s, observation = %s, dateserv=%s, idc=%s WHERE idav=%s",
                       GetSQLValueString($motif, "text"),
                       GetSQLValueString($message, "text"),
					   GetSQLValueString(date('Y-m-d H:i:s'), "date"),
                       GetSQLValueString($_SESSION['ariane_admin_id'], "int"),
                       GetSQLValueString($_POST['idav'], "int"));

  mysql_select_db($database_liaisondb, $liaisondb);
  $Result1 = mysql_query($updateSQL, $liaisondb) or die(mysql_error());
	
	if ($Result1){
		echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Le message d\'annulation du paiement a été bien pris en compte ! Une copie a été envoyée à l\'abonné.</div>';
		
	$sujet = $motif.' - ESN ARIANE';
	$to = $_POST['to'];
	$headers = 'MIME-Version: 1.0' . "\n"; // Version MIME
	$headers .= "Content-Transfer-Encoding: 8bit\n";
	$headers .= "From: ESN ARIANE <rechargement@ariane.ci>\n";
	$headers .= "Content-Type: text/html; charset=utf-8\n";
	$headers .= "X-Mailer: PHP\n";
	$headers .= "X-Priority:2\n";
	$headers .= "Return-Path: ESN ARIANE <rechargement@ariane.ci>\n";
	$headers .= "Reply-To: ESN ARIANE <rechargement@ariane.ci>\n";
	$headers .= "Date:" . date("D, d M Y h:s:i") . " +0000\n";
	$message = $message;
	
	mail($to, $sujet, $message, $headers) ; // Envoi du mail	
	}
	else { echo '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>La validation du service Alertes Voyages a échoué... Veuillez recommencer !</div>';
	}
}
?>
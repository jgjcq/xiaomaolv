

<?
// ini_set('display_errors',1);            //������Ϣ  
// ini_set('display_startup_errors',1);    //php����������Ϣ  
// error_reporting(-1);                    //��ӡ�����е� ������Ϣ  
// ini_set('error_log', dirname(__FILE__) . '/error_log.txt'); //��������Ϣ�����һ���ı��ļ�
include_once("inc/auth.inc.php");

include_once("inc/header.inc.php");
?>




<body class="bodycolor">

<?
include("function.php"); 

if($_POST['import']=="��������"){

	$leadExcel=$leadExcel;
	
	if($leadExcel == "true")
	{
		// var_dump($_FILES);
		// exit();
		//echo "OK";die();
		//��ȡ�ϴ����ļ���
		$filename = $_FILES['inputExcel']['name'];
		//�ϴ����������ϵ���ʱ�ļ���
		$tmp_name = $_FILES['inputExcel']['tmp_name'];
		
		$msg = uploadFile($filename,$tmp_name);
		{ Message(_("��ʾ"),_($msg));
			?>

			<br>
			<div align="center">
			 <input type="button" value="<?=_("����")?>" class="BigButton" onClick="location='../teacher_operation/new.php?start=<?=$start?>'">
			</div>

			<?
			    exit;
		}
	}
}
?>

</body>
</html>
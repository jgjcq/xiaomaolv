<?
//����Excel�ļ�
function uploadFile($file,$filetempname) 
{
	//�Լ����õ��ϴ��ļ����·��
	$filePath = 'upFile/';
	$str = "";
	//�����·��������PHPExcel��·�����޸�
	set_include_path('.'. PATH_SEPARATOR .'D:\MYOA\webroot\general\DIY_WSCP\DIY_exam\manage\excel\PHPExcel' . PATH_SEPARATOR .get_include_path()); 
      
	require_once 'PHPExcel.php';
	require_once 'PHPExcel\IOFactory.php';
	//require_once 'PHPExcel\Reader\Excel5.php';//excel 2003
	require_once 'PHPExcel\Reader\Excel2007.php';//excel 2007

	$filename=explode(".",$file);//���ϴ����ļ����ԡ�.����Ϊ׼��һ�����顣
	if($filename[1]!='xls'&&$filename[1]!='xlsx') 
	{
		$msg='�ļ���ʽ����ȷ�����ϴ���׺��Ϊxls����xlsx��excel�ļ�';
	}
	else{
			$time=date("y-m-d-H-i-s");//ȥ��ǰ�ϴ���ʱ�� 
			$filename[0]=$time;//ȡ�ļ���t�滻 
			$name=implode(".",$filename); //�ϴ�����ļ��� 
			$uploadfile=$filePath.$name;//�ϴ�����ļ�����ַ 

		  
			//move_uploaded_file() �������ϴ����ļ��ƶ�����λ�á����ɹ����򷵻� true�����򷵻� false��
		    $result=move_uploaded_file($filetempname,$uploadfile);//�����ϴ�����ǰĿ¼��
		    if($result) //����ϴ��ļ��ɹ�����ִ�е���excel����
		    {
			   //$objReader = PHPExcel_IOFactory::createReader('Excel5');//use excel2003
			   $objReader = PHPExcel_IOFactory::createReader('Excel2007');//use excel2003 �� 2007 format
			   //$objPHPExcel = $objReader->load($uploadfile); //����������httpd����
			   $objPHPExcel = PHPExcel_IOFactory::load($uploadfile);//�ĳ����д���ͺ���

			   $sheet = $objPHPExcel->getSheet(0); 
			   $highestRow = $sheet->getHighestRow(); // ȡ�������� 
			   $highestColumn = $sheet->getHighestColumn(); // ȡ��������
		    
				//ѭ����ȡexcel�ļ�,��ȡһ��,����һ��
				for($j=2;$j<=$highestRow;$j++)
				{ 
					

					for($k='A';$k<=$highestColumn;$k++)
					{ 
						$str .= iconv('utf-8','gbk',$objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue()).'\\';//��ȡ��Ԫ��
					} 
					//explode:�������ַ����ָ�Ϊ���顣
					$strs = explode("\\",$str);



					//��֤���ݺϷ���
					if(!$strs[0])
					{
						$msg = "���ݸ�ʽ����ȷ������ʧ�ܣ�";
						break;
					}
					else if(!$strs[1])
					{
						$msg = "���ݸ�ʽ����ȷ������ʧ�ܣ�";
						break;
					}
					else if(!$strs[2])
					{
						$msg = "���ݸ�ʽ����ȷ������ʧ�ܣ�";
						break;
					}
					else if(!$strs[3])
					{
						$msg = "���ݸ�ʽ����ȷ������ʧ�ܣ�";
						break;
					}
					else if(!$strs[4])
					{
						$msg = "���ݸ�ʽ����ȷ������ʧ�ܣ�";
						break;
					}
					else if(!$strs[5])
					{
						$msg = "���ݸ�ʽ����ȷ������ʧ�ܣ�";
						break;
					}
					else if(!$strs[6])
					{
						$msg = "���ݸ�ʽ����ȷ������ʧ�ܣ�";
						break;
					}
					else
					{
						//var_dump($strs);
						//die();
						if($strs[4]=='��')
						{
							$IS_AT=1;
						}
						else{
							$IS_AT=0;
						}
						if($strs[6]=='��')
						{
							$IS_SCHOOL=1;
						}
						else{
							$IS_SCHOOL=0;
						}
						$sql = "INSERT INTO DIY_WSCP_TEACHER(TEA_USERID,TEA_IDCARD,TEA_BANK_CARD_NUMBER,TEA_BANK,IS_AT,INAUGURATION_TIME,IS_SCHOOL) VALUES('".$strs[0]."','".$strs[1]."','".$strs[2]."','".$strs[3]."','".$IS_AT."','".strtotime($strs[5])."','".$IS_SCHOOL."')";     
						//echo $sql;
						
						if(!exequery(TD::conn(),$sql)){
							return false;
						}
						$str = "";
						$msg = "����ɹ���";
					}
					
					
			   } 
		   
		   	   unlink($uploadfile); //ɾ���ϴ���excel�ļ�
		    }else{
		       $msg = "����ʧ�ܣ�";
		    }
	}

    return $msg;
}
?>
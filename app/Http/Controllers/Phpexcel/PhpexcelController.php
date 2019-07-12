<?php

namespace App\Http\Controllers\Phpexcel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tools\JWTAuth\JWTAuth;

class PhpexcelController extends Controller
{
    //PHPExcel带出excel表格
    public function test_export(Request $request)
    {
        require_once(app_path() . '/Tools/phpexcel/Classes/PHPExcel.php');
        require_once(app_path() . '/Tools/phpexcel/Classes/PHPExcel/Writer/Excel2007.php');

        //要输出的数据，二维数组
        $data=\DB::table('student')->get();
        $date=json_decode($data,true);
        foreach ($date as $k => $v){
            $datas[$k]=array_values($v);
        }

//        $datas = array(
//            array('王城1', '男', '18', '1997-03-13', '18948348924'),
//            array('李飞虹', '男', '21', '1994-06-13', '159481838924'),
//            array('王芸', '女', '18', '1997-03-13', '18648313924'),
//            array('郭瑞', '男', '17', '1998-04-13', '15543248924'),
//            array('李晓霞', '女', '19', '1996-06-13', '18748348924'),
//        );
        // 创建一个excel
        $objPHPExcel = new \PHPExcel();
        //设置文件创建人，文件名，以及excel表格的表头部分
        $objPHPExcel->getProperties()->setCreator("")->setLastModifiedBy("金峰兄")->setTitle("金峰兄")->setSubject("金峰兄")->setDescription("金峰兄")->setKeywords("金峰兄")->setCategory("金峰兄");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'id')->setCellValue('B1', 'username')->setCellValue('C1', 'pwd')->setCellValue('D1', 'sex')->setCellValue('e1', 'grade');

        // 表格的标题
        $objPHPExcel->getActiveSheet()->setTitle('excel-' . date('Y-m-d'));

        //设置当前的表格,也就是第一行的表格
        $objPHPExcel->setActiveSheetIndex(0);
        //设置所有表格的默认高度
        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(15);

        //循环赋值，填充表格
        foreach ($datas as $k=>$data) {
            //由于$k是键名，是从0开始的，而我们的表格的正式内容的第一行是表头部分，比如：姓名，年龄等
            //所以这边的 A.($k+2)代表的是A2的内容，相当于都从第二行开始填充
            $objPHPExcel->getActiveSheet()->setCellValue('A' . ($k+2), $data[0])->getStyle('A' . ($k+2))->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . ($k+2), $data[1]);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . ($k+2), $data[2]);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('D' . ($k+2), $data[3], \PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->getStyle('D' . ($k+2))->getNumberFormat()->setFormatCode("@");

              //设置文本格式
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('E' . ($k+2), $data[4], \PHPExcel_Cell_DataType::TYPE_STRING);
//            $objPHPExcel->getActiveSheet()->getStyle('E' . ($k+2))->getAlignment()->setWrapText(true);
//            $objPHPExcel->getActiveSheet()->setCellValueExplicit('F' . ($k+2), $data[5], \PHPExcel_Cell_DataType::TYPE_STRING);
//            $objPHPExcel->getActiveSheet()->getStyle('F' . ($k+2))->getAlignment()->setWrapText(true);
//            $objPHPExcel->getActiveSheet()->setCellValueExplicit('G' . ($k+2), $data[6], \PHPExcel_Cell_DataType::TYPE_STRING);
//            $objPHPExcel->getActiveSheet()->getStyle('G' . ($k+2))->getNumberFormat()->setFormatCode("@");
//            $objPHPExcel->getActiveSheet()->setCellValueExplicit('H' . ($k+2), $data[7], \PHPExcel_Cell_DataType::TYPE_STRING);
//            $objPHPExcel->getActiveSheet()->getStyle('H' . ($k+2))->getNumberFormat()->setFormatCode("@");

            //}
        }
        //这边可以打印下，就可以看到我们已经把数组的内容放到excel对象中了
        /*    var_dump($objPHPExcel);
          exit;*/
        $objActSheet = $objPHPExcel->getActiveSheet();

        // 设置CELL填充颜色
        $cell_fill = array(
            'A1',
            'B1',
            'C1',
            'D1',
            'E1',
            'F1',
            'G1',
            'H1',
        );
        // TODO 加注释
        //设置格式
        foreach($cell_fill as $cell_fill_val){
            $cellstyle = $objActSheet->getStyle($cell_fill_val);
            $cellstyle->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
            // 字体格式,中间的14代表了字体的大小
            $cellstyle->getFont()->setSize(14)->setBold(true);
            // 边框格式
            $cellstyle->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN)->getColor()->setARGB('FFFF0000');
            $cellstyle->getBorders()->getBottom()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN)->getColor()->setARGB('FFFF0000');
            $cellstyle->getBorders()->getLeft()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN)->getColor()->setARGB('FFFF0000');
            $cellstyle->getBorders()->getRight()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN)->getColor()->setARGB('FFFF0000');
        }
        //设置第一行单元格高度
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

//设置第一行单元格高度
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
        //设置单元格的宽度
        $objActSheet->getColumnDimension('A')->setWidth(18.5);
        $objActSheet->getColumnDimension('B')->setWidth(23.5);
        $objActSheet->getColumnDimension('C')->setWidth(12);
        $objActSheet->getColumnDimension('D')->setWidth(12);
        $objActSheet->getColumnDimension('E')->setWidth(12);
        $objActSheet->getColumnDimension('F')->setWidth(18.5);
        $objActSheet->getColumnDimension('G')->setWidth(18.5);
        $objActSheet->getColumnDimension('H')->setWidth(18.5);

        $filename = '数据库导出';
        ob_end_clean();//清除缓冲区,避免乱码
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
        header('Cache-Control: max-age=0');
        // 如果是在ie9浏览器下，需要用到这个
        header('Cache-Control: max-age=1');
        // 如果你是在ie浏览器或者https下，需要用到这个
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
        $objWriter->save('php://output');
    }


    /**
     * jwt 加密数据调用
     */

    public function getToken()
    {
        $obj = JWTAuth::getInstance();
        $token = $obj->setUid(1)->encode()->getToken();


        $data = [
            'code'=>1,
            'msg'=>"success",
            'data'=>$token
        ];
        dd(json_encode($data,JSON_UNESCAPED_UNICODE)) ;

    }

    public function check()
    {
        echo 11111;
    }
}

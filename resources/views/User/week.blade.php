<?
$color = array('蓝色','黄色','白色','黑色');
$size  = array(36,37,38,39,40);
$class = array('男士','女士');
$goods = array('衬衫','裤子','鞋子');
for($a=0;$a<count($class);$a++){
    for($b=0;$b<count($color);$b++){
        for($c=0;$c<count($goods);$c++){
            for($d=0;$d<count($size);$d++){
                echo $class[$a].$color[$b].$goods[$c].$size[$d].'码'.'<br>';
            }
        }
    }
}


echo   "<hr>";

 $arr1 = ['blue'=>'蓝色','red'=>'红色','white'=>'白色','pink'=>'粉色'];
 $arr2 = ['first'=>'第一个','second'=>'第二个','third'=>'第三个'];

$data = [];

foreach($arr1 as $k=>$v){
    $data[$v]=$k;
}

foreach($arr2 as $k=>$v){
    $data[$v]=$k;
}
print_r($data);
?>
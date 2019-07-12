<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>学生数据展示</title>
</head>
<body>
<table border="1px">
    <tr>
        <td>ID</td>
        <td>学生姓名</td>
        <td>学生性别</td>
        <td>学生成绩</td>
    </tr>
    @foreach($data as $k=>$v)
    <tr>
        <td>{{$v->id}}</td>
        <td>{{$v->username}}</td>
        <td>{{$v->sex}}</td>
        <td>{{$v->grade}}</td>
    </tr>
    @endforeach
</table>
</body>
</html>
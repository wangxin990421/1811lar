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

        <tr>
            <td>{{$data->id}}</td>
            <td>{{$data->username}}</td>
            <td>{{$data->sex}}</td>
            <td>{{$data->grade}}</td>
        </tr>

</table>
</body>
</html>
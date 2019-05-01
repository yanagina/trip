<?php
require dirname(__FILE__) . '/trip_util.php';
if(!chen($_POST)){
    $encoding = mb_internal_encoding();
    $err = "Encoding Error! The expected encoding is " . $encoding;
    exit($err);
}
$_POST = es($_POST);
    
$errors = [];

if (isset($_POST['prefecture'])) {
    $prefecture = $_POST['prefecture'];
    // echo $prefecture;
} else {
    $errors[] = "場所が入力されていません。";
}

if (isset($_POST['purpose'])) {
    $purpose = $_POST['purpose'];
    // echo $purpose;
} else {
    $errors[] = "目的が入力されていません。";
}

if (isset($_POST['impressions'])) {
    $impressions = $_POST['impressions'];
    // echo $impressions;
} else {
    $errors[] = "詳細が入力されていません。";
}
// ここから画像
if(is_uploaded_file($_FILES['images']['tmp_name'])){
    if(!file_exists('upload')){
        // mkdir('upload');
    }
    $images = 'upload/' . basename($_FILES['images']['name']);
    if(move_uploaded_file($_FILES['images']['tmp_name'],$images)){
        echo $images, 'のアップロードに成功しました。';
        echo '<p><img src="',$images,'"><p>';
    } else{
        $errors[] = "アップロードに失敗しました。";
    }
} else {
        $errors[] = "画像をアップし直してください。";
}

    // if ($prefecture==''||$purpose==''||$impressions=='') {
if (count($errors)>0) {
    echo '<ol class="error">';
    foreach ($errors as $value) {
    echo "<li>",$value,"</li>";
    }
    print'<form>';
    print'<input type="button" onclick="history.back()" value="戻る">';
    print'</form>';
}
$dsn = 'mysql:dbname=trip;host=localhost;charset=utf8';
$user = "yanagina";
$password = "atsuki0229";
?>

<!DOCTYPE html>
<html lang="jp">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>旅行共有サイト</title>
    <style type="text/css">
    body {
        background-image: url("b039.gif");
    }
    div.container{
        margin: 20px 0px 0px 0xp;
    }
    div.kuchikomi-list-cassette{
        margin: 40px 10px 10px 10px;
        width: 740px;
    } 
    div.user-kuchikomi{
        padding: 15px 18px 10px 18px;
        background: #fff8e8 url(/uw/images/kuchi_bod_img_lin_dot.png) no-repeat center bottom;
        border: #ffbd7c solid 2px;
        border-width: 2px;
        border-style: solid;
        border-color: rgb(255, 189, 124);
        font-size: 100%;
    }
    table{
        background-color: #ffffff;
        border-color: #ffbd7c;
    }
    #gray{
        background-color: #F0F0F0;
        width: 50px;
        text-align: center;
        writing-mode: horizontal-tb;
    }
    .movement{
        text-align: right;
    }
    </style>
</head>
<header>
    <h1 class="title text-center m-4"><a href="trip_view.php">旅行共有サイト</a></h1>
    <h5 class="title text-center m-3">あなたのおすすめ場所を共有しよう！</h5>
    <nav id="global_navi">
    <ul class="nav nav-pills nav-fill">
    <li class="nav-item">HOME作成中(ログイン機能搭載予定)</li>
    <li class="nav-item">
        <a href="trip_view.php">記事閲覧</a>
    </li>
    <li class="nav-item">
        <a href="trip_form.php">記事投稿</a>
    </li>
    <li class="nav-item">お問い合わせ作成中(割勘アプリも公開予定)</li>
    </ul>
    <body>
        <div>
        <?php
        try {
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // 画像確認部分
        
        // $sql = "INSERT INTO article(prefecture, purpose, impressions, images) VALUES (:prefecture, :purpose, :impressions :images)";
        $sql = "INSERT INTO article(prefecture, purpose, impressions) VALUES (:prefecture, :purpose, :impressions)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':prefecture', $prefecture, PDO::PARAM_STR);
        $stmt->bindValue(':purpose', $purpose, PDO::PARAM_STR);
        $stmt->bindValue(':impressions', $impressions, PDO::PARAM_STR);
        // $stmt->bindValue(':images', $images, PDO::PARAM_STR);
        if ($stmt->execute()) {
        $sql = "SELECT * FROM article";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        print'<div class="container mt-3">';
        print'<div class="kuchkomi-list-cassette m-1">';
        print'<div class="user-kuchikomi m-1">';
        print'<h4>新規投稿をありがとうございます！<h4>';
        print'<h5>以下の内容で投稿されました。</h5>';
        print '<table border=1>';
            print '<tr>';
            print '<td id="gray">場所</td>';
            print '<td>'.$prefecture.'</td>';
            print '</tr>';
            print '<tr>';
            print '<td id="gray">目的</td>';
            print '<td>'.$purpose.'</td>';
            print '</tr>';
            print '<tr>';
            print '<td id="gray">感想</td>';
            print '<td>'.$impressions.'</td>';
            print '</tr>';
            print '<tr>';

            // 画像確認部分
            
            // print '<td id="gray">画像</td>';
            // echo '<td><img src="', $images,'"></td>';
            // print '</tr>';
            print '</table>';
            print'</br>';
        print'<div class="movement">';
        print'<a href="trip_view.php">記事一覧へ移動</a>';
        print'</div>';
        print'</form>';
        print'</div>';
        print'</div>';
        print'</div>';
        } else {
        echo '<span class="error">追加エラーがありました。</span><br>';
        }
        } catch (Exception $e) {
        echo '<apan class="error">エラーがありました。</span><br>';
        echo $e->getMessage();
        }
        ?>
        </div>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>
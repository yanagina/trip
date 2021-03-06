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
    div {
        border-radius: 10px 10px 10px 10px;
    }
    div.container{
        margin: 0px 0px 0px 0xp;
    }
    div.kuchikomi-list-cassette{
        margin: 10px 10px 10px 10px;
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
        line-height: 1.4;
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
    div.col-3{
        text-align: center;
    }
    </style>
</head>
<header>
    <div class="container mt-3">
    <h1 class="title text-center m-4"><a href="trip_view2.php">旅行共有サイト</a></h1>
        <h5 class="title text-center m-3">あなたのおすすめ場所を共有しよう！</h5>
            <div class="row">
            <div class="col-3">HOME作成中<br/>(ログイン機能搭載予定)</div>
            <div class="col-3">
                <a href="trip_view2.php">記事閲覧</a>
            </div>
            <div class="col-3">
                <a href="trip_from2.php">記事投稿</a>
            </div>
            <div class="col-3">お問い合わせ作成中<br/>(割勘アプリ公開予定)</div>
            </div>
</header>
        <body>
        <div class="container mt-3">
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
            } else {
            $errors[] = "場所が入力されていません。";
            }

            if (isset($_POST['purpose'])) {
            $purpose = $_POST['purpose'];
            } else {
            $errors[] = "目的が入力されていません。";
            }

            if (isset($_POST['impressions'])) {
            $impressions = $_POST['impressions'];
            } else {
            $errors[] = "詳細が入力されていません。";
            }

            // if(is_uploaded_file($_FILES['images']['tmp_name'])){
            //     if(!file_exists('upload')){
            //         mkdir('upload');
            //     }
            //     $images = 'upload/' . basename($_FILES['images']['name']);
            //     if(move_uploaded_file($_FILES['images']['tmp_name'],$images)){
            //         echo $images, 'のアップロードに成功しました。';
            //         echo '<p><img src="',$images,'"><p>';
            //     } else{
            //         echo 'アップロードに失敗しました。';
            //     }
            // } else {
            //     echo 'ファイルを選択してください。';
            // }

            if(count($errors)>0){
            echo '<ol class="error">';
            foreach ($errors as $value){
            echo "<li>",$value,"</li>";
            }
            print'<form>';
            print'<input type="button" onclick="history.back()" value="戻る">';
            print'</form>';
            } else {
            print'<div class="kuchkomi-list-cassette m-1">';
            print'<div class="user-kuchikomi m-1">';
            print'<form method="POST" action="trip_reply2.php" enctype="multipart/form-data">';
            print '<table border=1>';
            print '<tr>';
            print '<td id="gray">場所</td>';
            print '<td>'.$prefecture.'</td>';
            print '</tr>';
            print '<td id="gray">目的</td>';
            print '<td>'.$purpose.'</td>';
            print '</tr>';
            print '<tr>';
            print '<td id="gray">感想</td>';
            print '<td>'.$impressions.'</td>';
            print '</tr>';
            print'</br>';
            // print '<tr>';
            // print '<td id="gray">画像</td>';
            // echo '<td><img src="', $images,'"></td>';
            // print '</tr>';
            print '</table>';
            print '<input type="hidden" name="prefecture" value="'.$prefecture.'">';
            print '<input type="hidden" name="purpose" value="'.$purpose.'">';
            print '<input type="hidden" name="impressions" value="'.$impressions.'">';
            print '<input type="file" name="images" id="upload" size="30">';
            print'<h5>※こちらの内容でよろしいでしょうか？</h5>';
            print'<h6>宜しければ「登録」ボタンをクリック！・訂正は「戻る」ボタンをクリック<h6>';
            print'</div>';
            print'</div>';
            print'</div>';
            print'<div class="mt-3 text-right">';
            print'<div class="kuchkomi-list-cassette m-1 text-right">';
            print'<div class class="user-kuchikomi m-3">';
            print'<input type="button" onclick="history.back()" value="戻る" class="btn btn-primary"><br/>';
            print'<input type="submit" value="登録" class="btn btn-primary mt-1">';
            print'</form>';
            print'</div>';
            print'</div>';
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
<?php
// データベースの情報
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
    <style type="text/css">
    body {
        background-image: url("b039.gif");
    }
    div {
        border-radius: 10px 10px 10px 10px;
    }
    .title {
        text-align;
    }
    .container.btn btn-primary{
        float:right;
    } 
    div.kuchikomi-list-cassette{
        margin: 10px 10px 10px 10px;
        width: 740px;
    } 
    div.user-kuchikomi{
        padding: 15px 18px 10px 18px;
        background: #fff8e8 url(/uw/images/kuchi_bod_img_lin_dot.png) no-repeat center bottom;
        border-left: #ffbd7c solid 2px;
        border-left-width: 2px;
        border-left-style: solid;
        border-left-color: rgb(255, 189, 124);
        border-right: #ffbd7c solid 2px;
        border-right-width: 2px;
        border-right-style: solid;
        border-right-color: rgb(255, 189, 124);
        border-top: #ffbd7c solid 2px;
        border-top-width: 2px;
        border-top-style: solid;
        font-size: 200%;
        line-height: 1.4;
        border-bottom: #ffbd7c solid 2px;
        border-bottom-width: 2px;
        border-bottom-style: solid;
        font-size: 120%;
        line-height: 1.4;
    }
    div.col-3{
        text-align: center;
    }
    </style>
    <title>旅行共有サイト</title>
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
        try {
        $pdo = new PDO($dsn,$user,$password);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM place";
        $stmt = $pdo->query($sql);
        $stmt->execute();
        $prefecture_data ='';

        foreach($stmt as $row){
            $prefecture_data .= "<option value='".$row['prefecture'];
            $prefecture_data .= "'>".$row['prefecture']."</opition>"; 
            }
            $pdo = null;
    } catch(Exception $e) {
        echo '<span class="error">エラーがありました。</span><br>';
        echo $e->getMessage();
        exit();
    }
    ?>
        <form method="POST" action="trip_check2.php" enctype="multipart/form-data">
            <!-- <div class="container mt-3"> -->
            <div class="kuchkomi-list-cassette mt-1">
            <div class="user-kuchikomi">
                <select class="custom-select" name="prefecture">
                    <?php
                    echo $prefecture_data; ?>
                </select>
                    <small id="prefecture" class="form-text text-muted">※場所を選択してください。</small><br/>
                <input type="text" name="purpose" class="form-control" id="exampleInputPassword1" placeholder="目的を入力してください。" required>
                    <small id="purpose" class="form-text text-muted">※旅の目的（友達とぶらり・デート・家族旅行）など</small><br/>
                <textarea name="impressions" class="form-control" placeholder="詳細を記載してください。" required></textarea>
                    <small id="impressions" class="form-text text-muted">※旅行先のどういう所がよかったかを記載してください。</small><br/> 
                    <!-- ここから画像アップロード -->
                <!-- <label for="upload">画像アップロード</label> -->
                <!-- <input type="file" name="images" id="upload"> -->
                <!-- <small id="upload" class="form-text text-muted">※画像があればアップしよう</small><br/> -->
            </div>
            <div class="container text-right mt-1">
                <input type="submit" value="入力確認" class="btn btn-primary">
            </div>
        </form>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>
<?php
require dirname(__FILE__) . '/trip_util.php';
$gobackURL = "trip_view.php";

if(!chen($_POST)){
    $encoding = mb_internal_encoding();
    $err = "Encoding Error! The expected encoding is " . $encoding;
    exit($err);
}
$_POST = es($_POST);

$dsn = 'mysql:dbname=trip;host=localhost;charset=utf8';
$user = "root";
$password = "";
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
    td, th {
        border: 2px #808080 solid;
        border-color:rgb(255, 189, 124);
        margin:2px;
        padding:4px;
        background: #fff8e8 url(/uw/images/kuchi_bod_img_lin_dot.png) no-repeat center bottom;
        text-align: center;
    }
    th{
        width: 60px;
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
        font-size: 200%;
        line-height: 1.4;
        font-size: 100%;
        line-height: 1.4;
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
    </header>            
        <body>
            <div>
            <?php
            $search = $_POST['search'];
            try {
            $pdo = new PDO($dsn, $user, $password);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM article WHERE CONCAT(prefecture,purpose, impressions) LIKE (:search)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':search', "%{$search}%", PDO::PARAM_STR);
            ($stmt->execute()) ;
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(count($result)>0){
            echo '<div class = "container mt-3">';
            echo '<div class = "form-group">';
            echo '<div class="kuchkomi-list-cassette m-1">';
            echo '<div class="user-kuchikomi m-1">';
            echo "キーワード「{$search}」が含まれるもの</br>";
            echo "<table>";
            echo '<thead class = "thead-light"><tr>';
            print '<th scope = "col">場所</th>';
            print '<th scope = "col">目的</th>';
            echo '<th scope = "col">感想</th>';
            echo "</tr></thead>";
            echo "<tbody>";
            foreach ($result as $row){
            echo '<tr>';
            echo '<td scope = "row">', es($row['prefecture']), '</td>';
            echo '<td scope = "row">', es($row['purpose']), '</td>';
            echo '<td scope = "row">', es($row['impressions']), '</td>';
            echo '</tr>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            }
            echo "</tbody>";
            echo "</table>";   
            } else {
            echo "検索結果はありませんでした。";
            }
            } catch (Exception $e) {
            echo '<apan class="error">エラーがありました。</span><br>';
            echo $e->getMessage();
            }
            ?>
            <div class = "form-group m-1 text-right">
                <HR>
                <p><a href="<?php echo $gobackURL ?>" class="btn btn-primary">戻る</a></p>
            </div>
            </div>
            <!-- Optional JavaScript -->
            <!-- jQuery first, then Popper.js, then Bootstrap JS -->
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        </body>
</html>
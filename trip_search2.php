<?php
require dirname(__FILE__) . '/trip_util.php';
$gobackURL = "trip_form2.php";

if(!chen($_POST)){
    $encoding = mb_internal_encoding();
    $err = "Encoding Error! The expected encoding is " . $encoding;
    exit($err);
}
$_POST = es($_POST);

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
        /* margin: 40px 10px 10px 10px; */
        width: 740px;
    } 
    div.user-kuchikomi{
        /* padding: 15px 18px 10px 18px; */
        font-size: 200%;
        line-height: 1.4;
        font-size: 100%;
        line-height: 1.4;
    }
    /* div.row{
        margin:0px;
        border-top:solid 1px;
        border-left:solid 1px;
        box-shadow:1px 1px;
    } */
    div #fix{
        margin:0px;
        /* border-top:solid 1px;
        border-left:solid 1px;
        box-shadow:1px 1px;
        border: 1px #808080 solid;
        border-color:rgb(255, 189, 124);
        margin:2px;
        padding:4px; */
        background: #fff8e8 url(/uw/images/kuchi_bod_img_lin_dot.png) no-repeat center bottom;
        text-align: center;
    }
    div.col-4{
        border: 1px #808080 solid;
        border-color:rgb(255, 189, 124);
        text-align: center;
    }
    img{
        width: 100px;
        height: 100px; 
    }
  </style>
</head>
    <header>
    <div class="container mt-3">
        <h1 class="title text-center m-5"><a href="trip_view.php">旅行共有サイト</a></h1>
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
            $search = $_POST['search'];
            $prefecture =$_POST['prefecture'];

            // var_dump($search);
            // var_dump($prefecture);
            try {
            $pdo = new PDO($dsn, $user, $password);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM article WHERE CONCAT(purpose, impressions, images) LIKE (:search) AND prefecture = (:prefecture)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':search', "%{$search}%", PDO::PARAM_STR);
            $stmt->bindValue(':prefecture', "{$prefecture}",PDO::PARAM_STR);
            // var_dump($stmt);
            // 部分検索（％）ではなく＝
            ($stmt->execute()) ;
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(count($result)>0){
            // print '<div class = "form-group">';
            // print '<div class="kuchkomi-list-cassette mt-1">';
            // print '<div class="user-kuchikomi mt-1">';
            print "場所「{$prefecture}」・キーワード「{$search}」が含まれるもの</br>";
            echo '<div class = "container mt-3">';
            print '<table>';
            print '<thead class = "thead-light"><tr>';
            print '<th scope = "col-3">場所</th>';
            print '<th scope = "col-3">目的</th>';
            print '<th scope = "col-3">感想</th>';
            print '<th scope = "col-3">画像</th>';
            print '</thaad></tr>';
            foreach ($result as $row){
            print '<tbody>';
            print '<tr>'; 
            echo '<td>', es($row['prefecture']), '</td>';
            echo '<td>', es($row['purpose']), '</td>';
            echo '<td>', es($row['impressions']), '</td>';
            echo '<td><img src=', es($row['images']), '></td>';
            echo '</tr>';
            print '</tbady>';
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
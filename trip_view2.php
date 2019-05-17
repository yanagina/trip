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
    div {
        border-radius: 10px 10px 10px 10px;
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
    /* div.kuchikomi-list-cassette{
        margin: 40px 10px 10px 10px;
    }  */
    div.user-kuchikomi{
        /* padding: 15px 18px 10px 18px; */
        font-size: 200%;
        line-height: 1.4;
        font-size: 100%;
        line-height: 1.4;
    }
    /* .alt-table-responsive {
        width: 100%;
        overflow-y: hidden;
        overflow-x: auto;
        -ms-overflow-style: -ms-autohiding-scrollbar;
        -webkit-overflow-scrolling: touch;
    }  */
    div.col-3{
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
        <h1 class="title text-center mt-5 "><a href="trip_view2.php">旅行共有サイト</a></h1>
        <h5 class="title text-center mt-3">あなたのおすすめ場所を共有しよう！</h5>
            <div class="row">
            <div class="col-3">HOME作成中<br/>(ログイン機能搭載予定)</div>
            <div class="col-3">
                <a href="trip_view2.php">記事閲覧</a>
            </div>
            <div class="col-3">
                <a href="trip_form2.php">記事投稿</a>
            </div>
            <div class="col-3">お問い合わせ作成中<br/>(割勘アプリ公開予定)</div>
            </div>
    </header>
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
        <body>
            <div class = "container mt-3">
            <div class = "form-group mt-4">
                <form method="POST" action="trip_search2.php">
                    <input type="text" name="search" placeholder="キーワードを入力" >
                    <select name="prefecture" onchange="this.form.submit()">
                    <?php
                    echo $prefecture_data; ?>
                    </select>
                    <input type = "submit" value= "検索" class="btn btn-primary">
                </form>
            </div>
            </div>
            <div>
            <?php
            try {
                $pdo = new PDO($dsn, $user, $password);
                $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "SELECT * FROM article";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                print '<div class = "container mt-3">';
                print '<div class = "form-group">';
                print '<div class="kuchkomi-list-cassette mt-1">';
                print '<div class="user-kuchikomi mt-1">';
                print '<div>';
                print '<table>';
                print '<thead class ="thead-light"><tr>';
                print '<th scope = "col-3">場所</th>';
                print '<th scope = "col-3">目的</th>';
                print '<th scope = "col-3">感想</th>';
                print '<th scope = "col-3">画像</th>';
                // print '<th class="col-xs-3 col-ms-3 col-md-4 col-lg-4">場所</th>';
                // print '<th class="col-xs-3 col-ms-3 col-md-3 col-lg-4">目的</th>';
                // print '<th class="col-xs-1 col-ms-1 col-md-1 col-lg-1">感想</th>';
                print '</tr></thead>';
                print "<tbody>";
                foreach ($result as $row) {
                echo '<tr>';
                // echo '<td scope = "row">', es($row['prefecture']), '</td>';
                // echo '<td scope = "row">', es($row['purpose']), '</td>';
                // echo '<td scope = "row">', es($row['impressions']), '</td>';
                echo '<td>', es($row['prefecture']), '</td>';
                echo '<td>', es($row['purpose']), '</td>';
                echo '<td>', es($row['impressions']), '</td>';
                echo '<td><img src=', es($row['images']), '></td>';

                // 問題はここ
                // echo '<td>', es($row['images']), '</td>';
                // こちらでsrcを用いらないとデータ名のみが表示されてしまう。
                // echo '<td>', es($row["prefecture"]), '</td>';
                // echo '<td>', es($row["purpose"]), '</td>';
                // echo '<td>', es($row["impressions"]), '</td>';
                echo '</tr>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                }
                echo "</tbody>";
                echo "</table>";
                } catch (Exception $e) {
                echo '<apan class="error">エラーがありました。</span><br>';
                echo $e->getMessage();
            }
            ?>
            <div class = "form-group mt-1 text-right">
                <HR>
                <p><a href="<?php echo $gobackURL ?>" class="btn btn-primary ">新規投稿</a></p>
                </div>
            </div>
            <!-- Optional JavaScript -->
            <!-- jQuery first, then Popper.js, then Bootstrap JS -->
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        </body>
</html>
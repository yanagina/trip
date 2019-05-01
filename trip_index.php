<?php
require dirname(__FILE__) . '/trip_util.php';
$gobackURL = "trip_check.php";

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

if (count($errors)>0){
    echo '<ol class="error">';
    foreach ($erros as $value) {
        echo "<li>", $value, "</li>";
    }
    echo "</ol>";
    echo "<hr>";
    echo "<a href=", $gobackURL, ">戻る</a>";
}

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
</head>
    <body>
        <div>
        <?php
        $prefecture =$_POST["prefecture"];
        $purpose = $_POST["purpose"];
        $impressions = $_POST["impressions"];
            try {
                $pdo = new PDO($dsn, $user, $password);
                $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "INSERT INTO article(prefecture, purpose, impressions) VALUES (:prefecture, :purpose, :impressions)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':prefecture', $prefecture, PDO::PARAM_STR);
                $stmt->bindValue(':purpose', $purpose, PDO::PARAM_STR);
                $stmt->bindValue(':impressions', $impressions, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    $sql = "SELECT * FROM article";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    print '<div class = "container">';
                    print '<div class = "form-group">';
                    print "<table>";
                    print '<thead class = "thead-light"><tr>';
                    print '<th scope = "col">場所</th>';
                    print '<th scope = "col">目的</th>';
                    print '<th scope = "col">感想</th>';
                    print '</tr></thead>';
                    print "<tbody>";
                    print '</div>';
                    print '</div>';
                    foreach ($result as $row) {
                        echo '<div class = "container">';
                        echo '<div class = "form-group">';
                        echo '<tr>';
                        echo '<td scope = "row">', es($row['prefecture']), '</td>';
                        echo '<td scope = "row">', es($row['purpose']), '</td>';
                        echo '<td scope = "row">', es($row['impressions']), '</td>';
                        echo '</tr>';
                        echo '</div>';
                        echo '</div>';
                    }
                    echo "</tbody>";
                    echo "</table>";
                } else {
                    echo '<span class="error">追加エラーがありました。</span><br>';
                };
            } catch (Exception $e) {
                echo '<apan class="error">エラーがありました。</span><br>';
                echo $e->getMessage();
            }
            ?>
            <p><a href="<?php echo $gobackURL ?>" class="btn btn-primary ">戻る</a></p>
        </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>

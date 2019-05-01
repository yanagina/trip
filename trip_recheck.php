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

    // if ($prefecture==''||$purpose==''||$impressions=='') {
    if(count($errors)>0){
        echo '<ol class="error">';
        foreach ($errors as $value){
            echo "<li>",$value,"</li>";
        ver_dump($value);
        }
        print'<form>';
        print'<input type="button" onclick="history.back()" value="戻る">';
        print'</form>';
    } else {
        print'<div class="container">';
        print'<form method="post" action="trip_index.php">';
        print' <label>場所：<input name="prefecture"  value="'.$prefecture.'"></label><br/>';
        print' <label>目的：<input name="purpose"  value="'.$purpose.'"></label><br/>';
        print' <label>感想：<input name="impressions"  value="'.$impressions.'"></label><br/>'; 
        print'<input type="button" onclick="history.back()" value="戻る"><br/>';
        print'<input type="submit" value="登録・投稿">';
        print'</form>';
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
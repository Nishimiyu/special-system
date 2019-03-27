<html>
<head>
   <title>mission2</title>
   <meta charset="utf-8">
</head>
<body>

<?php

//使用するデフォルトのタイムゾーンを指定する
date_default_timezone_set('Asia/Tokyo');
//dateの関数を変数にする
$date = date ("Y年m月d日 H:i:s");

//変数にする
$name=$_POST["name"];
$comment=$_POST["comment"];
$delete = $_POST["deleteNo"];
$edit = $_POST["editNo"];
$filename = "mission_2_nishikawa.txt";
$editnumber =$_POST["editnumber"];
$pass =$_POST["pass"];
$deletepass =$_POST["deletepass"];
$editpass = $_POST["editpass"];

// 追記モードでファイルを開く
$fp=fopen($filename, 'a');
// ファイルのデータの行数を数えて$numに代入
$num = count( file( $filename ) ); 
 // 投稿番号を取得
$num++;
//投稿内容をまとめて一つの変数にする
$matome = $num."<>".$name."<>".$comment."<>".$date."<>".$pass;

if(!empty($edit)){//$edit編集番号がセットされている時の処理
    // ファイルを閉じる
    fclose($fp);
    $edfilename = "mission_2_nishikawa.txt";
    // 読み込みモードでファイルを開く
    $fp=fopen($edfilename, 'r');
    //配列に読み込む
    $arr=file($edfilename);
    foreach($arr as $value){//foreachで取り出す配列と要素の値を格納する変数を指定する。
    //$valueの文字列を分割する。分割したのが$min
    $min=explode("<>",$value);
  
if($min[0] == $edit && $min[4] == $editpass
    ){//投稿番号が編集番号と一致する時  
        $editcn = "$min[1]"; //名前の変数を用意
        $editcc = "$min[2]"; //コメントの変数を用意
        $editnum = "$min[0]"; //編集したい投稿番号の変数を用意
}//投稿番号が編集番号と一致する時の処理終わり
}//foreachの処理終わり
}//$edit編集番号がセットされている時)の処理終わり

        // ファイルを閉じる
        fclose($fp); 
?>

<!_フォームデータの送信_>
  <form action="mission2.php" method="POST">     
    <input type="text" name="name" value ="<?php echo $editcn;?>"> <br>
    <input type="text" name="comment" value ="<?php echo $editcc;?>"><br>
    <input type="text" name="pass" placeholder ="パスワード">
    <input type="submit" value ="送信"><br>
    <input type="hidden" name="editnumber" value ="<?php echo $editnum;?>">
    
    <br>
    
    <input type="text" name="deleteNo" placeholder ="削除対象番号"><br>
    <input type="text" name="deletepass" placeholder ="パスワード">
    <input type="submit" value="削除" > <br>
    
    <input type="text" name="editNo" placeholder ="編集対象番号"><br>
    <input type="text" name="editpass" placeholder ="パスワード">
    <input type="submit" value="編集" > 
    
    </form>

<?php

// ファイルに書き込む
if(!empty($name) && !empty($comment) &&empty($editnumber)){//名前・コメントあり、編集番号なしの時
    $filename = "mission_2_nishikawa.txt";
    // 追記モードでファイルを開く
    $fp=fopen($filename, 'a');
    fwrite($fp,$matome."<>".PHP_EOL);
    }//名前・コメントあり、編集番号なしの時の処理終わり
    
if(!empty($delete)){ //$deleteがセットされている時の処理
    $defilename = "mission_2_nishikawa.txt";
    //読み込み/書き込みモードでファイルを開く
     $fp=fopen($defilename, 'r+');
    //配列に読み込む
    $arr=file($defilename);
    //ファイルを空にする(0に丸める)
    ftruncate($fp,0);
    // ファイルポインタを先頭に戻す
    fseek($fp,0);
    // ファイルを閉じる
    fclose($fp);
    //読み込み／書き出しモードでファイルを開く
    $fp=fopen($defilename, 'w+');
          
 foreach($arr as $value){//foreachで取り出す配列と要素の値を格納する変数を指定する。
    //$valueの文字列を分割する。分割したのが$min
    $min=explode("<>",$value);

if($min[0] != $delete || $min[4] != $deletepass //投稿番号が削除番号と一致しない時
    ){
    fwrite($fp,$value);//書き込む
    }//投稿番号が削除番号と一致しない時の処理終わり
    }//foreachの処理終わり
    // ファイルを閉じる
    fclose($fp);
    
    }//if($deleteがセットされている時)の処理終わり
        

if(!empty($name) && !empty($comment) &&!empty($editnumber)){//名前・コメント・編集番号ありの時の処理
    $lines=file("mission_2_nishikawa.txt");
    $edfilename = "mission_2_nishikawa.txt";
    //読み込み/書き込みモードでファイルを開く
    $fp=fopen($edfilename, 'w+');
    foreach($lines as $line){//foreachで取り出す配列と要素の値を格納する変数を指定する。
    //$lineの文字列を分割する。分割したのが$min
    $min=explode("<>",$line);
    
    if($min[0] != $editnumber){//投稿番号が編集したい投稿番号と一致しない時   
    fwrite($fp,$line);//書き込む
}//投稿番号が編集したい投稿番号と一致しない時の処理終わり
    
    else{//投稿番号が編集したい投稿番号と一致する時
    //使用するデフォルトのタイムゾーンを指定する
    date_default_timezone_set('Asia/Tokyo');
    //dateの関数を変数にする
    $date = date ("Y年m月d日 H:i:s");
    $new_line = $editnumber."<>".$name."<>".$comment."<>".$date."<>".$pass;
    fwrite($fp,$new_line."<>".PHP_EOL);//書き込む
}//投稿番号が編集したい投稿番号と一致する時の処理終わり
}//foreachの処理終わり

}//名前・コメント・編集番号ありの時の処理終わり


//配列に読み込む,投稿をフォームの下に表示する
$arr=file($filename);
foreach($arr as $value){ //foreachで取り出す配列と要素の値を格納する変数を指定する。
//$valueの文字列を分割する。分割した$minを一つづつ表示する
$min=explode("<>",$value);
echo $min[0]."&nbsp";
echo $min[1]."&nbsp";
echo $min[2]."&nbsp";
echo $min[3];
echo("<br>");
}//foreachの処理終わり 
      
?>
</body>
</html>
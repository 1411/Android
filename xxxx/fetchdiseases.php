<?php
    include("conn.inc");
    $s=explode(",", trim($_POST["sym"],"[]"));
    //$s=$_POST["sym"];
    $diseases=array();
    for ($i=0; $i<count($s); $i++){
        $avi=ltrim($s[$i]);
        $s1=mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `symptoms` WHERE symptom='$avi'"));
        $check=mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `diseases` WHERE s_id='$s1[0]'"), MYSQLI_NUM);
        //print_r($check);
        $result = $link->query("SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = 'diseases'");
        $num = $result->fetch_row();
        //array_merge($diseases,$check);
        for ($j=3; $j<$num[0]; $j++){
            if ($check[$j]!=null){
            array_push($diseases,$check[$j]);
            } 
        }
        //print_r($diseases);
    }
    $diseases=array_values($diseases);
    $count=array_count_values($diseases);
    arsort($count);
    $maxi=array_keys($count);
    $max1=max($count);
    $count1=array_count_values($count);
    $max=$count1[$max1];
    $final1=array();
    for ($k=0;$k<$max;$k++){
        array_push($final1, $maxi[$k]);
    }
    $final1=implode(",", $final1);
    echo $final1;
    exit;
?>
<?php
    include("conn.inc");
    $s3=trim($_POST["sym"],"[]");
    
    $s=explode(",",$s3);
    //echo $s[0];
    //echo mysqli_num_rows(mysqli_query($link, "SELECT * FROM `symptoms` WHERE symptom='$s[0]'"));
    //$result1=mysqli_query($link, "SELECT COUNT(*) FROM `symptoms` WHERE symptom='$s[0]'");
    //echo $result1 ;
    $d= trim($_POST['die'],"[]");
    for ($i=0; $i<count($s); $i++){
        if (mysqli_num_rows(mysqli_query($link, "SELECT * FROM `symptoms` WHERE symptom='$s[$i]'"))>0) {
            //echo 1;
        }else {
            $statement = mysqli_prepare($link, "INSERT INTO symptoms(symptom) VALUES(?)");
            mysqli_stmt_bind_param($statement, "s",$s[$i] );
            mysqli_stmt_execute($statement);
            mysqli_stmt_close($statement);
        }
    }
    for ($i=0; $i<count($s); $i++){
        $s1=mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `symptoms` WHERE symptom='$s[$i]'"));
        //echo $s1[1];
        
        if (mysqli_num_rows(mysqli_query($link, "SELECT * FROM `diseases` WHERE s_id=$s1[0]"))<1) {
            //echo 0;
            $statement1="INSERT INTO diseases(diseases, s_id) SELECT '$d', s_id FROM symptoms WHERE symptom = '$s[$i]' ";
            $result= mysqli_query($link, $statement1 );
        }
        else if (mysqli_num_rows(mysqli_query($link, "SELECT * FROM `diseases` WHERE s_id=$s1[0]"))>0) {
            $check= mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `diseases` WHERE s_id='$s1[0]'"));
            if (!in_array("$d", $check)){
                $result = $link->query("SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = 'diseases'");
                $num = $result->fetch_row();
                if (!in_array(NULL,$check)) {
                    //echo 1;
                //echo '#: ', $row[0];
                    $statement1="ALTER TABLE diseases ADD COLUMN diseases.$num[0] VARCHAR(40)";
                    $result= mysqli_query($link, $statement1 );
                    $statement2="UPDATE diseases SET diseases.$num[0]='$d' WHERE s_id='$s1[0]' ";
                    $result2=mysqli_query($link, $statement2 );
                }else {
                    for ($k=3; $k<$num[0];$k++){
                        //echo $k;
                        $check1 = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM `diseases` WHERE s_id='$s1[0]'"));
                        //print_r($check1);
                        if (!in_array("$d", $check1)){
                            //echo 1;
                            $statement3="UPDATE diseases SET `$k`=(case when `$k` is NULL then '$d' else `$k` end) WHERE s_id='$s1[0]' ";
                            $result3=mysqli_query($link, $statement3 );
                        }else{
                            //echo 0;
                            break;  
                        }
                    }
                }
            }
        }
    }

 //mysqli_query("ALTER TABLE mytable ADD COLUMN `diseases.$i` VARCHAR(40)",$db_con);
        
?>
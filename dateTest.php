<?php    
$dateNow = date("d-m-y");
$date2 = date("01-02-21");
while ($dateNow > $date2){
    echo "<a href ='organiserContest.php'>$date2</a><br>";
    echo $dateNow."<br>";
    $dateNow = date("d/m/y", strtotime("+1 week"));
    echo $dateNow;
    echo "<br>";
    echo"true";
    break;
}
// break;
// }


?>
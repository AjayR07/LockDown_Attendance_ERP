<!-- Insert Values into Class Table -->
<!-- <?php 
//    include_once("./db.php");
//    session_start();
//        $cnt=0;
//         $d=date('Y-m-d');
//         $str="INSERT INTO `18-CSE-A` VALUES(".$d.",'18CST38',";      
//         for($i=1;$i<=60;$i++)
//         {
//             $str.="'P',";   
//         }
//         $str=substr($str,0,strlen($str)-1);
//         $str.=")";
//         if($con->query($str))
//         {
//             echo "Successfull";
//         }
//         else
//         {
//             echo $str;
//             echo "error";
//         }

?> -->





<!--  Create Table -->

<?php  
include_once("../db.php");
session_start();


$tableName="17-cse-b";
$batch="2017";
$sec="B";

$str="CREATE TABLE `$tableName` (date varchar(10) NOT NULL,code varchar(10) NOT NULL,period int NOT NULL,";
$sql="SELECT regno FROM `registration` WHERE batch LIKE '$batch' AND sec LIKE '$sec'";
echo $sql;
$res=$con->query($sql);
while($row=$res->fetch_assoc())
{
  $roll=$row["regno"];
    $str.=$roll." VARCHAR(2) NULL,";   
}
$str.="PRIMARY KEY(DATE,CODE),FOREIGN KEY (CODE) REFERENCES COURSE_LIST(CODE))";
// if($con->query($str))
// {
//     echo "Successfull";
// }
// else
// {
//     echo $str;
//     echo "error";
// }
echo $str;
exit();
?>

<!-- Table View -->
<!-- <?php 
//     session_start();
//     include_once("navbar.php");
//     if(!isset($_SESSION["id"]))
//     {
//         header('Location: ./login.php');
//     }
// ?>


<!-- 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body >
    <style>
    body
    {
        background-image: url("./images/bgpic.jpg");
    }
    </style>
    <div class="ui header" style="text-align:center;font-size:30px;margin-top:2%;color:#ADEFD1FF">Your Class Associations</div>
    <table class="ui selectable striped  table" style="margin:auto;width:70%;margin-top:5%">
  <thead>
    <tr  style="color:black;font-size:20px" class="center aligned">
      <th>Year</th>
      <th>Section</th>
      <th>Course Code</th>
      <th>Course Name</th>
      <th >Actions</th>
    </tr>
  </thead>
  <tbody class="center aligned">
    <tr><td colspan="5" style="font-size:17px" class="left aligned"><em>General Course</em></td></tr>
    <tr>
      <td>II</td>
      <td>A</td>
      <td>18ITT051</td>
      <td>Computer Networks</td>
      <td class="right aligned"><button class="ui primary right icon button "> Mark Attendance &nbsp&nbsp<i class="check icon"></i></button></td>
    </tr>
    <tr >
      <td >II</td>
      <td>A</td>
      <td>18ITT051</td>
      <td>Computer Networks</td>

      <td class="right aligned"><button class="ui primary right icon button "> Mark Attendance &nbsp&nbsp<i class="check icon"></i></button></td>
    </tr>
    <tr ><td colspan="5" style="font-size:17px" class="left aligned"><em>Laboratory Course</em></td></tr>
    <tr >
      <td>II</td>
      <td>A</td>
      <td>18ITT051</td>
      <td>Computer Networks</td>

      <td class="right aligned"><button class="ui primary right icon button "> Mark Attendance &nbsp&nbsp<i class="check icon"></i></button></td>
    </tr>
    
  </tbody>
</table>
</body>
</html> -->




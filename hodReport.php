
<?php 
session_start();
if(!isset($_SESSION['id']))
{
    header('Location: index.html');
}
include_once("./db.php");
$staffid=$_SESSION["id"];
$res=$con->query("SELECT * FROM staff where `staffid` LIKE '$staffid'")->fetch_assoc();
$dept=$res["dept"];
if($_SESSION["id"]!='CSE001SF' || $_SESSION["id"]!='CSE004SF' )
{
    // header('Location: exportAdv.php');
}
include_once('navbar.php'); 
$staffid=$_SESSION['id'];
$sql="SELECT `code` FROM `course_list` where `dept` LIKE '$dept' AND `status` LIKE 'active' AND `category` LIKE 'ELECTIVE'";
$res=$con->query($sql);
$ele=array();
while($row=mysqli_fetch_array($res))
{
    array_push($ele,$row['code']);
}
$ele=array("14CSE06","14CSE11","14CSO07","14ITO01","18ITO02","18MEO01","18CSO01");

$temp='';
?>
<head>
<title>Pending Report</title>
</head>
<body>
<style>
    body {
        background: url("./images/bgpic.jpg");
    }
</style> 
    <div class="ui raised segment" style="width:96%;margin:2%;">

        <div class="ui header">Missing Attendace List
            <a href="home.php"><i class="close icon" style="float:right"></i></a>
        </div>
        <table class="ui celled table">
            <thead>
                <tr>
                    <th>Staff</th>
                    <th>Subject</th>
                    <th style="text-align:center">Class</th>
                    <th>Dates &emsp;&emsp;&emsp;&ensp;&nbsp;- &ensp;Periods</th>
                    <th>Inform</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                    $sql="SELECT * FROM `staff` WHERE `dept` LIKE '$dept' ORDER BY `staffid` Asc";
                    $data=$con->query($sql);
                    $p=0;
                    $st=0;
                    while($row=mysqli_fetch_array($data))
                    {
                        $sid=$row['staffid'];
                        $sname=$row['name'];
                        $smail=$row['mail'];
                        $sql="SELECT * FROM `course_list` WHERE (`staffA`  LIKE '$sid' OR `staffB`  LIKE '$sid' OR `staffC`  LIKE '$sid' OR `staffD` LIKE '$sid' ) AND `status` LIKE 'active'";
                        $data1=$con->query($sql);
                        
                        $n=mysqli_num_rows($data1);

                        $bool=true;
                        $bol=0;
                            while($row1=mysqli_fetch_array($data1))
                            {
                                echo '<tr>';
                                $ssub=$row1['name'];
                                if($bool)
                                {
                                    echo '<td rowspan="'.$n.'"><span style="color:red;">'.$sname.'</span></td>';
                                    $bool=false;
                                }   
                                
                                echo '<td><span style="color:blue">'.$ssub.'</span></td>';

                                $code=$row1["code"];
                                if($row1["staffA"]==$sid)
                                {
                                    $sec="A";
                                }
                                else if($row1["staffB"]==$sid)
                                {
                                    $sec="B";
                                }
                                else if($row1["staffC"]==$sid)
                                {
                                    $sec="C";
                                }
                                else 
                                {
                                    $sec="D";
                                }
                                $batch=$row1["batch"]%2000;
                                $cls=($batch==17?'IV':(($batch==18)?'III':'II')).' - '.$sec;
                                if($row1['dept']=='MCSE')
                                {
                                    $cls='ME';
                                }
                                echo '<td style="text-align:center"><span style="color:blue">'.$cls.'</span></td>';
                                $tab=strtolower($batch.'-'.$dept.'-'.$sec);
                                $sql="SELECT * FROM `tt` WHERE `class` LIKE '$tab'";
                                $res=$con->query($sql);
                                $day=array();
                                $day_per=array();
                                while($row=$res->fetch_assoc())
                                { 
                                    $per=array();
                                    foreach($row as $in=>$v)
                                    {
                                        if(strpos($v,$code)!==false)
                                        {
                                                array_push($per,$in);
                                        } 
                                    }
                                    if(!empty($per))
                                    {
                                            $day_per+=array($row["day"]=>$per);
                                    }   
                                }
                                $x=date("Y-m-d");
                                $tdy=date_create($x);
                                $date=date("2020-08-03");
                                $diff=intval(date_diff($tdy,date_create($date))->format("%a"))+1;
                                $dates=array();
                                
                                for($i=1;$i<=$diff;$i++)
                                {    
                                    if($con->query("select * from holiday where date LIKE '$date'")->num_rows!=0)
                                    {
                                        continue;
                                    }
                                    $s=date("l", strtotime($date));
                                    foreach($day_per as $d=>$pd)
                                    {
                                            if($d==$s)
                                            {
                                                $day_pd=array();
                                                foreach($pd as $periods)
                                                {
                                                    if(in_array($code,$ele))
                                                        $sql="SELECT * FROM `$code` where date LIKE '$date' AND code LIKE '$sid' AND `period` LIKE '$periods'"; 
                                                    else
                                                        $sql="SELECT * FROM `$tab` where date LIKE '$date' AND code LIKE '$code' AND `period` LIKE '$periods'"; 
                                                
                                                    $r=$con->query($sql);
                                                    if($r->num_rows==0)
                                                    {
                                                        $p+=1;
                                                        $bol=1;
                                                        array_push($day_pd,$periods);
                                                    }
                                                        
                                                        
                                                }
                                            
                                                if(!empty($day_pd))
                                                {
                                                        $dates+=array($date=>$day_pd);
                                                }  
                                            }
                                    }
                                    $date=date_format(date_add(date_create($date),date_interval_create_from_date_string("1 days")),"Y-m-d");
                                }
                            echo '<div class="bulleted list">';
                            $mailcontent="Dear ".$sname." Attendace entry is pending for '".$ssub. "' on the following dates:".'%0A%0A';
                            $datecell='';
                            foreach($dates as $i=>$pds)
                            {  
                                
                                $mailcontent.=date_format(date_create($i),"d-m-Y").'%20'.'-'.'%20'.implode(",",$pds).'%0A';
                                $datecell.=date_format(date_create($i),"d-m-Y").' &emsp;- &ensp;'.implode(",",$pds).'<br>';
                            }
                        
                            $mailcontent.="%0AKindly mark the attendance ASAP %0A %20 -"."Advisor";
                            $mailcontent="mailto:".$smail."?subject=Attendace%20Pending%20report&body=".$mailcontent;
                            if(!empty($dates))
                            {
                                echo '<td>'.$datecell.'</td>';    
                                echo '<td><a href="'.$mailcontent.'" target="_blank">
                                    <button class="ui violet button">
                                    <i class="mail icon"></i> Send Mail
                                    </button></a></td>';
                            }
                            else
                            {
                                
                                echo '<td>NIL</td>';    
                                echo '<td>
                                    <button class="ui violet button" disabled>
                                    <i class="mail icon"></i> Send Mail
                                    </button></td>';
                            }
                            echo '</tr>';
                            
                          
                        }
                        if($bol==1)
                        {
                            $st+=1;
                        }
                       
                    }
                    echo '</tbody>
                    <tfoot>
                        <tr>
                        <th><em>'.$st.' Staffs </em></th>
                        <th></th>
                        <th></th>
                        <th><em>'.$p.' Periods </em></th>
                        <th><em>Pending </em></th>
                    </tr></tfoot>';
                ?>
              
                </table>
        <div class="actions">
            <div class="ui bottom attached buttons">
            <div class="ui positive button" onclick="window.print()">Print</div>
            <div class="ui negative button" onclick="window.location.replace('home.php');">Close</div>
        </div>
</div>
</body>
</html>


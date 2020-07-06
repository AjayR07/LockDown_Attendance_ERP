<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Attendance</title>

</head>

<?php

include_once('./navbar.php');
$course="18CSE51-Theory of Computation";
$date="06/07/2020";
$class="18CSE-A";
?>
<style>
body {
    background: url("./images/bgpic.jpg");
}

#card {
    margin: 0;
    position: absolute;
    top: 50%;
    left: 50%;
    -ms-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
}
</style>

<div class="ui raised padded container segment" id="card" style="margin:auto;width:60%;">
    <h1 class="header">
        Attendance Entry
    </h1>
    <form class="ui form">
        <div class="field">
            <label>Course</label>
            <input type="text" value="<?php echo $course; ?>" readonly />
        </div>
        <div class="two fields">
            <div class="field">
                <label>Class</label>
                <input type="text" value="<?php echo $class; ?>" readonly />
            </div>
            <div class="field">
                <label>Date</label>
                <input type="text" value="<?php echo $date; ?>" readonly />
            </div>
        </div>
        <div class="two field">
            <div class="field">
                <label>Sample</label>
                <div class="ui message">
                    <p>Download Sample Excel here, <i class="blue download icon"></i></p>
                </div>
            </div>
            <div class="field">
                <label>Upload</label>
                <div class="ui action input">
                    <input type="text" placeholder="Upload xlsx" readonly>
                    <input type="file" name="excel">
                    <div class="ui icon button">
                        <i class="attach icon"></i>
                        Upload
                    </div>
                </div>
            </div>

        </div>
        <div class="field">
            <center> <button class="ui positive button">Submit</button></center>
        </div>

    </form>
</div>



<script>
$("input:text").click(function() {
    $(this).parent().find("input:file").click();
});

$('input:file', '.ui.action.input')
    .on('change', function(e) {
        var name = e.target.files[0].name;
        $('input:text', $(e.target).parent()).val(name);
    });
</script>
<style>
.ui.action.input input[type="file"] {
    display: none;
}
</style>
</body>

</html>

<?php

include_once('./assets/simplexlsx-master/src/SimpleXLSX.php');

$a = array();
if ($xlsx = SimpleXLSX::parse('./files/sample.xlsx')) {
    foreach ($xlsx->rows(6) as $r) {
        $s = implode($r);
        $str = substr(trim($s), -8);
        array_push($a,$str);
        //echo $str . '<br/>';
    }
} else {
    echo SimpleXLSX::parseError();
}
?>
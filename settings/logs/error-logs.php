<?php

include '../../includes/auth.php';
include '../../db.php';

if(!can('settings_view')){
    die("Access Denied");
}

$pageTitle="Error Logs";

$logFile=dirname(__DIR__,2).'/logs/php-error.log';

$logs=[];

if(file_exists($logFile)){

    $lines=file($logFile,FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES);

    $lines=array_reverse($lines);

    $logs=array_slice($lines,0,500);

}

include '../../includes/header.php';
include '../../includes/sidebar.php';

?>

<link rel="stylesheet" href="../assets/style.css">


<div class="profile-page">

<div class="profile-header">

<div>

<h1>

<i class="fa-solid fa-triangle-exclamation"></i>

Error Logs

</h1>

<p>

View PHP and application errors.

</p>

</div>

<div>

<a
href="clear-error-log.php"
class="btn btn-danger"
onclick="return confirm('Clear all error logs?');"
>

<i class="fa-solid fa-trash"></i>

Clear Logs

</a>

<a
href="../index.php"
class="btn btn-dark"
>

<i class="fa-solid fa-arrow-left"></i>

Back

</a>

</div>

</div>

<div class="profile-card">

<div class="profile-card-header">

<h3>

<i class="fa-solid fa-file-lines"></i>

Latest Errors

</h3>

</div>

<div class="profile-body">

<div class="table-responsive">

<table class="table table-bordered table-hover">

<thead>

<tr>

<th width="70">

#</th>

<th>

Error

</th>

</tr>

</thead>

<tbody>
    <?php

if(empty($logs)){

?>

<tr>

<td colspan="2" class="text-center text-muted">

No errors found.

</td>

</tr>

<?php

}else{

foreach($logs as $index=>$log){

?>

<tr>

<td>

<?= $index+1; ?>

</td>

<td>

<pre class="error-log">

<?= htmlspecialchars($log); ?>

</pre>

</td>

</tr>

<?php

}

}

?>

</tbody>

</table>

</div>

</div>

</div>
</div>


<?php include '../../includes/footer.php'; ?>
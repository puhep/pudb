<html>
<head>
<title>Purdue University CMS FPix Upgrade Production Database</title>
<link rel="stylesheet" type="text/css" href="css/summary3.css" />
<body>
<img src="pics/pu_logo.jpg" width="200" height="100">
<img src="pics/CMS_logo_col.gif" width="100" height="100">
<br>
<h>
Purdue University CMS FPix Upgrade Production Database
</h>
<br>
<font color='red'><b>Database stress test ongoing. Expect a large quantity of dummy data</b></font>
<div style="position:fixed;left:420px;top:2px;">
<form method="link" action="login.php?prev=index.php">
<input type="submit" value="LOG IN">
</form>
</div>

<div2 style="position:fixed;left:420px;top:30px;">
<form method="link" action="logout.php">
<input type="submit" value="LOG OUT">
</form>
</div2>
<br>

<?php if($_SESSION['hidepre']){ ?>
<div3 style="position:fixed;left:420px;top:58px;">
<form method="link" action="hidepre.php">
<input type="submit" value="SHOW PREPRODUCTION">
</form>
</div3>
<?php } else{ ?>
<div3 style="position:fixed;left:420px;top:58px;">
<form method="link" action="hidepre.php">
<input type="submit" value="HIDE PREPRODUCTION">
</form>
</div3>
<?php } ?>

<div4 style="position:fixed;left:520px;top:200px">
<a href="graphing/modulegrapher.php" target="blank"><img src="graphing/modulegrapher.php" width="910" height="600" /></a>
</div4>

<br>
<br>

Assembly Flow Handler
<form action="assembly/status.php" method="get">
  <input value="Assembly Status" type="submit">
  </form>
<br>

Data Viewing
<form action="summary/list.php" method="get">
  <input value="Part List"
 type="submit"></form>

<form action="summary/attached.php?sort=mod" method="get">
  <input value="Detailed Module List"
 type="submit"></form>

<form action="summary/test_list.php" method="get">
  <input value="Tested Modules List"
 type="submit"></form>

<form action="summary/recently_updated.php" method="get">
  <input value="Recently Updated Modules"
 type="submit"></form>

<form action="summary/time.php" method="get">
  <input value="Assembly Over Time"
 type="submit"></form>

<form action="summary/pos.php" method="get">
  <input value="IV by Position"
 type="submit"></form>

<form action="../MoReWeb/Results/Overview.html" method="get">
  <input value="MoReWeb Results"
 type="submit"></form>

<br>

New Parts Information
<form action="submit/wafersubmit.php" method="get">
  <input value="Wafer Submit" type="submit">
  </form>

<form action="submit/HDIsubmit.php" method="get">
  <input value="HDI Submit" type="submit">
  </form>

<form action="submit/modulesubmit.php" method="get">
  <input value="Module Submit" type="submit">
  </form>

<form action="submit/ROCsubmit.php" method="get">
  <input value="ROC Submit" type="submit">
  </form>

<form action="submit/batchrocsubmit.php" method="get">
  <input value="Module Batch Submit" type="submit">
  </form>

<form action="submit/batchHDIsubmit.php" method="get">
  <input value="HDI Batch Submit" type="submit">
  </form>

<form action="submit/flexsubmit.php" method="get">
  <input name="flex" value="Flex and Carrier Submit - Purdue" type="submit">
  <input name="name" value="Purdue" type="hidden">
  </form>

<form action="submit/flexsubmit.php" method="get">
  <input name="flex" value="Flex and Carrier Submit - Nebraska" type="submit">
  <input name="name" value="Nebraska" type="hidden">
  </form>

<form action="submit/workordersubmit.php" method="get">
  <input value="New HDI Work Order Submit" type="submit">
  </form>

<br>

Testing Data
<form action="submit/meassubmit.php" method="get">
  <input  value="Measurement Submit" type="submit">
  </form>
<form action="submit/batchmeassubmit.php" method="get">
  <input  value="Batch Measurement Submit" type="submit">
  </form>
<form action="submit/batchfulltestsubmit.php" method="get">
  <input value="Batch Full Test Submit" type="submit">
  </form>
<form action="submit/batchallsubmit.php" method="get">
  <input value="Consolidated Batch Submit" type="submit">
  </form>
<form action="submit/morewebsubmit.php" method="get">
  <input value="MoReWeb Data Submit" type="submit">
  </form>

<br>

Change/Edit
<form action="submit/newcomment.php" method="get">
  <input value="Add Comments to Existing Part" type="submit">
  </form>
<form action="submit/newpic.php" method="get">
  <input value="Add Pictures to Existing Part" type="submit">
  </form>
<form action="submit/ROCedit.php" method="get">
  <input value="Edit ROCs" type="submit">
  </form>
<br>

Information
<form action="namingconvention.php" method="get">
  <input value="Naming Convention" type="submit">
  </form>
<form action="wafermap.php" method="get">
  <input value="Wafer Maps" type="submit">
  </form>
<br>

</body>
</html>

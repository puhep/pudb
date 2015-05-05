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
<div style="position:fixed;left:420px;top:2px;">
<form method="link" action="login.php?prev=index.php">
<input type="submit" value="LOG IN">
</form>
</div>
<br>
<div2 style="position:fixed;left:420px;top:30px;">
<form method="link" action="logout.php">
<input type="submit" value="LOG OUT">
</form>
</div2>
<br>
<br>

Assembly Flow Handler
<form action="assembly/status.php" method="post">
  <input name="assembly" value="Assembly Status" type="submit">
  </form>
<br>

Data Viewing
<form action="summary/list.php" method="post">
  <input name="summary" value="Part List"
 type="submit"></form>

<form action="summary/attached.php?sort=mod" method="post">
  <input name="exploded" value="Assembled Modules"
 type="submit"></form>

<form action="summary/test_list.php" method="post">
  <input name="tested" value="Tested Modules List"
 type="submit"></form>

<form action="summary/time.php" method="post">
  <input name="time" value="Assembly Over Time"
 type="submit"></form>

<form action="summary/pilotsummary.php" method="post">
  <input name="time" value="Pilot Module IV Graphs"
 type="submit"></form>

<form action="../MoReWeb/Results/Overview.html" method="post">
  <input name="moreweb" value="MoReWeb Results"
 type="submit"></form>

<br>

New Parts Information
<form action="submit/wafersubmit.php" method="post">
  <input name="wafer" value="Wafer Submit" type="submit">
  </form>

<form action="submit/HDIsubmit.php" method="post">
  <input name="hdi" value="HDI Submit" type="submit">
  </form>

<form action="submit/modulesubmit.php" method="post">
  <input name="module" value="Module Submit" type="submit">
  </form>

<form action="submit/ROCsubmit.php" method="post">
  <input name="ROC" value="ROC Submit" type="submit">
  </form>

<form action="submit/batchrocsubmit.php" method="post">
  <input name="batchROC" value="Batch Module Submit" type="submit">
  </form>

<form action="submit/flexsubmit.php" method="post">
  <input name="flex" value="Flex Cable Submit - Purdue" type="submit">
  <input name="id" value="1" type="hidden">
  </form>

<form action="submit/flexsubmit.php" method="post">
  <input name="flex" value="Flex Cable Submit - Nebraska" type="submit">
  <input name="id" value="2" type="hidden">
  </form>

<form action="submit/morewebsubmit.php" method="post">
  <input name="mwsub" value="MoReWeb Data Submit" type="submit">
  </form>

<br>

Testing Data
<form action="submit/meassubmit.php" method="post">
  <input name="meas" value="Measurement Submit" type="submit">
  </form>
<form action="submit/batchmeassubmit.php" method="post">
  <input name="batch" value="Batch Measurement Submit" type="submit">
  </form>
<form action="submit/batchfulltestsubmit.php" method="post">
  <input name="fullbatch" value="Batch Full Test Submit" type="submit">
  </form>
<form action="submit/batchallsubmit.php" method="post">
  <input name="allbatch" value="Consolidated Batch Submit" type="submit">
  </form>
<form action="submit/morewebsubmit.php" method="post">
  <input name="morewebdata" value="MoReWeb Data Submit" type="submit">
  </form>

<br>

Change/Edit
<form action="submit/newcomment.php" method="post">
  <input name="comment" value="Add Comments to Existing Part" type="submit">
  </form>
<form action="submit/newpic.php" method="post">
  <input name="pic" value="Add Pictures to Existing Part" type="submit">
  </form>
<form action="submit/ROCedit.php" method="post">
  <input name="ROCe" value="Edit ROCs" type="submit">
  </form>
<br>

Information
<form action="namingconvention.php" method="post">
  <input name="con" value="Naming Convention" type="submit">
  </form>
<form action="wafermap.php" method="post">
  <input name="map" value="Wafer Maps" type="submit">
  </form>
<br>

</body>
</html>

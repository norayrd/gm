		<link href="images/global00.css" rel="stylesheet" type="text/css" media="all">

<!-- Breadcrumb -->
<div class="breadcrumb bordercolor"><div class="breadcrumb_inner">
	<a href="index.php" title="�� �������">�������</a><span class="navigation-pipe">&gt;</span><span class="navigation_page">����� �����</span>
</div></div>
<!-- /Breadcrumb -->
<div id="noro_inner">
	<div class="rte">
	<h1>����� �����</h1>
	<div class="tree_top"><a href="index.php">�������</a></div>
	<ul class="tree">
		<li><a href="index.php" title="�� �������">�������</a></li>
		<li><a href="manufacturer.php" title="�������������">�������������</a>
			<ul>
			<?php 
			$sql="select * from p_tov_make tm order by tm.tov_make";
			$tm=mysql_query($sql) or die(mysql_error());
			@$tm_n=mysql_numrows($tm);
			$i=0;
			while($i<$tm_n){
				$tm_tov_make_kod=mysql_result($tm,$i,"tov_make_kod");
				$tm_tov_make=mysql_result($tm,$i,"tov_make");
			?>
				<li><a href="manufacturer.php?tovmake=<?php print $tm_tov_make_kod; ?>" title="�������� <?php print $tm_tov_make; ?>">�������� <?php print $tm_tov_make; ?></a></li>
			<?php
				$i+=1;
			}
			?>
			</ul>
		</li>
		<li><a href="prices-drop.php" title="�����">�����</a></li>
		<li><a href="delivery.php" title="������� ��������">��������</a></li>
		<li><a href="contact-form.php" title="��������">��������</a></li>
		<li class="last"><a href="about.php" title="� ���">� ���</a></li>
	</ul>
		</div>
</div>

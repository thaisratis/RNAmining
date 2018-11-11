<!DOCTYPE html>
<html>
<head>
	<?php include("head.php"); ?>
</head>
<body>
	<div id="main">
		<div class="container">
			<div id="base">
				<nav class="navbar navbar-expand-lg navbar-light bg-white">
					<?php include("navbar.php"); ?>				
				</nav>

				<div id="slide">
					<h1>Tutorial</h1>
					<p></p>
				</div>
				<div id="baseButtons">
					<?php include("buttons.php"); ?>
				</div>
				<div id="forms">
					<form >
						<h3>GEO2R results</h3>
						<p>A complete tutorial on how to use GEO2R to perform differential expression analysis on any of the available GEO gene expression datasets is available <a href="https://www.ncbi.nlm.nih.gov/geo/info/geo2r.html" target="_blank">here</a>. After selecting the studies and running GEO2R. The results have to be exported and then upload to Metavolcano. Make sure your exported results contains the "ID", "adj.P.Val", "P.Value", "t", "B", "logFC", "Gene.symbol" and "Gene.title" columns.</p>
						<p>Each GEO2R result file should look like this:</p>
						<img src="assets/images/.png" width="100%" alt=""><p></p>

						<h3>Criteria</h3>
						<p>The user first has to set a significance and a log2 fold-change threshold to define the differential expressed genes by study. For significance, the user has to set first either "adj.P.Val" or "P.Value". Once both parameter were settled, Metavolcano will display the result per study and a cumulative frequency of genes being consistently perturbed. Based on the user-desired number of consistently perturbed genes, the user can then settle the consistency threshold parameter which range among 0 and 1.</p>

						<h3>Signicance criteria</h3>
						<p>"adj.P.Val" or "P.Value"</p>

						<h3>P-value</h3>
						<p>A number among 0 and 1.</p>

						<h3>Log2FC</h3>
						<p>A number among 0 and Inf.</p>

						<h3>Consistency threshold</h3>
						<p>A number among 0 and 1 indicating the proportion of studies where the gene has to be consistently perturbed to be consider as consistently and differentially expressed.</p>
											
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="container d-none d-sm-block">
		<div class="footer">
			<?php include("footer.php"); ?>
		</div>
	</div>	
</body>
	<?php include("endscripts.php"); ?>
</html>

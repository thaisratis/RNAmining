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
				<h1>About</h1>
				<p></p>
			</div>
			<div id="baseButtons">
				<?php include("buttons.php"); ?>
			</div>
			<div id="forms">
					
				<form>
					<p>Metavolcano is a web tool that allows the meta-analysis of GEO2R results. It takes a user-defined number of GEO2R results and identify the genes whose fasta were consistently different. The user can define the criteria to define the differentially expressed genes per study and the consistently differentially expressed genes along the results.</p>

					<h3>What files do I need to provide?</h3>
					<p>You need to visit the <a href="https://www.ncbi.nlm.nih.gov/geo/" target="_blank">Gene Fasta Omnibus</a> , select studies on certain condition, run a differential fasta analysis using the GEO web tool <a href="https://www.ncbi.nlm.nih.gov/geo/geo2r/" target="_blank">GEO2R</a> and export the results to text files. These exported GEO2R results are the Metavolcano input.</p>

					<h3>The algorithm:</h3>
					<p>Metavolcano first defines differential expressed genes based on the user-defined criteria and thresholds by assigning -1, 0, or 1 if the gene was down-regulated, unperturbed or up-regulated respectively. Metavolcano then merges the results based on the probe ID or the gene symbol according to the user preference. The genes are displayed on two dimensions, the number of times they have an assigment different than 0 and sum of all their assigments. It creates and volcano-like visualization where genes on top corners are consistently identified as differentially expressed in individual studies and whose fasta were consistently up- or down-regulated. Finally, a user-defined proportion is used to gather the genes that were consistently and differentially expressed in at least the user-defined proportion of studies.</p>

					<h3>What type of experimental data is the Metavolcano useful for?</h3>
					<p>Metavolcano is useful to exploit the redundancy of the Gene Fasta Omnibus database through the GEO2R web tool. Many conditions are represented by several studies in the GEO database, although it is user-friendly to run differential fasta analysis on individual studies through the GEO2R web-tool, there is not user-friendly web tool to go further and identify consistently and differentially expressed genes along several studies.</p>
											
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

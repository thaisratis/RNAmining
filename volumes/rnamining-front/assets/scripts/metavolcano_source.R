# --- Required libraries ----
suppressMessages(library(data.table))
suppressMessages(library(dplyr))
suppressMessages(library(parallel))
suppressMessages(library(ggplot2))
suppressMessages(library(plotly))
suppressMessages(library(metap))
suppressMessages(library(metafor))

# --- Functions ----
if.geo2rformat <- function(geo2r_res_file, inputfolder) {
	cnames <- gsub('"', '', unlist(strsplit(system(paste0("head -n 1 ", inputfolder, geo2r_res_file), intern = TRUE), '"\\t"')))
	if(length(which(cnames %in% c("ID", "adj.P.Val", "P.Value", "t", 
						   "B", "logFC", "Gene.symbol", "Gene.title"))) != 8) {
		message(paste(geo2r_res_file, "file does not look as a GEO2R output with Confidence Interval..."))
		FALSE
	} else {
		if(strsplit(system(paste0("wc ", inputfolder, geo2r_res_file), intern = TRUE), "\\s")[[1]][2] == 1) {
			message(paste(geo2r_res_file, "file looks as a GEO2R output but with no-rows"))
			FALSE
		} else {
			TRUE
		}
	}
}

# DEFINE COLUMN WITH ENTRY - LOGFC
deg.def <- function(geo2r, columnStatistics, pvalue, logfc) {

	mutate(geo2r, deg = ifelse(as.numeric(!!as.name(columnStatistics)) < pvalue & as.numeric(logFC) < (-1*logfc), -1,
				   ifelse(as.numeric(!!as.name(columnStatistics)) < pvalue & as.numeric(logFC) > logfc, 1, 0)))

}

collapse.deg <- function(geo2r) {
	ugen <- names(which(table(geo2r[['Gene.symbol']]) == 1))
	dgen <- names(which(table(geo2r[['Gene.symbol']]) > 1))
	if(length(dgen) == 0) {
		geo2r
	} else {
		sdgen <- filter(geo2r, Gene.symbol %in% dgen)
		expdir <- summarize(group_by(sdgen, Gene.symbol), deg_sum = length(unique(deg)))
		rbind(filter(geo2r, Gene.symbol %in% ugen), 
		      filter(sdgen, Gene.symbol %in% filter(expdir, deg_sum == 1)[['Gene.symbol']]))
	}
}

rename.col <- function(geo2r_list, columnFeatureid, ncores) {
	mclapply(1:length(geo2r_list), function(nstudy) {
		       geo2r <- geo2r_list[[nstudy]]

		       colnames(geo2r) <- paste(colnames(geo2r), nstudy, sep = "_")

		       #print(colnames(geo2r))

		       #valor <- match( !!as.name(paste0(columnFeatureid,"_",nstudy)) , colnames(geo2r) )

		       index <- which(colnames(geo2r) == as.name(paste0(columnFeatureid,"_",nstudy)))

		       #if(collaps) {
			   #    colnames(geo2r)[7] <- "Gene.symbol"
		       #} else {
			       colnames(geo2r)[index] <- columnFeatureid
		       #}
		       return(geo2r)
		       }, mc.cores = ncores)
}	

draw.mv.gplotly <- function(meta_geo2r, nstud, metathr, columnFeatureid, metap) {
		if(metap) {

			g <- ggplot(meta_geo2r, aes(x = organismslist, y = -log10(metap), text = !!as.name(columnFeatureid) )) +
				geom_point(aes(color = dcol_combin) , alpha = 0.9) +
				labs(x = "Meta-Fold Change",
				     y = "-log10(Meta-p value)") +
				geom_hline(yintercept = quantile(as.numeric(-log10(meta_geo2r$metap)), 
								 metathr, na.rm = TRUE), 
					   linetype = "longdash", colour = "grey", alpha = 0.4) +
				geom_vline(xintercept = c(-(quantile(as.numeric(meta_geo2r$organismslist), 
								     1-metathr, na.rm = TRUE)),
							    quantile(as.numeric(meta_geo2r$organismslist), 
								     1-metathr, na.rm = TRUE)), 
			   		   linetype = "longdash", colour = "grey", alpha = 0.4)

		} else {

			g <- ggplot(meta_geo2r, aes(x = ddeg, y = ndeg, text = !!as.name(columnFeatureid) )) +
				geom_jitter(aes(color = dcol_vote) , alpha = 0.9, width = 0.4) +
				labs(x = "Direction consistency of the differential fasta",
				     y = "Number of studies being differentially expressed") +
				geom_vline(xintercept = c(-(nstud*metathr), (nstud*metathr)), 
					   linetype = "longdash", colour = "grey", alpha = 0.4) +
				geom_hline(yintercept = nstud*metathr, 
					   linetype = "longdash", colour = "grey", alpha = 0.4)

		}
		ggplotly(
			g + 
			theme_classic() +
			theme(panel.border= element_blank()) +
			theme(axis.text.x = element_text(angle = 0, hjust = 1)) +
			theme(axis.line.x = element_line(color = "black", size = 0.6, lineend = "square"),
			      axis.line.y = element_line(color = "black", size = 0.6, lineend = "square")) +
			theme(legend.position = "none") + 
			scale_color_manual(values=c("#377EB8", "grey", "#E41A1C"))
		)
}

set.degbar.data <- function(geo2r_res) {
	deg_sum <- lapply(names(geo2r_res), function(geo2rname) {
				  geo2r <- geo2r_res[[geo2rname]]
				  deg_sum <- rep("b.Unperturbed", nrow(geo2r))
				  deg_sum[which(geo2r[[grep('deg', colnames(geo2r))]] == -1)] <- "c.Downregulated"
				  deg_sum[which(geo2r[[grep('deg', colnames(geo2r))]] ==  1)] <- "a.Upregulated"
				  data.frame('dataset' = rep(geo2rname, nrow(geo2r)),
					     'Regulation' = deg_sum)
			   })
	Reduce(rbind, deg_sum)
}

draw.degbar <- function(degbar_data) {
	ggplotly(
		ggplot(degbar_data, aes(dataset)) +
			geom_bar(aes(fill = Regulation)) +
			theme_classic() +
			theme(panel.border= element_blank()) +
			theme(axis.text.x = element_text(angle=90, hjust = 1)) +
			theme(axis.line.x = element_line(color="black", size = 0.6, lineend = "square"),
	      		      axis.line.y = element_line(color="black", size = 0.6, lineend = "square")) +
	        	guides(colour = guide_colorbar()) +
			labs(x = "Datasets",
			     y = "Number of genes") +
			scale_fill_manual(values=c("#E41A1C", "grey", "#377EB8" ))
		)
}

cum.freq.data <- function(meta_geo2r, nstud) {
	data.frame(DEGs = sapply(0:nstud, function(idx) {
		     length(which(meta_geo2r[['ndeg']] >= idx))
		     }),
		   ndatasets = 0:nstud
	)
}

draw.cum.freq <- function(meta_geo2r, nstud) {
	ggplotly(
	ggplot(cum.freq.data(meta_geo2r, nstud), aes(x = ndatasets, y = DEGs)) +
	       geom_line(color = "lightblue", size = 2, alpha = 0.7) +
	       theme_classic() +
	       theme(panel.border= element_blank()) +
	       theme(axis.text.x = element_text(angle=0, hjust = 1)) +
	       theme(axis.line.x = element_line(color="black", size = 0.6, lineend = "square"),
		     axis.line.y = element_line(color="black", size = 0.6, lineend = "square")) +
		guides(colour = guide_colorbar()) +
		labs(x = "Number of datasets",
		     y = "Number of differentially expressed genes") +
		scale_x_discrete(limits=0:nstud)
	)
}

draw.degbar.cum <- function(geo2r_res, columnStatistics, columnFeatureid, pvalue, logfc, jobname, outputfolder, ncores) {
	nstud <- length(geo2r_res)

	# --- Defining DEGs, criteria = Pmethod, pvalue and lofFC-value
	geo2r_res <- lapply(geo2r_res, function(...) deg.def(..., columnStatistics, pvalue, logfc))

	if(FALSE){

		if (collaps) {
			# --- Removing non-named genes
			geo2r_res <- mclapply(geo2r_res, function(...) filter(..., Gene.symbol != ""), mc.cores = ncores)
				
			# --- Collapsing genes whose probes do not have the same fasta pattern
			geo2r_res_col <- lapply(geo2r_res, collapse.deg)
			geo2r_res_col <- rename.col(geo2r_res_col, collaps, ncores)
			geo2r_res_col <- mclapply(geo2r_res_col, function(...) filter(..., !duplicated(Gene.symbol)), 
						  mc.cores = ncores)
			names(geo2r_res_col) <- names(geo2r_res)
		
			# --- Drawing DEGs by dataset
			gg <- draw.degbar(set.degbar.data(geo2r_res_col))
			# --- Writing html device for offline visualization
			htmlwidgets::saveWidget(as_widget(gg), paste0(outputfolder, "degbar_", jobname, ".html"))

			# --- merging DEG results	
			meta_geo2r <- Reduce(function(...) merge(..., by = 'Gene.symbol', all = TRUE), geo2r_res_col)

			# --- Defining new vars for visualization
			meta_geo2r[['ndeg']] <- apply(select(meta_geo2r, matches("deg_")), 1, function(r) sum((r^2), na.rm = T))
			meta_geo2r[['ddeg']] <- apply(select(meta_geo2r, matches("deg_")), 1, function(r) sum(r, na.rm = TRUE))
		
			# --- Drawing cDEGs by dataset
			gg <- draw.cum.freq(meta_geo2r, nstud)
			#print(nstud)
			# --- Writing html device for offline visualization
			htmlwidgets::saveWidget(as_widget(gg), paste0(outputfolder, "cumdeg_", jobname, ".html"))
		
			#return(filter(meta_geo2r, ndeg != 0))
			return(meta_geo2r)

		} #else {

	}
		
	# --- Drawing DEGs by dataset
	gg <- draw.degbar(set.degbar.data(geo2r_res))

	# --- Writing html device for offline visualization
	htmlwidgets::saveWidget(as_widget(gg), paste0(outputfolder, "degbar_", jobname, ".html"))

	# --- merging DEG results
	meta_geo2r <- Reduce(function(...) merge(..., by = columnFeatureid, all = TRUE), rename.col(geo2r_res, columnFeatureid, ncores))
	#meta_geo2r <- Reduce(function(...) merge(..., by = columnFeatureid, all = TRUE))

	# --- Defining new vars for visualization
	meta_geo2r[['ndeg']] <- apply(select(meta_geo2r, matches("deg_")), 1, function(r) sum((r^2), na.rm = T))
	meta_geo2r[['ddeg']] <- apply(select(meta_geo2r, matches("deg_")), 1, function(r) sum(r, na.rm = TRUE))
	
	# --- Drawing cDEGs by dataset
	gg <- draw.cum.freq(meta_geo2r, nstud)
	# --- Writing html device for offline visualization
	htmlwidgets::saveWidget(as_widget(gg), paste0(outputfolder, "cumdeg_", jobname, ".html"))

	# return(filter(meta_geo2r, ndeg != 0))
	return(meta_geo2r)
	
	#}	
	
}

draw.metavolcano <- function(meta_geo2r, metathr, nstud, jobname, columnFeatureid, outputfolder) {
	meta_geo2r <- mutate(meta_geo2r, 
			     dcol_vote = ifelse(ndeg >= nstud*metathr & ddeg >= nstud*metathr, "Up-regulated",
					   ifelse(ndeg >= nstud*metathr & ddeg <= -nstud*metathr, "Down-regulated", 
						  "Unperturbed")))
	# --- Drawing volcano ggplotly 
	gg <- draw.mv.gplotly(meta_geo2r, nstud, metathr, columnFeatureid, FALSE)
	# --- Writing html device for offline visualization
	htmlwidgets::saveWidget(as_widget(gg), paste0(outputfolder, jobname, ".html"))
	meta_geo2r
}

draw.metavolcano.metap <- function(meta_geo2r, columnFeatureid, columnLog2fc, columnStatistics, metathr, nstud, jobname, metap, organismslist, outputfolder) {
	if(metap == "Fisher") {
		meta_geo2r <- mutate(meta_geo2r, 
				     metap = apply(select(meta_geo2r, matches(columnStatistics)), 1, 
						   function(p) { 
							   pp <- as.numeric(p[which(!is.na(p))])
							   if(length(pp) == 1) {
							   	pp
							   } else {
								metap::sumlog(pp)$p
							   }
						   }))
	}
	if(organismslist == "Mean") {
		meta_geo2r <- mutate(meta_geo2r,
				     organismslist = apply(select(meta_geo2r, matches(columnLog2fc)), 1, 
						   function(...) mean(as.numeric(...), na.rm = TRUE)))
	} else if (organismslist == "Median") {
		meta_geo2r <- mutate(meta_geo2r, 
				     organismslist = apply(select(meta_geo2r, matches(columnLog2fc)), 1, 
						   function(...) median(as.numeric(...), na.rm = TRUE)))
	}

	meta_geo2r <- mutate(meta_geo2r, 
			     dcol_combin = ifelse(metap <= quantile(as.numeric(metap), 1-metathr, na.rm = TRUE) & 
					   organismslist >= quantile(as.numeric(organismslist), metathr, na.rm = TRUE), "Up-regulated",
					   ifelse(metap <= quantile(as.numeric(metap), 1-metathr, na.rm = TRUE) & 
					      	  organismslist <= quantile(as.numeric(organismslist), 1-metathr, na.rm = TRUE), "Down-regulated", 
						  "Unperturbed")))
	# --- Drawing volcano ggplotly 
	gg <- draw.mv.gplotly(meta_geo2r, nstud, metathr, columnFeatureid, TRUE)
	# --- Writing html device for offline visualization
	htmlwidgets::saveWidget(as_widget(gg), paste0(outputfolder, jobname, "_metap.html"))
	meta_geo2r
}

calc.vi <- function(geo2r) {
	print(dim(geo2r))
	geo2r[['vi']] <- apply(geo2r, 1, function(gene) {
				    ((as.numeric(gene['CI.R']) - as.numeric(gene['CI.L']))/3.92)^2 
			     })
	geo2r
}

rnmodel <- function(gene) {
	fc <- gene[grep("logFC", names(gene))]
	fc <- as.numeric(fc[which(!is.na(fc))])
	v <- gene[grep("vi", names(gene))]
	v <- as.numeric(v[which(!is.na(v))])
	
	# compute random and fixed effects from FCs e variances
	random <- tryCatch({ metafor::rma(fc, v) }, 
		error = function(e){ return(e) })
	# Increase iterations in case Fisher scoring algorithm doesn't converge
	if(any(class(random) == 'error')) {
		random <- tryCatch({ metafor::rma(fc, v, control = list(maxiter = 2000, stepadj = 0.5)) },
			error = function(e){ print(e); return(e) })
	}
	# If metafor is still returning error, give up and register line for gene
	if(any(class(random) == 'error')) {
		df_res <- data.frame(dircon = length(which(fc > 0)) - length(which(fc < 0)),
				     randomSummary = NA, 
				     randomCi.lb = NA, 
				     randomCi.ub = NA, 
				     randomP = NA, 
				     het = NA, 
				     het_p = NA, 
				     #available = available, 
				     error = T)
	} else {
		df_res <- data.frame(dircon = length(which(fc > 0)) - length(which(fc < 0)),
				     randomSummary = as.numeric(random$beta), 
				     randomCi.lb = random$ci.lb, 
				     randomCi.ub = random$ci.ub, 
				     randomP = random$pval, 
				     het = random$QE, 
				     het_p = random$QEp, 
				     #available = available, 
				     error = F)
	}
	return(df_res)
}	

draw.metav <- function(meta_res, jobname, outputfolder) {
	gg <- ggplotly(
			ggplot(arrange(meta_res, abs(randomSummary)),
				aes(x = randomSummary, y = -log10(randomP), color = dircon, text = Gene.symbol)) +
					geom_point() +
					scale_color_gradient2(midpoint=0, low="blue", mid="white", high="red") +
					geom_errorbarh(aes(xmax = randomCi.ub, xmin = randomCi.lb, color = dircon)) +
					theme_classic() +
					theme(panel.border= element_blank()) +
					theme(axis.text.x = element_text(angle = 0, hjust = 1)) +
					theme(axis.line.x = element_line(color = "black", size = 0.6, lineend = "square"),
					      axis.line.y = element_line(color = "black", size = 0.6, lineend = "square"))
	)
	htmlwidgets::saveWidget(as_widget(gg), paste0(outputfolder, "randomSummary_", jobname, ".html"))
}

do.metafor <- function(geo2r_res, pcriteria, pvalue, logfc, collaps, jobname, outputfolder, ncores) {
	# --- Defining DEGs, criteria = Pmethod, pvalue and lofFC-value
	geo2r_res <- lapply(geo2r_res, function(...) deg.def(..., pcriteria, pvalue, logfc))
	
	# --- Removing non-named genes
	geo2r_res <- mclapply(geo2r_res, function(...) filter(..., Gene.symbol != ""), mc.cores = ncores)
	

	geo2r_res <- lapply(geo2r_res, function(...) calc.vi(...))
	
	# --- Collapsing genes whose probes do not have the same fasta pattern
#	geo2r_res_col <- lapply(geo2r_res, collapse.deg)
	geo2r_res_col <- rename.col(geo2r_res, collaps, ncores)
	geo2r_res_col <- mclapply(geo2r_res_col, function(...) filter(..., !duplicated(Gene.symbol)), 
				  mc.cores = ncores)

	names(geo2r_res_col) <- names(geo2r_res)
	
	print(str(geo2r_res_col))
	
	meta_geo2r <- Reduce(function(x, y) merge(x, y, by = "Gene.symbol", all = TRUE), geo2r_res_col)

	meta_res <- cbind(meta_geo2r, Reduce(rbind, apply(meta_geo2r, 1, function(...) rnmodel(...))))
	draw.metav(meta_res, jobname, outputfolder)
	meta_res
}

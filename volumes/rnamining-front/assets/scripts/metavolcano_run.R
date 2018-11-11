# ------
# Running MetaVolcano interactively
# ------
source("./metavolcano_source.R")

msgStatus <- function(status_msg){
        status <- paste0('{"status" : "',status_msg,'"}','\n')
        cat(status)
}

errorExit <- function(error_msg){
        error <- paste0('{"error" : "',error_msg,'"}')
        cat(error)
        stop(error_msg)
}

msgStatus("Start execution...")

args <- commandArgs(trailingOnly = TRUE)
# Input parameters
folder <- args[1] # "/<whole path>"
jobname <- args[2] # "test"
metathr <- as.numeric(args[3]) # 0.8 # percentage of DE to be considered as cDEG

#pcriteria <- args[4] # "P.Value" #"P.Value"#"adj.P.Val" #c("adj.P.Val", "P.Value")
columnFeatureid <- args[4]
columnLog2fc <- args[5]
columnStatistics <- args[6]

pvalue <- as.numeric(args[7]) # 0.05
logfc <- as.numeric(args[8]) # 0.1 
ncores <- as.numeric(args[9]) # 4 # number of processor user wants to use
#collaps <- args[8] # TRUE # c(TRUE, FALSE)
metap <- args[10] # "Fisher"
organismslist <- args[11] # "Mean" # c("Mean", "Median")
optionCI <- as.logical(as.numeric(args[12])) # If use CI

# define input/output dir
inputfolder <- paste(folder,"input/",sep = "/")
outputfolder <- paste(folder,"/",sep = "/")

# --- data input
geo2r_res_files <- list.files(path = inputfolder)

geo2r_res_files <- setNames(geo2r_res_files, gsub("\\..+", "", geo2r_res_files))

# these function verify tables - ERROR
#geo2r_res_files <- geo2r_res_files[which(sapply(geo2r_res_files, 
#						function(...) if.geo2rformat(..., inputfolder)))] # checking files' format before read them into the R enviroment 

geo2r_res <- mclapply(geo2r_res_files, function(...) fread(paste0(inputfolder, ...)), 
		      mc.cores = ncores)

nstud <- length(geo2r_res)

# --- Running 

msgStatus("Starting stage 1...")

msgStatus("Executing Function draw degbar cum...")
# --- draw meta-volcano (stage 1) DEGs by study and cummulative DEG distribution
meta_geo2r <- draw.degbar.cum(geo2r_res, columnStatistics, columnFeatureid, pvalue, logfc, jobname, outputfolder, ncores)
	# showing DEGs table
	#print(head(meta_geo2r, 3))
	# writing table

msgStatus("Finish executing Function draw degbar cum...")

msgStatus("Executing write file deg_by_study tsv...")
	write.table(meta_geo2r, paste0(outputfolder, '/output/', "deg_by_study_", jobname, ".tsv"), 
		    sep = "\t", row.names = FALSE, quote = FALSE)
msgStatus("Finish executing write file deg_by_study tsv...")

msgStatus("Executing Function draw metavolcano...")
	# --- draw meta-volcano (stage 2) "Vote-counting aproach"
meta_degs <- draw.metavolcano(meta_geo2r, metathr, nstud, jobname, columnFeatureid, outputfolder)
	# showing meta-DEGs
	#print(head(meta_degs, 3))
msgStatus("Finish executing Function draw metavolcano...")

msgStatus("Finish execution stage 1...")

# --- draw meta-volcano (stage 2) "Combining aproach" FC Mean or Median & Fisher combining p-values
msgStatus("Executing stage 2...")
# --- [[[ here would be perfect to have a different slider for the metathr ]]]
meta_degs_metap <- draw.metavolcano.metap(meta_geo2r, columnFeatureid, columnLog2fc, columnStatistics, metathr, nstud, 
					  jobname, metap, organismslist, outputfolder)

	# showing meta-DEGs
	#print(head(meta_degs_metap, 3))
	# writing table
	write.table(meta_degs_metap, paste0(outputfolder, '/output/', "meta_degs_", jobname, "_combining.tsv"), 
		    sep = "\t", row.names = FALSE, quote = FALSE)

msgStatus("Finish execution stage 2...")

if(optionCI){

	# --- draw meta-volcano (stage 3) "Random effect model approach" calculating proper meta-Fold change
	msgStatus("Executing stage 3...")

	meta_degs_metafor <- do.metafor(geo2r_res, pcriteria, pvalue, logfc, collaps, jobname, outputfolder, ncores)
		#print(head(meta_degs_metafor, 3))
		# writing table
		write.table(meta_degs_metafor, paste0(outputfolder, '/output/', "metafor_degs_", jobname, "_summarizing.tsv"), 
			    sep = "\t", row.names = FALSE, quote = FALSE)

	msgStatus("Finish execution stage 3!")

}

msgStatus("Execution successful!")
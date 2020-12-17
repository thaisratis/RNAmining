from sys import argv
import sys
import os
from Bio import SeqIO
from Bio import Seq
#call script: python arff_creator.py sequences.fa

def Verification(input_verification,output_verification):

	input_file = open(input_verification,"r")
	lines = input_file.readlines()

	firstline = lines[0]
	lastline = lines[-1]

	if((not firstline.startswith('>')) or (lastline.startswith('>'))):
		sys.exit("Error: The inserted file does not match with the default of fasta file! Check the lines, the header and sequence lines do not match!")
			
	else:
		for index, record in enumerate(SeqIO.parse(input_verification, "fasta")):
			seed= record.seq
			output_verification.writelines(">" + record.description + '\n' + seed + '\n')



def header(dl_input):

	#header arff file
	from itertools import product


	dl_input.writelines('@relation rna\n\n')

	caracteres = ['a', 'c', 'g', 't']
	permsList = [''.join(str(i) for i in x) for x in product(caracteres, repeat=3)]
	for i in permsList:
		dl_input.writelines('@attribute '+i + ' real\n')

	dl_input.writelines('\n@data\n')



def trinucleotides_counts(file_counts,output_file):

	my_seq = open(file_counts,"r");
	mapa = {"a" : 0,"c" : 1,"t" : 2,"g" : 3}
	tri_nucleotides_counts =[[[0 for col in range(4)]for row in range(4)] for x in range(4)]
	word = ""
	toCompare = ["a","c","t","g"]
	
	my_seq.readline()

	for line in my_seq:
	    word = str(line.lower())[:-1]
	    if(line[0] != '>'):
	    	for x in range(0,len(word)-2,3):
	    		if(word[x] in toCompare):
	    			first = mapa[word[x]]
	    		if(word[x+1] in toCompare):
	    			seccond = mapa[word[x + 1]]
	    		if(word[x+2] in toCompare):
	    			third = mapa[word[x + 2]]
	    			tri_nucleotides_counts[first][seccond][third] += 1
	            
	    if(line[0] == '>'):

	    	for i in range(0, 4):
	    		for j in range(0, 4):
	    			for l in range(0, 4):
	    				if(i ==3 & j==3 & l==3):
	    					output_file.writelines(str(tri_nucleotides_counts[i][j][l]) + "\n")
	    				else:
	    					output_file.writelines(str(tri_nucleotides_counts[i][j][l]) + ", ")
	    	tri_nucleotides_counts =[[[0 for col in range(4)]for row in range(4)] for x in range(4)]
				

	#last sequence counts
	for i in range(0, 4):
		for j in range(0, 4):
			for l in range(0, 4):
				if(i ==3 & j==3 & l==3):
					output_file.writelines(str(tri_nucleotides_counts[i][j][l]))
				else:
					output_file.writelines(str(tri_nucleotides_counts[i][j][l]) + ", ")



def take_ids(filename):
	inputfile = open(filename, "r")
	id = []

	for line in inputfile:
		if(line[0] == '>'):
			#if(len(line) > 20):
			#	id.append(line[1:20])
			#else:
			id.append(line[1:-1])

	return id

class RNA:
	id = ""
	sequence = ""
	
	def __init__(self, id, sequence):
		self.id = id
		self.sequence = sequence
		
	def setid(self,id):
		self.id = self
		
	def getid(self):
		return self.id
		
	def setsequence(self, sequence):
		self.sequence = sequence
		
	def getsequence(self):
		return self.sequence
		
	def __eq__(self, other):
		return self.id == other.id


def loadsequences(filename,prediction,coding_output,nc_output):
	
	listcodingRNA = []
	listncRNA = []
	tempid = ""
	tempseq = ""

	with open(filename) as input_data:
		tempid = input_data.readline() #Read the first id

		#predictionfile = open(prediction, "r")

		#Read the prediction headers
		for i in range(0,5):
			prediction.readline()

		for classification in prediction:
			classification_split = classification.split("\t")
			sequence_id = classification_split[0]
			classification_id = classification_split[1]

			#input_data = open(filename, 'r')

			for line in input_data:
				if line.startswith(">"):

					if((tempid[1:-1] == sequence_id) and (("non-coding" in classification_id) == True)):
						listncRNA.append(RNA(tempid,tempseq))

					elif((tempid[1:-1] == sequence_id) and (("non-coding" in classification_id) == False)):
						listcodingRNA.append(RNA(tempid,tempseq))
					
					else:
						continue;
					
					tempid = line
					tempseq = ""
					break;

				else:	
					tempseq += line
			#add the last one

		if(("non-coding" in classification_id) == True):
			listncRNA.append(RNA(tempid,tempseq))
		else:
			listcodingRNA.append(RNA(tempid,tempseq))


	for item in listncRNA:
		nc_output.writelines("%s%s" % (item.id, item.sequence))


	for item in listcodingRNA:
		coding_output.writelines("%s%s" % (item.id, item.sequence))


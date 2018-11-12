from sys import argv
import sys

#call script: python arff_creator.py sequences.fa

def Verification(input_file):

	input_file = open(input_file,"r")
	lines = input_file.readlines()

	firstline = lines[0]
	lastline = lines[-1]

	if((not firstline.startswith('>')) or (lastline.startswith('>'))):
		sys.exit("The inserted file does not match with the default of fasta file!")
        


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
			if(len(line) > 20):
				id.append(line[1:20])
			else:
				id.append(line[1:-1])

	return id

#def main():
#	output_file = open('dl_input.arff', 'w')
#	header(output_file)
#	filename = argv[1]
#	trinucleotides_counts(filename,output_file)


#main()
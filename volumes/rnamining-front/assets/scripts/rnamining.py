from scipy.io import arff
import numpy as np
import pandas as pd
from sys import argv
from counters import arff_creator
import argparse
import os
import pickle

os.environ['TF_CPP_MIN_LOG_LEVEL'] = '3' 

def process_inputfile(filename, organism_name):
    """
        Description: function to process the input file. It generates the header and counts its nucleotides frequency. Then,
        it reads the file and uses as input to the network model.
        Arguments: filename - the name of input file
                   organism_name - the name of the organism (e.g.. escherichia_coli, arabidopsis_thaliana)

    """
    out = organism_name+'.arff'
    output_file = open(out, 'w')
    arff_creator.Verification(filename)
    arff_creator.header(output_file)
    arff_creator.trinucleotides_counts(filename,output_file)
    output_file.close()
    data = arff.loadarff(out)
    data = pd.DataFrame(data[0])
    
    #Normalização do tamanho da sequencia
    ar = np.array(data)
    X = ar.astype(int)
    norm = X.sum(axis=1) * 3
    X = X / norm[:,np.newaxis]
    
    os.remove(out)

    return X


def process_outputfile(filename_path, predict, organism_name, prediction_type, output_folder):
    """
        Description: function that generates the output file. First, it converts the predict classes so that the predictions
        with value equal to 1 are renamed to coding and 0 to non-coding. Then, the funciton generates a file with a header for general information
        (i.e. sequence type and organism name) and the predictions itself.
        Arguments: predict - an array with the sequence predictions 
                   organism_name - the name of the organism (e.g.. escherichia_coli, arabidopsis_thaliana)
                   prediction_type - the sequence type (coding_prediction, ncRNA_functional_assignation)
    """
    out = ["" for x in range(len(predict))]
    ids = arff_creator.take_ids(filename_path)

    for i in range(len(predict)):

        #The last instance
        if(i==(len(predict)-1)):
            if predict[i]==0:
                out[i] = ids[i] + '\tnon-coding'
            
            else:
                out[i] = ids[i] + '\tcoding'
        else:
            #All instances
            if predict[i]==0:
                out[i] = ids[i] + '\tnon-coding\n'
                
            else:
                out[i] = ids[i] + '\tcoding\n'
                
    output_file = open(output_folder+'/predictions.txt', 'w')
    output_file.writelines("RNAMining Predictions\n")
    output_file.writelines("Prediction Type: " + prediction_type + '\n')
    output_file.writelines("Name of the Organism: " + organism_name + '\n')
    output_file.writelines("Sequence ID \t Predictions:\n\n")
    output_file.writelines(out)
    output_file.close()

    #Create a file to Coding Sequences and Non-Coding Sequences
    coding_output_file = open(output_folder+'/codings.txt', 'w')
    nc_output_file = open(output_folder+'/noncodings.txt', 'w')

    classification_file = open(output_folder+'/predictions.txt', 'r')

    arff_creator.loadsequences(filename_path,classification_file,coding_output_file,nc_output_file)
    
    coding_output_file.close()
    nc_output_file.close()
    classification_file.close()

    #output_file.writelines(out)
    #np.savetxt('predictions.txt',out,delimiter = ",", fmt="%s")
def predict(filename_path, organism_name, prediction_type, output_folder):
    """
        Description: function to predict a sequence based on a trained CNN model. The function first process the input file
        by counting the nucleotides frequency and loading the trained model of the organism. Thereafter, the function returns
        the seuqence prediction and generates the output_file.
        Arguments: filename - the filename path that contains the sequence
                   organism_name - the name of the organism (e.g.. escherichia_coli, arabidopsis_thaliana)
                   prediction_type - the sequence type (coding_prediction, ncRNA_functional_assignation)
    """

    try:
        X = process_inputfile(filename_path, organism_name)
        model = pickle.load(open('models/' + 'teste/' + organism_name + '.pkl', 'rb'))
        predict = model.predict(X)
        process_outputfile(filename_path, predict, organism_name, prediction_type,output_folder)
            
    except NameError:
        print('Please check if organism_name and prediction_type matches RNAMining documentation.')

def main():
    parser = argparse.ArgumentParser(description='RNAmining: a deep learning stand-alone and web server tool for sequences coding prediction and RNA functional assignation')
    parser.add_argument('-f','--filename', help='The filename with a sequence to predict', required=True)
    parser.add_argument('-organism_name','--organism_name', help='The name of the organism you want to predict/train. Currently, the following organism names are suported in this tool: escherichia_coli, arabidopsis_thaliana, drosophila_melanogaster, homo_sapiens, mus_musculus, saccharomyces_cerevisiae', required=True)
    parser.add_argument('-prediction_type','--prediction_type', help='The type of the sequence (coding_prediction, ncRNA_functional_assignation)', required=True)
    parser.add_argument('-output_folder', '--output_folder', help='The output folder',required= True)
    args = vars(parser.parse_args())
    
    predict(args['filename'], args['organism_name'], args['prediction_type'], args['output_folder'])
    

main()

import argparse
import numpy as np
import pandas as pd
from scipy.io import arff
from xgboost import XGBClassifier
import imp
from counters import arff_creator
import os
import _pickle as pkl
from sklearn.utils import shuffle

def process_inputfile(filename, organism_name):
    """
        Description: function to process the input file. It generates the header and counts its nucleotides frequency. Then,
        it reads the file and uses as input to the network model.
        Arguments: filename - the name of input file
                   organism_name - the name of the organism (e.g.. mus_musculus, homo_sapiens)

    """
    out = organism_name+'.arff'
    output_file = open(out, 'w')
    arff_creator.Verification(filename)
    arff_creator.header(output_file)
    arff_creator.trinucleotides_counts(filename,output_file)
    output_file.close()


    return out


def process_dataset(path, cod):
    """
        Description: function to read the dataset, separates the input and the target, as well as performs one hot encoding
        in the target and it adjusts the input to 3 dimensions so that it can be used on the network.
        Arguments - path: the dataset filename path
        return - the input matrix (X) and the target one-hot encoding matrix (Y)
    """
    data = arff.loadarff(path)
    data = pd.DataFrame(data[0])
    ar = np.array(data)
    X = ar.astype(int)
    #Normalização do tamanho da sequencia
    norm = X.sum(axis=1) * 3
    X = X / norm[:,np.newaxis]
      
    if cod:
        Y = np.ones(X.shape[0], dtype=int)
    else:
        Y = np.zeros(X.shape[0], dtype=int)
    dataset = pd.DataFrame(X)
    dataset['cod'] = Y     
    
    return dataset

def balance(dataset_cod, dataset_ncod):
    cod_instances = dataset_cod.shape[0]
    ncod_instances = dataset_ncod.shape[0]
    

    dataset_cod = shuffle(dataset_cod, random_state=0)
    dataset_ncod = shuffle(dataset_ncod, random_state=2)

    if ncod_instances < cod_instances:
        dataset_cod = dataset_cod.sample(n = ncod_instances)
    elif cod_instances > ncod_instances:
        dataset_ncod = dataset_ncod.sample(n = cod_instances)
        
        
    final_dataset = pd.concat([dataset_cod, dataset_ncod], ignore_index= True, axis=0)
    final_dataset = shuffle(final_dataset)
    
    return final_dataset


def xgboost_model(X_train, y_train, output_file):
   # Fitting Xgboost to the Training set
   classifier = XGBClassifier()
   classifier.fit(X_train, y_train)
   
   pkl.dump(classifier, open(output_file+'.pkl', 'wb'), -1)
   
   return classifier

# RNAMining 

RNAmining is a web tool that allows coding potential prediction and non-coding RNA functional assignation. It takes a user-defined fasta sequences and depending on the user chosen option, it distinguish coding and non-coding sequences or perform the non-coding RNA assignation. The tool performs the predictions using Deep Learning (Convolutional Neural Networks) and this repository contains the implementation using Python and Keras API using the Tensorflow framework.

## How it works

RNAMining is based on four main steps:

1. It receives RNA sequences in a file of a specific organism
2. It counts the nucleotides frequency of each sequence
3. It loads a Convolutional Neural Network trained model of the organism.
4. It returns the predictions of each sequence 

## Instructions

First, make sure you have Python 3.6, Pandas, Scikit-learn, Keras and Tensorflow installed. Then, go into scripts folder and run the rnamining.py file. The file can be used to predict new sequences or to train a CNN model. If the fasta file header has more than 20 characters, only the first 20 characters will be displayed in the results file. The file results will be called "predictions.txt".

### Predict

To perform prediction, go to therminal and run:

```sh
$ python3 rnamining.py -f filename -organism_name organism_name -prediction_type coding_prediction -output_folder output
```
where: filename is the filename path of the file with RNA sequences to predict, organism_name is the name of the organism (arabidopsis_thaliana, drosophila_melanogaster, escherichia_coli, homo_sapiens, mus_musculus or saccharomyces_cerevisiae) to predict, prediction_type is the type of the prediction (coding_prediction, ncRNA_functional_assignation) and output_folder is the folder where the file results will be saved (make sure that the folder already exists). Please note that RNAMining provides a list of specific organisms trained by the Deep Learning algorithm and it only works for these specific organisms. 

### Train

To train a model, go to the terminal and run:

```sh
$ python3 rnamining.py -f filename -out path_to_model -prediction_type coding_prediction -p False
```
where: filename is the filename path of the file with RNA sequences to predict, path_to_model is the path that your network model will be saved in h5 extension and prediction_type the type of the prediction (coding_prediction, ncRNA_functional_assignation). Also, make sure the -p flag is set to False to perform train over prediction. 

Please note that this command-line will train a network with the default parameters values. To check these values run:

```sh
$ python3 rnamining.py -h 
```
This command will display all the parameters available to change such as the number of filters and kernel_size of the convolutional neural network layers. To change it run the rnamining.py script as described above and add the parameter you want to change. For instance, if you want to change the number of filters, run:

```sh
$ python3 rnamining.py -f filename -out path_to_model -prediction_type coding_prediction -p False -num_filters 128
```
In addition, if you want to train each layer with different kernel size (e.g. first layer with 3x3 filters and the second one with 5x5 filters), run:

```sh
$ python3 rnamining.py -f filename -out path_to_model -prediction_type coding_prediction -p False -k 3 5
```

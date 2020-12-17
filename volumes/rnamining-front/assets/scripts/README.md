# RNAMining 

RNAmining is a stand-alone and web tool that allows nucleotides coding potential prediction. It only takes a user-defined fasta sequences and the name of the organism the user wants to use as model organism. The tool performs the predictions using XGBoost algorithm and this repository contains the implementation using Python language.

# Dependencies

1. Python Version >= 3.8
2. Pandas Version >= 0.23.3
3. Scikit-learn Version >= 0.21.3
4. XGBoost Version >= 1.2.0
5. Biopython Version >= 1.78

## How it works

RNAMining is based on four main steps:

1. It receives RNA sequences in a file of a specific organism
2. It counts the nucleotides frequency of each sequence
3. It perfoms a sequences normalization by its lenght
4. It loads a XGBoost trained model of the organism
5. It returns the predictions of each sequence 

## Instructions

First, make sure you have Python 3.8, Pandas, Scikit-learn and Xgboost installed. Then, go into scripts folder and run the rnamining.py file. The file can be used to predict new sequences or to train a new model. The file results will be called "predictions.txt".

### Predict

To perform prediction, go to therminal and run:

```sh
$ python3 rnamining.py -f cod filename -organism_name organism_name -prediction_type coding_prediction -output_folder output
```
where: filename is the filename path of the file with RNA sequences to predict, organism_name is the name of the organism (Anolis_carolinensis, Chrysemys_picta_bellii, Crocodylus_porosus, Danio_rerio, Eptatretus_burgeri, Gallus_gallus, Homo_sapiens, Latimeria_chalumnae, Monodelphis_domestica, Mus_musculus, Notechis_scutatus, Ornithorhynchus_anatinus, Petromyzon_marinus, Sphenodon_punctatus, Xenopus_tropicalis) to predict, prediction_type is the type of the prediction which is coding_prediction and output_folder is the folder where the file results will be saved (make sure that the folder already exists). Please note that RNAMining provides a list of specific organisms trained by the XGBoost algorithm and it this option only works for these specific organisms. 

### Train

To train a model, go to the terminal and run:

```sh
$ python3 rnamining.py -f coding_filename -n noncoding_filename -organism_name organism_name -out path_and_model_name -prediction_type coding_prediction -p False
```
where: filename is the filename path of the file with RNA sequences to predict, path_to_modeland_model_name is the path that your model will be saved in pkl extension (eg. /home/user/models/model) and prediction_type the type of the prediction (coding_prediction, ncRNA_functional_assignation). Also, make sure the -p flag is set to False to perform train over prediction. 

Please note that this command-line will train a Xgboost classifier with the default parameters values. To check these values run:

```sh
$ python3 rnamining.py -h 
```
This command will display all the parameters available to change. To change it run the rnamining.py script as described above and add the parameter you want to change. 

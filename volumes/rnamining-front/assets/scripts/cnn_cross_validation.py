# MLP for Pima Indians Dataset with 10-fold cross validation
from keras.models import Sequential
from keras.layers import Dense
from sklearn.model_selection import StratifiedKFold
import numpy
import numpy as np
import pandas as pd
from scipy.io import arff
from sklearn.preprocessing import LabelEncoder
from sklearn.preprocessing import OneHotEncoder
from keras.models import Sequential
from keras.layers import Dense, Flatten, Dropout, BatchNormalization, Conv1D, Embedding, MaxPooling1D
from sklearn.preprocessing import normalize
from keras.preprocessing.text import one_hot
from keras.preprocessing.sequence import pad_sequences
from sklearn.model_selection import train_test_split, StratifiedKFold
from keras.wrappers.scikit_learn import KerasClassifier
from sklearn.model_selection import cross_val_score
from sklearn.datasets import make_classification
import matplotlib.pyplot as plt
from sklearn.utils import shuffle
from keras.utils import to_categorical

def process_dataset(path, data_type):
	#load data and transforms in dataframe
    #data = pd.read_csv(path, header = None)
    data = arff.loadarff(path)
    data = pd.DataFrame(data[0])
    ar = np.array(data)
    X = ar[:, :-1].astype(int)
    Y = ar[:, -1:]
    X = np.expand_dims(X, 1) 
    label_encoder = LabelEncoder()
    integer_encoded = label_encoder.fit_transform(Y)
    onehot_encoder = OneHotEncoder(sparse=False)
    integer_encoded = integer_encoded.reshape(len(integer_encoded), 1)
    Y = onehot_encoder.fit_transform(integer_encoded)
    return X,Y
   
#X, Y = process_dataset('dl_input.arff', 'train')
#X, Y = process_dataset('..//Datasets//Originais//ecoli.arff', 'train')
#X, Y = process_dataset('..//Datasets//kmer5//sequencias_Cerevisiae.txt', 'train')
#X, Y = process_dataset('..//Datasets//kmer5//sequencias_Mus.txt', 'train')
#X, Y = process_dataset('..//Datasets//kmer//sequencias_Cerevisiae.txt', 'train')

def cnn_model(): 
    model = Sequential()
    model.add(Conv1D(512,5, padding='same', activation='relu', input_shape=(X.shape[1], X.shape[2])))
    model.add(Conv1D(512,5,activation='relu', padding='same'))
    model.add(Flatten())
    model.add(Dense(128,activation="relu"))
    model.add(Dense(2,activation="softmax"))
    model.compile(loss='binary_crossentropy', optimizer='adam', metrics=['accuracy'])
    return model

# fix random seed for reproducibility
seed = 7
numpy.random.seed(seed)
kfold = StratifiedKFold(n_splits=10, shuffle=True, random_state=seed)
cvscores = []

for train, test in  kfold.split(X, Y.argmax(1)):
  # create model
    model = cnn_model()
	# Fit the model
    model.fit(X[train], Y[train], epochs=10, batch_size=64, verbose=1)
	# evaluate the model
    scores = model.evaluate(X[test], Y[test], verbose=1)
    print("%s: %.2f%%" % (model.metrics_names[1], scores[1]*100))
    cvscores.append(scores[1] * 100)
print(cvscores)
print("%.2f%% (+/- %.2f%%)" % (numpy.mean(cvscores), numpy.std(cvscores)))
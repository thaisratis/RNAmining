import argparse
import numpy as np
import pandas as pd
from scipy.io import arff
import imp
from sklearn.preprocessing import LabelEncoder
from sklearn.preprocessing import OneHotEncoder
from keras.models import Sequential
from keras.layers import Dense, Flatten, Dropout, BatchNormalization, Conv1D, Embedding, MaxPooling1D
from keras.models import load_model
import tensorflow as tf
tf.logging.set_verbosity(tf.logging.ERROR)
def process_dataset(path):
    """
        Description: function to read the dataset, separates the input and the target, as well as performs one hot encoding
        in the target and it adjusts the input to 3 dimensions so that it can be used on the network.
        Arguments - path: the dataset filename path
        return - the input matrix (X) and the target one-hot encoding matrix (Y)
    """
    data = arff.loadarff(path)
    data = pd.DataFrame(data[0])
    ar = np.array(data)
    X = ar[:, :-1].astype(int)
    Y = ar[:, -1:]
    onehot_encoder = OneHotEncoder(sparse=False)
    X = np.expand_dims(X, 1) 
    Y = onehot_encoder.fit_transform(Y)
    return X,Y

def cnn_model(X_train,y_train,num_filters,kernels,num_neurons,output_file,a_conv,a_dense,batch_size):
    """"
        Description: a funciton to train the convolutional neural network. The network has two convolutional layers
        and one fully connected (dense) layer. The number of filters and kernel dimension can be the same for all convolution
        layers if the parameters num_filters and kernels are integers or each layer can have its own parameters if these
        parameters are a list of integers. In the end, it saves the model in a h5 file.
        Arguments:  X_train - input data with the nucleotide counts
                    y_train - target array with one-hot encoding
                    num_filters - the number of filters used in convolution layers
                   num_filters - the number of filters used in convolution layers
                   kernels - the kernel dimension used in convolution layers. The filter dimension is quadratic (i.e. mxm) 
                            so it is only necessary to provide the m dimension (e.g. 5 for 5x5 filters).
                   num_neurons - the number of neurons used in fully connected layer
                   activation_conv - the activation function used in convolution layers
                   activation_dense - the activation function used in dense layers
                   batch_size - the size of the batch used for training. 
        Return: the trained model.
    """
    model = Sequential()
    if type(kernels) == list:
        model.add(Conv1D(num_filters,kernels[0], padding='same', activation=a_conv, input_shape=(X_train.shape[1], X_train.shape[2])))
        model.add(Conv1D(num_filters,kernels[1],activation=a_conv, padding='same'))
    else:
        model.add(Conv1D(num_filters,kernels, padding='same', activation=a_conv, input_shape=(X_train.shape[1], X_train.shape[2])))
        model.add(Conv1D(num_filters,kernels,activation=a_conv, padding='same'))    
    model.add(Flatten())
    model.add(Dense(128,activation=a_dense))
    model.add(Dense(2,activation="softmax"))
    model.compile(loss='binary_crossentropy', optimizer='adam', metrics=['accuracy'])
    model.fit(X_train, y_train,
          batch_size=batch_size,
          epochs=10,
          verbose=1,
          shuffle=True,
          validation_split=0.2)
    model.save(output_file)
    return model

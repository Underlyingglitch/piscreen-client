import os

def file_get_contents(filename):
    with open(filename) as f:
        return f.read()

name = file_get_contents('../data/playername')

print(name)

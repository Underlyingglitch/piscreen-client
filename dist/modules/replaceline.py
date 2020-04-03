import sys
import fileinput

def replace_exclude(string, search, replace="", excluding_char='-'):
    # Does replace unless instance in search string is prefixed with excluding_char.
    if (not string) or (not search): return None
    for i in range(len(string)):
        while string[i-1] == excluding_char:
            i += 1
        if i < len(string):
            for j in range(len(search)):
                possible = True
                if not (string[i + j] == search[j]):
                    possible = False
                    break
        if possible:
            string = string[0:i] + replace + string[i+len(search):]
            i += len(replace)
    return string

filename = ""
replacestring = ""
newstring = ""

def main():
    for line in fileinput.input([filename], inplace=True):
        sys.stdout.write(replace_exclude(line, replacestring, replacestring))

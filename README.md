NN-MD5
======

NOTE - These scripts will likely be deprecated in the near future in favour of an upcoming better NN solution.


Collects scene data using the providers, stores them with an MD5 hash in NN, compares releases names with the hashes, renames and categorizes the releases. Based off an original idea by hw.

NZPre users should jump straight to /Providers/nzpre/ for more information

With the exception of the /providers/irc section, all files should be placed in /testing 

The files in /setup will build the table and populate it with 11,000 successful matching MD5's. You can run it as <code>php init.php datafile.txt</code> Both files can be deleted afterward.

Unlike the optional choice of providers, hashcompare.php is the central lib file and must be present. It is advised that it be called before update_parsing. The modified update_parsing file ensures this always happens. This is a good solution for tmux users.

In addition, the hascompare-standalone.php file can be called from your screen script whenever you'd like to process the hashes.

DO NOT hammer providers with requests! They are kind enough to provide this information publically at their own expense. The information across providers is almost all the same so be respectful. IRC is the preferred and most effective solution.



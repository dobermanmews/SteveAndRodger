import glob, os
src_ext = ".jpg"
for infile in glob.glob("*" + src_ext):
    file,ext = os.path.splitext(infile)
    os.rename( infile, file + ext.lower() + ".1")
    os.rename( file + ext.lower() + ".1", file + ext.lower())

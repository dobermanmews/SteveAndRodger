from PIL import Image
import glob, os

src_dir = raw_input("Source directory: ")
src_ext = ".jpg"
dest_dir = raw_input("Destination directory: ")
base_name = raw_input("Destination base name: ")

size = 400, 300
os.chdir(src_dir)

i = 0
for infile in glob.glob("*" + src_ext):
    file,ext = os.path.splitext(infile)
    im = Image.open(infile)
    destfilename = "%s_%04d%s" % (base_name, i, src_ext)
    print infile + '...' + destfilename

    destfile = os.path.join(dest_dir, destfilename)
    im.thumbnail(size, Image.ANTIALIAS)
    im.save(destfile, "JPEG")
    i = i + 1

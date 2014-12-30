from PIL import Image
import sys
import os
import os.path

def endWith(s,*endstring):
        array = map(s.endswith,endstring)
        if True in array:
            return True
        else:
            return False

if __name__ == '__main__':
	rootdir = input("转换目录: ")
	# rootdir = "E:/tif"
	if ( rootdir == '' ):
		print ("目录不存在")
		sys.exit()
	for parent,dirnames,filenames in os.walk(rootdir): 
		for filename in filenames:    
			if endWith(filename,'.tif','.tiff'): 
				try:
					newfilename = filename.split(".")
					im = Image.open(os.path.join(parent,filename))
					im.save(os.path.join(parent,newfilename[-2]+".jpg")) 
					print ( os.path.join(parent,filename) + "转换成功！")
				except Exception:
					print (Exception)
					continue
	print ("转换完成！")
	print ("")
	print ("")		      
	input("")
	sys.exit()
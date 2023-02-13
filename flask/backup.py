import shutil, os, sys, pathlib
from datetime import datetime

now = datetime.now()

src = os.getcwd()
dst = os.path.join(src, sys.argv[1])

content = ""
# stream file
with open(os.path.join(src, "web.log"), "r") as f:
    for item in f.read():
        content += item
    # nutup streaming
    f.close()

try:
    os.mkdir(dst)
except OSError as error:
    error.with_traceback(error.__traceback__)
else:
    filepath = os.path.join(dst, f"{now}.backup.log")
    os.system(f"type web.log > {filepath}")

clean:
	rm -rf build

update:
	ppm --generate-package="src/TmpFile"

build:
	mkdir build
	ppm --no-intro --compile="src/TmpFile" --directory="build"

install:
	ppm --no-intro --no-prompt --fix-conflict --install="build/net.intellivoid.tmpfile.ppm"
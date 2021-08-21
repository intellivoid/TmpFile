# TmpFile

Stores temporary files on the system


## Example

```php
<?php

    require('ppm');
    import('net.intellivoid.tmpfile');
    
    $file = new \TmpFile\TmpFile('Example Content', '.dat');

    // save to disk
    $file->saveAs('/dir/test.html');
    
    // Access file name and directory
    print($file->getFileName() . PHP_EOL);
    print($file->getTempDir() . PHP_EOL);

    // To keep the temporary file
    $file->delete =f alse;
```
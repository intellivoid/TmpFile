<?php

    /** @noinspection PhpUnused */

    namespace TmpFile;
    
    class TmpFile
    {
        /**
         * @var bool whether to delete the tmp file when it's no longer referenced
         * or when the request ends.  Default is `true`.
         */
        public $delete = true;
    
        /**
         * @var string the name of this file
         */
        protected $_fileName;

        /**
         * @var null|string
         */
        private static $tmpDir = null;
    
        /**
         * Constructor
         *
         * @param string $content the tmp file content
         * @param string|null $suffix the optional suffix for the tmp file
         * @param string|null $prefix the optional prefix for the tmp file. If null
         * 'tmp_' is used.
         * @param string|null $directory directory where the file should be
         * created. Auto-detected if not provided.
         */
        public function __construct($content, $suffix = null, $prefix = null, $directory = null)
        {
            if ($directory === null) 
            {
                $directory = self::getTempDir();
            }
    
            if ($prefix === null)
            {
                $prefix = 'tmp_';
            }
    
            $this->_fileName = tempnam($directory,$prefix);
            
            if ($suffix !== null)
            {
                $newName = $this->_fileName . $suffix;
                rename($this->_fileName, $newName);
                $this->_fileName = $newName;
            }
            file_put_contents($this->_fileName, $content);
        }

        /**
         * @return string|null
         */
        public static function getCustomTmpDir()
        {
            return self::$tmpDir;
        }

        /**
         * @param string|null $tmpDir
         */
        public static function setCustomTmpDir($tmpDir)
        {
            self::$tmpDir = $tmpDir;
        }

        /**
         * Delete tmp file on shutdown if `$delete` is `true`
         */
        public function __destruct()
        {
            if ($this->delete && file_exists($this->_fileName))
            {
                unlink($this->_fileName);
            }
        }

        /**
         * @param string $name the name to save the file as
         * @return bool whether the file could be saved
         * @noinspection PhpUnused
         */
        public function saveAs($name)
        {
            return copy($this->_fileName, $name);
        }
    
        /**
         * @return string the full file name
         * @noinspection PhpUnused
         */
        public function getFileName()
        {
            return $this->_fileName;
        }
    
        /**
         * @return string the path to the temp directory
         */
        public static function getTempDir()
        {
            if(self::$tmpDir !== null)
                return self::$tmpDir;

            if (function_exists('sys_get_temp_dir'))
            {
                return sys_get_temp_dir();
            }
            elseif (($tmp = getenv('TMP')) || ($tmp = getenv('TEMP')) || ($tmp = getenv('TMPDIR')))
            {
                return realpath($tmp);
            }

            return '/tmp';
        }
    
        /**
         * @return string the full file name
         */
        public function __toString()
        {
            return $this->_fileName;
        }
    }

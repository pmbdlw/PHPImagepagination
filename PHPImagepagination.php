<?php
namespace PIP;
use Exception;

class PHPImagepagination
{
    private $pageIndex;
    private $pageSize;
    private $totalPages;
    private $recordCount;
    private $filePath;
    
    function __construct($filePath,$pageIndex = 1, $pageSize = 10, $recordCount = 0)
    {
        if(empty($filePath)){
            throw new Exception("the argument \"filePath\" is empty.");
        }
        $this->filePath = $filePath;
        $this->pageIndex = $pageIndex;
        $this->pageSize = $pageSize;
        $this->recordCount = $recordCount;
        $this->totalPages = $recordCount / $pageSize;
    }

    public function GetPageIndex(){
        return  $this->pageIndex;
    }

    public  function GetPageSize(){
        return $this->pageSize;
    }

    public  function GetFilePath(){
        return $this->filePath;
    }

    public function GetFilesByPath(){
        if(empty($this->filePath)){
            return  array();
        }
        if(!is_dir($this->filePath)){
            throw new Exception("Your filePath is not a directory.", 1);            
        }
        $files = scandir($this->filePath);
        if(empty($files)){
            $files = array_values(array_diff($files,array('.','..','.DS_Store')));
        }
        return $files;
    }
}

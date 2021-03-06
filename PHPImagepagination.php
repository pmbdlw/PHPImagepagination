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
    private $allFiles;
    
    function __construct($filePath, $pageIndex = 1, $pageSize = 10)
    {
        if (empty($filePath)) {
            throw new Exception("the argument \"filePath\" is empty.");
        }
        $this->filePath = $filePath;
        $this->pageIndex = $pageIndex;
        $this->pageSize = $pageSize;
        $this->InitData();
    }

    private function InitData(){
        $this->GetFilesByPath();
        $this->recordCount = count($this->allFiles);
        $this->totalPages = ceil($this->recordCount / $this->pageSize);
        if($this->pageIndex > $this->totalPages){
            $this->pageIndex = $this->totalPages;
        }

        if($this->pageIndex < 1){
            $this->pageIndex = 1;
        }
    }

    public function GetPageIndex()
    {
        return  $this->pageIndex;
    }

    public function GetPageSize()
    {
        return $this->pageSize;
    }

    public function GetFilePath()
    {
        return $this->filePath;
    }

    public function GetRecordCount()
    {
        return $this->recordCount;
    }

    public function GetTotalPages()
    {
        return $this->totalPages;
    }

    public function GetPrePage(){
        if($this->pageIndex > 1){
            return $this->pageIndex - 1;
        }
        return 1;
    }

    public function GetNextPage(){
        if($this->pageIndex < $this->totalPages){
            return  $this->pageIndex + 1;
        }
        return $this->totalPages;
    }

    public function GetFiles()
    {
        $currentFiles = array();
        $page = $this->pageIndex - 1;
        $start = $this->pageSize*$page;
        $end = ($page+1)*$this->pageSize;
        if(empty($this->allFiles)){
            $end = 0;
        }
        if($this->IsLastPage() && ($this->recordCount-1 < $end)){
            $end = $this->recordCount;
        }
        for ($i=$start; $i<$end; $i++) {
            array_push($currentFiles, $this->allFiles[$i]);
        }
        return $currentFiles;
    }

    private function IsFirstPage(){
        if($this->pageIndex == 1){
            return true;
        }
        return false;
    }

    private function IsLastPage(){
        if($this->pageIndex == $this->totalPages){
            return  true;
        }
        return false;
    }

    private function GetFilesByPath()
    {
        if (empty($this->filePath)) {
            throw new Exception("Your filePath can not be empty.", 1);
        }
        if (!is_dir($this->filePath)) {
            throw new Exception("Your filePath is not a directory.", 1);
        }
        $files = scandir($this->filePath);
        if (empty($files)) {
            $this->allFiles = array();
            return;
        }
        $this->allFiles = array_values(array_diff($files, array('.','..','.DS_Store')));
        if(empty($this->allFiles)){
            $this->allFiles = array();
            return;
        }
    }
}
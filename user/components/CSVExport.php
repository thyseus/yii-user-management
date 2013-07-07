<?php

/**
 * export a csv file (string) from given CSqlDataProvider
 * usage in your controller:
 * Yii::import('ext.CSVExport');
 * $provider = YourClass::model()->createCSqlProvider()
 * or
 * $provider = Yii::app()->db->creatCommand(...)->queryAll();
 * $csv = new CSVExport($provider);
 * $content = $csv->toCSV();					
 * Yii::app()->getRequest()->sendFile($filename, $content, "text/csv", false);
 * exit();
 *
 * @author Kenrick Buchanan
 * @version 0.2
 */
class CSVExport
{
    /**
     * @var mixed CSqlDataProvider|array
     */
    protected $dataProvider;
    
    /**     
     * @var boolean export file with headers generated from sql
     */
    public $includeColumnHeaders = true;
    
    /**
     * if you want to make more readable headers from your sql statement
     * this will be used as a find/replace for outputting the headers
     * in the format of expected_header=>desired_header
     * @var array of formatted headers
     */
    public $headers = array();
    
    /**     
     * @var integer how much memory to allocate when creating csv. defaults to 5mb
     */
    public $memoryLimit;
    
    /**
     * if false, and $dataProvider is CSqlDataProvider, it will not turn off pagination
     * @var boolean
     */
    public $exportFull = true;
    
    /**
     * a callback to run on each row, prefereably a closure, but can also
     * be an array.
     * @var mixed array|closure row callback function
     */
    public $callback;
    
    /**
     * constructor
     * @param mixed array|CSqlDataProvider $dataProvider
     */
    public function __construct($dataProvider)
    {
        $this->dataProvider = $dataProvider;
        $this->memoryLimit = 5 * 1024 * 1024;
    }
    
    /**
     * replace headers with user desired names
     * @param array $headers
     */
    protected function _replaceHeaders(array $headers)
    {
        if(!count($this->headers)) {
            return $headers;
        }
        $out = array();
        foreach($headers as $header) {
            if(array_key_exists($header, $this->headers)) {
                $out[] = $this->headers[$header];
                continue;
            }
            $out[] = $header;
        }
        
        return $out;
    }
    
    /**
     * call fetchData on the CSqlDataProvider and return a string of sql
     * OR optionally write it to a file
     * @param string $outputFile optional file to write to instead of returning string
     * @param string $delimiter defaults to ','
     * @param string $enclosure defaults to '"'
     * @throws Exception on $this->dataProvider being incorrect data type
     * @return mixed string|integer|boolean if writing a file, number of bytes written or false,
     * if not then returns the generated csv string
     */
    public function toCSV($outputFile=null, $delimiter=",", $enclosure='"')
    {                    
        // get data
        $data = array();        
        if($this->dataProvider instanceof CSqlDataProvider) {
            // check to see if pagination should be turned off
            if($this->exportFull) {
                $this->dataProvider->setPagination(false);
            }
            $data = $this->dataProvider->getData();    
        } else if(is_array($this->dataProvider)) {
            $data = $this->dataProvider;
        } else {
            throw new Exception('Data provider must be an instance of CSqlDataProvider or an array.');
        }
        
        if(!count($data)){
            return false;
        }
        
        // open stream
        $fp = fopen("php://temp/maxmemory:{$this->memoryLimit}", 'w');
        if ($this->includeColumnHeaders) {
            $headers = $this->_replaceHeaders(array_keys($data[0]));
            fputcsv($fp, $headers, $delimiter, $enclosure);
        }
        
        foreach($data as $d) {
            if($this->callback) {               
                $d = call_user_func($this->callback, $d);               
            }
            fputcsv($fp, $d, $delimiter, $enclosure);
        }
                        
        rewind($fp);
        
        if($outputFile !== null) {
            return file_put_contents($outputFile, $fp);
        } else {
            return stream_get_contents($fp);    
        }
        
    }
}

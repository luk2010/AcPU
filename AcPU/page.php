<?php

require 'htmlconstructor.php';

class Page
{
    protected static $instance;
    
    protected function __construct() {
    }
    
    protected function __clone() {
        
    }
    
    public function get() 
    {
        if(!isset(self::$instance))
        {
            self::$instance = new self;
        }
        
        return self::$instance;
    }
    
    //Members
    
    public $links_list = array();
    public $meta_list = array();
    public $scripts = array();
    public $src_scripts = array();
    public $customs_head = array();
    
    public $manual_header = true;
    public $use_htmlconstructor  = false;
    
    public $headerfunc = Header_Func;
    public $centerfunc = Center_Function;
    public $footerfunc = Footer_Func;
    
    public $constructor = NULL;
    
    // Class functions
    
    public function setManualHeader($bool)
    {
        $this->manual_header = ($bool == true);
    }
    
    public function setHTMLConstructor($cstr)
    {
        if($cstr != NULL)
        {
            $this->constructor = $cstr;
            $this->use_htmlconstructor = true;
        }
    }
    
    public function draw($title, $description)
    {
        echo '<!DOCTYPE html><html>';
        
        if($this->manual_header == false)
        {
            self::makeHeader($title);
        }
        
        if($this->use_htmlconstructor == false)
        {
            call_user_func($this->headerfunc, $title, $description);
        
            call_user_func($this->centerfunc);
        
            call_user_func($this->footerfunc);
        }
        
        else
        {
            $this->constructor->initPage();
            echo $this->constructor->getHTML();
        }
        
        echo '</html>';
    }
    
    public function addHeadLinks($path, $type)
    {
        $this->links_list[$path] = $type;
    }
    
    public function addMeta($name, $content)
    {
        $this->meta_list[$name] = $content;
    }
    
    public function addHeadJavaScript($src)
    {
        $this->scripts[] = $src;
    }
    
    public function addJavascriptFile($path)
    {
        $this->src_scripts[] = $path;
    }
    
    public function addCustomHeadContent($content)
    {
        $this->customs_head[] = $content;
    }
    
    public function makeHeader($title)
    {
        echo '<head>';
        
        if(count($this->meta_list) > 0)
        foreach($this->meta_list as $name => $content)
        {
            echo '<meta name="'.$name.'" content="'.$content.'" />';
        }
        
        if(count($this->links_list) > 0)
        foreach($this->links_list as $path => $type)
        {
            echo '<link href="'.$path.'" rel="'.$type.'" />';
        }
        
        if(count($this->src_scripts) > 0)
        foreach($this->src_scripts as $script)
        {
            echo '<script language="text/javascript" src="'.$script.'" />';
        }
        
        if(count($this->scripts) > 0)
        foreach($this->scripts as $script)
        {
            echo '<script language="text/javascript">'.$script.'</script>';
        }
        
        echo '<title>'.$title.'</title>';
        
        foreach($this->customs_head as $content)
        {
            echo $content;
        }
        
        echo '</head>';
    }
    
    public function setHeaderFunc($ptrfunc)
    {
        $this->headerfunc = $ptrfunc;
    }
    
    public function setCenterFunc($ptrfunc)
    {
        $this->centerfunc = $ptrfunc;
    }
    
    public function setFooterFunc($ptrfunc)
    {
        $this->footerfunc = $ptrfunc;
    }
    
    public function toPlainText($sentence)
    {
        return htmlspecialchars($sentence);
    }
    
}

?>

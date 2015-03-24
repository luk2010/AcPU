<?php

require 'JavaScriptConstructor.php';
require 'htmlelement.php';
require 'UiConstructor.php';

class HTMLConstructor
{
    //Members
    protected $name = '';
    protected $computedHTML = '';
    
    protected $element_footer = NULL;
    protected $element_header = NULL;
    protected $element_center = NULL;
    
    protected $body = NULL;
    
    protected $jsConstructor = NULL;
    
    public function __construct($name) 
    {   
        $this->name = $name; 
        $this->constructBaseElement();
    }
    
    public function getHTML()
    {
        return $this->computedHTML;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getHeader()
    {
        return $this->element_header;
    }
    
    public function getCenter()
    {
        return $this->element_center;
    }
    
    public function getFooter()
    {
        return $this->element_footer;
    }
    
    public function getBody()
    {
        return $this->body;
    }
    
    public function getJavaScriptConstructor()
    {
        return $this->jsConstructor->jsConstructor;
    }
    
    public function setJavaScriptConstructor($constructor)
    {
        $this->jsConstructor->jsConstructor = $constructor;
        return $constructor;
    }
    
    public function createJavaScriptConstructor($name)
    {
        $c = $this->setJavaScriptConstructor(new JavaScriptConstructor());
        $c->setName($name);
        
        return $c;
    }
    
    public function constructBaseElement()
    {
		// From Build 26 and above, this function creates directly 
		// UiElement Objects to ensure that it can use every functions.
		
        $this->body = new UiElement();
        $this->body->setBalise('body');
        
        $this->element_header = $this->body->CreateAndAdd('header');   
        $this->element_center = $this->body->CreateAndAdd('center');
        $this->element_footer = $this->body->CreateAndAdd('footer');
        
        $this->jsConstructor = new ScriptElement();
        $this->body->addChild($this->jsConstructor);
    }
    
    public function initPage()
    {
        $this->computedHTML = $this->body->toPlainHTML();
    }
}

?>

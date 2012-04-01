<?php

require 'JavaScriptConstructor.php';
require 'htmlelement.php';

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
        $this->body = new HtmlElement();
        $this->body->setBalise('body');
        
        $this->element_header = $this->body->createChild();
        $this->element_header->setBalise('header__');
        
        $this->element_center = $this->body->createChild();
        $this->element_center->setBalise('center__');
        
        $this->element_footer = $this->body->createChild();
        $this->element_footer->setBalise('footer__');
        
        $this->jsConstructor = new ScriptElement();
        $this->body->addChild($this->jsConstructor);
    }
    
    public function initPage()
    {
        $this->computedHTML = $this->body->toPlainHTML();
    }
}

?>

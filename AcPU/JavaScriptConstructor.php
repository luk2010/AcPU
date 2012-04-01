<?php

require 'JavaScriptFunction.php';

class JavaScriptConstructor extends JavaScriptFunction
{
    public $elements = array();
    public $name = '';
    
    public function createFunction($name, $argues, $content)
    {
        $function = new JavaScriptFunction();
        $function->setName($name);
        $function->setContent($content);
        
        foreach($argues as $arg)
        {
            $function->addArgue($arg);
        }
        
        $this->elements[] = $function;
        return $function;
    }
    
    public function addElement($element)
    {
        $this->elements[] = $element;
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function getFunction($name)
    {
        foreach($this->elements as $function)
        {
            if($function instanceof JavaScriptFunction)
                if($function->getName() == $name)
                    return $function;
        }
        
        return NULL;
    }
    
    public function removeFunction($name)
    {
        foreach($this->elements as $function)
        {
            if($function instanceof JavaScriptFunction)
                if($function->getName() == $name)
                {
                    unset($this->functions);
                    $this->functions = array_values($this->functions);
                    break;
                }
        }
    }
    
    public function draw()
    {
        $text = '<script name="'.$this->name.'" type="text/javascript" language="JavaScript" >';
        
        foreach($this->elements as $element)
        {
            $text .= $element->draw();
            $text .= ' ';
        }
        
        $text .= '</script>';
        return $text;
    }
    
    public function initJQuery()
    {
        $jquery = new JavaScriptElement();
        
        $jquery->addInstruction('$(');
        $jquery_function = $jquery->addFunction('', array(), '');
        $jquery_function->setInline(true);
        $jquery->addInstruction(');');
        
        $this->addElement($jquery);
        return $jquery_function;
    }
}

?>

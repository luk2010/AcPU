<?php

require 'JavaScriptFunction.php';

class JavaScriptConstructor extends JavaScriptFunction
{
    public $functions = array();
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
        
        $this->functions[] = $function;
        return $function;
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function getFunction($name)
    {
        foreach($this->functions as $function)
        {
            if($function->getName() == 'name')
                return $function;
        }
        
        return NULL;
    }
    
    public function removeFunction($name)
    {
        foreach($this->functions as $function)
        {
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
        $text = '<script name="'.$this->name.'" type="text/javascript" language="JavaScript" > $(function() { ';
        
        foreach($this->functions as $function)
        {
            $text .= $function->draw();
            $text .= ' ';
        }
        
        $text .= $this->content;
        
        $text .= ' }); </script>';
        return $text;
    }
    
    public function addEventListener($element, $event, $listenFunction)
    {
        if($event == '')
        {
            return false;
        }
        
        if($element->getID() == '')
            return false;
        
        $this->addInstruction('$("#'.$element->getID().'").on("'.$event.'", '.$listenFunction->getName().'); ');
        
        return true;
    }
}

?>

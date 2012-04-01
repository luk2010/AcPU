<?php

class JavaScriptElement
{
    public $content = '';
    public $childs = array();
    
    public function getContent()
    {
        return $this->content;
    }
    
    public function setContent($content)
    {
        $this->content = $content;
    }
    
    public function addChild($child)
    {
        $this->childs[] = $child;
    }
    
    public function addInstruction($content)
    {
        $instruction = new JavaScriptInstruction();
        $instruction->setContent($content);
        
        $this->addChild($instruction);
        return $instruction;
    }
    
    public function addFunction($name, $argues, $content)
    {
        $function = new JavaScriptFunction();
        $function->setName($name);
        $function->setContent($content);
        
        foreach($argues as $arg)
        {
            $function->addArgue($arg);
        }
        
        $this->childs[] = $function;
        return $function;
    }
    
    public function draw()
    {
        $text = '';
        $text .= $this->content;
        
        foreach($this->childs as $child)
        {
            $text .= $child->draw();
        }
        
        return $text;
    }
}

class JavaScriptFunction extends JavaScriptElement
{
    public $name = '';
    public $argues = array();
    public $inline = false;
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getArgues()
    {
        return $this->argues;
    }
    
    public function addArgue($argue)
    {
       $this->argues[] = $argue;
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function setInline($inline)
    {
        $this->inline = $inline;
    }
    
    public function draw()
    {
        $text = 'function '.$this->name.' (';
        
        foreach($this->argues as $i => $argue)
        {
            if($i == 0)
            {
                $text .= $argue;
            }
            else
            {
                $text .= ', '.$argue;
            }
        }
        
        $text .= ') { ';
        
        $text .= $this->content;
        
        foreach($this->childs as $child)
        {
            $text .= $child->draw();
        }
                
        $text .= ' }';
        
        if($this->inline == false)
            $text .= '; ';
        
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

class JavaScriptInstruction extends JavaScriptElement
{
    public function draw()
    {
        return $this->content;
    }
}

?>

<?php

class JavaScriptFunction
{
    public $name = '';
    public $argues = array();
    public $content = '';
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getArgues()
    {
        return $this->argues;
    }
    
    public function getContent()
    {
        return $this->content;
    }
    
    public function setContent($content)
    {
        $this->content = $content;
    }
    
    public function addArgue($argue)
    {
       $this->argues[] = $argue;
    }
    
    public function setName($name)
    {
        $this->name = $name;
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
        
        $text .= ') { '.$this->content.' }; ';
        
        return $text;
    }
    
    public function addInstruction($instruction)
    {
        $this->content .= $instruction;
    }
}

class JavaScriptInstruction extends JavaScriptFunction
{
    public function draw()
    {
        return $this->content;
    }
}

?>

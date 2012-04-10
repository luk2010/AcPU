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
    
    public function initDragAndDrop()
    {
        $dragndrop = new JavaScriptDragDropHandler();
        
        $dragndrop->addInstruction('var dndHandler = { 
            draggedElement: null,
            applyDragEvents: ');
        $applyDragEvents = $dragndrop->addFunction('', array('element'), '');
            $applyDragEvents->addInstruction('element.draggable = true;');
            $applyDragEvents->addInstruction('var dndHandler = this');
            $applyDragEvents->addInstruction('element.addEeventListener(\'dragstart\', ');
            $applyDragEvents_f1 = $applyDragEvents->addFunction('', array('e'), '');
                $applyDragEvents_f1->addInstruction('dndHandler.draggedElement = e.target;');
                $applyDragEvents_f1->addInstruction('e.dataTransfer.setData(\'text/plain\', \'\');');
                $applyDragEvents_f1->setInline(true);
            $applyDragEvents->addInstruction(', false);');
            $applyDragEvents->setInline(true);
        
        $dragndrop->addInstruction(',
            applyDropEvents: ');
        $applyDropEvents = $dragndrop->addFunction('', array('dropper', 'class_'), '');
            $applyDropEvents->setInline(true);
            
            $applyDropEvents->addInstruction('dropper.addEventListener(\'dragover\', ');
            $applyDropEvents_f1 = $applyDropEvents->addFunction('', array('e'), '');
                $applyDropEvents_f1->addInstruction('e.preventDefault();');
                $applyDropEvents_f1->addInstruction('this.className = class_ + \' drop_hover\';');
                $applyDropEvents_f1->setInline(true);
            $applyDropEvents->addInstruction(');');
            
            $applyDropEvents->addInstruction('dropper.addEventListener(\'dragleave\', ');
            $applyDropEvents_f2 = $applyDropEvents->addFunction('', array(), '');
                $applyDropEvents_f2->addInstruction('this.className = class_;');
                $applyDropEvents_f2->setInline(true);
            $applyDropEvents->addInstruction(');');
            
            $applyDropEvents->addInstruction('var dndHandler = this;');
            
            $applyDropEvents->addInstruction('dropper.addEventListener(\'drop\', ');
            $applyDropEvents_f3 = $applyDropEvents->addFunction('', array('e'), '');
                $applyDropEvents_f3->addInstruction('var target = e.target, draggedElement = dndHandler.draggedElement, clonedElement = draggedelement.cloneNode(true);');
                $applyDropEvents_f3->addInstruction('while (target.className.indexOf(class_) == -1) {');
                $applyDropEvents_f3->addInstruction('target = target.parentNode;');
                $applyDropEvents_f3->addInstruction('}');
                $applyDropEvents_f3->addInstruction('target.className = class_;');
                $applyDropEvents_f3->addInstruction('clonedElement = target.appendChild(clonedElement);dndHandler.applyDragEvents(clonedElement);');
                $applyDropEvents_f3->addInstruction('draggedElement.parentNode.removeChild(draggedElement);');
                $applyDropEvents_f3->setInline(true);
            $applyDropEvents->addInstruction(');');
        
        $dragndrop->addInstruction('};');
        
        $this->addElement($dragndrop);
        return $dragndrop;
    }
}

?>

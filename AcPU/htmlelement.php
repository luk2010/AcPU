<?php

class HtmlElement
{
    protected $childs = array();
    protected $parent = NULL;
    
    protected $class = array();
    
    protected $id = '';
    protected $balise = '';
    protected $name = '';
    public $mustFinite = false;
    
    protected $properties = array();
    
    public function getChilds()
    {
        return $this->childs;
    }
    
    public function getParent()
    {
        return $this->parent;
    }
    
    public function getClasses()
    {
        return $this->class;
    }
    
    public function getID()
    {
        return $this->id;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getProperties()
    {
        return $this->properties;
    }
    
    public function getBalise()
    {
        return $this->balise;
    }
    
    public function getBody()
    {
        $next = $this->parent;
        while($next->getBalise() != 'body')
        {
            $next = $next->getParent();
            
            if($next == NULL)
                break;
        }
        
        return $next;
    }
    
    public function addChild($child)
    {
        $this->childs[] = $child;
        $child->setParent($this);
    }
    
    public function setParent($p)
    {
        $this->parent = $p;
    }
    
    public function addClass($c)
    {
        $this->class[] = $c;
    }
    
    public function setID($id)
    {
        $this->id = $id;
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function addProperty($propname, $content)
    {
        $this->properties[$propname] = $content;
    }
    
    public function addProperties($array)
    {
        foreach($array as $prop => $content)
        {
            $this->addProperty($prop, $content);
        }
    }
    
    public function setBalise($b)
    {
        $this->balise = $b;
    }
    
    public function mustBeFinite($f)
    {
        $this->mustFinite = $f;
    }
    
    public function toPlainHTML()
    {
        $html = '';
        
        if($this->balise == '')
            return $html;
        
        $html .= '<'.$this->balise.' ';
            
        foreach($this->properties as $property => $content)
        {
            $html .= $property.'="'.$content.'" ';
        }
        
        if(count($this->class) > 0)
        {
            $html .= 'class="';
            
            foreach($this->class as $class)
            {
                $html .= $class.' ';
            }
            
            $html .= '" ';
        }
        
        if($this->id != '')
            $html .= 'id="'.$this->id.'" ';
        
        if($this->name != '')
            $html .= 'name="'.$this->name.'" ';
        
        if($this->mustFinite == true)
        {
            $html .= '/>';
        }
        else if(count($this->childs) > 0)// C'est un element fini
        {
            $html .= '>';
            
            foreach($this->childs as $child)
            {
                $html .= $child->toPlainHTML();
            }
            
            $html .= '</'.$this->balise.'>';
            return $html;
        }
        else
        {
            $html .= '>';
            $html .= '</'.$this->balise.'>';
            return $html;
        }
    }
    
    public function createChild($balise = '', $name = '', $id = '', $class = array())
    {
        $element = new HtmlElement();
        
        $element->setBalise($balise);
        $element->setName($name);
        $element->setID($id);
        
        foreach($class as $class_u)
        {
            $element->addClass($class_u);
        }
        
        $this->addChild($element);
        return $element;
    }
    
    public function createChildWithText($balise = '', $texte = '', $name = '', $id = '', $class = array())
    {
        $element = $this->createChild($balise, $name, $id, $class);
        $element->addText($texte);
        
        return $element;
    }
    
    public function addParagraphe($text, $class = array(), $id = '')
    {
        $p = $this->createChild('p', '', $id, $class);
        $p->addText($text);
        
        return $p;
    }
    
    public function addText($text)
    {
        $element = new TextElement();
        $element->setText($text);
        
        $this->addChild($element);
        return $element;
    }
    
    public function addLink($name, $text = '', $href = '#', $id = '', $class = array())
    {
        $link = $this->createChild('a', $name, $id, $class);
        $link->addProperty('href', $href);
        $link->addText($text);
        
        return $link;
    }
    
    public function addInput($name, $type, $value, $id = '', $class = array())
    {
        $input = $this->createChild('input', $name, $id, $class);
        $input->addProperties(array('type' => $type, 'value' => $value));
        return $input;
    }
    
    public function addForm($name, $method, $action, $id = '', $class = array(), $onsubmit = '')
    {
        $input = new FormElement;
        
        $input->setBalise('form');
        $input->setName($name);
        $input->setID($id);
        
        foreach($class as $class_)
        {
            $input->addClass($class_);
        }
        
        $input->addProperties(array('method' => $method, 
                                    'action' => $action,
                                    'onsubmit' => $onsubmit));
        
        $this->addChild($input);
        return $input;
    }
    
    public function addCondition($name, $condition = false)
    {
        $conditionChild = new ConditionElement();
        $conditionChild->setName($name);
        $conditionChild->setCondition($condition);
        
        $this->addChild($conditionChild);
        return $conditionChild;
    }
    
    public function addTemplate($name, $function)
    {
        $template = new TemplateElement();
        $template->setName($name);
        $template->setFunction($function);
        
        $this->addChild($template);
        return $template;
    }
    
    public function importHtml($html)
    {
        $dom = new DOMDocument();
        $dom->loadXML($html);
        
        $elements_list = $dom->getElementsByTagName('*');
        $parent = $elements_list->item(0)->parentNode;
        
        foreach($elements_list as $element)
        {
            $this->importFromDomNode($parent, $element);
        }
        
        return $this;
    }
    
    public function importFromDomNode($parent, $element)
    {
        if(($element instanceof DOMNode) == false)
            return;
        
        if($element->parentNode != $parent)
            return;
        
        if($element->nodeType == XML_TEXT_NODE)
        {
            $this->addText($element->nodeValue);
        }
            
        else
        {
            $child = $this->createChild($element->tagName);
                
            foreach($element->attributes as $attr)
            {
                if($attr->nodeName == 'id')
                {
                    $child->setID($attr->nodeValue);
                }
                else if($attr->nodeName == 'name')
                {
                    $child->setName($attr->nodeValue);
                }
                else if($attr->nodeName == 'class')
                {
                    $child->addClass($attr->nodeValue);
                }
                else
                {
                    $child->addProperty($attr->nodeName, $attr->nodeValue);
                }
            }
                
            if($element->hasChildNodes())
            {
                 foreach($element->childNodes as $subchild)
                 {
                     $child->importFromDomNode($element, $subchild);
                 }
            }
            
            if($child->getBalise() == 'textarea' and count($child->childs) == 0)
            {
                $child->addText('');
            }
        }
        
        return $this;
    }
    
    public function getChildByName($name)
    {
        if(count($this->childs) <= 0)
            return NULL;
        
        foreach($this->childs as $child)
        {
            if($child->getName() == $name)
                return $child;
        }
    }
    
    public function getChildByBalise($balise)
    {
        if(count($this->childs) <= 0)
            return NULL;
        
        foreach($this->childs as $child)
        {
            if($child->getBalise() == $balise)
                return $child;
        }
    }
    
    public function getChildByID($id)
    {
        if(count($this->childs) <= 0)
            return NULL;
        
        foreach($this->childs as $child)
        {
            if($child->getID() == $id)
                return $child;
        }
    }
    
    public function getChild($index)
    {
        if($index >= count($this->childs) or $index < 0)
            return NULL;
        
        return $this->childs[$index];
    }
    
    public function findChild($child)
    {
        if(count($this->childs) <= 0)
            return -1;
        
        foreach($this->childs as $i => $child_)
        {
            if($child_ == $child)
                return $i;
        }
        
        return -1;
    }
    
    public function nextSibling()
    {
        $index = $this->parent->findChild($this);
        if($index > -1)
        {
            return $this->parent->getChild($index + 1);
        }
        
        return NULL;
    }
    
    public function previousSibling()
    {
        $index = $this->parent->findChild($this);
        if($index > 0)
        {
            return $this->parent->getChild($index - 1);
        }
        
        return NULL;
    }
    
    public function removeChild($index)
    {
        if($index > -1 and index < count($this->childs))
        {
            unset($this->childs[$index]);
            $this->childs = array_values($this->childs);
        }
    }
    
    public function removeProperty($property)
    {
        unset($this->properties[$property]);
        $this->properties = array_values($this->properties);
    }
    
    public function removeClass($class)
    {
        foreach($this->class as $i => $class_)
        {
            if($class == $class_)
            {
                unset($this->class[$i]);
                $this->class = array_values($this->class);
                return;
            }
        }
    }
    
    public function returnToLine($times = 1)
    {
        for($i = 0; $i < $times; $i++) {
            $this->createChild('br');
        }
    }
}

class TextElement extends HtmlElement 
{
    protected $text = '';
    
    public function setText($text)
    {
        $this->text = htmlspecialchars($text);
    }
    
    public function toPlainHTML()
    {
        return $this->text;
    }
}

class FormElement extends HtmlElement
{
    public function addInput($label_text, $name, $type, $value, $id = '', $class = array()) {
        
        if($type != 'button' and $type != 'submit' and $label_text != '') {
            $label = $this->createChild('label', 'label_'.$name, 'label_'.$name);
            $label->addProperty('for', $name);
            $label->addText($label_text);
        }
        
        return parent::addInput($name, $type, $value, $id, $class);
    }
    
    public function addLabel($for, $text, $id = '', $class = array())
    {
        $label = $this->createChild('label', 'label_'.$for, $id, $class);
        $label->addProperty('for', $for);
        $label->addText($text);
        
        return $label;
    }
    
    public function addTextArea($name, $text = '', $id = '', $class = array())
    {
        $textarea = $this->createChild('textarea', $name, $id, $class);
        $textarea->addText($text);
        
        return $textarea;
    }
}

class ConditionElement extends HtmlElement
{
    public $condition = false;
    
    public function setCondition($condition)
    {
        $this->condition = ($condition == true);
    }
    
    public function toPlainHTML() {
        if($this->condition == true)
        {
            if(count($this->childs) > 0)
            {
                $html = '';
                
                foreach($this->childs as $child)
                {
                    $html .= $child->toPlainHTML();
                }
                
                return $html;
            }
        }
    }
}

class TemplateElement extends HtmlElement
{
    protected $ptrfunc = NULL;
    
    public function setFunction($ptrfunc)
    {
        $this->ptrfunc = $ptrfunc;
    }
    
    public function toPlainHTML() {
        
        $text = call_user_func($this->ptrfunc);   
        return $text;
    }
}

class ScriptElement extends HtmlElement
{
    public $jsConstructor = NULL;
    
    public function toPlainHTML()
    {
        if($this->jsConstructor != NULL)
            return $this->jsConstructor->draw();
        
        return '';
    }
}

?>

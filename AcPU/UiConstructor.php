<?php

/*
	File : UiConstructor.php
	Purpose : A helper class to create Ui Elements.
*/

require 'Utils.php';
require_once "page.php";

class UiElement extends HtmlElement
{
	private $styles; // Array of styles, by key and value.
	
	public function __construct() {
		$this->styles = array();
	}
	
	/////////////////////////////////////////////////////
	/// @brief Adds given style property to the object.
	/////////////////////////////////////////////////////
	public function AddStyle($propname, $propvalue) {
		$this->styles[$propname] = $propvalue;
	}
	
	/////////////////////////////////////////////////////
	/// @brief Adds several styles properties to an Object.
	/////////////////////////////////////////////////////
	public function AddStyles($proparrays) {
		foreach($proparrays as $prop => $value) {
			$this->styles[$prop] = $value;
		}
	}
	
	/////////////////////////////////////////////////////
	/// @brief Creates a new UiElement.
	/////////////////////////////////////////////////////
	public function Create($balise, $name = '', $id = '', $class = array(), $style = array()) {
		$uielement = new UiElement();
		$uielement->SetBalise($balise);
        $uielement->SetName($name);
        $uielement->SetID($id);
		$uielement->class = $class;
		$uielement->styles = $style;
		return $uielement;
	}
	
	/////////////////////////////////////////////////////
	/// @brief Creates a new UiElement and adds it to the
	/// object.
	/////////////////////////////////////////////////////
	public function CreateAndAdd($balise, $name = '', $id = '', $class = array(), $style = array()) {
		$uielement = $this->Create($balise, $name, $id, $class, $style);
		$this->AddChild($uielement);
		return $uielement;
	}
	
	/////////////////////////////////////////////////////
	/// @brief Sets the correct style to the Object then
	/// call the normal ::toPlainHtml() method.
	/////////////////////////////////////////////////////
	public function toPlainHtml() {
		
		$property = 'style';
		$content  = '';
		
		foreach ($this->styles as $name => $value) {
			$content .= $name . ":" . $value . ";";
		}
		
		if(count($this->styles) > 0) {
			if(array_key_exists('style', $this->properties) == false)
				$this->AddProperty($property, $content);
			else
				$this->properties['style'] .= $content;
		}
		
		return parent::toPlainHtml();
	}
}

class UiMenuBar extends UiElement
{
	public $MenuElementDiv;
	public $MenuElementUl;
	
	public function AddItem($ItemName) {
		$Item = $this->MenuElementUl->CreateAndAdd('li');
		$Item->CreateAndAdd('a')->CreateAndAdd('span')->addText($ItemName);
		return $Item;
	}
	
	public function SetStyle($IdStyleName) {
		$this->MenuElementDiv->setID($IdStyleName);
	}
	
	public function toPlainHtml() {
		return $this->MenuElementDiv->toPlainHtml();
	}
}

class UiLayout extends UiElement
{
	public $Container;
	public $DivArrays;
	
	public function Get($divid) {
		if(count($this->DivArrays) > $divid) {
			return $this->DivArrays[$divid];
		} else if (count($this->DivArrays) == $divid) {
			// Create a new element
			$div = $this->Container->CreateAndAdd('div');
			$this->DivArrays[] = $div;
			return $div;
		} else {
			return null;
		}
	}
	
	/////////////////////////////////////////////////////
	/// @brief Parse Properties given to this layout.
	/////////////////////////////////////////////////////
	public function ParseProperties($LayoutProperties) {
		if($LayoutProperties != null) {
			
		foreach($LayoutProperties as $id => $Property) {
			
			if($id === "ContainerStyle") {
					// Specify the Style array for the Container.
					$this->Container->AddStyles($Property);
			}
			else if($id === "ContainerClasses") {
				// Specify classes for the Container.
				$this->Container->AddClasses($Property);
			}
			else if(is_numeric($id)) {
				$div = $this->Container->CreateAndAdd('div');
				$divstyle = '';
				
				foreach($Property as $name => $value) {
					if($name == "grow") {
						$divstyle .= "-webkit-flex-grow:".$value.";";
						$divstyle .= "flex-grow:".$value.";";
					}
					else if($name == "min-width") {
						$divstyle .= "min-width".$value.";";
					}
				}
				
				$div->addProperty('style', $divstyle);
				$this->DivArrays[] = $div;
			}
		}
			
		}
	}
	
	public function toPlainHtml() {
		return $this->Container->toPlainHtml();
	}
}

class UiConstructor
{
	public function __construct() {
		
	}
	
	public function CreateSimpleTitle($level, $text, $parent = null) {
		// You can create a new title and add it manually or specify the parent.	
		$title = new UiElement();
		$title->setBalise("h".$level);
		$title->addText($text);
		
		if($parent != null) 
			$parent->addChild($title);
		
		return $title;
	}
	
	/////////////////////////////////////////////////////
	/// @brief Creates a menu bar corresponding to given 
	/// Elements.
	/////////////////////////////////////////////////////
	public function CreateMenuBar($MenuName, $ItemsArray) {
		$constructor = Page::Get()->GetHtmlConstructor();
		
		// A menu bar is always in the Header part, or you are crazy.
		$header = $constructor->getHeader();
		$MenuBar = new UiMenuBar();
		
		// We create a new element.
		$MenuBar->MenuElementDiv = $MenuBar->CreateAndAdd('div', $MenuName);
		$MenuBar->MenuElementDiv->setID($MenuName);
		$MenuBar->MenuElementUl = $MenuBar->MenuElementDiv->CreateAndAdd('ul');
		
		// We add every items in the menu.
		foreach($ItemsArray as $Element) {
			$MenuBar->AddItem($Element);
		}
		
		$MenuBar->setName($MenuName);
		$header->addChild($MenuBar);
		return $MenuBar;
	}
	
	/////////////////////////////////////////////////////
	/// @brief Creates a layout to organize elements.
	/////////////////////////////////////////////////////
	public function CreateLayout($LayoutProperties, $Parent = null) {
		
		$Layout = new UiLayout;
		if($Parent != null)
			$Layout->Container = $Parent->CreateAndAdd('div');
		else {
			$Layout->Container = new UiElement;
			$Layout->Container->setBalise('div');
		}
		
		$Layout->ParseProperties($LayoutProperties);
		
		return $Layout;
	}
	
	public function CreateHorizontalLayout($properties, $parent = null) {
		$layout = $this->CreateLayout($properties, $parent);
		if($layout == null)
			return $layout;
		
		$layout->Container->AddClass('acpu-layout-hrz');
		return $layout;
	}
	
	public function CreateVerticalLayout($properties, $parent = null) {
		$layout = $this->CreateLayout($properties, $parent);
		if($layout == null)
			return $layout;
		
		$layout->Container->AddClass('acpu-layout-vert');
		return $layout;
	}
}

?>
<?php

/*
	File : UiConstructor.php
	Purpose : A helper class to create Ui Elements.
*/

require_once "page.php";

class UiElement extends HtmlElement
{
	
}

class UiMenuBar extends UiElement
{
	public $MenuElementDiv;
	public $MenuElementUl;
	
	public function AddItem($ItemName) {
		$Item = $this->MenuElementUl->createChild('li');
		$Item->createChild('a')->createChild('span')->addText($ItemName);
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
			$div = $this->Container->createChild('div');
			$this->DivArrays[] = $div;
			return $div;
		} else {
			return null;
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
		$title = new UiElement;
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
		$MenuBar->MenuElementDiv = $MenuBar->createChild('div', $MenuName);
		$MenuBar->MenuElementDiv->setID($MenuName);
		$MenuBar->MenuElementUl = $MenuBar->MenuElementDiv->createChild('ul');
		
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
			$Layout->Container = $Parent->createChild('div');
		else {
			$Layout->Container = new UiElement;
			$Layout->Container->setBalise('div');
		}
		
		if($LayoutProperties != null) {
			
		foreach($LayoutProperties as $id => $Property) {
			$div = $Layout->Container->createChild('div');
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
			$Layout->DivArrays[] = $div;
		}
			
		}
		
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
<?php

class BDD
{
    protected $pdo = NULL;
    protected $name = NULL;
    
    protected $isinrequest = false;
    protected $computedRequest = '';
    
    protected $isinalter = false;
    protected $computedAlter = '';
    
    protected $isinupdate = false;
    protected $computedupdate = '';


    public function __construct($_pdo, $_name) {
        $this->pdo = $_pdo;
        $this->name = $_name;
    }
    
    public function getPDO()
    {
        return $this->pdo;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function makeRequest($request)
    {
        try
        {
            $rep = $this->pdo->prepare($request);
            $rep->execute(array());
        
            return $rep;
        }
        catch(Exception $e)
        {
            die('Error on bdd '.$this->name.' : '.$e->getMessage().' | request was : '.$request);
            return NULL;
        }
    }
    
    public function makeFetchRequest($request)
    {
        $ret = $this->makeRequest($request);
        if($ret != NULL) 
        {
            return $ret->fetchAll();
        }
        else
        {
            return NULL;
        }
    }
    
    public function request()
    {
        $this->isinrequest = true;
        $this->computedRequest = '';
        
        return $this;
    }
    
    public function select($what)
    {
        $this->computedRequest .= 'SELECT '.$what.' ';
        return $this;
    }
    
    public function from($where)
    {
        $this->computedRequest .= 'FROM '.$where.' ';
        return $this;
    }
    
    public function where($id, $value)
    {
        $this->computedRequest .= 'WHERE '.$id.' = "'.$value.'" ';
        return $this;
    }
    
    public function _and()
    {
        $this->computedRequest .= 'AND ';
        return $this;
    }
    
    public function tag($id, $value)
    {
        $this->computedRequest .= $id.' = "'.$value.'" ';
        return $this;
    }
    
    public function order_by($tag)
    {
        $this->computedRequest .= 'ORDER BY '.$tag.' ';
        return $this;
    }
    
    public function desc()
    {
        $this->computedRequest .= 'DESC ';
        return $this;
    }
    
    public function limit($born1, $born2)
    {
        $this->computedRequest .= 'LIMIT '.$born1.', '.$born2.' ';
        return $this;
    }
    
    public function end()
    {
        
        if($this->isinrequest) {
            $ret = $this->makeRequest($this->computedRequest);
            $this->isinrequest = false;
            
            $this->computedRequest = '';
            return $ret;
        }
        
        if($this->isinalter) {
            $ret = $this->makeRequest($this->computedAlter);
            $this->isinalter = false;
            
            $this->computedAlter = '';
            return $ret;
        }
        
        if($this->isinupdate) {
            $ret = $this->makeRequest($this->computedupdate);
            $this->isinupdate = false;
            
            $this->computedupdate = '';
            return $ret;
        }
    }
    
    public function alter()
    {
        $this->isinalter = true;
        $this->computedAlter = '';
        
        return $this;
    }
    
    public function insertInto($table, $target = array())
    {
        $this->computedAlter .= 'INSERT INTO '.$table.' ';
        
        if(count($target) > 0)
        {
            $this->computedAlter .= '(';
            
            foreach($target as $i => $tar)
            {
                $tar = addslashes($tar);
                if($i == 0)
                {
                    $this->computedAlter .= $tar;
                }
                else
                {
                    $this->computedAlter .= ', '.$tar;
                }
            }
            
            $this->computedAlter .= ') ';
        }
        
        return $this;
    }
    
    public function delete()
    {
        $this->computedAlter .= 'DELETE ';
        return $this;
    }
    
    public function values($values = array())
    {
        $this->computedAlter .= 'VALUES(';
        foreach($values as $i => $value)
        {
            $value = addslashes($value);
            if($i == 0)
            {
                $this->computedAlter .= '\''.$value.'\'';
            }
            else
            {
                $this->computedAlter .= ', \''.$value.'\'';
            }
        }
        
        $this->computedAlter .= ') ';
        
        return $this;
    }
    
    public function update($db)
    {
        $this->isinupdate = true;
        $this->computedupdate = '';
        
        $this->computedupdate .= 'UPDATE '.$db.' ';
        
        return $this;
    }
    
    public function set($target = array())
    {
        $this->computedupdate .= 'SET ';
        
        $counter = 0;
        foreach($target as $column => $content)
        {
            addslashes($content);
            
            if($counter == 0)
            {
                $this->computedupdate .= $column.' = \''.$content.'\'';
            }
            else
            {
                $this->computedupdate .= ', '.$column.' = \''.$content.'\'';
            }
            
            $counter++;
        }
        
        $this->computedupdate .= ' ';
        return $this;
    }
    
    
    
}

?>

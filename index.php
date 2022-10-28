<?php

class Tree {
    private $opening;
    private $closing;
    
    public static function validate($input) {
        $tree = new Tree();
        for ($i = 0; $i < count($input); $i++) {
            if ($tree == null) $tree = new Tree();
            
            if ($tree->opening == null) {
                if ($tree->isOpening($input[$i])) {
                    $tree->opening = $input[$i];
                } else {
                    return false;
                }
            } else if ($tree->closing == null) {
                if ($tree->isOpening($input[$i])) {
                    $tempTree = new Tree();
                    $tempTree->parent = $tree;
                    $tree = $tempTree;
                    $i -= 1;
                } else if ($tree->isClosing($input[$i])) {
                    $tree->closing = $input[$i];
                    $tree = $tree->parent;
                } else {
                    return false;
                }
            } 
        }
        if ($tree == null) return true;
    }
    
    private function isOpening($token) {
        $openingTokens = ["{", "[", "("];
        
        if (in_array($token, $openingTokens)) {
            return true;
        } else {
            return false;
        }
    }
    
    private function isClosing($token) {
        $closingTokens = ["}", "]", ")"];
        
        if (in_array($token, $closingTokens) && $this->isMatch($token)) {
            return true;
        } else {
            return false;
        }
    }
    
    private function isMatch($token) {
        switch($this->opening) {
            case "(":
                if ($token == ")") return true;
            case "[":
                if ($token == "]") return true;
            case "{":
                if ($token == "}") return true;
            default:
                return false;
        }
    }
}

function main($input) {
    $input = str_split($input);
    if (count($input) % 2 != 0) return false;
    
    return Tree::validate($input);
}

$input = "[{)]]]";
    
if (main($input) == false) {
    echo "\nfalse";
} else {
    echo "\ntrue";
}
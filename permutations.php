<?php 
// PHP program to print all  
// permutations of a given string. 
  
  
/** 
* permutation function 
* @param str string to  
*  calculate permutation for 
* @param l starting index 
* @param r end index 
*/
function permute($str, $l, $r) 
{ 
    if ($l == $r) 
        echo $str. ":"; 
    else
    { 
        for ($i = $l; $i <= $r; $i++) 
        { 
            $str = swap($str, $l, $i); 
            permute($str, $l + 1, $r); 
            $str = swap($str, $l, $i); 
        } 
    } 
} 
  
/** 
* Swap Characters at position 
* @param a string value 
* @param i position 1 
* @param j position 2 
* @return swapped string 
*/
function swap($a, $i, $j) 
{ 
    $temp; 
    $charArray = str_split($a); 
    $temp = $charArray[$i] ; 
    $charArray[$i] = $charArray[$j]; 
    $charArray[$j] = $temp; 
    return implode($charArray); 
} 
  
// Driver Code 
$str = "0JQK"; 
$n = strlen($str); 
permute($str, 0, $n - 1); 
  
// This code is contributed by mits. 
?> 
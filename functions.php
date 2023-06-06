<?php

function qsort( $arr ) 
{ 
    if( sizeof( $arr ) < 2 )    
    { 
        return $arr; 
    } 
    else 
    { 
        $baseIndex = 0;
        // в качестве опорного значения можно взять любое из массива
        // $baseIndex = rand( 0, sizeof( $arr ) - 1 );
        $base = $arr[ $baseIndex ];
        $lt = []; 
        $gt = []; 
        $mid = [ $base ]; 
        foreach( $arr as $index => $value ) 
        { 
            if( $value > $base ) 
            { 
                array_push( $gt, $value ); 
            } 
            else if( $value < $base ) 
            { 
                array_push( $lt, $value ); 
            }           
        }
        return array_merge( qsort( $lt ), $mid, qsort( $gt ) ); 
    } 
} 

function qsortWithRepeats( $arr ) 
{ 
    if( sizeof( $arr ) < 2 )    
    { 
        return $arr; 
    } 
    else 
    { 
        $baseIndex = 0;
        $base = $arr[ $baseIndex ];
        $lt = []; 
        $gt = []; 
        $mid = [ $base ]; 
        foreach( $arr as $index => $value ) 
        { 
            if( $value > $base ) 
            { 
                array_push( $gt, $value ); 
            } 
            else if( $value < $base ) 
            { 
                array_push( $lt, $value ); 
            } 
            else if( $index != $baseIndex AND $value == $base ) 
            { 
                array_push( $mid, $value ); 
            } 
        }
        return array_merge( qsortWithRepeats( $lt ), $mid, qsortWithRepeats( $gt ) ); 
    } 
} 

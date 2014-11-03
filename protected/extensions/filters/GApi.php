<?php
class GApi extends CFilter
{
    protected function preFilter($filterChain)
    {
    	header('Access-Control-Allow-Origin: *');
    	header('Content-Type: application/json');
    	// header('HTTP/1.1 401 Unauthorized', true, 401);
        // logic being applied before the action is executed
        return true; // false if the action should not be executed
    }
 
    protected function postFilter($filterChain)
    {
        // logic being applied after the action is executed
    }
}
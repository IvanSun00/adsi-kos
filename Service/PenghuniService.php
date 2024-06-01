<?php

    if(isset($_GET['request'])){
        $request = $_GET['request'];
        
        switch($request){
            case 'create':
                echo "something";
                break;
            case 'read':
                echo "something";
                break;
            default:
                echo "Invalid request";
                break;
        };

    }

?>
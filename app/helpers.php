<?php

function is_mobile($user_mobile){

    $chars = "/^((\(\d{2,3}\))|(\d{3}\-))?1(3|5|8|9)\d{9}$/";

    if (preg_match($chars, $user_mobile)){

        return true;

    }else{

        return false;

    }

}

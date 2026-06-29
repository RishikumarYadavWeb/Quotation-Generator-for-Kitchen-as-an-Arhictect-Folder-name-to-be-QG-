<?php
function can(string $permission):bool {
    if(
        !isset($_SESSION['permissions'])
    ){
        return false;
    }
    return in_array(
        $permission,
        $_SESSION['permissions']
    );
}
?>
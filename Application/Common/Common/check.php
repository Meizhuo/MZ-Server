<?php

function checkSex($sex) {
    if ($sex === '男' || $sex === '女') {
        return true;
    }
    return false;
}

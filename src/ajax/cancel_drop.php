<?php

if($_GET){
    unlink($_GET['path']);
    unlink($_GET['HQ']);
}
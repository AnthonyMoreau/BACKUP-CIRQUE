<?php

use AppCirque\core\HTML\form;
use AppCirque\admin\Controllers\Admin;

echo ($this->Auth) ? 'vous êtes connecté' : '';



if (isset($var)){
    echo $var['AddArticle'];
    echo $var['addEvent'];
    echo $var['modifyArticles'];
    echo $var['deconnect'];
}

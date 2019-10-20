<?php


namespace AppCirque\APP\Controllers;


class HeaderController
{
    public function HeaderHome(): void
    {

        ?>
            <div class="main-title">
                <h1 class="home-header-title"><span class="test">T</span><span>o</span><span>u</span><span>t</span> <span>u</span><span>n</span> <span>c</span><span>i</span><span>r</span><span>q</span><span>u</span><span>e</span></h1>
            </div>
            <div class="logo">
                <img src="/src/assets/img/tuc_Logo_white.png" alt="">
            </div>
        <?php
    }
}
<header>
    <div id="navContainer">
        <div id="logoContainer"><div><a href="./"><div id="logo"></div><div id="logoHover"></div></a></div></div>
        <div id="searchBarContainer">
            <input id="searchBar" class="typeahead" type="text" placeholder="Search"/>
        </div>
        <nav>
            <ul>
                <li><a>Topics</a>
                    <div>
                        <ul>
                            <?php 
                            foreach($GLOBALS['cfg']['sections'] as $section){
                                $section_ref = './'.str_replace(' ','_',$section);
                                echo '<li><a href="'.$section_ref.'">'.$section.'</a></li>';
                            }
                            //navbar(); 
                            /*<li><a href="./Data_Structures">Data Structures</a></li>
                            <li><a href="./Sorting">Sorting</a></li>
                            <li><a href="./Geometry">Geometry</a></li>
                            <li><a href="./Graph_Theory">Graph Theory</a></li>
                            <li><a href="./Number_Theory">Number Theory</a></li>
                            <li><a href="./Pattern_Matching">Pattern Matching</a></li>*/
                            ?>
                        </ul>
                    </div>
                </li>
                <li><a href="./Interviews">Interviews</a></li>
                <li><a href="./about">About</a></li>
            </ul>
            <a id="pull" href="#">MENU</a>
        </nav>
    </div>
</header>
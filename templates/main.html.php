<?php require('indexHeader.php'); ?>
<?php require('nav.php'); ?>

<div class="box-wrapper">
<div class="box" id="aboutbox">
    <h1>The Computer Science Handbook</h1>
    <h1>A Reference for Data Structures and Algorithms</h1>
    <p>A Perfect Resource For:</p>
    <ul>
        <li>College Courses!</li>
        <li>Interview Preparation!</li>
        <li>An Everyday Reference!</li>
    </ul>
    <h1>Topics:</h1>
    <ol>
        <?php 
        foreach($GLOBALS['cfg']['sections'] as $section){
        	$section_ref = './'.str_replace(' ','_',$section);
        	echo '<li><a href="'.$section_ref.'">'.$section.'</a></li>';
        }?>
    </ol>
    <a href="./topics">List of Topics</a><br>
    <a href="./public_html/TheComputerScienceHandbook.pdf">Free E-Book (First Draft)</a>
</div>

<div class="box" id="emailbox">
<!-- Begin MailChimp Signup Form -->
<div id="mc_embed_signup">
<form action="//thecshandbook.us9.list-manage.com/subscribe/post?u=0f5565d4f1a06563116ef2293&amp;id=f3ca03a0ed" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
    <div id="mc_embed_signup_scroll">
	<label for="mce-EMAIL">Interested in a book? Subscribe for updates!</label>
	<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required>
    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
    <div style="position: absolute; left: -5000px;"><input type="text" name="b_0f5565d4f1a06563116ef2293_f3ca03a0ed" tabindex="-1" value=""></div>
    <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
    </div>
</form>
</div>
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<div class="addthis_container">
<h1>Share on social media!</h1>
<div class="addthis_sharing_toolbox"></div>
</div>

<!--End mc_embed_signup-->
</div>

<div class="clear"></div>

</div>
<?php require('indexFooter.php'); ?>
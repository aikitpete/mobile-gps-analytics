		
	<div id="menuarea">	
		<div style="height:50%;display:block">
		<ul style="-webkit-margin-before: 0em;
-webkit-margin-after: 0em;
-webkit-margin-start: 0px;
-webkit-margin-end: 0px;
-webkit-padding-start: 0px;">
			
			<li><a href="http://www.piglin.eu/demola?action=intro" onclick="javascript:showIntro();" class="menuitem">INTRO</a></li>
			
			<?php
			if (isset( $_COOKIE['user_id'] )) : ?>
			<li><a href="http://www.piglin.eu/demola?action=admin" class="menuitem">ADMIN</a></li>

			<li><a href="http://studentinnovation.lu.se/?page_id=384" onclick="showProjectblog();" class="menuitem">BLOG</a></li>

			<li><a href="http://www.piglin.eu/demola?action=collect" class="menuitem">COLLECT</a></li>

			<li><a href="http://www.piglin.eu/demola?action=view" class="menuitem">VIEW</a></li>
			
			<li><a href="http://www.piglin.eu/demola?action=data" class="menuitem">DATA</a></li>

			<li><a href="http://www.piglin.eu/demola?action=analyze" class="menuitem" >ANALYZE</a></li>
			
			<?php endif; ?>
			<?php if (!isset( $_COOKIE['user_id'] )) : ?>
			<li><a href="http://www.piglin.eu/demola?action=signin" class="menuitem">SIGN IN</a></li>
			<?php endif; ?>
			
			<li><a href="http://www.piglin.eu/demola?action=signup" class="menuitem">SIGN UP</a></li>
			
			<li><a href="http://www.piglin.eu" onclick="javascript:showHomepage();" class="menuitem">HOME</a></li>

		</ul>
		<h2>Cyclists and the City Home</h2><br/>
		<p>Demola Team: Peter Gerhat, Jack Smith, Emelie Torstensson</p>
		</div>
		<div id="overlay" style="height:50%;width:100%;display:inline-block;float:left">
    		
			<?php
	
				include("login.php");
	
			?>
		</div>
		<!--<div style="height:50%;width:50%;display:inline-block;float:right">
			
		</div>-->
	</div>
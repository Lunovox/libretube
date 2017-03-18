<center>
	<div style="max-width:760px; padding:15px;">
		<center>
			<img width="300" src="imgs/modelos/sbl_forbidden.png"/><br/>
			<h2>ACESSO PROIBIDO</h2>
			<?php if(Propriedade("aviso")!=""){ ?>
				<div align="center" style="background-color:#FFFF00; border-color:#000000; border-width:1px; border-style:dashed;">
					<h2><?php
						$Aviso=Propriedade("aviso");
						echo $Aviso
					?></h2>
				</div>
				<br/>
			<?php } ?>
			<button onclick="window.location='?sub=log&redirect=<?php
				echo Propriedade("redirect")!=""?("&redirect=".Propriedade("redirect")):urlencode($_SERVER['QUERY_STRING']);
			?>';">LOGIN</button>
		</center>
	</div>
</center>
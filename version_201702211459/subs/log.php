<center>
	<div class_="FormSession"align_="justify">
		<?php if(Propriedade("aviso")!=""){ ?>
			<div align="center" style="background-color:#FFFF00; border-color:#000000; border-width:1px; border-style:dashed;">
				<h2><?php
					$Aviso=strip_tags(Propriedade("aviso"));
					$Aviso=str_replace("[FORBIDDEN]", "<img width='200' src='imgs/modelos/sbl_forbidden.png'/><br/>" , $Aviso);
					echo $Aviso
				?></h2>
			</div>
		<br/>
		<?php } ?>

		<form method="POST" enctype="application/x-www-form-urlencoded" >
			<input name="redirect" type="hidden" value="<?=Propriedade('redirect');?>"/>
			<br/><br/>
			<center>
				<img src="imgs/modelos/sbl_passwod.png" style="width:200px;" /><br/>
				<br/>
				<input id="txtLogEmail" name="LogEmail" type="email" required="true" autocomplete="true" 
					value="<?=Propriedade('LogEmail');?>" placeholder="E-Mail:"
				/><br/>
				
				<input id="txtLogPass" name="LogPass" type="password" required="true" placeholder="Senha:"/><br/>
				
				<input size='big' type="submit" formaction="?sub=log-in" value="Entrar"/> 
				<input size='big' type="button" onclick="window.location='?sub=log-on';" value="Registrar"/>

			</center>
		</form>

		<br/><br/>
	</div>
<center>




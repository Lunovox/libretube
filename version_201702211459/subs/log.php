<center>
	<div id="FormSession" align="left">

		<form method="POST" enctype="application/x-www-form-urlencoded" >
			<br/><br/>
			<center>
				<img src="imgs/modelos/sbl_passwod.png" style="width:200px;" /><br/>
				<?php if(Propriedade("Aviso")!=""){ ?>
					<div style="border-width:1px; border-style:dashed; border-color:#000000">
						<?=Propriedade("Aviso");?>
					</div><br/>
				<?php } ?>
				<br/>
				<input id="txtLogEmail" name="LogEmail" type="email" required="true" autocomplete="true" 
					value="<?=Propriedade('LogEmail');?>" placeholder="E-Mail:"
				/><br/>
				
				<input id="txtLogPass" name="LogPass" type="password" required="true" placeholder="Senha:"/><br/>
				
				<input type="submit" formaction="?sub=log-in" value="Entrar"/> <br/>
				<input type="button" onclick="window.location='?sub=log-on';" value="Resgistrar"/>

			</center>
		</form>

		<br/><br/>
		<!--br/><br/><br/><br/><br/><br/><br/>-->

	</div>
<center>




<?php 
	if(getLogedType()=="owner"){ 
		?>
			<center>
				<div id="FormSession" class="FormSession" align="left">
					<div id="TitleSession">
						<h2>Lista de Usuários</h2>
					</div>
					<hr/><br/>
					
					<?php
						$Users=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."users", NULL,  "Username ASC", null, 0, 5);
					?>
					<table class="frmAbout">
							<tr>
								<td class="cabecalho">
									ID
								</td>
								<td class="cabecalho">
									Username
								</td>
								<td class="cabecalho">
									E-Mail
								</td>
								<td class="cabecalho">
									Ultimo Acesso
								</td>
								<td class="cabecalho">
									Privilégio
								</td>
							</tr>
						<?php 
							for($U=0; $U<count($Users); $U++){
						?>
							<tr>
								<td>
									<?=$Users[$U]['ID'];?>
								</td>
								<td>
									<img hspace="0" align="absmiddle" src="imgs/icons/sbl_pessoa.gif"	/>
									<b><?=$Users[$U]['Username'];?></b>
								</td>
								<td>
									<?=$Users[$U]['Email'];?>
								</td>
								<td>
									<?=$Users[$U]['LastLogin'];?>
								</td>
								<td>
									<?=$Users[$U]['NivelDeAcesso'];?>
								</td>
							</tr>
						<?php } ?>
					</table>
				</div>
			<center>
		<?php 
	}else{require_once "subs/forbidden.php";}
?>

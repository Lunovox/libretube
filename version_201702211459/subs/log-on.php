<center>
	<div class="FormSession" align="left">
		<div id="TitleSession">
			<h2>Registro de Novo Usuário</h2>
		</div>
		<hr/><br/>
		<form name="frmLogOn" action="index.php" method="post">
			<input type="hidden" name="sub" value="log-on-save"/>
			<table style="width:100%">

				<tr>
					<td>
						<nobr><b>Nome do Usuário:</b></nobr>
					</td>
					<td width="100%">
						<input id="txtUsername" name="txtUsername" type="text" style="width:98%" maxlength="50" required="true" />
					</td>
				</tr>

				<tr>
					<td>
						<nobr><b>E-Mail de Contato:</b></nobr>
					</td>
					<td width="100%">
						<input id="txtEmail" name="txtEmail" type="email" style="width:98%" maxlength="50" required="true" />
					</td>
				</tr>
				<tr>
					<td></td>
					<td width="100%">
						Não se preocupem, seu email não será publicado!<br/><br/>
					</td>
				</tr>
				<tr><td colspan="2"><center><h3>Autentificação</h3><center></td></tr>
				<tr>
					<td>
						<nobr><b>Senha de Acesso:</b></nobr>
					</td>
					<td width="100%">
						<input id="txtSenha" name="txtSenha" type="password" style="width:150px" maxlength="50" required="true" />
					</td>
				</tr>
				<tr>
					<td>
						<nobr><b>Repetição de Senha:</b></nobr>
					</td>
					<td width="100%">
						<input id="txtSenhaConfirma" name="txtSenhaConfirma" type="password" style="width:150px" maxlength="50" required="true" />
					</td>
				</tr>

				<tr><td colspan="2"><br/></td></tr>
			
				<tr style="width:100%;">
					<td></td>
					<td>
						<script>
							function OnSubmitLogOn(){
								var txtUsername = document.getElementById('txtUsername');
								var txtEmail = document.getElementById('txtEmail');
								var txtSenha = document.getElementById('txtSenha');
								var txtSenhaConfirma = document.getElementById('txtSenhaConfirma');
								
								if(txtUsername.value!=""){
									if(txtEmail.value!=""){
										if(isEmailFormat(txtEmail.value)){
											if(txtSenha.value!="" && txtSenhaConfirma.value!=""){
												if(txtSenha.value==txtSenhaConfirma.value){
													document.forms['frmLogOn'].submit();
												}else{
													txtSenha.value="";
													txtSenhaConfirma.value="";
													txtSenha.focus()
													alert("A redigite a 'Senha de Acesso' e a 'Repetição de Senha' igualmente!");
												}
											}else{
												txtSenha.value="";
												txtSenhaConfirma.value="";
												txtSenha.focus()
												alert("Favor preencha a 'Senha de Acesso' e a 'Repetição de Senha'!");
											}
										}else{
											txtEmail.focus()
											alert("Favor preencha o 'E-Mail de Contato' corretamente!");
										}
									}else{
										txtEmail.focus()
										alert("Favor preencha o 'E-Mail de Contato'!");
									}
								}else{
									txtUsername.focus()
									alert("Favor preencha o 'Nome do Usuário'!");
								}
							}
						</script>
						<input type="button" onclick="OnSubmitLogOn();" value="Registrar" />
						<input type="button" onclick="window.location='?sub=home';" value="Cancelar" />
					</td>
				</tr>
			</table>
		</form>
	</div>
<center>

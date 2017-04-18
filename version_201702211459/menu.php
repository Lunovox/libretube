<nav>
	<ul class="menu" align="middle">
		<spam id="mnuAssistir" <?=(Propriedade('q')!=""?"style='display:none;'":"");?>>
			
			<?php
				$Playlists=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."playlist_head", "timePublish IS NOT NULL",  "timePublish DESC, timeUpdate DESC", null, 0, 10);
				//echo count($Playlists)."=============";
				if(count($Playlists)>=1){ ?>
					<li>
						<a
							title="Listagem de vídeos dividida por categorias."
						>Listas</a>
						<ul><?PHP
							for($P=0; $P<count($Playlists); $P++){ 
								$Videos=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."playlist_videos", "idPlaylist = ".$Playlists[$P]['ID'],  "idPlaylist DESC, ID DESC");
								if(count($Videos)>=1){?>
									<li><a href="?sub=playlist&id=<?=$Playlists[$P]['ID'];?>"><?=$Playlists[$P]['Title']." (".count($Videos)." vídeos)";?></a></li>
									<?php
								
								}
							}
							?>
							<li><a href="?sub=playlists">===== Todos =====</a></li>                   
						</ul>
					</li> <?php
				}
			?>
			
			<li> 
				<img 
					hspace="0" src="imgs/icons/sbl_libretube.png"
				/>
				<ul>

					<a href="?sub=video_list&order=recents" 
						title="Vídeos lançados recentemente em ordem descrescente de lançamentos."
					><li>Recentes</li></a>
					
					<a href="?sub=video_list&order=mostviews"
						title="Vídeos mais assistidos pela comunidade em ordem descrescente de visualização."
					><li>Mais Vistos</li></a>
					<?php 
					if(getLogedType()=="owner" || getLogedType()=="moderator"){ ?>
						<a href="?sub=video_list&order=privates"
							title="Vídeos que você ainda não publicou para o mundo."
						><li>Privados</li></a><?php 
					}
					
					if(getLogedType()=="owner" || getLogedType()=="moderator"){ ?>
						<a href="?sub=video_add" 
							title="Adiciona novo vídeo ao Opentube."
						><li>SUBIR VÍDEO</li></a><?php 
					} ?>

				</ul>
			</li>
			
			<a onclick="doToggleBuscador();" title="Buscar">
				<li style="display:block;">
					<img 
						 
						hspace="0" src="imgs/icons/sbl_lupa.gif"
					/>
				</li>
			</a>
			
			<?php
				/*if(isLoged()){ ?>
				<li>
					<a
						title="Ligações externas para sites, ou canais parceiros."
					>Parceiros</a>
					<ul>
						<li><a target="_blank" href="http://www.tuatec.com.br/opentube">Canal de Lunovox</a></li>
					</ul>
				</li>
				<?php }/**/ 
			?>
		
			<?php if(!isLoged()){ ?>
				<a id="btnLog" href="?sub=log" title="Entrar ou Registrar sua Conta"><li><img 
					 
					hspace="0" src="imgs/icons/sbl_cadeado.png"
				/></li></a>
			<?php }else{ ?>
				<a id="btnLog" href="?sub=log-out" title="Sair da sua Conta"><li><img 
					 
					hspace="0" src="imgs/icons/sbl_door.png"
				/></li></a>
			<?php } /**/ ?>
		</spam>

		<li id="mnuBuscador" <?=(Propriedade('q')!=""?"style='display:block;'":"");?>>
			<form id="frmBuscador" autocomplete="on" formaction="index.php">
				<input name="sub" type="hidden" value="video_list"/>
				<input name="order" type="hidden" value="search"/>
				<input 
					id="txtQuery" name="q" type="text" 
					placeholder="Buscar:" value="<?=Propriedade('q');?>"
				/>
				<img size="16x16" style="cursor:pointer; margin-left:5px;"
					src="imgs/icons/sbl_lupa.gif" 
					onclick="document.forms['frmBuscador'].submit();"
				/>
				<img size="16x16" style="cursor:pointer; margin-left:0px;"
					src="imgs/icons/sbl_negar.gif" 
					onclick="doToggleBuscador(); return false;"
				/>
			</form>
		</li>
	</ul>
</nav>

<nav>
	<ul class="menu" align="middle">
		<spam id="mnuAssistir">
			<li>
				<a href="?sub=home" title="Vitrine"><img 
					style="margin-top:-5px; margin-left:-10px;" 
					hspace="0" src="imgs/icons/sbl_libretube.png"
				/></a>
				<?php if(getLogedType()=="owner" || getLogedType()=="moderator"){ ?>
					<ul>
						<li><a href="?sub=video_add" 
							title="Adiciona novo vídeo ao Opentube."
						>SUBIR VÍDEO</a></li>
					</ul>
				<?php } ?>
			</li>
			
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
				<a>Assistir</a>
				<ul>
					<li><a href="?sub=video_list&order=recents" 
						title="Vídeos lançados recentemente em ordem descrescente de lançamentos."
					>Recentes</a></li>
					<li><a href="?sub=video_list&order=mostviews"
						title="Vídeos mais assistidos pela comunidade em ordem descrescente de visualização."
					>Mais Vistos</a></li>
					<?php 
					/*
					if(isLoged()){ ?>
						<li><a href="?sub=video_list&order=favorites"
							title="Vídeos que você marcou como 'gostei' em ordem descrescente de data de apreciação."
						>Aprecisados</a></li><?php 
					} 
					/**/
					if(getLogedType()=="owner" || getLogedType()=="moderator"){ ?>
						<li><a href="?sub=video_list&order=privates"
							title="Vídeos que você ainda não publicou para o mundo."
						>Privados</a></li><?php 
					} ?>
				</ul>
			</li>
			<li style="display:block;">
				<a onclick="doToggleBuscador();" title="Buscar"><img 
					style="margin-top:-5px; margin-left:-10px;" 
					hspace="0" src="imgs/icons/sbl_lupa.gif"
				/></a>
			</li>
			
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
				<li><a id="btnLog" href="?sub=log" title="Entrar ou Registrar sua Conta"><img 
					style="margin-top:-5px; margin-left:-10px;" 
					hspace="0" src="imgs/icons/sbl_cadeado.png"
				/></a></li>
			<?php }else{ ?>
				<li>
					<a id="btnLog" href="?sub=log-out" title="Sair da sua Conta"><img 
					style="margin-top:-5px; margin-left:-10px;" 
					hspace="0" src="imgs/icons/sbl_door.png"
				/></a>
				</li>
			<?php } /**/ ?>
		</spam>

		<spam id="mnuBuscador">
			<li>
				<form autocomplete="on">
					<input name="sub" type="hidden" value="video_list"/>
					<input name="order" type="hidden" value="search"/>
					Buscar <input id="txtQuery" name="q" type="text"/>
					<button type="submit" formaction="index.php">Ok</button>
					<button onclick="doToggleBuscador(); return false;">CANCELAR</button>
				</form>
			</li>
		</spam>
	</ul>
</nav>

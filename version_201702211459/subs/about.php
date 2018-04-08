<center>
	<div class="FormSession" align="left">

		<div id="TitleSession">
			<h2>SOBRE O LIBRETUBE</h2>
		</div>
		<hr/><br/>

		<p align="justify">
			<img align="right" src="imgs/banners/simbol_libretube.png">
			O Libretube é uma plataforma Federada de Televisão (para publicações de vídeo) 
			sobre servidor apache que pode ser instalado no computadores pessoais (como por exemplo um Raspberry 
			Pi) do usuário publicador de vídeo. Permitindo que o usuário produtor de vídeo possa seguir as regras 
			e leis de publicação de conteúdo que acredita ser ético, sem depender da prévia permissão institucional. 
			Igual ocorre quando alguém quer publicar um vídeo em um servidor de vídeos terceirizado como o youtube, 
			twitter tv, facebook tv, vimeo, viki, Media Goblin e etc.<br/><br/>
		</p>
		<ul>
			<li>
				<b>Repositório:</b> <a target="_blank" href="https://github.com/Lunovox/libretube">Libretube</a> (Alfa)<br/><br/>
				
				<p align="justify">
					"<b>Alfa</b>" Significa que o Libretube ainda está em fase de desenvolvimento 
					inicial, por isso ainda existem muitos paineis, botões, e funções que ainda não estão funcionando. Para 
					ver como anda a velocidade de desenvolvimento basta ver o <a target="_blank" 
					href="https://github.com/Lunovox/libretube/graphs/contributors?from=2017-02-19&to=2017-04-09&type=c"
					>Gráfico de Commits</a>.
				</p>
			</li>
		</ul><br/><br/>

		<h2>Licença GPL-3.0-or-later</h2>
		<p>
			Este projeto (LibreTube) está licenciada sob <b>GNU Lesser General Public License versão 3, como publicado pela Free Software Foundation, ou (à sua escolha), qualquer versão posterior</b> (GNU GPL-3.0-or-later). Isto permite que você use, estude, adapte, redistribua (comercialmente ou não) tanto a obra original quanto as adaptações. Porém, você deve atribuir a obra todas as vezes que usá-la, indicando o detentor dos direitos autorais (a quem esta obra pertence), o nome dela, como ela foi adquirida (ou onde ela pode ser adquirida, seja um endereço, e-mail, telefone, ou qualquer outro meio em que ela possa ser transferida), além de ter a obrigação de informar a licença da obra, e um endereço ou documento com a licença completa (ou seja, contendo o código legal). Além disso, caso você faça adaptações do projeto, deve manter a mesma licença, ou uma licença completamente compatível, conforme avaliada pela Free Software Foundation.
		</p><br/>
		<p>
			<ul>
				<li>
					Para mais informações, consulte a <a target="_blank" 
					href="http://www.gnu.org/licenses/gpl-3.0.html"
					>licença completa (código legal)</a>.
				</li>
			</ul>
		</p><br/>
		<p>
			Como uma permissão adicional sob <b>GNU GPL</b> versão 3 seção 7, você pode distribuir códigos objetos que não são a fonte (e.g., por estarem minimizados ou compacotados) sem a cópia da <b>GNU GPL</b> normalmente requerida pela seção 4, desde que você inclua esta notificação de licença e um URL pelo qual os recipientes/leitores possam acessar a Fonte Correspondente.
		</p><br/><br/>

		<h2>IDIOMAS SUPORTADOS:</h2>
		<table class="frmAbout">
			<tr>
				<td>
					<h3>Português</h3>
					O desenvolvimento está apenas no início. Quando estiver na etapa de internacionalização haverá adaptação para outros idiomas.
				</td>
			</tr>		
		</table>
		<br/>


		<h2>Lista de Desenvolvedores ( ͡° ͜ʖ ͡°)</h2>
		<table class="frmAbout">
			<tr>
				<td>
					<ul>
						<li><a target="_blank" href="https://libreplanet.org/wiki/User:Lunovox"><b>Lunovox Heavenfinder</b></a></li>
						<li><a target="_blank" href="https://libreplanet.org/wiki/User:Adfeno"><b>Adonay Felipe Nogueira</b></a></li>
						<li><a target="_blank" href="https://www.youtube.com/watch?v=mUW3IqpAtH0"><b>Jeterson Lordano</b></a></li>
					</ul>
				</td>
			</tr>		
		</table>
		<br/>

		<h2>DEPENDÊNCIAS</h2>
		<table class="frmAbout">
			<tr>
				<td>
					<ul>
						<li><b>Apache2:</b>  Usado para fazer servidor de sites</li>
						<li><b>MySQL:</b>  Usado para fazer servidor de Banco de Dados MySQL</li>
						<li><b>PHP5:</b>  Usado para manipular dinamicamente ao formato de site</li>
						<li><b>Avcov:</b>  Usado para gerar os Thumbnails (posters de vídeos).</li>
						<!--li><b>SQLite3:</b>  Usado para geranciar banco de dados SQLite versão 3.</li-->
					</ul><br/>
					
					<b>Comando para Instalação de Dependências:</b><br/>
					<ul>
						<li>
							<code>
								sudo apt-get update & sudo apt-get install 
								apache2 mysql-server php5 <!--php5-sqlite--> php5-mysql <!--phpmyadmin--> libav-tools
							</code>
						</li>
					</ul>
				</td>
			</tr>		
		</table>
		<br/>

		<h2>BIBLIOTECAS INCLUSAS</h2>
		<table class="frmAbout">
			<tr>
				<td>
					<h3>TinyMCE</h3>
					Descrição: Usado como editor QWERTY para comentários de vídeos.<br/>
					Arquivo Apontado: <a href="libs/tinymce_4.3.2/js/tinymce/tinymce.min.js">tinymce.min.js</a><br/>
					Código Fonte: <a href="libs/tinymce_4.3.2/js/tinymce/tinymce.js">tinymce.js</a><br/>
					Licença: <a href="http://www.gnu.org/licenses/lgpl-2.1.html">GNU Lesser General Public License, versão 2.1</a><br/>
					Repositório do Mantenedor: <a href="https://github.com/tinymce/tinymce">github.com</a><br/>
				</td>
			</tr>		
			<tr>
				<td>
					<h3>getID3</h3>
					Descrição: Usado para coletar metadados dos vídeos.<br/>
					Arquivo Apontado: <a href="libs/getID3-1.9.12/getid3/getid3.php">getid3.php</a><br/>
					Código Fonte: <a href="libs/getID3-1.9.12/getid3/getid3.php">getid3.php</a><br/>
					Licença: <a href="http://www.gnu.org/licenses/lgpl-2.1.html">GNU Lesser General Public License, versão 2.1</a><br/>
					Repositório do Mantenedor: <a href="https://github.com/JamesHeinrich/getID3">github.com</a><br/>
				</td>
			</tr>		
		</table>
		<br/>

		<h2>Funções Extras</h2>
		<table class="frmAbout">
			<tr>
				<td>
					<h3>Implantadas</h3>
					<ul>
						<li>Botões de Assinatura de Novidade do Canal</li>
						<li>Botões de Compartilhamento em Rede Sociais</li>
						<li>Botões de Downoad de Mídias, como: Vídeo, Poster, e Legenda</li>
						<li>Adaptação para Tela de Navegadores Dispositivos Móveis como Tablet ou Celulares</li>
					</ul>
				</td>
			</tr>		
			<tr>
				<td>
					<h3> Futuras</h3>
					<ul>
						<li>Botões de Personalização de Aparência do Canal</li>
						<li>Botões de Configuração de Progressão de Vídeo</li>
						<li>Botões de Embutir Vídeo em sites Externos</li>
						<li>Botões de Postar Comentário sobre vídeo</li>
						<li>Botões de Postar Avaliação de Relevância sobre vídeo</li>
						<li>Botões de Gerenciamente de Federação</li>
					</ul>
				</td>
			</tr>		
		</table>
		<br/>
		
	</div>
<center>

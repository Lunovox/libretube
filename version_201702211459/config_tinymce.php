<script src="libs/tinymce_4.3.2/js/tinymce/tinymce.js"></script>
<script>
	tinymce.init({
		language : 'pt_BR',
		selector: "txtdescription",
		content_css : "estilo_tinymce.css?update=<?=date('Y-m-d H:i:s');?>",    //FONTE: http://www.tinymce.com/wiki.php/Configuration3x:content_css
		plugins: [
			//"bbcode code ", //exporta como bbcode
			//"print link anchor paste textcolor hr",
			//"image table",
			"code ", //Exporta como html somente
			"link anchor paste textcolor hr",
			"table",
			"advlist lists autolink",
			//"advlist autolink lists link image charmap print preview anchor",
			"searchreplace visualblocks emoticons fullscreen",
			//"insertdatetime media table contextmenu paste"
		],
	
		//toolbar: "insertfile undo redo | cut copy paste | styleselect | bold italic underline | link image | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent"
		//toolbar: "print undo redo | cut copy paste searchreplace | bold italic underline | link image hr | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | fullscreen"
		//toolbar: "print undo redo | cut copy paste searchreplace | bold italic underline | link image hr | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor emoticons | fullscreen"
		toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
		toolbar2: 'print preview media | forecolor backcolor emoticons',
	});
</script>

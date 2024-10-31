<?php

$filtered_POST = array();
foreach ($_POST as $key => $value) {
	$filtered_POST[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

$_POST = $filtered_POST;


if(isset($_POST['import_file_url'])){
	$file_url = esc_url_raw( $_POST['import_file_url'] );

	if ( ! function_exists( 'tnc_pvfw_import_pdf_file' ) ){
		function tnc_pvfw_import_pdf_file( $file_url , $post_id , $desc = '' ) {
	
			if ( ! empty($file_url)) {
				$tmp = download_url( $file_url );
		
				preg_match('/[^\?]+\.(pdf)/', $file_url, $matches);
				$file_array['name'] = basename($matches[0]);
				$file_array['tmp_name'] = $tmp;
		
				if ( is_wp_error( $tmp ) ) {
					@unlink($file_array['tmp_name']);
					$file_array['tmp_name'] = '';
					return false;
				}
				$desc = $file_array['name'];
				$id = media_handle_sideload( $file_array, $post_id, $desc );
				if ( is_wp_error($id) ) {
					@unlink($file_array['tmp_name']);
					return false;
				} else {
					$src = esc_url_raw( wp_get_attachment_url( $id ) );
				}
				
			}

			if ( !empty( $src )) 
				return $src;
			else 
				return false;
		}
	}
	

	$new_file_url = tnc_pvfw_import_pdf_file($file_url, 0, 'Imported PDF File');

}
?>
<div class="wrap">
	<div id="poststuff">
	    <div id="post-body">
		    <div class="tnc-upload-container">
		    	<h1><?php echo esc_html_e( "Import a PDF File from URL", $domain = 'pdf-viewer-by-themencode' ); ?></h1>
		    	<p><?php echo esc_html_e( "This page allows you to import a PDF file easily from web to your media library. The purpose of this page is to reduce the amount of work you need while downloading and uploading again to media library.", $domain = 'pdf-viewer-by-themencode' ); ?></p>
				<form action="" method="POST">
					<strong>Put link to any pdf file and click on import</strong> <br><br />
					<input type="text" name="import_file_url" class="uploaded_file_url"> <br><br />
					<input type="submit" value="Import" class="button button-primary copy_btn" />
				</form>
				<?php if(!empty($new_file_url)){ ?>
					<h1>Imported File</h1>
					<p>Copy the url in the input below and use that in your shortcode</p>
					<input id="fileurl" class="uploaded_file_url" type="text" name="tnc_quick_upload_file" value="<?php echo $new_file_url; ?>" onclick="this.select();" /> <br><br />
					<a href="#" onClick="copyInstr()" class="button button-primary copy_btn">Copy</a><br />
            		<p id="copy-instruction"></p>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
function copyInstr() {
    document.getElementById("fileurl").select();
    document.getElementById("copy-instruction").innerHTML = "Please Press ctrl+c (cmd+c on mac) on your keyboard now to copy.";
}
</script>
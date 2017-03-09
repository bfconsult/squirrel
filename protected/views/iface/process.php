
	<div class="test">
		<h2> File Upload</h2>

		<form id="fileupload" enctype="multipart/form-data">
			Select image to upload:
			<label htmlFor="">File</label>
			<br />
			<input id='fileinputtag' type="file" name="fileToUpload" id="fileToUpload">
			<br />

			<input id='fileuploadparent' type="hidden" value="<?php echo $model->id; ?>">
			<br />
			<input type="submit" value="Upload Image" name="submit">
		</form>
		<h3>Return:</h3>
		<h6>Data</h6>
		<pre id="fileupload-data"></pre>
		<h6>Status</h6>
		<pre id="fileupload-status"></pre>
		<h6>Message</h6>
		<pre id="fileupload-message"></pre>
		<h6>Content</h6>
		<pre id="fileupload-content"></pre>

		<script type="text/javascript">

			$('#fileupload').submit(function(e) {
				e.preventDefault();
				
				var file = $('#fileinputtag')[0].files[0];
				var parent = $('#fileuploadparent')[0].value;


				
				console.log(parent);

				var form_data = new FormData();

				// console.log('type', typeof acceptedFiles[0])
				form_data.append('fileToUpload',file,file.name);
				
				
				$.ajax('/iface/process?id='+parent,{
					type: "POST",
					data: form_data,
					cache: false,
					// contentType: "application/json; charset=utf-8",
					dataType: "html",
					processData: false, // Don't process the files
					contentType: false,
					success: function (data) {
						console.log('update', data)

						/* JAMES:  
						When you are returning proper AJAX uncomment the following three lines
						And then you can remove the first of the .html(data) lines below $('#fileupload-data')
						*/

						// const status = JSON.parse(data).status
						// const message = JSON.parse(data).message
						// const receivedData = JSON.parse(data).content;
						
						$('#fileupload-data').html(data);
						$('#fileupload-status').html(status);
						$('#fileupload-message').html(message);
						$('#fileupload-content').html(JSON.stringify(receivedData,null,2));

					},
					error: (error) => {
						console.log(error)
						$('#fileupload-status').html("Got an Error");
						$('#fileupload-message').html(error.statusText);
						$('#fileupload-content').html(error.responseText);
					},
				})
			});

		</script>
	</div>

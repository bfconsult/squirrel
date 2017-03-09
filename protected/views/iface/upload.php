

<div class="test">
    <h2> File Upload</h2>

    <form id="fileupload" enctype="multipart/form-data">
        Select image to upload:
        <label htmlFor="">File</label>
        <br />
        <input id='fileinputtag' type="file" name="fileToUpload" id="fileToUpload">
        <br />
        <label htmlFor="">Batch Name</label>

        <input id='fileuploadparent' type="text">
        <br />
        <input type="submit" value="Upload Image" name="submit">
    </form>
    <h3>Result</h3>
    <pre id="fileupload-data"></pre>


    <script type="text/javascript">

        $('#fileupload').submit(function(e) {
            e.preventDefault();

            var file = $('#fileinputtag')[0].files[0];
            var parent = $('#fileuploadparent')[0].value;



            console.log(parent);

            var form_data = new FormData();

            // console.log('type', typeof acceptedFiles[0])
            form_data.append('fileToUpload',file,file.name);


            $.ajax('/iface/uploadZip?name='+parent,{
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

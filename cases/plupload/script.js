/**
 * jQuery
 */
$ ( 'document' ).ready ( function ( ) {

	var uploader = new plupload.Uploader ( {
		runtimes : 'html5,flash,silverlight,html4',
		browse_button : 'pickfiles', // you can pass in id...
		container : document.getElementById ( 'uploadcontainer' ), // ... or DOM Element itself
		url : 'upload.php',
		flash_swf_url : 'lib/Moxie.swf',
		silverlight_xap_url : 'lib/Moxie.xap',
		resize : {
			width : 300,
			height : 600
		},

		filters : {
			max_file_size : '10mb',
			mime_types : [ {
				title : "Image files",
				extensions : "jpg,gif,png"
			}, {
				title : "Zip files",
				extensions : "zip"
			} ]
		},

		init : {
			PostInit : function ( ) {
				document.getElementById ( 'filelist' ).innerHTML = '';

				document.getElementById ( 'uploadfiles' ).onclick = function ( ) {
					uploader.start ( );
					return false;
				};
			},

			FilesAdded : function ( up, files ) {
				plupload.each ( files, function ( file ) {
					document.getElementById ( 'filelist' ).innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize ( file.size ) + ') <b></b></div>';
				} );
			},

			UploadProgress : function ( up, file ) {
				document.getElementById(file.id).getElementsByTagName('b') [ 0 ].innerHTML = '<span>' + file.percent + "%</span>";
			},

			FileUploaded : function ( up, file ) {
				$ ( '#images' ).append ( '<img src="images/' + file.name + '" />' );
			},

			Error : function ( up, err ) {
				document.getElementById ( 'console' ).innerHTML += "\nError #" + err.code + ": " + err.message;
			}
		}
	} );

	uploader.init ( );

} );

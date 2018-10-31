 //响应返回数据容器

		$( document ).ready( function () {
			//响应文件添加成功事件
			$( ".inputfile" ).change( function () {
				var onfiles = $( this ).attr( "class" );
				//创建FormData对象
				var data = new FormData();
				//为FormData对象添加数据
				$.each( $( this )[ 0 ].files, function ( i, file ) {
					data.append( 'upload_file' + i, file );
				} );

				$( ".loading_upfile" ).show(); //显示加载图片
				//发送数据
				var file1 = $( "input:file" ).prop( "name" );
				$.ajax( {
					url: '../submit_img.php?imgtype=300_300&file_name=' + file1,
					type: 'POST',
					data: data,
					cache: false,
					contentType: false, //不可缺参数
					processData: false, //不可缺参数
					success: function ( data ) {
						$( "#feedback" ).html( '<img src="../upload/compress/' + data + '" alt="" style="width:inherit;">' );
						console.log( onfiles );
						//$("#imgId").attr('src',data); 
						$( ".loading_upfile" ).hide(); //加载成功移除加载图片
					},
					error: function () {
						alert( '上传出错' );
						$( ".loading_upfile" ).hide(); //加载失败移除加载图片
					}
				} );
			} );
		} );

// JavaScript Document
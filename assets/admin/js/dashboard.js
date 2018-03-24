
    /* [ ---- Remove ---- ] */
        function remove_people(id){
            if(confirm("Are you sure you want to remove this people ?")){
                CloseAlert('#alert-error');
                CloseAlert('#alert-success');
                $.ajax({
                     url: "people/remove_people",
                     type: "post",
                     data: {people_id:id},
                     success: function(data){
                        var obj=$.parseJSON(data);
                        if(obj.status === 1)
                        {
                            OpenAlert('#alert-success',obj.message , false);
                            $("#row_"+id).remove();
                        }
                        else if(obj.status === 0)
                        {
                            OpenAlert('#alert-error',obj.message , false);
                        }
                     },
                     error:function(){
                        OpenAlert('#alert-error','Callback Error' , true);
                     }
                 });
            }
        };
		
        function edit_people(id){
            
            $.ajax({
                url: "people/people_data",
                type: 'POST',
                data: 'people_id=' + id,
                dataType: "json",
                context: this,
                success: function (data) {
                    $('#people_id').val(data.id);
                    $('#edit_name').val(data.name);
                },
                error: function (request) {
                    
                }
            });
        };

		
		$('#update-people-data').submit(function(event) {
			
			event.preventDefault();
			
			CloseAlert('#alert-error');
			CloseAlert('#alert-success');
			
			$('#name_error').html('');
			
			$('.update-people').attr('disabled', true);
			$('.update-people').html('<i class="fa fa-refresh fa-spin"></i> Please wait...');
			
			var $form = $('#update-people-data');
			var $modal = $('#edit-people-modal');
			var temp=$('#edit-people-modal .progress-sm').html();
			
			$.ajax({
				xhr: function () {
					var xhr = new window.XMLHttpRequest();
					xhr.upload.addEventListener("progress", function (evt) {
						if (evt.lengthComputable) {
							var percentComplete = Math.ceil((evt.loaded / evt.total)*100);
							$('#edit-people-modal .progress-sm .progress-bar').attr('aria-valuenow',percentComplete);
							$('#edit-people-modal .progress-sm .progress-bar').css('width',percentComplete+'%');
							$('#edit-people-modal .progress-sm .progress-bar').html(percentComplete+'%');
						}
					}, false);
					return xhr;
				},
				type : $form.attr('method'),
				url : $form.attr('action'),
				data : new FormData($('#update-people-data')[0]),
				contentType: false,
				processData: false,
				dataType : 'JSON',
				success : function(msg){
					if(msg.status)
					{
						location.reload();
					}
					else
					{
						OpenAlert('#alert-error-model',msg.msg , false);
					}
				},
				error: function () {

				},
				complete: function(){
					$('#edit-people-modal .progress-sm').html(temp);
					//$modal.modal('toggle');
				}
			});
	
		});

        $('#dataTables-people-list').dataTable({
            processing : true,
            searching  : true,
        });

		$('#add-people').submit(function(event) {
			
			event.preventDefault();
			
			var $form = $('#add-people');
			var $modal = $('#new-people-modal');
			var temp=$('#new-people-modal .progress-sm').html();
			
			$.ajax({
				xhr: function () {
					var xhr = new window.XMLHttpRequest();
					xhr.upload.addEventListener("progress", function (evt) {
						if (evt.lengthComputable) {
							var percentComplete = Math.ceil((evt.loaded / evt.total)*100);
							$('#new-people-modal .progress-sm .progress-bar').attr('aria-valuenow',percentComplete);
							$('#new-people-modal .progress-sm .progress-bar').css('width',percentComplete+'%');
							$('#new-people-modal .progress-sm .progress-bar').html(percentComplete+'%');
						}
					}, false);
					return xhr;
				},
				type : $form.attr('method'),
				url : $form.attr('action'),
				data : new FormData($('#add-people')[0]),
				contentType: false,
				processData: false,
				dataType : 'JSON',
				success : function(msg){
					if(msg.status)
					{
						location.reload();
					}
					else
					{
						OpenAlert('#alert-error-model',msg.msg , false);
					}
				},
				error: function () {

				},
				complete: function(){
					$('#new-people-modal .progress-sm').html(temp);
					//$modal.modal('toggle');
				}
			});
	
		});
		
    /* [ ---- Remove ---- ] */
        function remove_comment(id){
            if(confirm("Are you sure you want to remove this comment ?")){
                CloseAlert('#alert-error');
                CloseAlert('#alert-success');
                $.ajax({
                     url: "comments/remove_comment",
                     type: "post",
                     data: {comment_id:id},
                     success: function(data){
                        var obj=$.parseJSON(data);
                        if(obj.status === 1)
                        {
                            OpenAlert('#alert-success',obj.message , false);
                            $("#row_"+id).remove();
                        }
                        else if(obj.status === 0)
                        {
                            OpenAlert('#alert-error',obj.message , false);
                        }
                     },
                     error:function(){
                        OpenAlert('#alert-error','Callback Error' , true);
                     }
                 });
            }
        };

        function edit_comment(id){
            
            $.ajax({
                url: "comments/comment_data",
                type: 'POST',
                data: 'comment_id=' + id,
                dataType: "json",
                context: this,
                success: function (data) {
                    $('#comment_id').val(data.id);
                    $('#comment').val(data.comment);
                },
                error: function (request) {
                    
                }
            });
        };
		
		$('#update-comment-data').submit(function(){
		CloseAlert('#alert-error');
		CloseAlert('#alert-success');
		
		$('#full_name_error').html('');
		
		$('.update-comment').attr('disabled', true);
		$('.update-comment').html('<i class="fa fa-refresh fa-spin"></i> Please wait...');
		
		$.post('comments/update_comment',$(this).serialize(),function(result){
			var obj=$.parseJSON(result);
			if(obj.status === 0)
			{
				if(obj.message.comment !== ''){$('#comment_error').html(obj.message.comment);}else{$('#comment_error').html('');}
				OpenAlert('#alert-error-model',obj.message , false);
				$('.update-comment').attr('disabled', false);
				$('.update-comment').html('Update Comment');
			}
			else if(obj.status === 1)
			{
				$('#comment_error').html('');
				$('.update-comment').attr('disabled', false);
				$('.update-comment').html('Update Comment');
				location.reload();
			}
		});
			return false;
		});
		
        $('#dataTables-comment-list').dataTable({
            processing : true,
            searching  : true,
        });
		
        function remove_feedback(id){
            if(confirm("Are you sure you want to remove this feedback ?")){
                CloseAlert('#alert-error');
                CloseAlert('#alert-success');
                $.ajax({
                     url: "feedback/remove_feedback",
                     type: "post",
                     data: {feedback_id:id},
                     success: function(data){
                        var obj=$.parseJSON(data);
                        if(obj.status === 1)
                        {
                            OpenAlert('#alert-success',obj.message , false);
                            $("#row_"+id).remove();
                        }
                        else if(obj.status === 0)
                        {
                            OpenAlert('#alert-error',obj.message , false);
                        }
                     },
                     error:function(){
                        OpenAlert('#alert-error','Callback Error' , true);
                     }
                 });
            }
        };
		
        $('#dataTables-feedback-list').dataTable({
            processing : true,
            searching  : true,
        });
		
		function view_comment(comment_text)
		{
			var text_decode = atob(comment_text);
			
			//$('#view_comments_loading').hide();
			$('#view_comments_div').html(text_decode);
			$('#view-comment-modal').modal('show');
		};
		
// ************************************************************************************************* //
		
        /* [ ---- Update Name CallBack ---- ] */
        $(function() {
            $('#update-name').submit(function(){
            CloseAlert('#update-error');
            CloseAlert('#update-success');
            $('.update-name').attr('disabled', true);
            $('.update-name').html('<i class="fa fa-refresh fa-spin"></i> Please wait...');

            $.post('profile/update_name',$(this).serialize(),function(result){
            var obj=$.parseJSON(result);
                if(obj.status === 1)
                {
                    OpenAlert('#update-success',obj.message , false);
                    $('.update-name').attr('disabled', false);
                    $('.update-name').html('Update Your Name');
                }
                else if(obj.status === 0)
                {
                    OpenAlert('#update-error',obj.message , false);
                    $('.update-name').attr('disabled', false);
                    $('.update-name').html('Update Your Name');
                }
            });
            return false;
            });
        });
		
        /* [ ---- Update Name CallBack ---- ] */
        $(function() {
            $('#update-email').submit(function(){
            CloseAlert('#update-error');
            CloseAlert('#update-success');
            $('.update-email').attr('disabled', true);
            $('.update-email').html('<i class="fa fa-refresh fa-spin"></i> Please wait...');

            $.post('profile/update_email',$(this).serialize(),function(result){
            var obj=$.parseJSON(result);
                if(obj.status === 1)
                {
                    OpenAlert('#update-success',obj.message , false);
                    $('.update-email').attr('disabled', false);
                    $('.update-email').html('Update Your Email');
                }
                else if(obj.status === 0)
                {
                    OpenAlert('#update-error',obj.message , false);
                    $('.update-email').attr('disabled', false);
                    $('.update-email').html('Update Your Email');
                }
            });
            return false;
            });
        });
        
        /* [ ---- Update Password CallBack ---- ] */
        $(function() {
            $('#update-password').submit(function(){
            CloseAlert('#update-error');
            CloseAlert('#update-success');
            $('.update-password').attr('disabled', true);
            $('.update-password').html('<i class="fa fa-refresh fa-spin"></i> Please wait...');

            $.post('profile/update_password',$(this).serialize(),function(result){
            var obj=$.parseJSON(result);
                if(obj.status === 1)
                {
                    OpenAlert('#update-success',obj.message , false);
                    $('.update-password').attr('disabled', false);
                    $('.update-password').html('Update Password');
                }
                else if(obj.status === 0)
                {
                    OpenAlert('#update-error',obj.message , false);
                    $('.update-password').attr('disabled', false);
                    $('.update-password').html('Update Password');
                }
            });
            return false;
            });
        });
		
        $('#dataTables-articles-list').dataTable({
            processing : true,
            searching  : true,
        });
		
		
		
		$('#summer_text').summernote({height: 320});
		$('#edit_content').summernote({height: 320});
	
		$('#new-articles').submit(function(){
		CloseAlert('#alert-error-model');
		CloseAlert('#alert-success-model');
		
		$('.save-articles').attr('disabled', true);
		$('.save-articles').html('<i class="fa fa-refresh fa-spin"></i> Please wait...');
		
		$.post('blog/new_article',$(this).serialize(),function(result){
			var obj=$.parseJSON(result);
			if(obj.status === 0)
			{
				OpenAlert('#alert-error-model',obj.message , false);
				$('.save-articles').attr('disabled', false);
				$('.save-articles').html('Save Article');
			}
			else if(obj.status === 1){
		
				$('.save-articles').attr('disabled', false);
				$('.save-articles').html('Save Article');
				$('#new-article-modal').modal('hide');
				$('#new-articles')[0].reset();
				OpenAlert('#alert-success',obj.message , false);
				location.reload();
			}
		});
			return false;
		});
		
		$('#edit-articles-form').submit(function(){
		CloseAlert('#alert-error-model');
		CloseAlert('#alert-success-model');
		
		$('.save-article-edit').attr('disabled', true);
		$('.save-article-edit').html('<i class="fa fa-refresh fa-spin"></i> Please wait...');
		
		$.post('blog/update_article',$(this).serialize(),function(result){
			var obj=$.parseJSON(result);
			if(obj.status === 0)
			{
				OpenAlert('#alert-error-model-edit',obj.message , false);
				$('.save-article-edit').attr('disabled', false);
				$('.save-article-edit').html('Edit Article');
			}
			else if(obj.status === 1){
		
				$('.save-article-edit').attr('disabled', false);
				$('.save-article-edit').html('Edit Article');
				$('#edit-articles-modal').modal('hide');
				$('#edit-articles-form')[0].reset();
				OpenAlert('#alert-success',obj.message , false);
				location.reload();
			}
		});
			return false;
		});
		
        function edit_articles(id){
            $.ajax({
                url:"blog/article_data",
                type:"POST",
                dataType:"json",
				data: {article_id:id},
                success:function( rst ){
					
                    $("#topic").val( rst.topic );
                    $("#edit_content").summernote('code', rst.content);
					$("#article_id").val(id);
                }
            });
            return false;
        };
		
        function view_content(id){
            $.ajax({
                url:"blog/article_data",
                type:"POST",
                dataType:"json",
				data: {article_id:id},
                success:function( rst ){
                    $("#article_topic").html( rst.topic );
                    $("#article_body").html( rst.content );
                }
            });
            return false;
        };
		
        function remove_articles(article_id){
			
			var answer = confirm("Are you sure you want to delete this tutorial?")
			if (answer)
			{
				$.ajax({
					 url: "blog/delete_article",
					 type: "post",
					 data: {article_id:article_id},
					 success: function(data){
						var obj=$.parseJSON(data);
						if(obj.status === 1)
						{
							location.reload();
						}
						else if(obj.status === 0)
						{
							OpenAlert('#alert-error-model',obj.message , false);
						}
					 },
					 error:function(){
						OpenAlert('#alert-error-model','Callback Error' , true);
					 }
				 });
			}
        };
		
		
		
		
		
		
		
		
		
		
		
		function view_blog_comment(comment_text)
		{
			var text_decode = atob(comment_text);
			
			//$('#view_comments_loading').hide();
			$('#view_comments_div').html(text_decode);
			$('#view-comment-modal').modal('show');
		};
		
		
    /* [ ---- Remove ---- ] */
        function remove_blog_comment(id){
            if(confirm("Are you sure you want to remove this comment ?")){
                CloseAlert('#alert-error');
                CloseAlert('#alert-success');
                $.ajax({
                     url: "blog_comments/remove_comment",
                     type: "post",
                     data: {comment_id:id},
                     success: function(data){
                        var obj=$.parseJSON(data);
                        if(obj.status === 1)
                        {
                            OpenAlert('#alert-success',obj.message , false);
                            $("#row_"+id).remove();
                        }
                        else if(obj.status === 0)
                        {
                            OpenAlert('#alert-error',obj.message , false);
                        }
                     },
                     error:function(){
                        OpenAlert('#alert-error','Callback Error' , true);
                     }
                 });
            }
        };

        function edit_blog_comment(id){
            
            $.ajax({
                url: "blog_comments/comment_data",
                type: 'POST',
                data: 'comment_id=' + id,
                dataType: "json",
                context: this,
                success: function (data) {
                    $('#comment_id').val(data.id);
                    $('#comment').val(data.comment);
                },
                error: function (request) {
                    
                }
            });
        };
		
		$('#update-comment-blog-data').submit(function(){
		CloseAlert('#alert-error');
		CloseAlert('#alert-success');
		
		$('#full_name_error').html('');
		
		$('.update-comment').attr('disabled', true);
		$('.update-comment').html('<i class="fa fa-refresh fa-spin"></i> Please wait...');
		
		$.post('blog_comments/update_comment',$(this).serialize(),function(result){
			var obj=$.parseJSON(result);
			if(obj.status === 0)
			{
				if(obj.message.comment !== ''){$('#comment_error').html(obj.message.comment);}else{$('#comment_error').html('');}
				OpenAlert('#alert-error-model',obj.message , false);
				$('.update-comment').attr('disabled', false);
				$('.update-comment').html('Update Comment');
			}
			else if(obj.status === 1)
			{
				$('#comment_error').html('');
				$('.update-comment').attr('disabled', false);
				$('.update-comment').html('Update Comment');
				location.reload();
			}
		});
			return false;
		});
		
		
		
		
		
		
		
		
// ************************************************************************************************* //
		
        function OpenModal(a){
            $(a).modal({backdrop: 'static'});
        };
        
        function CloseModal(a){
            $(a).modal('hide');
        };

        function OpenAlert(a, b, c){
            $(a).fadeIn("1000", function () {
                $(a).children("span").html(b);
                $(a).removeClass('hidden');
            });
            if(c === true){
                $(a).delay(5000).fadeOut("slow", function () {
                    $(a).addClass('hidden');
                });
            };
        };

        function CloseAlert(a){
            $(a).fadeOut("slow", function () {
                $(a).addClass('hidden');
            });
        };

        $('.dismissable').click(function(){
            $('.alert').fadeOut("slow", function () {
                $('.alert').closest('div').addClass("hidden");
            });
        });
		
		$(document).ready(function(){
		  $(function() {
		  	$('#datetimepicker').datetimepicker({
		  		format: " YYYY-MM-DD"
		  	})
		  });
		  $('.stars li').on('mouseover', function(){
			
			var onStar = parseInt($(this).data('value'), 10);

			$(this).parent().children('li.star').each(function(e){
			  if (e < onStar) {
				$(this).addClass('hover');
			  }
			  else {
				$(this).removeClass('hover');
			  }
			});
			
		  }).on('mouseout', function(){
			$(this).parent().children('li.star').each(function(e){
			  $(this).removeClass('hover');
			});
		  });

		  $('.stars li').on('click', function(){
			var onStar = parseInt($(this).data('value'), 10);
			var stars = $(this).parent().children('li.star');
			
			for (i = 0; i < 5; i++) {
			  $(stars[i]).removeClass('selected');
			}
			
			for (i = 0; i < onStar; i++) {
			  $(stars[i]).addClass('selected');
			}
			
			var ratingValue = parseInt($('.stars li.selected').last().data('value'), 10);
			var people_id = $(this).closest(".stars").find("input[name='rating_people_id']").val();
			
			var $rating_id = '#rating-id-' + people_id;

			//alert(people_id + ' ' + ratingValue);
			var msg = "";
			
            $.ajax({
                url: "home/send_rating",
                type: 'POST',
                data: 'rating=' + ratingValue + '&people_id=' + people_id,
                dataType: "json",
                context: this,
                success: function (data) {
					
					$($rating_id).val(data.rating_id);
					
					if (status === 1)
					{
						responseMessage(data.message);
					}
					else {
						responseMessage(data.message);
					}
					
					
                },
                error: function (request) {
                    
                }
            });
			
			
		  });
		  
		});

		function responseMessage(msg) {
		  $('.success-box').fadeIn(200);  
		  $('.success-box div.text-message').html("<span>" + msg + "</span>");
		}
		
		$('.send-comment').submit(function(){
			
			var people_id = $(this).find('input[name="people_id"]').val();
			var $button = '.btn-comment';
			var $comment_form = '#comment-form';

			$($comment_form).removeClass('has-error');
			$($button).attr('disabled', true);
			$($button).html('<i class="fa fa-refresh fa-spin"></i> Please wait...');
			
			$.post('home/send_comment',$(this).serialize(),function(result){
				var obj=$.parseJSON(result);
				if(obj.status === 0)
				{
					if(obj.message.comment !== ''){$($comment_form).addClass('has-error');}else{$($comment_form).removeClass('has-error');}
					OpenAlert('#alert-error-model-comment',obj.message.comment , false);
					$($button).attr('disabled', false);
					$($button).html('Send');
					
				}
				else if(obj.status === 1)
				{
					OpenAlert('#alert-success-model-comment',obj.message , true);
					 window.setTimeout(function(){
						 $('#view_comments').modal('hide');
					  }, 2000);
					$($comment_form).find("textarea[name='comment']").val('');
					$($comment_form).removeClass('has-error');
					$($comment_form).addClass('has-success');
					$($button).attr('disabled', false);
					$($button).html('Send');
				}
			});
			return false;
		});
		
		
		$('#feedback-form').submit(function(){
			

			var $button = '.btn-feedback';
			var $feedback_form = '#feedback-form';

			$($feedback_form).removeClass('has-error');
			$($button).attr('disabled', true);
			$($button).html('<i class="fa fa-refresh fa-spin"></i> Please wait...');
			
			$.post('home/send_feedback',$(this).serialize(),function(result){
				var obj=$.parseJSON(result);
				if(obj.status === 0)
				{
					if(obj.message.feedback !== ''){$($feedback_form).addClass('has-error');}else{$($feedback_form).removeClass('has-error');}
					$($button).attr('disabled', false);
					$($button).html('Send');
					
				}
				else if(obj.status === 1)
				{
					OpenAlert('#alert-success-model-feedback',obj.message , true);
					 window.setTimeout(function(){
						 $('#feedback').modal('hide');
					  }, 2000);
					$($feedback_form).find("textarea[name='feedback']").val('');
					$($feedback_form).removeClass('has-error');
					$($feedback_form).addClass('has-success');
					$($button).attr('disabled', false);
					$($button).html('Send');
				}
			});
			return false;
		});
		
		$('#send-contact').submit(function(){
			
			var $button = '.btn-contact';
			var $feedback_form = '#send-contact';

			$($feedback_form).removeClass('has-error');
			$($button).attr('disabled', true);
			$($button).html('<i class="fa fa-refresh fa-spin"></i> Please wait...');
			
			$.post('home/send_contact',$(this).serialize(),function(result){
				var obj=$.parseJSON(result);
				if(obj.status === 0)
				{
					if(obj.message.contact_text !== ''){
						$('#contact_text_error').addClass('has-error');
						$('#contact_text_error').children("span").html(obj.message.contact_text);
					}else{
						
						$('#contact_text_error').removeClass('has-error');
						$('#contact_text_error').addClass('has-success');
						$('#contact_text_error').children("span").html('');
					}
					if(obj.message.contact_name !== ''){
						
						$('#contact_name_error').addClass('has-error');
						$('#contact_name_error').children("span").html(obj.message.contact_name);
					}else{
						$('#contact_name_error').removeClass('has-error');
						$('#contact_name_error').addClass('has-success');
						$('#contact_name_error').children("span").html('');
					}
					if(obj.message.contact_email !== ''){
						$('#contact_email_error').addClass('has-error');
						$('#contact_email_error').children("span").html(obj.message.contact_email);
					}else{
						$('#contact_email_error').removeClass('has-error');
						$('#contact_email_error').addClass('has-success');
						$('#contact_email_error').children("span").html('');
					}
					$($button).attr('disabled', false);
					$($button).html('Send');
					
				}
				else if(obj.status === 1)
				{
					OpenAlert('#alert-success-model-contact',obj.message , true);
					 window.setTimeout(function(){
						 $('#contact').modal('hide');
					  }, 2000);
					$($feedback_form)[0].reset();
					$($feedback_form).removeClass('has-error');
					$($feedback_form).removeClass('has-success');
					$('#contact_text_error').children("span").html('');
					$('#contact_name_error').children("span").html('');
					$('#contact_email_error').children("span").html('');
					$($button).attr('disabled', false);
					$($button).html('Send');
				}
			});
			return false;
		});
		

		function give_rating(id)
		{
			var starss = $('.stars li').parent().children('li.star');
			  
			responseMessage('');
			$(starss[0]).removeClass('selected');
			$(starss[1]).removeClass('selected');
			$(starss[2]).removeClass('selected');
			$(starss[3]).removeClass('selected');
			$(starss[4]).removeClass('selected');
			
			$('#give_rating').modal('show');
			$('#rating_people_id').val(id);
		};
		  
		function view_comments(id)
		{

			$('#no-comments').hide();
			$('#view_comments-list').hide();
			$('#view_comments_loading').show();
			$('#view_comments').modal('show');

            $.ajax({
                url : 'home/view_comments',
                type : 'POST',
                dataType : 'json',
                data : { people_id : id },
                success : function ( data ) {
					
					if(data.length > 0)
					{
						$('#view_comments_div').html(' ');
						var counter = 1;
						$.each(data,function(key, val){
							$('#view_comments_div').append(function(){
									return '<span class="thumbnail" style="padding:10px 10px 10px 10px;"><p><strong>'+ val.date  +'</strong><p>' + val.comment +'<span>';
							});
							counter++;
						});
						$('#view_comments-list').show();
						
					}
					else
					{
						$('#no-comments').show();
					}
					
					$('#people_id').val(id);
					$('#view_comments_loading').hide();
                }
            });

		};
		
		
		
		function view_blog_comments(id)
		{

			$('#no-comments').hide();
			$('#view_comments-list').hide();
			$('#view_comments_loading').show();
			$('#view_blog_comments').modal('show');

            $.ajax({
                url : 'home/view_blog_comments',
                type : 'POST',
                dataType : 'json',
                data : { article_id : id },
                success : function ( data ) {
					
					if(data.length > 0)
					{
						$('#view_comments_div').html(' ');
						var counter = 1;
						$.each(data,function(key, val){
							$('#view_comments_div').append(function(){
									return '<span class="thumbnail" style="padding:10px 10px 10px 10px;"><p><strong>'+ val.date  +'</strong><p>' + val.comment +'<span>';
							});
							counter++;
						});
						$('#view_comments-list').show();
						
					}
					else
					{
						$('#no-comments').show();
					}
					
					$('#article_id').val(id);
					$('#view_comments_loading').hide();
                }
            });

		};
		
		$('.send-blog-comment').submit(function(){
			
			var people_id = $(this).find('input[name="article_id"]').val();
			var $button = '.btn-comment-blog';
			var $comment_form = '#comment-blog-form';

			$($comment_form).removeClass('has-error');
			$($button).attr('disabled', true);
			$($button).html('<i class="fa fa-refresh fa-spin"></i> Please wait...');
			
			$.post('home/send_blog_comment',$(this).serialize(),function(result){
				var obj=$.parseJSON(result);
				if(obj.status === 0)
				{
					if(obj.message.comment !== ''){$($comment_form).addClass('has-error');}else{$($comment_form).removeClass('has-error');}
					OpenAlert('#alert-error-model-comment',obj.message.comment , false);
					$($button).attr('disabled', false);
					$($button).html('Send');
					
				}
				else if(obj.status === 1)
				{
					OpenAlert('#alert-success-model-comment',obj.message , true);
					 window.setTimeout(function(){
						 $('#view_comments').modal('hide');
					  }, 2000);
					$($comment_form).find("textarea[name='comment']").val('');
					$($comment_form).removeClass('has-error');
					$($comment_form).addClass('has-success');
					$($button).attr('disabled', false);
					$($button).html('Send');
				}
			});
			return false;
		});
		
		
		
		
		
		
		
		
		
		
		
		

        $('#people_auto_complete').autoComplete({
            minChars: 1,
            source: function(term, suggest){
                
                key = $("#people_auto_complete").val();

                $("#people_auto_complete").addClass('loading');

                $.ajax({
                    url: "home/name_auto_complete",
                    type: 'POST',
                    data: 'key=' + key,
                    dataType: "json",
                    context: this,                
                    success: function (choices) {
                        
                        //alert(1);
                        
                        var suggestions = [];
                        for (i=0;i<choices.length;i++)
                            suggestions.push(choices[i]['name']);
                        suggest(suggestions);
                        
                        $("#people_auto_complete").removeClass('loading');
                    },
                    error: function () {

                    }
                });
            },
			onSelect: function(e, term, item){
				e = jQuery.Event("keypress")
				e.which = 13 //choose the one you want
					$("#people-search-form").keypress(function(){
						$("#people-search-form").submit();
						$(this).val(term);
					}).trigger(e)
			},
        });


        $('#manager_auto_complete').autoComplete({
            minChars: 1,
            source: function(term, suggest){
                
                key = $("#manager_auto_complete").val();
                $("#manager_auto_complete").addClass('loading');

                $.ajax({
                    url: "movepage/manager_auto_complete",
                    type: 'POST',
                    data: 'key=' + key,
                    dataType: "json",
                    context: this,                
                    success: function (choices) {                        
                        //alert(1);                        
                        var suggestions = [];
                        for (i=0;i<choices.length;i++)
                            suggestions.push(choices[i]['name']);
                        suggest(suggestions);
                        
                        $("#manager_auto_complete").removeClass('loading');
                    },
                    error: function () {

                    }
                });
            },
			onSelect: function(e, term, item){
				e = jQuery.Event("keypress")
				e.which = 13 //choose the one you want
					$("#manager-search-form").keypress(function(){
						$("#manager-search-form").submit();
						$(this).val(term);
					}).trigger(e)
			},
        });

        $('#candidate_auto_complete').autoComplete({
            minChars: 1,
            source: function(term, suggest){
                
                key = $("#candidate_auto_complete").val();
                $("#candidate_auto_complete").addClass('loading');

                $.ajax({
                    url: "movepage/candidate_auto_complete",
                    type: 'POST',
                    data: 'key=' + key,
                    dataType: "json",
                    context: this,                
                    success: function (choices) {                        
                        //alert(1);                        
                        var suggestions = [];
                        for (i=0;i<choices.length;i++)
                            suggestions.push(choices[i]['name']);
                        suggest(suggestions);
                        
                        $("#candidate_auto_complete").removeClass('loading');
                    },
                    error: function () {

                    }
                });
            },
			onSelect: function(e, term, item){
				e = jQuery.Event("keypress")
				e.which = 13 //choose the one you want
					$("#candidate-search-form").keypress(function(){
						$("#candidate-search-form").submit();
						$(this).val(term);
					}).trigger(e)
			},
        });

        $('#date_auto_complete').autoComplete({
            minChars: 1,
            source: function(term, suggest){
                
                key = $("#date_auto_complete").val();
                $("#date_auto_complete").addClass('loading');

                $.ajax({
                    url: "movepage/date_auto_complete",
                    type: 'POST',
                    data: 'key=' + key,
                    dataType: "json",
                    context: this,                
                    success: function (choices) {                        
                        //alert(1);                        
                        var suggestions = [];
                        for (i=0;i<choices.length;i++)
                            suggestions.push(choices[i]['name']);
                        suggest(suggestions);
                        
                        $("#date_auto_complete").removeClass('loading');
                    },
                    error: function () {

                    }
                });
            },
			onSelect: function(e, term, item){
				e = jQuery.Event("keypress")
				e.which = 13 //choose the one you want
					$("#date-search-form").keypress(function(){
						$("#date-search-form").submit();
						$(this).val(term);
					}).trigger(e)
			},
        });
		
		$('#doctor_auto_complete').autoComplete({
            minChars: 1,
            source: function(term, suggest){
                
                key = $("#doctor_auto_complete").val();
                $("#doctor_auto_complete").addClass('loading');

                $.ajax({
                    url: "movepage/doctor_auto_complete",
                    type: 'POST',
                    data: 'key=' + key,
                    dataType: "json",
                    context: this,                
                    success: function (choices) {                        
                        //alert(1);                        
                        var suggestions = [];
                        for (i=0;i<choices.length;i++)
                            suggestions.push(choices[i]['name']);
                        suggest(suggestions);
                        
                        $("#doctor_auto_complete").removeClass('loading');
                    },
                    error: function () {

                    }
                });
            },
			onSelect: function(e, term, item){
				e = jQuery.Event("keypress")
				e.which = 13 //choose the one you want
					$("#doctor-search-form").keypress(function(){
						$("#doctor-search-form").submit();
						$(this).val(term);
					}).trigger(e)
			},
        });

        $('#friend_auto_complete').autoComplete({
            minChars: 1,
            source: function(term, suggest){
                
                key = $("#friend_auto_complete").val();
                $("#friend_auto_complete").addClass('loading');

                $.ajax({
                    url: "movepage/friend_auto_complete",
                    type: 'POST',
                    data: 'key=' + key,
                    dataType: "json",
                    context: this,                
                    success: function (choices) {                        
                        //alert(1);                        
                        var suggestions = [];
                        for (i=0;i<choices.length;i++)
                            suggestions.push(choices[i]['name']);
                        suggest(suggestions);
                        
                        $("#friend_auto_complete").removeClass('loading');
                    },
                    error: function () {

                    }
                });
            },
			onSelect: function(e, term, item){
				e = jQuery.Event("keypress")
				e.which = 13 //choose the one you want
					$("#friend-search-form").keypress(function(){
						$("#friend-search-form").submit();
						$(this).val(term);
					}).trigger(e)
			},
        });

        $('#neighbor_auto_complete').autoComplete({
            minChars: 1,
            source: function(term, suggest){
                
                key = $("#neighbor_auto_complete").val();
                $("#neighbor_auto_complete").addClass('loading');

                $.ajax({
                    url: "movepage/neighbor_auto_complete",
                    type: 'POST',
                    data: 'key=' + key,
                    dataType: "json",
                    context: this,                
                    success: function (choices) {                        
                        //alert(1);                        
                        var suggestions = [];
                        for (i=0;i<choices.length;i++)
                            suggestions.push(choices[i]['name']);
                        suggest(suggestions);
                        
                        $("#neighbor_auto_complete").removeClass('loading');
                    },
                    error: function () {

                    }
                });
            },
			onSelect: function(e, term, item){
				e = jQuery.Event("keypress")
				e.which = 13 //choose the one you want
					$("#neighbor-search-form").keypress(function(){
						$("#neighbor-search-form").submit();
						$(this).val(term);
					}).trigger(e)
			},
        });
		
		$('#professor_auto_complete').autoComplete({
            minChars: 1,
            source: function(term, suggest){
                
                key = $("#professor_auto_complete").val();
                $("#professor_auto_complete").addClass('loading');

                $.ajax({
                    url: "movepage/professor_auto_complete",
                    type: 'POST',
                    data: 'key=' + key,
                    dataType: "json",
                    context: this,                
                    success: function (choices) {                        
                        //alert(1);                        
                        var suggestions = [];
                        for (i=0;i<choices.length;i++)
                            suggestions.push(choices[i]['name']);
                        suggest(suggestions);
                        
                        $("#professor_auto_complete").removeClass('loading');
                    },
                    error: function () {

                    }
                });
            },
			onSelect: function(e, term, item){
				e = jQuery.Event("keypress")
				e.which = 13 //choose the one you want
					$("#professor-search-form").keypress(function(){
						$("#professor-search-form").submit();
						$(this).val(term);
					}).trigger(e)
			},
        });

        $('#student_auto_complete').autoComplete({
            minChars: 1,
            source: function(term, suggest){
                
                key = $("#student_auto_complete").val();
                $("#student_auto_complete").addClass('loading');

                $.ajax({
                    url: "movepage/student_auto_complete",
                    type: 'POST',
                    data: 'key=' + key,
                    dataType: "json",
                    context: this,                
                    success: function (choices) {                        
                        //alert(1);                        
                        var suggestions = [];
                        for (i=0;i<choices.length;i++)
                            suggestions.push(choices[i]['name']);
                        suggest(suggestions);
                        
                        $("#student_auto_complete").removeClass('loading');
                    },
                    error: function () {

                    }
                });
            },
			onSelect: function(e, term, item){
				e = jQuery.Event("keypress")
				e.which = 13 //choose the one you want
					$("#student-search-form").keypress(function(){
						$("#student-search-form").submit();
						$(this).val(term);
					}).trigger(e)
			},
        });
		
		 $('#teacher_auto_complete').autoComplete({
            minChars: 1,
            source: function(term, suggest){
                
                key = $("#teacher_auto_complete").val();
                $("#teacher_auto_complete").addClass('loading');

                $.ajax({
                    url: "movepage/teacher_auto_complete",
                    type: 'POST',
                    data: 'key=' + key,
                    dataType: "json",
                    context: this,                
                    success: function (choices) {                        
                        //alert(1);                        
                        var suggestions = [];
                        for (i=0;i<choices.length;i++)
                            suggestions.push(choices[i]['name']);
                        suggest(suggestions);
                        
                        $("#teacher_auto_complete").removeClass('loading');
                    },
                    error: function () {

                    }
                });
            },
			onSelect: function(e, term, item){
				e = jQuery.Event("keypress")
				e.which = 13 //choose the one you want
					$("#teacher-search-form").keypress(function(){
						$("#teacher-search-form").submit();
						$(this).val(term);
					}).trigger(e)
			},
        });
		
		 $('#landlord_auto_complete').autoComplete({
            minChars: 1,
            source: function(term, suggest){
                
                key = $("#landlord_auto_complete").val();
                $("#landlord_auto_complete").addClass('loading');

                $.ajax({
                    url: "movepage/landlord_auto_complete",
                    type: 'POST',
                    data: 'key=' + key,
                    dataType: "json",
                    context: this,                
                    success: function (choices) {                        
                        //alert(1);                        
                        var suggestions = [];
                        for (i=0;i<choices.length;i++)
                            suggestions.push(choices[i]['name']);
                        suggest(suggestions);
                        
                        $("#landlord_auto_complete").removeClass('loading');
                    },
                    error: function () {

                    }
                });
            },
			onSelect: function(e, term, item){
				e = jQuery.Event("keypress")
				e.which = 13 //choose the one you want
					$("#landlord-search-form").keypress(function(){
						$("#landlord-search-form").submit();
						$(this).val(term);
					}).trigger(e)
			},
        });

		 $('#founder_auto_complete').autoComplete({
            minChars: 1,
            source: function(term, suggest){
                
                key = $("#founder_auto_complete").val();
                $("#founder_auto_complete").addClass('loading');

                $.ajax({
                    url: "movepage/founder_auto_complete",
                    type: 'POST',
                    data: 'key=' + key,
                    dataType: "json",
                    context: this,                
                    success: function (choices) {                        
                        //alert(1);                        
                        var suggestions = [];
                        for (i=0;i<choices.length;i++)
                            suggestions.push(choices[i]['name']);
                        suggest(suggestions);
                        
                        $("#founder_auto_complete").removeClass('loading');
                    },
                    error: function () {

                    }
                });
            },
			onSelect: function(e, term, item){
				e = jQuery.Event("keypress")
				e.which = 13 //choose the one you want
					$("#founder-search-form").keypress(function(){
						$("#founder-search-form").submit();
						$(this).val(term);
					}).trigger(e)
			},
        });


		$('#investor_auto_complete').autoComplete({
            minChars: 1,
            source: function(term, suggest){
                
                key = $("#investor_auto_complete").val();
                $("#investor_auto_complete").addClass('loading');

                $.ajax({
                    url: "movepage/investor_auto_complete",
                    type: 'POST',
                    data: 'key=' + key,
                    dataType: "json",
                    context: this,                
                    success: function (choices) {                        
                        //alert(1);                        
                        var suggestions = [];
                        for (i=0;i<choices.length;i++)
                            suggestions.push(choices[i]['name']);
                        suggest(suggestions);
                        
                        $("#investor_auto_complete").removeClass('loading');
                    },
                    error: function () {

                    }
                });
            },
			onSelect: function(e, term, item){
				e = jQuery.Event("keypress")
				e.which = 13 //choose the one you want
					$("#investor-search-form").keypress(function(){
						$("#investor-search-form").submit();
						$(this).val(term);
					}).trigger(e)
			},
        });
        $('#babysitter_auto_complete').autoComplete({
            minChars: 1,
            source: function(term, suggest){
                
                key = $("#babysitter_auto_complete").val();
                $("#babysitter_auto_complete").addClass('loading');

                $.ajax({
                    url: "movepage/babysitter_auto_complete",
                    type: 'POST',
                    data: 'key=' + key,
                    dataType: "json",
                    context: this,                
                    success: function (choices) {                        
                        //alert(1);                        
                        var suggestions = [];
                        for (i=0;i<choices.length;i++)
                            suggestions.push(choices[i]['name']);
                        suggest(suggestions);
                        
                        $("#babysitter_auto_complete").removeClass('loading');
                    },
                    error: function () {

                    }
                });
            },
			onSelect: function(e, term, item){
				e = jQuery.Event("keypress")
				e.which = 13 //choose the one you want
					$("#babysitter-search-form").keypress(function(){
						$("#babysitter-search-form").submit();
						$(this).val(term);
					}).trigger(e)
			},
        });
		
		$('#roomate_auto_complete').autoComplete({
            minChars: 1,
            source: function(term, suggest){
                
                key = $("#roomate_auto_complete").val();
                $("#roomate_auto_complete").addClass('loading');

                $.ajax({
                    url: "movepage/roomate_auto_complete",
                    type: 'POST',
                    data: 'key=' + key,
                    dataType: "json",
                    context: this,                
                    success: function (choices) {                        
                        //alert(1);                        
                        var suggestions = [];
                        for (i=0;i<choices.length;i++)
                            suggestions.push(choices[i]['name']);
                        suggest(suggestions);
                        
                        $("#roomate_auto_complete").removeClass('loading');
                    },
                    error: function () {

                    }
                });
            },
			onSelect: function(e, term, item){
				e = jQuery.Event("keypress")
				e.which = 13 //choose the one you want
					$("#roomate-search-form").keypress(function(){
						$("#roomate-search-form").submit();
						$(this).val(term);
					}).trigger(e)
			},
        });
		
		$('#lawyer_auto_complete').autoComplete({
            minChars: 1,
            source: function(term, suggest){
                
                key = $("#lawyer_auto_complete").val();
                $("#lawyer_auto_complete").addClass('loading');

                $.ajax({
                    url: "movepage/lawyer_auto_complete",
                    type: 'POST',
                    data: 'key=' + key,
                    dataType: "json",
                    context: this,                
                    success: function (choices) {                        
                        //alert(1);                        
                        var suggestions = [];
                        for (i=0;i<choices.length;i++)
                            suggestions.push(choices[i]['name']);
                        suggest(suggestions);
                        
                        $("#lawyer_auto_complete").removeClass('loading');
                    },
                    error: function () {

                    }
                });
            },
			onSelect: function(e, term, item){
				e = jQuery.Event("keypress")
				e.which = 13 //choose the one you want
					$("#lawyer-search-form").keypress(function(){
						$("#lawyer-search-form").submit();
						$(this).val(term);
					}).trigger(e)
			},
        });

        $('#boss_auto_complete').autoComplete({
            minChars: 1,
            source: function(term, suggest){
                
                key = $("#boss_auto_complete").val();
                $("#boss_auto_complete").addClass('loading');

                $.ajax({
                    url: "movepage/boss_auto_complete",
                    type: 'POST',
                    data: 'key=' + key,
                    dataType: "json",
                    context: this,                
                    success: function (choices) {                        
                        //alert(1);                        
                        var suggestions = [];
                        for (i=0;i<choices.length;i++)
                            suggestions.push(choices[i]['name']);
                        suggest(suggestions);
                        
                        $("#boss_auto_complete").removeClass('loading');
                    },
                    error: function () {

                    }
                });
            },
			onSelect: function(e, term, item){
				e = jQuery.Event("keypress")
				e.which = 13 //choose the one you want
					$("#boss-search-form").keypress(function(){
						$("#boss-search-form").submit();
						$(this).val(term);
					}).trigger(e)
			},
        });

        $('#agent_auto_complete').autoComplete({
            minChars: 1,
            source: function(term, suggest){
                
                key = $("#agent_auto_complete").val();
                $("#agent_auto_complete").addClass('loading');

                $.ajax({
                    url: "movepage/agent_auto_complete",
                    type: 'POST',
                    data: 'key=' + key,
                    dataType: "json",
                    context: this,                
                    success: function (choices) {                        
                        //alert(1);                        
                        var suggestions = [];
                        for (i=0;i<choices.length;i++)
                            suggestions.push(choices[i]['name']);
                        suggest(suggestions);
                        
                        $("#agent_auto_complete").removeClass('loading');
                    },
                    error: function () {

                    }
                });
            },
			onSelect: function(e, term, item){
				e = jQuery.Event("keypress")
				e.which = 13 //choose the one you want
					$("#agent-search-form").keypress(function(){
						$("#agent-search-form").submit();
						$(this).val(term);
					}).trigger(e)
			},
        });
        $('#colleague_auto_complete').autoComplete({
            minChars: 1,
            source: function(term, suggest){
                
                key = $("#colleague_auto_complete").val();
                $("#colleague_auto_complete").addClass('loading');

                $.ajax({
                    url: "movepage/colleague_auto_complete",
                    type: 'POST',
                    data: 'key=' + key,
                    dataType: "json",
                    context: this,                
                    success: function (choices) {                        
                        //alert(1);                        
                        var suggestions = [];
                        for (i=0;i<choices.length;i++)
                            suggestions.push(choices[i]['name']);
                        suggest(suggestions);
                        
                        $("#colleague_auto_complete").removeClass('loading');
                    },
                    error: function () {

                    }
                });
            },
			onSelect: function(e, term, item){
				e = jQuery.Event("keypress")
				e.which = 13 //choose the one you want
					$("#colleague-search-form").keypress(function(){
						$("#colleague-search-form").submit();
						$(this).val(term);
					}).trigger(e)
			},
        });
		
		
		
		$('#add-people').submit(function(event) {
			
			event.preventDefault();
			$('#insert_person .progress-sm').show();
			var $form = $('#add-people');
			var $modal = $('#insert_person');
			var temp=$('#insert_person .progress-sm').html();
			
			$.ajax({
				xhr: function () {
					var xhr = new window.XMLHttpRequest();
					xhr.upload.addEventListener("progress", function (evt) {
						if (evt.lengthComputable) {
							var percentComplete = Math.ceil((evt.loaded / evt.total)*100);
							$('#insert_person .progress-sm .progress-bar').attr('aria-valuenow',percentComplete);
							$('#insert_person .progress-sm .progress-bar').css('width',percentComplete+'%');
							$('#insert_person .progress-sm .progress-bar').html(percentComplete+'%');
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
						window.location = window.location.href;
					}
					else
					{
						OpenAlert('#alert-error-model-insert',msg.msg , false);
						$('#insert_person .progress-sm').hide();
					}
				},
				error: function () {

				},
				complete: function(){
					$('#insert_person .progress-sm').html(temp);
					//$modal.modal('toggle');
				}
			});
	
		});
		
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

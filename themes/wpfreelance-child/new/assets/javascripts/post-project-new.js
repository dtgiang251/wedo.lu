!function(e){var t=Math.ceil(10*Math.random()),a=Math.ceil(10*Math.random()),i=t+a;console.log(i),e("#lcaptcha").html(t+" + "+a+" = "),jQuery.validator.addMethod("math",function(e,t,a){return this.optional(t)||e==a[0]+a[1]},jQuery.format("Please enter the correct value for {0} + {1}"));var n=0,s=jQuery("#submit-project-new").validate({onfocusout:function(e){jQuery(e).valid()},onkeyup:!1,ignore:".ignore",lang:"en",rules:{post_content:{required:!0},"acf[field_5a58256641663]":{required:!0},project_cat:{required:!0},agree:{required:!0},captcha:{required:!0,math:[t,a]}},messages:{post_content:{required:object_name1.description_text}}}),r={init:function(){e("#submit-project-new").on("submit",this.submitProject1),this.postsubmit=[],this.attach_ids=[];var t=this;e(".category-select").click(function(t){e(".category-select").parent().removeClass("active"),e(this).parent().addClass("active");var a=e(this).find(".category-slug").val();return e(".categories-wrapper ul").addClass("hidden"),e(".categories-wrapper ul."+a).removeClass("hidden"),jQuery(".same-height .col").matchHeight(),e("html,body").animate({scrollTop:e("#main").offset().top-100},1e3),!1}),e(".input-pack-type").click(function(t){e(".pack-type-item").removeClass("selected"),e(this).closest("li").addClass("selected")});var a=e("#fileupload-container").find(".nonce_upload_field").val(),i=new plupload.Uploader({runtimes:"html5,gears,flash,silverlight,browserplus,html4",multiple_queues:!0,multipart:!0,urlstream_upload:!0,multi_selection:!1,upload_later:!1,browse_button:"sp-upload",container:document.getElementById("fileupload-container"),url:bx_global.ajax_url,filters:{max_file_size:"10mb",mime_types:[{title:"Image files",extensions:"jpg,gif,png,jpeg,ico,pdf,doc,docx,zip,excel,txt"}]},multipart_params:{action:"box_upload_file",nonce_upload_field:a},init:{PostInit:function(){},BeforeUpload:function(t,a){e(t.settings.container).addClass("uploading"),t.disableBrowse(!0)},FilesAdded:function(e,t){},Error:function(e,t){document.getElementById("console").innerHTML+="\nError #"+t.code+": "+t.message},FileUploaded:function(a,i,n){var s=jQuery.parseJSON(n.response);if(s.success){var r='<li class="">'+i.name+'<span id ="'+s.attach_id+'" class="btn-del-attachment hide">(x)</span></li>';e("ul.list-attach").append(r),t.attach_ids.push(s.attach_id)}else alert(s.msg);setTimeout(function(){e(a.settings.container).removeClass("uploading")},300),a.disableBrowse(!1)}}});i.init(),i.bind("FilesAdded",function(e,t){e.refresh(),e.start()})},submitProject1:function(t){if(s.form()){t.preventDefault();var a="insert",i=e(t.currentTarget),o={};i.find(" input[type=text], input[type=number],  input[type=hidden], input[type=email],textarea,select").each(function(){var t=e(this).attr("name");o[t]=e(this).val()});var l={};if(i.find(".acf-field input, .acf-field textarea, .acf-field select").each(function(){var t=e(this).closest(".acf-field").attr("data-key");l[t]=e(this).val()}),i.find(".acf-field input input:radio:checked").each(function(){var t=e(this).attr("name");l[t]=e(this).val()}),o.acf=l,i.find("input:radio:checked").each(function(){var t=e(this).attr("name");o[t]=e(this).val()}),o.attach_ids=r.attach_ids,"0"!=o.ID&&(a="renew"),n)return!1;window.ajaxSend.submitPost(o,"sync_project",a,function(t){if(i.find(".btn-submit").removeClass("loading"),t.success)if(t.premium_post){console.log(t);var a=wp.template("frm_pay_premium_job"),n=JSON.parse(jQuery("#json_packages").html());n[t.premium_post].project_id=t.job;var s=a(n[t.premium_post]);e("#puPaymentGateways").find(".modal-content").html(s),e("#puPaymentGateways").modal().show()}else window.location.href=t.redirect_url;else alert(t.msg)},function(e){if(i.find(".btn-submit").addClass("loading"),n)return!1;n=!0,console.log("beforeSend submit Project")})}}};r.init()}(jQuery,window.ajaxSend);
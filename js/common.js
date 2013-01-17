/**
 * @author Zahar Pecherin
 */
var polimers = {
    init: function(){
	this.clickLogin();
	this.login();
	this.signup();
	this.refreshCapcha();
	this.forgot();
	this.profile();
	this.change();
	this.add_listing();
	this.edit_listing();
	this.statusActive();
	this.statusInactive();
	this.userActive();
	this.userInactive();
	this.changeRoleAdmin();
	this.changeRoleNoAdmin();
    },
    
    changeRoleAdmin: function() {
	$('.admin').click(function(e){
	    var userID = $(this).attr('rel').replace('user_', '');
	    e.preventDefault();
	    $('.ajax-window').show();
	    $.ajax({
		    url: siteUrl + 'users/ajaxChangeRole',
		    type: 'POST',
		    dataType: 'json',
		    data: {
			id: userID,
			role: '1'
		    },
		    success: function(result) {
			window.location.href = location.href;
		    }	
	    });
	})	
    },
    
    changeRoleNoAdmin: function() {
	$('.noadmin').click(function(e){
	    var userID = $(this).attr('rel').replace('user_', '');
	    e.preventDefault();
	    $('.ajax-window').show();
	    $.ajax({
		    url: siteUrl + 'users/ajaxChangeRole',
		    type: 'POST',
		    dataType: 'json',
		    data: {
			id: userID,
			role: '0'
		    },
		    success: function(result) {
			window.location.href = location.href;
		    }	
	    });
	})	
    },
    
    userActive: function() {
	$('.active_user').click(function(e){
	    e.preventDefault();
	    var userID = $(this).attr('rel').replace('user_', '');
	    $('.ajax-window').show();
	    $.ajax({
		    url: siteUrl + 'users/ajaxChangeStatus',
		    type: 'POST',
		    dataType: 'json',
		    data: {
			id: userID,
			status: '1'
		    },
		    success: function(result) {
			window.location.href = location.href;
		    }	
	    });
	})	
    },
    
    userInactive: function() {
	$('.inactive_user').click(function(e){
	    e.preventDefault();
	    var userID = $(this).attr('rel').replace('user_', '');
	    $('.ajax-window').show();
	    $.ajax({
		    url: siteUrl + 'users/ajaxChangeStatus',
		    type: 'POST',
		    dataType: 'json',
		    data: {
			id: userID,
			status: '0'
		    },
		    success: function(result) {
			window.location.href = location.href;
		    }	
	    });
	})	
    },
    
    statusActive: function() {
	$('.active-status').click(function(e){
	    e.preventDefault();
	    var listingID = $(this).attr('rel').replace('listing_', '');
	    $('.ajax-window').show();
	    $.ajax({
		    url: siteUrl + 'listings/ajaxChangeStatus',
		    type: 'POST',
		    dataType: 'json',
		    data: {
			id: listingID,
			status: '1'
		    },
		    success: function(result) {
			window.location.href = location.href;
		    }	
	    });
	})	
    },
    
    statusInactive: function() {
	$('.inactive-status').click(function(e){
	    e.preventDefault();
	    var listingID = $(this).attr('rel').replace('listing_', '');
	    $('.ajax-window').show();
	    $.ajax({
		    url: siteUrl + 'listings/ajaxChangeStatus',
		    type: 'POST',
		    dataType: 'json',
		    data: {
			id: listingID,
			status: '0'
		    },
		    success: function(result) {
			window.location.href = location.href;
		    }	
	    });
	})	
    },
    
    refreshCapcha: function() {
	$('#refresh').click(function(e){
	    $('#ref').attr('src', siteUrl+'/images/ajax-loader.gif');
	    e.preventDefault();
	    $.ajax({
		    url: siteUrl + 'login/ajaxCaptcha',
		    type: 'POST',
		    dataType: 'json',
		    data: "refresh=" + refresh,
		    success: function(result) {
			$('#ref').attr('src', siteUrl+'/images/refresh.png');
			$('#capcha_image').html(result.html);
		    }	
	    });
	})
    },
    
    clickLogin: function(){
	$('#login').click(function(e){
	    e.preventDefault();
	    var form = $('#login_form');
	    if(form.css('display') == 'block') {
		$("#login-form-top").validate().resetForm();
		form.css('display', 'none');
	    } else {
		form.css('display', 'block');
	    }
	})
    },
    
    change: function(){
	    $('#change').validate({
		    errorClass:'error',
		    validClass:'success',
		    errorElement:'span',
		    rules:{
				    old_password: {
					    required: true
					},
				    password: {
					    required: true,
					    minlength: 6
					 },					
				    passconf: {
					    required: true,
					    equalTo: '#change #password'
					}
			},
		    messages:{
			    old_password: {
				    required: "Введите свой старый пароль"
			    },
			    password: {
				    required: "Введите пароль новый",
				    minlength: "Пароль должен быть не короче 6 символов"
			    },
			    passconf: {
				    required: "Повторите пароль",
				    equalTo: "Пароли не совпадают"
			    }
		    },
		    highlight: function (element, errorClass, validClass) {
				    $(element).parents("div.control").addClass(errorClass).removeClass(validClass);
		    },
		    unhighlight: function (element, errorClass, validClass) {
				    $(element).parents("div.control").removeClass(errorClass).addClass(validClass);
		    }
	    });	
    },
   
    forgot: function(){
	    $('#forgot').validate({
		    errorClass:'error',
		    validClass:'success',
		    errorElement:'span',
		    rules:{
				    email: {
					    required: true,
					    email: true
					},
				    captcha: {
					    required: true
					}
			},
		    messages:{
			    email: {
				    required: "Введите свой email",
				    email: "Введите правильный email"
			    },
			    captcha: {
				    required: "Введите код"
			    }
		    },
		    highlight: function (element, errorClass, validClass) {
				    $(element).parents("div.control").addClass(errorClass).removeClass(validClass);
		    },
		    unhighlight: function (element, errorClass, validClass) {
				    $(element).parents("div.control").removeClass(errorClass).addClass(validClass);
		    }
	    });	
    },
    
    profile: function(){
	    $('#profile').validate({
		    errorClass:'error',
		    validClass:'success',
		    errorElement:'span',
		    rules:{
				    name: {
					    required: true,
					    minlength: 4,
					    maxlength: 12
					},	    
				    email: {
					    required: true,
					    email: true
					}

			},
		    messages:{
			    email: {
				    required: "Введите свой email",
				    email: "Введите правильный email"
			    },
			    name: {
				    required: "Придумайте имя на сайте",
				    minlength: "Имя должно быть не короче 4 символов",
				    maxlength: "Имя должно быть не длинее 12 символов"
			    }
		    },
		    highlight: function (element, errorClass, validClass) {
				    $(element).parents("div.control").addClass(errorClass).removeClass(validClass);
		    },
		    unhighlight: function (element, errorClass, validClass) {
				    $(element).parents("div.control").removeClass(errorClass).addClass(validClass);
		    }
	    });	
    },
    
    signup: function(){
	    $('#signup').validate({
		    errorClass:'error',
		    validClass:'success',
		    errorElement:'span',
		    rules:{
				    name: {
					    required: true,
					    minlength: 4,
					    maxlength: 12
					},	    
				    email: {
					    required: true,
					    email: true
					},
				    password: {
					    required: true,
					    minlength: 6
					 },					
				    passconf: {
					    required: true,
					    equalTo: '#signup #password'
					 },
				    captcha: {
					    required: true
					}
			},
		    messages:{
			    email: {
				    required: "Введите свой email",
				    email: "Введите правильный email"
			    },
			    password: {
				    required: "Введите пароль",
				    minlength: "Пароль должен быть не короче 6 символов"
			    },
			    passconf: {
				    required: "Повторите пароль",
				    equalTo: "Пароли не совпадают"
			    },
			    name: {
				    required: "Придумайте имя на сайте",
				    minlength: "Имя должно быть не короче 4 символов",
				    maxlength: "Имя должно быть не длинее 12 символов"
			    },
			    captcha: {
				    required: "Введите код"
			    }
		    },
		    highlight: function (element, errorClass, validClass) {
				    $(element).parents("div.control").addClass(errorClass).removeClass(validClass);
		    },
		    unhighlight: function (element, errorClass, validClass) {
				    $(element).parents("div.control").removeClass(errorClass).addClass(validClass);
		    }
	    });	
    },

    add_listing: function(){
	    $('#add-listing').validate({
		    errorClass:'error',
		    validClass:'success',
		    errorElement:'span',
		    rules:{
				    name: {
					    required: true,
					    maxlength: 100
					    },
				    tel: {
					    required: true
					    },
				    text: {
					    required: true
					    }
			},
		    messages:{
			    name: {
				    required: "Введите название объявления",
				    maxlength: "Название должно быть не более 100 символов"
			    },
			    text: "Введите текст объявления",
			    tel: "Введите контактный телефон"
		    },
		    highlight: function (element, errorClass, validClass) {
				    $(element).parents("div.control").addClass(errorClass).removeClass(validClass);
		    },
		    unhighlight: function (element, errorClass, validClass) {
				    $(element).parents("div.control").removeClass(errorClass).addClass(validClass);
		    }
	    });
    },

    edit_listing: function(){
	    $('#edit-listing').validate({
		    errorClass:'error',
		    validClass:'success',
		    errorElement:'span',
		    rules:{
				    name: {
					    required: true,
					    maxlength: 100
					    },
				    tel: {
					    required: true
					    },
				    text: {
					    required: true
					    }
			},
		    messages:{
			    name: {
				    required: "Введите название объявления",
				    maxlength: "Название должно быть не более 100 символов"
			    },
			    text: "Введите текст объявления",
			    tel: "Введите контактный телефон"
		    },
		    highlight: function (element, errorClass, validClass) {
				    $(element).parents("div.control").addClass(errorClass).removeClass(validClass);
		    },
		    unhighlight: function (element, errorClass, validClass) {
				    $(element).parents("div.control").removeClass(errorClass).addClass(validClass);
		    }
	    });
    },
    
    login: function(){
	    $('#login-form').validate({
		    errorClass:'error',
		    validClass:'success',
		    errorElement:'span',
		    rules:{
				    email: {
					    required: true,
					    email: true
					    },
				    password: {
					    required: true
					    }
			},
		    messages:{
			    email: {
				    required: "Введите свой email",
				    email: "Введите правильный email"
			    },
			    password: "Введите свой пароль"
		    },
		    highlight: function (element, errorClass, validClass) {
				    $(element).parents("div.control").addClass(errorClass).removeClass(validClass);
		    },
		    unhighlight: function (element, errorClass, validClass) {
				    $(element).parents("div.control").removeClass(errorClass).addClass(validClass);
		    }
	    });
	    
	    $('#login-form-top').validate({
		    errorClass:'error',
		    validClass:'success',
		    errorElement:'div',
		    rules:{
				    email: {
					    required: true,
					    email: true
					    },
				    password: {
					    required: true
					    }
			},
		    messages:{
			    email: {
				    required: "Введите свой email",
				    email: "Введите правильный email"
			    },
			    password: "Введите свой пароль"
		    },
		    highlight: function (element, errorClass, validClass) {
				    $(element).parents("div.control").addClass(errorClass).removeClass(validClass);
		    },
		    unhighlight: function (element, errorClass, validClass) {
				    $(element).parents("div.control").removeClass(errorClass).addClass(validClass);
		    }
	    });	    
    }    
}
$(function(){
    polimers.init();
    $("a.iframe").fancybox({ 
	"frameWidth" : 800, 
	"frameHeight" : 600
	});    
    })
$(function () {
    'use strict';
    var filesList = {}
    $('#root').fileupload({
       beforeSend: function(){
	   var spinner = $('<img/>').attr({'src':siteUrl+'/images/spinner.gif'});
	   $('#logo').html(spinner);
       },	
       url: siteUrl + 'listings/upload',
       multipart: true,
       dataType: 'json',
       singleFileUploads: false,
       add: function(e,data) {
         var jqXHR = data.submit()
                .success(function(result, textStatus, jqXHR) {
		    if(result.error != 0){
			$('#logo').html('<span style="color:red;">Размер файла превышает 2Mb, либо вы загрузили не картинку</span>');
		    } else {
			var logo = $('<img/>').attr({'src':result.url2, 'alt': result.name2, 'title': result.name2});
			    $('#logo').html(logo);
			    $('#logo').append('<input type="hidden" name="image1" value="'+result.name1+'">');
			    $('#logo').append('<input type="hidden" name="image2" value="'+result.name2+'">');
		    }    
		})
		    .error(function (jqXHR, textStatus, errorThrown) {
		    })
		    .complete(function (result, textStatus, jqXHR) {
		    });		    
		    
       },
       progress: function(e, data) {
         var progress = parseInt(data.loaded / data.total * 100, 10);
       }
       
    });
});

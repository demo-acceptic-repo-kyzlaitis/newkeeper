/*$(document).ready(function(){
   var ind = true;
	function sortMethod(a, b) {
		var x = a.name.toLowerCase();
		var y = b.name.toLowerCase();
		return ((x < y) ? -1 : ((x > y) ? 1 : 0));
	}
		
	window.fbAsyncInit = function() {
	FB.init({ appId: '589294821132211',
		status: true,
		cookie: true,
		xfbml: true,
		oauth: true
	});
   function updateButton(response) {
		var button = document.getElementById('fb-auth');
			if (response.authResponse) { // в случае если не вошли в систему
			var userInfo = document.getElementById('user-info');
			FB.api('/me', function(response) {
				userInfo.innerHTML = '<img src="https://graph.facebook.com/' + response.id + '/picture">' + response.name;
				button.remove();
			});

			// получение списка друзей
			FB.api('/me/friends?limit=99', function(response) {
					var result_holder = document.getElementById('result_friends');
					var friend_data = response.data.sort(sortMethod);
					var results = '';
					for (var i = 0; i < friend_data.length; i++) {
					results += "<div class='checkboxes2'><a href='#'><img id="+friend_data[i].id+" src='https://graph.facebook.com/" + friend_data[i].id + "/picture' >" + friend_data[i].name +  "<div class='check' id='0'>" + "</div></div><br>";
				}

				// вывод на экран
				result_holder.innerHTML = results;
				//$("#result_friends").children().first().remove();
			});

			button.onclick = function() {
				FB.logout(function(response) {
				window.location.reload();
				});
			};

			//обработик нажатия на кнопку "поделиться"
			//проверка ind - сделана, чтоб окошко фейсбука взлетало только 1 раз(почему-то два раза взлетало, может 2 протокола используются, но х3)
			$(document).on("click",".checkboxes2",function(){
				if (ind)
					ind = false;
				else{
					ind = true;
					return 0;
				}
				id = $(this).children().last().children().first().attr("id");//идентификатор пользователя фейсбука, которому слать, friend_data[i].id = facebook identifier
				FB.ui(
					{ 
						method: 'send', 
						to: id,
						link: 'http://nk.applemint.net',
						picture: 'http://nk.applemint.net/images/logo.jpg',
						caption: 'Новостной портал',
						description: 'NewsKeeper - только свежие новости.'
						
					}, 	
				function(param){
					
				}
				);
			});
		} else { // в противном случае – кнопка входа
			button.onclick = function() {
				FB.login(function(response) {
					if (response.authResponse) {
						window.location.reload();
					}
				}, {scope:'email'});
			}
		}
	}

		// выполняется один раз с текущим статусом и каждый раз, когда статус изменяется
		FB.getLoginStatus(updateButton);
		FB.Event.subscribe('auth.statusChange', updateButton);
	};
   (function() {
		var e = document.createElement('script'); e.async = true;
		e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
		try{//проверка, на случай, если fb sdk подключен несколько раз
			$('#fb-root').last().append(e);
		}catch(k){
			$('#fb-root').append(e);
		}
		
  }());
  });*/
    $(document).ready(function(){

		$('.show-password').click(function() {
				if($(this).prev('input').prop('type') == 'password') {
					//Si c'est un input type password
					$(this).prev('input').prop('type','text');
					/*$(this).text('cacher');*/
				} else {
					//Sinon
					$(this).prev('input').prop('type','password'); 
					/*$(this).text('<hr>');*/
				}
			});

$('#ok').submit(function(e){
        /*$('#connecter').click(function(){*/
          name = $('#user').val();

          if (name == "" || name == " ") 
          	{
				swal.fire({
							type: 'error',
							title:'Champ vide',
							text:"Svp remplir les bonnes information !",
							footer:'<a></a>'  
						
						});
          	} 
          	else 
          	{
		$.post("pages/php/connection.php",{mail: name}, function(data) 
			{

if (data == "ereur") 
	{
				swal.fire({
							type: 'error',
							title:'utilisateur introuvable',
							text:"Svp remplir les bonnes information !",
							footer:'<a></a>' 
						
						});
	}
	 else 
	 {
	 	if (data == 0) 
	 		{
				swal.fire({
							type: 'succes',
							title:'compte bloquer',
							text:"Trois tentative echouer",
							footer:'<a>Svp contacter l\'administrateur!</a>' 
						
						});
	 		} 
	 		else
	 		 {
	 	$.post("pages/php/select.php",{id: data}, function(nom_u)
			{
				
				       Swal.fire({
    showCancelButton: false,
    showConfirmButton: false,
  title: ''+nom_u+' !&nbsp&nbsp<span> <button type="button" id="stop"><span aria-hidden="true">&times;</span></button> </span>',
  html:
  '<br></center><form id="ok1"><input autocomplete="off" autofocus required type="password" autocomplete="off" id="passe"placeholder="entrer votre Mot de pass" id="passe"><span class="show-password"><i class="zmdizmdi-eye"></i></span><br><br><br><center><input type="submit" id="connecte" value="connecter" class="btn btn-lg btn-success"><br><br></form></center>',
});
     $('#stop').click(function(){
swal.close();
}); 

$('#ok1').submit(function(e){
     	pass = $('#passe').val();
     		 	$.post("pages/php/check_passe.php",{id: data,pass: pass}, function(donnee)
			{
				if (donnee == '1') 
					{ 
location.replace("pages/page_principale.php"); 
					} 
				else 
					{
/*///////////////////////////////duexiemme//////////////////////////*/
				       Swal.fire({
    showCancelButton: false,
    showConfirmButton: false,
  title: ''+nom_u+' !&nbsp&nbsp<span> <button type="button" id="stop"><span aria-hidden="true">&times;</span></button> </span>',
  html:
  '<br><form id="ok1"></center><input autocomplete="off" autofocus required type="password" autocomplete="off" id="passe"placeholder="entrer votre Mot de pass" id="passe"><span class="show-password"><i class="zmdizmdi-eye"></i></span><br><br><br><center><input type="submit" id="connecte" value="connecter" class="btn btn-lg btn-success"><br><br></center></form>',
});
     $('#stop').click(function(){
swal.close();
}); 

$('#ok1').submit(function(e){
     	pass = $('#passe').val();
     		 	$.post("pages/php/check_passe.php",{id: data,pass: pass}, function(donne)
			{
				if (donne == '1') 
					{
location.replace("pages/page_principale.php"); 
					} 
				else 
					{
/*////////////////////////////troisiemme fois/////////////////////////*/
				       Swal.fire({
    showCancelButton: false,
    showConfirmButton: false,
  title: ''+nom_u+' !&nbsp&nbsp<span> <button type="button" id="stop"><span aria-hidden="true">&times;</span></button> </span>',
  html:
  '<br><form id="ok1"></center><input autocomplete="off" autofocus required type="password" autocomplete="off" id="passe"placeholder="entrer votre Mot de pass" id="passe"><span class="show-password"><i class="zmdizmdi-eye"></i></span><br><br><br><center><input type="submit" id="connecte" value="connecter" class="btn btn-lg btn-success"><br><br></center></form>',
});
     $('#stop').click(function(){
swal.close();
}); 

$('#ok1').submit(function(e){
     	pass = $('#passe').val();
$.post("pages/php/check_passe.php",{id: data,pass: pass}, function(datas)
			{
				if (datas == '1') 
					{
location.replace("pages/page_principale.php"); 
					} 
				else 
					{
	     		 	$.post("pages/php/bloquer.php",{id: data}, function(donne)
						{
							   swal.fire( 
									  'compte bloquer',
									  'Trois tatative echoué !!!', 
									  'error'
									  ); 
						});
	     		 	return false;
					}

			});return false;
});

/*///////////////////////////////////////////////////////////////////*/
					}

			});return false;
});

/*/////////////////////////////////////////////////////////////////*/
					}

			});return false;
});
	});	 		 	
	 		 }	

	 	return false;

	 }
			});
		return false; 
          	}
        });return false; 
    });
$(function(){
	$('#test').click(function(event){
		
		
		/*message simple 
			swal.fire(
				'message simple !'
			);*/


		/* message avec animation 
			swal.fire({ 
				title:"animation",
				animation:false,
				customClass:{
					popup:'animated tada'
				}
			});*/

		   /*message d erreur 
			swal.fire({
				
				type: 'error',
				title:"Champs vides !!",
				text:"Svp remplir les champs !",
				footer:'<a>nom ?</a>' 
			
			});*/
		
			 //message de success
			swal.fire(
				'Good job!',
				'You clicked the boutton ! ',
				'success'
			);
			
			
			/* question ? 
			swal.fire(
				'Good job ?',
				'You clicked the boutton ! ',
				'question'
			);*/
			
			/* confirmation d'enregistrement 
			swal.fire({ 
				position: 'top-end',
				title:"succes",
				text:"enregister",
				focusConfirmButton:false,
				timer:1500
			
			});*/
			
			/* message de confirmation 1  
			swal.fire({
				title: '<strong>Example</strong>',
				type: 'info',
				html: 'Je vis à <u>Bafoussam</u> '+'et je donne cours à foumban'+'le mardi et le vendredi',
				showCloseButton:true,
				showCancelButton:true,
				focusConfirm:false,
				confirmButtonText: '<i class="fa fa-thumbs-up"></i> Great !',
				confirmButtonAriaLabel:'Thumbs-up, great!',
				cancelButtonText: '<i class="fa fa-thumbs-down"></i>',
				cancelButtonAriaLabel: 'Thumbs-down'
			}); */
			
			/* message de confirmation 2 */
			/*swal.fire({
				title: 'êtes-vous sûr !',
				text: " Impossible de revenir en arrière !",
				type: 'warning',
				showCancelButton:true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Oui, Supprimer !'
			}).then((result)=>{
				if(result.value){
				swal.fire(
				'Supprimer !',
				'fichier supprimer.',
				'success'
				)
			 }
			}); */
			
			/* charger image 
			swal.fire({
				title: 'image',
				text: " mon image !",
				imageUrl: '13LDS6MPW.jpg',
				imageWidth:200,
				imageHeight:200,
				imageAlt:'custom image',
				animation: true
			}); */
			
			/* charger image 
			swal.fire({
				title: 'changer fond',
				text: " mon image !",
				imageUrl: '13LDS6MPW.jpg',
				imageWidth:200,
				imageHeight:200,
				imageAlt:'custom image',
				animation: true
			}); */
			
			/* confirmation 3 
			
			const swalWithBootstrapButtons = Swal.mixin({
				  customClass: {
					confirmButton: 'btn btn-success',
					cancelButton: 'btn btn-danger'
				  },
				  buttonsStyling: false
				})

				swalWithBootstrapButtons.fire({
				  title: 'Are you sure?',
				  text: "You won't be able to revert this!",
				  type: 'warning',
				  showCancelButton: true,
				  confirmButtonText: 'Yes,delete ',
				  cancelButtonText: 'No, cancel!',
				  reverseButtons: true
				}).then((result) => {
				  if (result.value) {
					swalWithBootstrapButtons.fire(
					  'Deleted!',
					  'Your file has been deleted.',
					  'success'
					)
				  } else if (
					
					result.dismiss === Swal.DismissReason.cancel
				  ) {
					swalWithBootstrapButtons.fire(
					  'Cancelled',
					  'Your imaginary file is safe :)',
					  'error'
					)
				  }
				});*/
				
				/* chrono 
				let timerInterval
				Swal.fire({
				  title: 'Auto close alert!',
				  html: 'I will close in <strong></strong> milliseconds.',
				  timer: 2000,
				  onBeforeOpen: () => {
					Swal.showLoading()
					timerInterval = setInterval(() => {
					  Swal.getContent().querySelector('strong')
						.textContent = Swal.getTimerLeft()
					}, 100)
				  },
				  onClose: () => {
					clearInterval(timerInterval)
				  }
				}).then((result) => {
				  if (
					
					result.dismiss === Swal.DismissReason.timer
				  ) {
					console.log('I was closed by the timer')
				  }
				})
			*/
			
			/* test mot de pass
			Swal.fire({
			  title: 'Submit your Github username',
			  input: 'text',
			  inputAttributes: {
				autocapitalize: 'off'
			  },
			  showCancelButton: true,
			  confirmButtonText: 'Look up',
			  showLoaderOnConfirm: true,
			  preConfirm: (login) => {
				return fetch(`${login}`)
				  .then(response => {
					if (!response.ok) {
					  throw new Error(response.statusText)
					}
					return response.json()
				  })
				  .catch(error => {
					Swal.showValidationMessage(
					  `Request failed: ${error}`
					)
				  })
			  },
			  allowOutsideClick: () => !Swal.isLoading()
			}).then((result) => {
			  if (result.value) {
				Swal.fire({
				  title: `${result.value.login}'s avatar`,
				  imageUrl: result.value.avatar_url
				})
			  }
			})*/
			
			/* reponse message
			Swal.mixin({
			  input: 'text',
			  confirmButtonText: 'Next &rarr;',
			  showCancelButton: true,
			  progressSteps: ['1', '2', '3']
			}).queue([
			  {
				title: 'Question 1',
				text: 'Chaining swal2 modals is easy'
			  },
			  'Question 2',
			  'Question 3'
			]).then((result) => {
			  if (result.value) {
				Swal.fire({
				  title: 'All done!',
				  html:
					'Your answers: <pre><code>' +
					  JSON.stringify(result.value) +
					'</code></pre>',
				  confirmButtonText: 'Lovely!'
				})
			  }
			});*/
			
			/* afficher une pub
			const ipAPI = 'https://api.ipify.org?format=json'

			Swal.queue([{
			  title: 'Your public IP',
			  confirmButtonText: 'Show my public IP',
			  text:
				'Your public IP will be received ' +
				'via AJAX request',
			  showLoaderOnConfirm: true,
			  preConfirm: () => {
				return fetch(ipAPI)
				  .then(response => response.json())
				  .then(data => Swal.insertQueueStep(data.ip))
				  .catch(() => {
					Swal.insertQueueStep({
					  type: 'error',
					  title: 'Unable to get your public IP'
					})
				  })
			  }
			}]);*/
			
			/* chrono 2
			let timerInterval
			Swal.fire({
			  title: 'Auto close alert!',
			  html:
				'I will close in <strong></strong> seconds.<br/><br/>' +
				'<button id="increase" class="btn btn-warning">' +
				  'I need 5 more seconds!' +
				'</button><br/>' +
				'<button id="stop" class="btn btn-danger">' +
				  'Please stop the timer!!' +
				'</button><br/>' +
				'<button id="resume" class="btn btn-success" disabled>' +
				  'Phew... you can restart now!' +
				'</button><br/>' +
				'<button id="toggle" class="btn btn-primary">' +
				  'Toggle' +
				'</button>',
			  timer: 10000,
			  onBeforeOpen: () => {
				const content = Swal.getContent()
				const $ = content.querySelector.bind(content)

				const stop = $('#stop')
				const resume = $('#resume')
				const toggle = $('#toggle')
				const increase = $('#increase')

				Swal.showLoading()

				function toggleButtons () {
				  stop.disabled = !Swal.isTimerRunning()
				  resume.disabled = Swal.isTimerRunning()
				}

				stop.addEventListener('click', () => {
				  Swal.stopTimer()
				  toggleButtons()
				})

				resume.addEventListener('click', () => {
				  Swal.resumeTimer()
				  toggleButtons()
				})

				toggle.addEventListener('click', () => {
				  Swal.toggleTimer()
				  toggleButtons()
				})

				increase.addEventListener('click', () => {
				  Swal.increaseTimer(5000)
				})

				timerInterval = setInterval(() => {
				  Swal.getContent().querySelector('strong')
					.textContent = (Swal.getTimerLeft() / 1000)
					  .toFixed(0)
				}, 100)
			  },
			  onClose: () => {
				clearInterval(timerInterval)
			  }
			});*/
		
	});
	
});
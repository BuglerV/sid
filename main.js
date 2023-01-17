var system = {
	loaded: false,

	eventType_row_check(target) {
		let input = target.querySelector('input');
	
		input.checked = !input.checked;
	},
	eventType_send() {
		if( this.loaded ) return;

		let inputsToSend = document.querySelectorAll('input:checked');

		if( !inputsToSend.length ) return;

		if( !confirm('Действительно хотите перенести выбранные лиды в U-ON?') ) return;

		ids = [];

		inputsToSend.forEach((input) => {
			ids.push(input.closest('tr').id);
		});

		let data = new FormData;
		data.append('ids', ids.join(','));

		fetch('/sendToUON.php',{
			method: 'POST',
			body: data
		}).then(() => {
			inputsToSend.forEach((input) => {
				input.closest('tr').remove();
			});
		}).finally(() => {
			this.loaded = false;
		});
	}
};

window.system = system;

window.onload = function(){
	// Будем ловить события нажатия.
	document.addEventListener('click',function(event){
	  // Ловятся только те, что имеют структуру
	  //  <div data-role="menu-navigator">
	  //      <div data-type="eventName">ELEMENT</div>
	  //  </div>
	  let navigator = event.target.closest('[data-role="menu-navigator"]');
	  let target = event.target.closest('[data-type]');
	  
	  if(!navigator || !target || !navigator.contains(target)) return;
	  
	  let eventType = 'eventType_'+target.dataset['type'];
	  if(!system[eventType]) return;

	  event.preventDefault();

	  // Запуск самого события.
	  system[eventType](target,navigator);
	});
};
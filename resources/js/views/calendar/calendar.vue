<template>
	<div>
		<full-calendar :events="events" :config="config"></full-calendar>
	</div>
</template>

<script>
	import { FullCalendar } from 'vue-full-calendar'

	export default {
		components: {FullCalendar},
		data(){
			return {
				events: [],
				config: {
					defaultView: 'month',
					isRTL: this.getConfig('direction') == 'rtl' ? true : false,
					eventRender: function(event, element) {
				    	$(element).tooltip({title: event.title});     
				    	if(event.icon){          
					        element.find(".fc-title").prepend(" <i class='fas fa-"+event.icon+"'></i> ");
					    }        
				  	}
				}
			}
		},
		mounted(){
			this.getEvents();
		},
		methods: {
			getConfig(config){
				return helper.getConfig(config);
			},
			getEvents(){
				axios.post('/api/dashboard/calendar/event')
					.then(response => {
						response.holidays.forEach(holiday => {
							this.events.push({
								title: holiday.description,
								start: holiday.date,
								icon: 'coffee',
								color: 'teal'
							})
						})
						response.todos.forEach(todo => {
							this.events.push({
								title: todo.title,
								start: todo.date,
								icon: 'check-circle',
								color: todo.date < moment().format('YYYY-MM-DD') ? 'red' : ''
							})
						})
						response.events.forEach(event => {
							this.events.push({
								title: event.title,
								start: event.start_date,
								end: event.end_date,
								icon: 'bullhorn',
								color: 'purple'
							})
						})
					})
					.catch(error => {
						helper.showErrorMsg(error);
					})
			}
		}
	}
</script>
<style>
	.fc-row .fc-content-skeleton tbody td.fc-event-container {
		padding: 0 10px;
	}
	.fc-day-grid-event {
		border-radius: 5px;
	    margin-top: 2px;
	    margin-bottom: 2px;
	}
	.fc-day-grid-event .fc-content {
	  white-space: nowrap; 
	  overflow: hidden;
	  text-overflow: ellipsis;
	}
</style>
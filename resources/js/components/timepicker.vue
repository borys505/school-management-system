<template>
	<div>
	    <select :value="hour" class="custom-select" style="width:auto;" name="hour" @change="updateHour">
	      <option value="">{{trans('general.select_hour')}}</option>
	      <option v-for="hr in hours" v-bind:value="hr">
	        {{ timePadding(hr) }}
	      </option>
	    </select>
	    <select :value="minute" class="custom-select m-l-10" style="width:auto;" name="minute" @change="updateMinute">
	      <option value="">{{trans('general.select_minute')}}</option>
	      <option v-for="min in mins" v-bind:value="min">
	        {{ timePadding(min) }}
	      </option>
	    </select>
	    <select :value="meridiem" class="custom-select m-l-10" style="width:auto;" name="meridiem" @change="updateMeridiem">
	      <option v-for="mer in meridiems" v-bind:value="mer.value">
	        {{ mer.text }}
	      </option>
	    </select>
	</div>
</template>

<script>
	export default {
        props: ['hour','minute','meridiem'],
        data(){
        	return{
                hours: [1,2,3,4,5,6,7,8,9,10,11,12],
                mins: [0,5,10,15,20,25,30,35,40,45,50,55],
                meridiems: [
                	{
                		text: i18n.general.am,
                		value: 'am'
                	},
                	{
                		text: i18n.general.pm,
                		value: 'pm'
                	}
                ]
        	}
        },
		methods: {
			timePadding(time){
                return helper.formatWithPadding(time,2);
			},
            updateHour(val){
                this.$emit('update:hour',val.target.value);
            },
            updateMinute(val){
                this.$emit('update:minute',val.target.value);
            },
            updateMeridiem(val){
                this.$emit('update:meridiem',val.target.value);
            }
		}
	}
</script>
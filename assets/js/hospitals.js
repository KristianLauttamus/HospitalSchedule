Vue.config.delimiters = ['<%', '%>'];
Vue.config.debug = true;

var vuejs = new Vue({
	el: 'form',

	data: {
		defaultOption: 0,
		options: ['test', 'test2'],
		hours: [-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1],

		slider: null
	},

	ready: function(){
		var that = this;
		this.slider = new Slider('#hours', {});
		this.slider.on('slide', function(){
			that.hoursChanged();
		});
	},

	methods: {
		hoursChanged: function(){
			var hours = this.slider.getValue();

			this.showableHours = [];
			for(var i = hours[0]; i < hours[1]; i++){
				this.showableHours.push(this.hours[i]);
			}
		},

		defaultOptionChanged: function(){
			for(var i = 0; i < this.hours.length; i++){
				if(hours[i] == -1){
					hours[i] = this.defaultOption;
				}
			}
		}
	}
});
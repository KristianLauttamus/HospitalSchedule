Vue.config.delimiters = ['<%', '%>'];

var vuejs = new Vue({
	el: '#table',

	data: {
		selectedRole: 1,
		roles: 0
	},

	methods: {
		addRole: function(evt){
			var value = $('#table-add-select').find(':selected').val();
			var rolename = $('#table-add-select').find(':selected').html();

			var table = $('#table-add').parent();
			table.append('<tr>' +
					'<td>' +
						'<input type="hidden" name="roles['+this.roles+'][role_id]" value="'+ value +'"/>' +
						'<input type="number" class="form-control" name="roles['+this.roles+'][needed]" value="1" min ="1"/>' +
					'</td>' + 
					'<td>' + rolename + '</td>' + 
					'<td><button class="btn btn-default" v-on:click="removeRole(\'' + this.roles + '\')"><i class="fa fa-times fa-fw"></i> Poista</button></td>' + 
				'</tr>');

			$('#table-add-select').find(':selected').remove();

			this.roles++;

			evt.preventDefault();
		}
	}
});

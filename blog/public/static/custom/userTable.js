	$('#table').bootstrapTable({
		onAll: function (number, size) {
	    	updateRow();
	        return false;
	    },
	    locale: "zh-TW",
	    columns: [
	            {
	                field: 'user_check',
	                //checkbox: true,
	                align: 'center',
	                valign: 'middle'
	            },{
	                field: 'user_email',
	            },{
	                field: 'user_username',
	            },{
	                field: 'user_nickname',
	            },{
	                field: 'user_type',
	            },{
	                field: 'user_group',
	            },{
	                field: 'user_isActive',
	                align: 'center',
	                valign: 'middle'
	            },{
	                field: 'user_edit',
	                align: 'center',
	                valign: 'middle'
	            }
	        ],
	});

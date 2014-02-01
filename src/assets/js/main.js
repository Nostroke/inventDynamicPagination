var c_data,c_page,c_items,i;

$(document).ready(function()
{
	requestData(0);
});

function requestData(page,items)
{
	page = typeof page !== 'undefined' ? page : 0;
	items = typeof items !== 'undefined' ? items : 10;
	
	c_page = page;
	c_items = items;
	
	$.post(	'interface.php',{page:page,items:items},retrieveData,'json');
}

function retrieveData(data)
{
	var num_results = parseInt(data.count);
	
	delete data.count;
	
	if(num_results > 1)
	{
		c_data = data;
		
		$('#data,#pagination').html('');
		
		
		$.each(data,function(i,item)
		{
			$('#data').append('<li>[' + item.id + '] &nbsp; <a href="' + item.link + '" target="_blank">' + item.title + '</a></li>');
		});
		
		for(i = 0;i < Math.ceil(num_results / c_items);i++)
		{
			var fl = c_page == i ? ' class="active_page"':'';
			 
			$('#pagination').append('<a href="#"' + fl + ' onclick="requestData(' + i + ');">' + (i + 1) + '</a>');
		}
	}
}
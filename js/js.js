$(document).ready(function(){
	$('form').submit(function(){
		var notice = $('.notice').hide().removeClass('error').removeClass('success'),
			regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/,
			link = $('input[name="link"]').val(),
			descr = $('input[name="description"]').val(),
			id = $('input[type="hidden"]').val();
		
		if (!regexp.test(link)){
			notice.show().addClass('error').find('.text').text('Please, provide a valid link');
			return false;
		}

		$.post('/api/addLink', {link: link, description: descr, id: id}, function(data) {
			var text = notice.show().addClass('success').find('.text');
			if (data.result != 'ok'){
				$(text).text(data.msg);
				return false;
			}

			$('form h5').text('Add new link');
			$('input[type="submit"]').val('Add new link');
			$('input[type="text"]').val('');
			$('input[type="hidden"]').val('');
			
			if (id != ''){
				text.text('Link updated!');

				var row = $('td[data-linkId="' + id + '"]').parent();

				row.find('a').get(0).innerHTML = link;
				row.find('td').get(1).innerHTML = descr;
			} else {
				text.text('Link added!');
				var row = '<tr><td><a href="/go/' + data.id + '" target="_blank">' + link + '</a><br><span class="date">Last edit: right now</span></td>\
				<td>' + descr + '</td>\
				<td class="actions" data-linkId="' + data.id + '">\
					<a href="#" class="edit"><span class="icon green small" title="Edit this link"><span aria-hidden="true">7</span></span></a>\
					<a href="#" class="delete"><span class="icon red small" title="Delete this link"><span aria-hidden="true">T</span></span></a>\
				</td></tr>';

				$('#linksTable').show().find('tbody').append(row);

				observeEventCallbacks();
			}
		}, 'json');

		return false;
	});

	function observeEventCallbacks(){
		$('.actions a.delete').click(function(){
			if (!confirm('Are you sure to delete this link?'))
				return false;
			
			var self = $(this);
			var id = $(this).parents('td').attr('data-linkId');

			$.post('/api/deleteLink', {id: id}, function(data) {
				if (data.result != 'ok'){
					alert(data.msg);
					return false;
				}
				$(self).parents('tr').remove();
			}, 'json');

			return false;
		});

		$('.actions a.edit').click(function(){
			$('.notice').hide();
			var parent = $(this).parents('tr'),
				id = $(this).parents('td').attr('data-linkId');
			
			var link = $(parent).find('a').get(0).innerHTML,
				description = $(parent).find('td').get(1).innerHTML;

			$('input[name="link"]').val(link),
			$('input[name="description"]').val(description);
			$('input[type="hidden"]').val(id);
			$('input[type="submit"]').val('Update link');
			$('form h5').text('Update link');

			window.location.hash = '';
			window.location.hash = 'addForm';

			return false;
		});

		$('.actions a.twitter').click(function(){
			$('.notice').hide();
			var parent = $(this).parents('tr'),
				id = $(this).parents('td').attr('data-linkId');
			
			var link = $(parent).find('a').get(0).innerHTML,
				description = $(parent).find('td').get(1).innerHTML;
			
			window.open('https://twitter.com/intent/tweet?text=' + encodeURI(description) + '&url=' + encodeURI(link) + '&via=HarryLyu')

			return false;
		});
	}

	observeEventCallbacks();
});
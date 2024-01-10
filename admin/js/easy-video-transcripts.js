var el = wp.element.createElement;

wp.blocks.registerBlockType('easy-video-transcripts/video-block', {
	title: 'Easy Video Transcripts',
	icon: 'media-spreadsheet',
	category: 'media',
	attributes: {
		headers: { type: 'string', default: 'headers-first-row' },
		data: { type: 'string' },
	},

	edit: function(props) {
		function updateHeaders( newdata ) {
			props.setAttributes( { headers: event.target.value } );
		}

		function updateData( event ) {
			props.setAttributes( { data: event.target.value } );
		}

		return el( 'div', 
			{ 
				className: 'easy-video-transcripts show-' + props.attributes.headers
			}, 
			el(
				'select', 
				{
					onChange: updateHeaders,
					value: props.attributes.headers,
				},
				el("option", {value: "headers-first-row" }, "First Row Is Headers"),
				el("option", {value: "headers-first-column" }, "First Column Is Headers"),
				el("option", {value: "headers-first-row-and-column" }, "First Row and Column are Headers"),
				el("option", {value: "headers-none" }, "No Headers")/*,

				el( ServerSideRender, {
                    block: 'easy-video-transcripts/example-dynamic',
                    attributes: props.attributes,
                } )*/


			),
			el(
				'textarea', 
				{
					type: 'text', 
					placeholder: 'Paste spreadsheet data here...',
					value: props.attributes.data,
					onChange: updateData,
					style: { width: '100%' }
				}
			)
		);
	},
	save: function(props) {
		return el( 'div', 
			{ 
				className: 'easy-video-transcripts show-' + props.attributes.headers
			}, 
			el(
				'figure', 
				null,
				props.attributes.data
			)
		);
	}
});
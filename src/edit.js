/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

//InspectorControls are required to use the block settings sidebar
import { 
	useBlockProps,
	InspectorControls 
} from '@wordpress/block-editor';

//PanelBody, PanelRow are required to use the block settings sidebar
import { 
	PanelBody,
	PanelRow,
	SelectControl,
	RadioControl
} from '@wordpress/components';

//to use value from inputs??? works without it but I feel 
import { useState } from '@wordpress/element';

//to be able to use getEntityRecords
import { useSelect } from '@wordpress/data';
/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */

//help from https://rudrastyh.com/gutenberg/get-posts-in-dynamic-select-control.html for getting options from db

export default function Edit( { attributes, setAttributes } ) {
	
	const { 
		videoID,
		layout
	} = attributes;


	// querying pages
	const { videos } = useSelect( ( select ) => {
		const { getEntityRecords } = select( 'core' );
	
		// Query args
		const query = {
			status: 'publish',
		}
	
		return {
			videos: getEntityRecords( 'postType', 'vid_w_transcript', query ),
		}
	} )
	
	// populate options for <SelectControl>
	let options = [];
	if( videos ) {
		options.push( { value: 0, label: 'Select a video' } )
		videos.forEach( ( page ) => {
			options.push( { value : page.id, label : page.title.rendered } )
		})
	} else {
		options.push( { value: 0, label: 'Loading...' } )
	}

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Content Settings', 'author-plugin' ) }>

					<PanelRow>
						<SelectControl
    						label={ __( 'Select Video:' ) }
    						value={ videoID }
							/* cast the saved value as a number -this ensures it will show properly in the editor */
    						onChange={ ( value ) => setAttributes( { videoID: Number( value ) } ) }
					
    						options={ options }
    						__nextHasNoMarginBottom
						/>
					</PanelRow>

					<PanelRow>
						<RadioControl
    						label={ __( 'Layout' ) }
    						selected={ layout }
    						onChange={ ( value ) => setAttributes( { layout: value  } ) }
					
    						options={ [
    							{ label: 'Video on left', value: 'vleft' },
    							{ label: 'Video on top', value: 'vtop' },
    							{ label: 'Full page', value: 'fullpage' }
    						] }
    						__nextHasNoMarginBottom
						/>
					</PanelRow>
				</PanelBody>
			</InspectorControls>
			<div { ...useBlockProps() }>
				<div class={ layout }>
					<div></div>
					<div></div>
				 </div>
			</div>
		
		</>
	);
}

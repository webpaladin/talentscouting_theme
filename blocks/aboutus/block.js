( function( blocks, components, i18n, element, editor, compose ) {
    const el = element.createElement;
    const { InnerBlocks } = wp.blockEditor;
    const MediaUpload = wp.blockEditor.MediaUpload;
    const Button = components.Button;
    const { TextControl } = components;

    blocks.registerBlockType( 'sc-avax/aboutus', {
        title: 'About us',
        icon: 'button',
        category: 'sc-blocks',
        description: 'aboutus',
        example: {
        },
        attributes: {
            mediaID: {
                type: 'number',
                default: ''
            },
            mediaURL: {
                type: 'string',
                default: ''
            },
            mediaAlt: {
                type: 'number',
                default: ''
            },
            mediaTitle: {
                type: 'string',
                default: ''
            },

            title: { type: 'string',  default: '' },
        },
        edit: function(props) {
            var attributes = props.attributes;
            var onSelectImage = function( media ) {
                return props.setAttributes( {
                    mediaURL: media.url,
                    mediaID: media.id,
                    mediaAlt: media.alt,
                    mediaTitle: media.title,
                } );
            };
            var deleteImg = function( event ){
                event.stopPropagation();
                return props.setAttributes( {
                    mediaURL: '',
                    mediaID: '',
                    mediaAlt: '',
                    mediaTitle: '',
                } );
            }

            return [

            el( 'div', { 
                className: props.className,
            },

            el('div',{className:'image'},

                el( 'label', {
                    className: 'blocks-base-control__label',
                    style: {
                        width: '100%',
                        display: 'block',
                        fontSize: '13px'
                    }
                }, 'Upload image'),

                el( MediaUpload, {
                    onSelect: onSelectImage,
                    type: 'image',
                    value: attributes.mediaID,
                    render: function( obj ) {
                        return [ 
                        el( Button, {
                            className: attributes.mediaID ? 'image-button' : 'button button-large',
                            onClick: obj.open
                        },
                        ! attributes.mediaID ? i18n.__( 'Upload Image' ) : "\u270E"),
                        ! attributes.mediaID ? '' : el(Button, {className: 'delete-img', onClick: deleteImg}, "\xD7"),
                        el( 'img', { 
                            src: attributes.mediaURL,

                        } ),
                        ]
                    }
                } )
                ),

            el('div',{className:'text'},

                el( TextControl,
                {
                    label: 'Title',
                    onChange: ( value ) => {
                        props.setAttributes( { title: value } );
                    },
                    value: props.attributes.title
                }
                ),

                el(InnerBlocks, {})

                )

            )
            ]
        },
        save: function(props) {
            var attributes = props.attributes;
            return el( 'div', { 
                className:props.className,
                id:'aboutus'
            },
            el('div', {className:'container'},
                el('div', {className:'image'},
                    el('img',{
                        src:attributes.mediaURL,
                        alt:attributes.mediaAlt,
                        title:attributes.mediaTitle
                    })
                    ),
                el('div',{className:'text'},
                    el('div',{className:'title'},
                        el('h2',{},attributes.title),
                        ),

                    el( InnerBlocks.Content )

                    )
                )
            )

        },
    } );
}(
    window.wp.blocks,
    window.wp.components,
    window.wp.i18n,
    window.wp.element,
    window.wp.editor,
    window.wp.compose
    ) );
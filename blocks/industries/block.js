( function( blocks, components, i18n, element, editor, compose ) {
    const el = element.createElement;
    const { InnerBlocks } = wp.blockEditor;
    const MediaUpload = wp.blockEditor.MediaUpload;
    const Button = components.Button;
    const { TextControl } = components;
    var RichText = wp.blockEditor.RichText;
    const ALLOWED_BLOCKS = [ 'sc-avax/industriesitem' ];


    blocks.registerBlockType( 'sc-avax/industriesitem', {
        title: 'Industries item',
        icon: 'button',
        description: 'industries item',
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
            } ),
            

            el( TextControl,
            {
                label: 'Title',
                onChange: ( value ) => {
                    props.setAttributes( { title: value } );
                },
                value: props.attributes.title
            }
            )

            )
            ]
        },
        save: function(props) {
            var attributes = props.attributes;
            return el( 'div', { 
                className:props.className
            },
            el('div', {className:'image'},
                el('img',{
                    src:attributes.mediaURL,
                    alt:attributes.mediaAlt,
                    title:attributes.mediaTitle
                })
                ),
            el('h3',{},attributes.title),   

            )

        },
    } );

    blocks.registerBlockType( 'sc-avax/industries', {
        title: 'Industries',
        icon: 'button',
        category: 'sc-blocks',
        description: 'industries',
        example: {
        },
        attributes: {
            title: { type: 'string',  default: '' },
            content: {type: 'string'},
            buttontext: { type: 'string',  default: 'Get a Quote!' },
            buttonlink: { type: 'string',  default: '' },
        },
        edit: function(props) {
            var attributes = props.attributes;

            return [

            el( 'div', { 
                className: props.className,
            },

            el( TextControl,
            {
                label: 'Title',
                onChange: ( value ) => {
                    props.setAttributes( { title: value } );
                },
                value: props.attributes.title
            }
            ),

            el(
                RichText,
                {
                    tagName: 'p',
                    placeholder: 'Text',
                    style: {},
                    className: 'text',
                    onChange: ( value ) => {
                        props.setAttributes( { content: value } );
                    },
                    value: props.attributes.content,
                }
                ),

            el(InnerBlocks, {allowedBlocks:ALLOWED_BLOCKS,}),

            el( TextControl,
            {
                label: 'Button text',
                onChange: ( value ) => {
                    props.setAttributes( { buttontext: value } );
                },
                value: props.attributes.buttontext
            }
            ),

            el( TextControl,
            {
                label: 'Button link',
                onChange: ( value ) => {
                    props.setAttributes( { buttonlink: value } );
                },
                value: props.attributes.buttonlink
            }
            ),

            )

            
            ]
        },
        save: function(props) {
            var attributes = props.attributes;
            return el( 'div', { 
                className:props.className,
                id:'services'
            },
            el('div',{className:'container'},
                el('div',{className:'title'},el('h2',{},attributes.title)),
                el( RichText.Content, {
                    tagName: 'p',
                    className:'text',
                    value: props.attributes.content,
                } ),
                el('div',{className:'items'},
                    el( InnerBlocks.Content )
                    ),
                el('a',{href:attributes.buttonlink},attributes.buttontext)
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
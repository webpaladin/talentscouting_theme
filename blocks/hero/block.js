( function( blocks, components, i18n, element, editor, compose ) {
    const el = element.createElement;
    const { InnerBlocks } = wp.blockEditor;
    const MediaUpload = wp.blockEditor.MediaUpload;
    const Button = components.Button;
    const { TextControl } = components;

    blocks.registerBlockType( 'sc-avax/hero', {
        title: 'Hero',
        icon: 'button',
        category: 'sc-blocks',
        description: 'hero',
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

            mediaID2: {
                type: 'number',
                default: ''
            },
            mediaURL2: {
                type: 'string',
                default: ''
            },

            title: { type: 'string',  default: '' },
            buttontext: { type: 'string',  default: '' },
            buttonlink: { type: 'string',  default: '' },
        },
        edit: function(props) {
            var attributes = props.attributes;
            var onSelectImage = function( media ) {
                return props.setAttributes( {
                    mediaURL: media.url,
                    mediaID: media.id,
                } );
            };
            var deleteImg = function( event ){
                event.stopPropagation();
                return props.setAttributes( {
                    mediaURL: '',
                    mediaID: '',
                } );
            }

            var onSelectImage2 = function( media ) {
                return props.setAttributes( {
                    mediaURL2: media.url,
                    mediaID2: media.id,
                } );
            };
            var deleteImg2 = function( event ){
                event.stopPropagation();
                return props.setAttributes( {
                    mediaURL2: '',
                    mediaID2: '',
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
            }, 'Upload video for desktop version'),

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
                    ! attributes.mediaID ? i18n.__( 'Upload Video' ) : "\u270E"),
                    ! attributes.mediaID ? '' : el(Button, {className: 'delete-img', onClick: deleteImg}, "\xD7"),
                    el( 'video', { 
                        src: attributes.mediaURL,

                    } ),
                    ]
                }
            } ),

            el( 'label', {
                className: 'blocks-base-control__label',
                style: {
                    width: '100%',
                    display: 'block',
                    fontSize: '13px'
                }
            }, 'Upload image for mobile version'),

            el( MediaUpload, {
                onSelect: onSelectImage2,
                type: 'image',
                value: attributes.mediaID2,
                render: function( obj ) {
                    return [ 
                    el( Button, {
                        className: attributes.mediaID2 ? 'image-button' : 'button button-large',
                        onClick: obj.open
                    },
                    ! attributes.mediaID2 ? i18n.__( 'Upload Image' ) : "\u270E"),
                    ! attributes.mediaID2 ? '' : el(Button, {className: 'delete-img', onClick: deleteImg2}, "\xD7"),
                    el( 'img', { 
                        src: attributes.mediaURL2,

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
            ),

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
                style: {
                    backgroundImage:'url('+attributes.mediaURL2+')',
                    backgroundSize:'cover'
                }
            },

            el('div', {className:'video-bg'},
                el('video',{
                    autoplay:true,
                    muted:true,
                    loop:true,
                    playsinline:true,
                    id: 'background-video'
                },
                el('source',{
                    src:attributes.mediaURL,
                    type:"video/mp4"
                })
                )
                ),
            (attributes.title) ? (el('h1',{},attributes.title)) : (''),
            el('div',{className:'link-block'},
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
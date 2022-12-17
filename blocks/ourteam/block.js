( function( blocks, components, i18n, element, editor, compose ) {
    const el = element.createElement;
    const { InnerBlocks } = wp.blockEditor;
    const MediaUpload = wp.blockEditor.MediaUpload;
    const Button = components.Button;
    const { TextControl } = components;
    var RichText = wp.blockEditor.RichText;
    const ALLOWED_BLOCKS = [ 'sc-avax/ourteamitem' ];


    blocks.registerBlockType( 'sc-avax/ourteamitem', {
        title: 'ourteam item',
        icon: 'button',
        description: 'ourteam item',
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
            linkedin: { type: 'string',  default: '' },
            email: { type: 'string',  default: '' },
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
                label: 'Name',
                onChange: ( value ) => {
                    props.setAttributes( { title: value } );
                },
                value: props.attributes.title
            }
            ),

            el( 'label', {
                className: 'blocks-base-control__label',
                style: {
                    width: '100%',
                    display: 'block',
                    fontSize: '13px'
                }
            }, 'Quick bio: '),

            el(InnerBlocks, {}),

            el( TextControl,
            {
                label: 'Linkedin',
                onChange: ( value ) => {
                    props.setAttributes( { linkedin: value } );
                },
                value: props.attributes.linkedin
            }
            ),

            el( TextControl,
            {
                label: 'E-mail',
                onChange: ( value ) => {
                    props.setAttributes( { email: value } );
                },
                value: props.attributes.email
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
            el('div', {
                className:'image',
                style: {
                    background: 'url('+attributes.mediaURL+')',
                    backgroundSize: 'cover'
                }
            },
                ),
            el('h3',{},attributes.title),
            el('div',{className:'bio'},
                el( InnerBlocks.Content ),
                ),
            el('button',{className:'more'},'more'),
            el('div',{className:'social'},
                (attributes.linkedin) ? (
                    el('a',{href:attributes.linkedin},
                        el('img',{src:folder.img+'linkedin.svg'})
                        )
                    ) : (''),
                (attributes.email) ? (
                    el('a',{href:'mailto:'+attributes.email},
                        el('img',{src:folder.img+'email.svg'})
                        )
                    ) : (''),
                )

            )

        },
    } );

blocks.registerBlockType( 'sc-avax/ourteam', {
    title: 'Our team',
    icon: 'button',
    category: 'sc-blocks',
    description: 'ourteam',
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

        )


        ]
    },
    save: function(props) {
        var attributes = props.attributes;
        return el( 'div', { 
            className:props.className, id:'ourteam'
        },

        el('div',{className:'ourteam-header'},
            el('div',{className:'container'},
                el('div',{className:'title'},el('h2',{},attributes.title)),
                el( RichText.Content, {
                    tagName: 'p',
                    className:'text',
                    value: props.attributes.content,
                } ),
                )
            ),
        el('div',{className:'ourteam-body'},
            el('div',{className:'container'},
                el('div',{className:'items'},
                    el( InnerBlocks.Content )
                    ),
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
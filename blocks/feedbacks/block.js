( function( blocks, components, i18n, element, editor, compose ) {
    const el = element.createElement;
    const { InnerBlocks } = wp.blockEditor;
    const { TextControl } = components;
    var RichText = wp.blockEditor.RichText;
    const ALLOWED_BLOCKS = [ 'sc-avax/feedbacksitem' ];
    const BLOCKS_THEMPLATE = [ ['sc-avax/feedbacksitem',{}] ];

    blocks.registerBlockType( 'sc-avax/feedbacksitem', {
        title: 'feedbacks item',
        icon: 'button',
        description: 'feedbacksitem',
        example: {
        },
        attributes: {
            title: { type: 'string',  default: '' },
            subtitle: { type: 'string',  default: '' },
            feedback: { type: 'string',  default: '' },
        },
        edit: function(props) {
            var attributes = props.attributes;
            return [

            el( 'div', { 
                className: props.className,
            },

            el( TextControl,
            {
                label: 'Name',
                onChange: ( value ) => {
                    props.setAttributes( { title: value } );
                },
                value: props.attributes.title
            }
            ),

            el( TextControl,
            {
                label: 'Company and Position',
                onChange: ( value ) => {
                    props.setAttributes( { subtitle: value } );
                },
                value: props.attributes.subtitle
            }
            ),

            el( 'label', {
                className: 'blocks-base-control__label',
                style: {
                    width: '100%',
                    display: 'block',
                    fontSize: '13px'
                }
            }, 'Feedback'),
            
            el(InnerBlocks, {}),

            )
            ]
        },
        save: function(props) {
            var attributes = props.attributes;
            return el( 'div', { 
                className:props.className
            },

            el('h3',{},attributes.title),
 
            (attributes.subtitle) ? (el('h4',{},attributes.subtitle)) : (''),

            el( InnerBlocks.Content )

            )

        },
    } );

    blocks.registerBlockType( 'sc-avax/feedbacks', {
        title: 'Feedbacks',
        icon: 'button',
        category: 'sc-blocks',
        description: 'feedbacks',
        example: {
        },
        attributes: {
            title: { type: 'string',  default: '' },
            content: { type: 'string',  default: '' },
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

            el(InnerBlocks, {
                allowedBlocks:ALLOWED_BLOCKS,
                template: BLOCKS_THEMPLATE,
            }),
            

            )
            ]
        },
        save: function(props) {
            var attributes = props.attributes;
            return el( 'div', { className:props.className},
                el( 'div', { className:'container'},
                    el('div',{className:'title'},el('h2',{},attributes.title)),
                    el( RichText.Content, {
                        tagName: 'p',
                        className:'text',
                        value: props.attributes.content,
                    } ),
                    el('div',{className:'feedbacks-slider owl-carousel'},
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
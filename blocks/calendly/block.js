( function( blocks, components, i18n, element, editor, compose ) {
    const el = element.createElement;
    const { InnerBlocks } = wp.blockEditor;
    const { TextControl } = components;
    var RichText = wp.blockEditor.RichText;
    const MY_TEMPLATE = [
    ['core/html']
    ];


    blocks.registerBlockType( 'sc-avax/calendly', {
        title: 'Calendly',
        icon: 'button',
        category: 'sc-blocks',
        description: 'calendly',
        example: {
        },
        attributes: {
            title: { type: 'string',  default: '' },
            content: {type: 'string'},
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
                template: MY_TEMPLATE,
                templateLock: 'all',

            })

            )
            ]
        },
        save: function(props) {
            var attributes = props.attributes;
            return el( 'div', { 
                className:props.className,
                id: 'calendly'
            },
            el('div', {className:'container'},
                el('div',{className:'title'},
                    el('h2',{},attributes.title),
                    ),
                el( RichText.Content, {
                    tagName: 'p',
                    className:'text',
                    value: props.attributes.content,
                } ),

                el( InnerBlocks.Content )

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
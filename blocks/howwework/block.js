( function( blocks, components, i18n, element, editor, compose ) {
    const el = element.createElement;
    const { InnerBlocks } = wp.blockEditor;
    const { TextControl } = components;

    blocks.registerBlockType( 'sc-avax/howwework', {
        title: 'How we work',
        icon: 'button',
        category: 'sc-blocks',
        description: 'howwework',
        example: {
        },
        attributes: {
            title: { type: 'string',  default: '' },
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

            el(InnerBlocks, {
             
            }),
            

            )
            ]
        },
        save: function(props) {
            var attributes = props.attributes;
            return el( 'div', { className:props.className},
                el( 'div', { className:'container'},
                    el('div',{className:'title'},el('h2',{},attributes.title)),
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
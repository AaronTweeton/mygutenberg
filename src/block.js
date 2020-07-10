import { registerBlockType } from '@wordpress/blocks';
 
registerBlockType( 'mygutenberg/my-block', {
    title: 'My Gutenberg Block',
    icon: 'wordpress',
    category: 'mygutenberg',
    example: {},
    edit( { className } ) {
        return <p className={ className }>This is a basic Gutenberg block (from the editor, in green).</p>;
    },
    save() {
        return <p>This is a basic Gutenberg block (from the frontend, in red).</p>;
    },
} );
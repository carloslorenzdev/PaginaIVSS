import { Editor, Extension } from '@tiptap/core';
import Blockquote from '@tiptap/extension-blockquote';
import Bold from '@tiptap/extension-bold';
import BulletList from '@tiptap/extension-bullet-list';
import CharacterCount from '@tiptap/extension-character-count';
import Link from '@tiptap/extension-link';
import ListItem from '@tiptap/extension-list-item';
import OrderedList from '@tiptap/extension-ordered-list';
import Paragraph from '@tiptap/extension-paragraph';
import Placeholder from '@tiptap/extension-placeholder';
import Underline from '@tiptap/extension-underline';
import StarterKit from '@tiptap/starter-kit';
import TextAlign from '@tiptap/extension-text-align';
import { TextStyle } from '@tiptap/extension-text-style';
import { FontFamily } from '@tiptap/extension-font-family';
import Image from '@tiptap/extension-image';

// Custom Extension for Font Size
const FontSize = Extension.create({
  name: 'fontSize',
  addOptions() {
    return {
      types: ['textStyle'],
    }
  },
  addGlobalAttributes() {
    return [
      {
        types: this.options.types,
        attributes: {
          fontSize: {
            default: null,
            parseHTML: element => element.style.fontSize.replace(/['"]+/g, ''),
            renderHTML: attributes => {
              if (!attributes.fontSize) {
                return {}
              }
              return {
                style: `font-size: ${attributes.fontSize}`,
              }
            },
          },
        },
      },
    ]
  },
  addCommands() {
    return {
      setFontSize: fontSize => ({ chain }) => {
        return chain()
          .setMark('textStyle', { fontSize })
          .run()
      },
      unsetFontSize: () => ({ chain }) => {
        return chain()
          .setMark('textStyle', { fontSize: null })
          .removeEmptyTextStyle()
          .run()
      },
    }
  },
});

// Custom Extension for Line Height
const LineHeight = Extension.create({
    name: 'lineHeight',
    addOptions() {
        return {
            types: ['paragraph', 'heading', 'list_item'],
            defaultLineHeight: 'normal',
        }
    },
    addGlobalAttributes() {
        return [
            {
                types: this.options.types,
                attributes: {
                    lineHeight: {
                        default: this.options.defaultLineHeight,
                        parseHTML: element => element.style.lineHeight || this.options.defaultLineHeight,
                        renderHTML: attributes => {
                            if (attributes.lineHeight === this.options.defaultLineHeight) {
                                return {}
                            }
                            return { style: `line-height: ${attributes.lineHeight}` }
                        },
                    },
                },
            },
        ]
    },
    addCommands() {
        return {
            setLineHeight: lineHeight => ({ commands }) => {
                return this.options.types.every(type => commands.updateAttributes(type, { lineHeight }))
            },
            unsetLineHeight: () => ({ commands }) => {
                return this.options.types.every(type => commands.resetAttributes(type, 'lineHeight'))
            },
        }
    },
});

/**
 * Construye el editor
 * @param {string} idElemento
 * @param {string|null} placeholder
 * @return {Editor}
 */
function buildEditor(idElemento, placeholder = 'Escribe algo...') {
    const limit = 5000;
    const field = document.querySelector(`#${idElemento} [data-hs-editor-field]`);
    const content = field.innerHTML;
    field.innerHTML = '';
    const editor = new Editor({
        element: field,
        content,
        editorProps: {
            attributes: {
                class: 'relative min-h-[400px] text-sm text-gray-800 dark:text-neutral-200 p-3 outline-none'
            },
            limit,
        },
        onUpdate({ editor }) {
            const msgLimit = document.querySelector('div[data-hs-editor-limit]');
            msgLimit.innerHTML = `${editor.storage.characterCount.characters()} / ${limit} caracteres`;
        },
        extensions: [
            StarterKit.configure({
                history: false,
                paragraph: false,
                bold: false,
                listItem: false,
                orderedList: false,
                bulletList: false,
                blockquote: false
            }),
            Placeholder.configure({
                placeholder: placeholder,
                emptyNodeClass: 'text-sm before:text-gray-500'
            }),
            Paragraph.configure({
                HTMLAttributes: {
                    class: 'mb-3',
                }
            }),
            Bold.configure({
                HTMLAttributes: {
                    // class: 'font-bold',
                }
            }),
            Underline,
            Link.configure({
                HTMLAttributes: {
                    class: 'inline-flex items-center gap-x-1 text-blue-600 decoration-2 hover:underline focus:outline-hidden focus:underline font-medium dark:text-white'
                }
            }),
            BulletList.configure({
                HTMLAttributes: {
                    class: 'list-disc list-inside text-gray-800 dark:text-white'
                }
            }),
            OrderedList.configure({
                HTMLAttributes: {
                    class: 'list-decimal list-inside text-gray-800 dark:text-white'
                }
            }),
            ListItem.configure({
                HTMLAttributes: {
                    class: 'marker:text-sm'
                }
            }),
            Blockquote.configure({
                HTMLAttributes: {
                    class: 'relative border-s-4 ps-4 sm:ps-6 dark:border-neutral-700 sm:[&>p]:text-lg'
                }
            }),
            CharacterCount.configure({
                limit
            }),
            TextAlign.configure({
                types: ['heading', 'paragraph'],
                alignments: ['left', 'center', 'right', 'justify'],
            }),
            TextStyle,
            FontFamily,
            FontSize,
            LineHeight,
            Image.configure({
                HTMLAttributes: {
                    class: 'rounded-lg max-w-full my-4 shadow-sm',
                },
            }),
        ]
    });
    
    const actions = [
        {
            id: `#${idElemento} [data-hs-editor-bold]`,
            fn: () => editor.chain().focus().toggleBold().run()
        },
        {
            id: `#${idElemento} [data-hs-editor-italic]`,
            fn: () => editor.chain().focus().toggleItalic().run()
        },
        {
            id: `#${idElemento} [data-hs-editor-underline]`,
            fn: () => editor.chain().focus().toggleUnderline().run()
        },
        {
            id: `#${idElemento} [data-hs-editor-strike]`,
            fn: () => editor.chain().focus().toggleStrike().run()
        },
        {
            id: `#${idElemento} [data-hs-editor-link]`,
            fn: () => {
                const url = window.prompt('Ingrese la URL');
                editor.chain().focus().extendMarkRange('link').setLink({ href: url }).run();
            }
        },
        {
            id: `#${idElemento} [data-hs-editor-ol]`,
            fn: () => editor.chain().focus().toggleOrderedList().run()
        },
        {
            id: `#${idElemento} [data-hs-editor-ul]`,
            fn: () => editor.chain().focus().toggleBulletList().run()
        },
        {
            id: `#${idElemento} [data-hs-editor-blockquote]`,
            fn: () => editor.chain().focus().toggleBlockquote().run()
        },
        {
            id: `#${idElemento} [data-hs-editor-image]`,
            fn: () => {
                const button = document.querySelector(`#${idElemento} [data-hs-editor-image]`);
                const fileInput = document.querySelector(`#${idElemento} #hs-editor-image-input`);
                if(fileInput && button) {
                    fileInput.click();
                    fileInput.onchange = async (e) => {
                        const file = e.target.files[0];
                        if(file) {
                            const originalHtml = button.innerHTML;
                            button.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i>';
                            button.disabled = true;

                            const formData = new FormData();
                            formData.append('image', file);
                            formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '');
                            try {
                                const response = await fetch('/admin/noticias/upload-editor-image', {
                                    method: 'POST',
                                    body: formData
                                });
                                const result = await response.json();
                                if(result.success) {
                                    editor.chain().focus().setImage({ src: result.file.url }).run();
                                } else {
                                    alert('Error al subir la imagen');
                                }
                            } catch (error) {
                                console.error('Error uploading image', error);
                                alert('Error al subir la imagen');
                            } finally {
                                button.innerHTML = originalHtml;
                                button.disabled = false;
                                fileInput.value = ''; // reset
                            }
                        }
                    };
                }
            }
        },
        {
            id: `#${idElemento} [data-hs-editor-code]`,
            fn: () => editor.chain().focus().toggleCode().run()
        },
        {
            id: `#${idElemento} [data-hs-editor-align-left]`,
            fn: () => editor.chain().focus().setTextAlign('left').run()
        },
        {
            id: `#${idElemento} [data-hs-editor-align-center]`,
            fn: () => editor.chain().focus().setTextAlign('center').run()
        },
        {
            id: `#${idElemento} [data-hs-editor-align-right]`,
            fn: () => editor.chain().focus().setTextAlign('right').run()
        },
        {
            id: `#${idElemento} [data-hs-editor-align-justify]`,
            fn: () => editor.chain().focus().setTextAlign('justify').run()
        }
    ];

    // For dropdown changes (font family, font size, line height)
    setTimeout(() => {
        const fontFamilySelect = document.querySelector(`#${idElemento} [data-hs-editor-font-family]`);
        if (fontFamilySelect) {
            fontFamilySelect.addEventListener('change', (e) => {
                editor.chain().focus().setFontFamily(e.target.value).run();
            });
        }

        const fontSizeSelect = document.querySelector(`#${idElemento} [data-hs-editor-font-size]`);
        if (fontSizeSelect) {
            fontSizeSelect.addEventListener('change', (e) => {
                editor.chain().focus().setFontSize(e.target.value).run();
            });
        }

        const lineHeightSelect = document.querySelector(`#${idElemento} [data-hs-editor-line-height]`);
        if (lineHeightSelect) {
            lineHeightSelect.addEventListener('change', (e) => {
                editor.chain().focus().setLineHeight(e.target.value).run();
            });
        }
    }, 100);
    // Old actions array removed

    actions.forEach(({ id, fn }) => {
        const action = document.querySelector(id);

        if (action === null) return;

        action.addEventListener('click', fn);
    });

    return editor;
}

export { buildEditor };


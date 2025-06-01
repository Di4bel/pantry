import {Editor, isActive} from '@tiptap/core'
import StarterKit from '@tiptap/starter-kit'

window.setupEditor = function (content) {
    let editor

    return {
        content: content,
        isActive: {
            'bold': false,
            'italic': false,
            'heading': false,
            'bulletList': false,
            'orderedList': false,
            'code': false,
            'horizontalRule': false,
        },
        init(element) {
            editor = new Editor({
                element: element,
                extensions: [
                    StarterKit,

                ],
                content: this.content,
                onUpdate: ({ editor }) => {
                    this.content = editor.getHTML()
                },
                onTransaction: ({ editor }) => {
                    this.updateActive()
                },
                editorProps: {
                    attributes: {
                        class: 'min-h-full outline-none prose prose-sm sm:prose-base lg:prose-lg xl:prose-2xl m-5 focus:outline-none dark:text-white',
                    },
                },
            })

            this.isActive = {
                bold: () => editor.isActive('bold'),
                italic: () => editor.isActive('italic'),
                heading: (level) => editor.isActive('heading', { level }),
                bulletList: () => editor.isActive('bulletList'),
                orderedList: () => editor.isActive('orderedList'),
                code: () => editor.isActive('code')
            }
            this.$watch('content', (content) => {
                // If the new content matches Tiptap's then we just skip.
                if (content === editor.getHTML()) return

                /*
                  Otherwise, it means that an external source
                  is modifying the data on this Alpine component,
                  which could be Livewire itself.
                  In this case, we only need to update Tiptap's
                  content and we're done.
                  For more information on the `setContent()` method, see:
                    https://www.tiptap.dev/api/commands/set-content
                */
                editor.commands.setContent(content, false)
            })
        },

        // Methods to control the editor
        toggleBold() {
            editor.chain().focus().toggleBold().run()
        },
        toggleItalic() {
            editor.chain().focus().toggleItalic().run()
        },
        toggleHeading(level) {
            editor.chain().focus().toggleHeading({ level }).run()
        },
        toggleBulletList() {
            editor.chain().focus().toggleBulletList().run()
        },
        toggleOrderedList() {
            editor.chain().focus().toggleOrderedList().run()
        },
        toggleCode() {
            editor.chain().focus().toggleCode().run()
        },
        setHorizontalRule() {
            editor.chain().focus().setHorizontalRule().run()
        },
        updateActive() {
            this.isActive = {
                bold: () => editor.isActive('bold'),
                italic: () => editor.isActive('italic'),
                heading: (level) => editor.isActive('heading', { level }),
                bulletList: () => editor.isActive('bulletList'),
                orderedList: () => editor.isActive('orderedList'),
                code: () => editor.isActive('code'),
                horizontalRule: () => editor.isActive('horizontalRule'),
            }
        }
    }
}

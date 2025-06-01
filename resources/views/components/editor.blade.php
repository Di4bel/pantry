<div
        x-data="setupEditor(
            $wire.entangle('{{ $attributes->wire('model')->value() }}').live
        )"
        x-init="() => init($refs.editor)"
        wire:ignore
        {{ $attributes->whereDoesntStartWith('wire:model') }}
>
    <div class="tiptap border border-gray-300 rounded-t p-2 bg-gray-100 dark:bg-gray-700 flex flex-wrap gap-2">
        <button
            @click="toggleBold()"
            class="px-2 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-600 dark:text-white"
            :class="{ 'bg-gray-300 dark:bg-gray-600': isActive.bold() }"
            title="Bold"
        >
            <strong>B</strong>
        </button>
        <button
            @click="toggleItalic()"
            :class="{ 'bg-gray-300 dark:bg-gray-600': isActive.italic() }"
            class="px-2 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-600 dark:text-white"
            title="Italic"
        >
            <em>I</em>
        </button>
        <button
            @click="toggleHeading(1)"
            :class="{ 'bg-gray-300 dark:bg-gray-600': isActive.heading(1) }"
            class="px-2 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-600 dark:text-white"
            title="Heading 1"
        >
            H1
        </button>
        <button
            @click="toggleHeading(2)"
            :class="{ 'bg-gray-300 dark:bg-gray-600': isActive.heading(2) }"
            class="px-2 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-600 dark:text-white"
            title="Heading 2"
        >
            H2
        </button>
        <button
                @click="toggleHeading(3)"
                :class="{ 'bg-gray-300 dark:bg-gray-600': isActive.heading(3) }"
                class="px-2 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-600 dark:text-white"
                title="Heading 3"
        >
            H3
        </button>
        <button
            @click="toggleBulletList()"
            :class="{ 'bg-gray-300 dark:bg-gray-600': isActive.bulletList() }"
            class="px-2 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-600 dark:text-white"
            title="Bullet List"
        >
            • List
        </button>
        <button
            @click="toggleOrderedList()"
            :class="{ 'bg-gray-300 dark:bg-gray-600': isActive.orderedList() }"
            class="px-2 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-600 dark:text-white"
            title="Ordered List"
        >
            1. List
        </button>
        <button
            @click="toggleCode()"
            :class="{ 'bg-gray-300 dark:bg-gray-600': isActive.code() }"
            class="px-2 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-600 dark:text-white"
            title="Code"
        >
            &lt;/&gt;
        </button>
        <button
                @click="setHorizontalRule()"
                class="px-2 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-600 dark:text-white"
                title="Horizontal Rule"
        >
            ---
        </button>
    </div>
    <div x-ref="editor" class="border border-gray-300 rounded-b p-2 min-h-[300px] h-full dark:bg-gray-800 dark:text-white"></div>
    <style>
        .ProseMirror {
            min-height: 100%;
            height: 100%;
            overflow-y: auto;
        }
        .ProseMirror p {
            margin: 0.5em 0;
        }
        .ProseMirror > * + * {
            margin-top: 0.75em;
        }
        .tiptap {
            button.is-active {
                background: black;
                color: white;
            }
        }
    </style>
</div>
